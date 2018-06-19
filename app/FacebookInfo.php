<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacebookInfo extends Model
{
    protected $table = 'facebook_info';

    public function ScriptInfo()
    {
        return $this->hasOne('App\Script','name','model');
    }
}
