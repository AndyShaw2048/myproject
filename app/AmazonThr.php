<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AmazonThr extends Model
{
    protected $table = 'amazon_thr';

    public function ScriptInfo()
    {
        return $this->hasOne('App\Script','name','model');
    }
}
