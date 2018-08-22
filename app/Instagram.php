<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instagram extends Model
{
    protected $table = 'instagram_info';

    public function ScriptInfo()
    {
        return $this->hasOne('App\Script','name','model');
    }
}
