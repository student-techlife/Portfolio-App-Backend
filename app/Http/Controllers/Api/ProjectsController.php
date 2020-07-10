<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Project;
use Image;
use File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectsController extends Controller {
    public function create(Request $request) {

        $project = new Project;
        $project->user_id = Auth::user()->id;
        $project->desc = $request->desc;

        //check if project has photo
        if($request->photo != ''){
            //choose a unique name for photo
            $photo = time().'.png';
            $base64_str = $request->photo;
            $image = base64_decode($base64_str);
            $path = public_path() ."/projects/" . $photo;
            Image::make($image)->save($path);
        }
        //mistake
        $project->save();
        $project->user;
        return response()->json([
            'success' => true,
            'message' => 'posted',
            'project' => $project
        ]);
    }


    public function update(Request $request){
        $project = Project::find($request->id);
        // check if user is editing his own project
        // we need to check user id with project user id
        if(Auth::user()->id != $project->user_id){
            return response()->json([
                'success' => false,
                'message' => 'unauthorized access'
            ]);
        }
        $project->desc = $request->desc;
        $project->update();
        return response()->json([
            'success' => true,
            'message' => 'project edited'
        ]);
    }

    public function delete(Request $request){
        $project = Project::find($request->id);
        // check if user is editing his own project
        if(Auth::user()->id !=$project->user_id){
            return response()->json([
                'success' => false,
                'message' => 'unauthorized access'
            ]);
        }
        
        //check if project has photo to delete
        if($project->photo != '') {
            File::delete( public_path()."/projects/".$project->photo);
        }
        $project->delete();
        return response()->json([
            'success' => true,
            'message' => 'project deleted'
        ]);
    }

    public function projects(){
        $projects = Project::orderBy('id','desc')->get();
        foreach($projects as $project){
            //get user of project
            $project->user;
            //comments count
            $project['commentsCount'] = count($project->comments);
            //likes count
            $project['likesCount'] = count($project->likes);
            //check if users liked his own project
            $project['selfLike'] = false;
            foreach($project->likes as $like){
                if($like->user_id == Auth::user()->id){
                    $project['selfLike'] = true;
                }
            }

        }

        return response()->json([
            'success' => true,
            'projects' => $projects
        ]);
    }

    

    public function myProjects(){
        $projects = Project::where('user_id',Auth::user()->id)->orderBy('id','desc')->get();
        $user = Auth::user();
        return response()->json([
            'success' => true,
            'projects' => $projects,
            'user' => $user
        ]);
    }


}

