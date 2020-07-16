<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{

    protected $fillable = ['application_id','type', 'description'];
    public function application(){
        $this->belongsTo(Application::class);
    }
}

