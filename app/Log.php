<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    public function application(){
        $this->belongsTo(Application::class);
    }
}

