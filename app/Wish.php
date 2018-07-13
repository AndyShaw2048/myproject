<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wish extends Model
{
    protected $table = 'wish_info';
    public $timestamps = false;
    public function ScriptInfo()
    {
        return $this->hasOne('App\Script','name','model');
    }
}
