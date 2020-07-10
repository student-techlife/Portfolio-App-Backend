<?php

namespace App;

use App\Project;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function project(){
        return $this->belongsTo(Project::class);
    }
}
