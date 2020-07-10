<?php

namespace App;

use App\Project;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public function project(){
        return $this->belongsTo(Project::class);
    }
}
