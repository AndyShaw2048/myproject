<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Amazon extends Model
{
    protected $table = 'amazon_info';

    public function ScriptInfo()
    {
        return $this->hasOne('App\Script','name','model');
    }
}
