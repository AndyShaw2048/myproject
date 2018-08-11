<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    protected $table = 'line_info';

    public function ScriptInfo()
    {
        return $this->hasOne('App\Script','name','model');
    }
}
