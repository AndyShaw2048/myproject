<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Whatsapp extends Model
{
    protected $table = 'whatsapp_info';

    public function ScriptInfo()
    {
        return $this->hasOne('App\Script','name','model');
    }
}
