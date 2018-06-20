<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messenger extends Model
{
    protected $table = 'messenger_info';

    public function ScriptInfo()
    {
        return $this->hasOne('App\Script','name','model');
    }
}
