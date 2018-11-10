<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Request;

class Export extends AbstractTool
{

    public function render()
    {
        return '<a class="btn btn-sm btn-primary" href="withdraw/export/un" target="_blank">导出未转账清单</a>';
    }
}