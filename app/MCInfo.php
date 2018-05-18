<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MCInfo extends Model
{
    protected $table = 'mc_info';

    public function ModeInfo()
    {
        return $this->hasOne('App\Mode','id','mode');
    }
}
