<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\User;
use Laravel\Passport\Client;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Image;
use File;
use DB;

class AuthController extends Controller {

    use IssueTokenTrait;

    private $client;

    public function __construct() {
        $this->client = Client::find(2);
    }

    // Gebruiker inloggen
    public function login(Request $request) {

        $validatedData = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        return $this->issueToken($request, 'password');

        // $creds = $request->only(['email','password']);

        // if(!$token=auth()->attempt($creds)){
            
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'invalid credintials'
        //     ]);
        // }
        // return response()->json([
        //     'success' =>true,
        //     'token' => $token,
        //     'user' => Auth::user()
        // ]);
    }

    // Nieuwe gebruiker aanmaken
    public function register(Request $request) {

        // dd($request->all());

        $validatedData = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'email' => request('email'),
            'password' => bcrypt(request('password')),
        ]);

        return $this->issueToken($request, 'password');
        
        // $encryptedPass = Hash::make($request->password);

        // $user = new User;

        // try{
        //     $user->email = $request->email;
        //     $user->password = $encryptedPass;
        //     $user->save();
        //     return $this->login($request);
        // }
        // catch(Exception $e){
        //     return response()->json([
        //         'success' => false,
        //         'message' => ''.$e
        //     ]);
        // }
    }

    // Gebruiker gegevens updaten
    public function update(Request $request) {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email,'.$user->id,
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
        ]);

        $user->email = $request->email;
        $user->name = $request->name;
        $user->lastname = $request->lastname;

        if($request->photo != ''){

            if($user->photo != 'user.png') {
                File::delete( public_path()."/profiles/".$user->photo);
            }

            $photo = time().'.jpg';
            $base64_str = $request->photo;
            $image = base64_decode($base64_str);
            $path = public_path() ."/profiles/" . $photo;
            Image::make($image)->resize(null, 400, function($constraint) {
                $constraint->aspectRatio();
            })->save($path);
            $user->photo = $photo;
        }

        $user->update();

        return response()->json([
            'success' => true,
            'message' => 'profile edited'
        ]);
    }

    public function refresh(Request $request) {
        $validatedData = $request->validate([
            'refresh_token' => 'required',
        ]);

        return $this->issueToken($request, 'refresh_token');
    }

    // Gebruiker uitloggen
    public function logout(Request $request) {
        
        $accessToken = Auth::user()->token();

        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update(['revoked' => true]);

        $accessToken->revoke();

        return response()->json([], 204);
        
        // try{
        //     JWTAuth::invalidate(JWTAuth::parseToken($request->token));
        //     return response()->json([
        //         'success' => true,
        //         'message' => 'logout success'
        //     ]);
        // }
        // catch(Exception $e){
        //     return response()->json([
        //         'success' => false,
        //         'message' => ''.$e
        //     ]);
        // }
    }

    // Gebruiker kan zijn eigen gebruikrs informatie ophalen
    public function getUserInfo(Request $request) {
        $user = Auth::user();
        return $user;
    }

    // this function saves user name,lastname and photo
    public function saveUserInfo(Request $request){
        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->lastname = $request->lastname;

        //check if user provided photo
        if($request->photo != ''){
            //choose a unique name for photo
            $photo = time().'.jpg';
            $base64_str = $request->photo;
            $image = base64_decode($base64_str);
            $path = public_path() ."/profiles/" . $photo;
            Image::make($image)->resize(null, 400, function($constraint) {
                $constraint->aspectRatio();
            })->save($path);
            $user->photo = $photo;
        } else {
            // default image
            $user->photo = "user.png";
            $photo = "user.png";
        }

        $user->update();

        return response()->json([
            'success' => true,
            'photo' => $photo
        ]);

    }

    public function changePassword(PasswordRequest $request) {
        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return response()->json([
            'success' => true,
            'message' => 'password changed',
        ]);
    }

}