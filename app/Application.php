<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }

    //for mass assinment

    protected $fillable = ['user_id','name', 'description', 'api_key'];


    public function logs() {
        return $this->hasMany(Log::class);
    }

}
