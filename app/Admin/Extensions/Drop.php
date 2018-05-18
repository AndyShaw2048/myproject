<?php

namespace App\Admin\Extensions;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Displayers\AbstractDisplayer;

class Drop extends AbstractDisplayer
{
    public function display()
    {
        return <<<EOT
<!-- Button trigger modal -->
<a style="color:#0ba8cc;font-weight:bold;cursor:pointer;" data-toggle="modal" data-target="#{$this->row->id}">
  {$this->row->machine_code}
</a>

<!-- Modal -->
<div class="modal fade" id="{$this->row->id}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body" style="margin-top:200px">
      <b>
            <table class="table table-bordered table-hover" style="table-layout:fixed;">
                <tr>
                    <td>序号</td>
                    <td>{$this->row->id}</td>
                </tr>
                <tr>
                    <td>模式</td>
                    <td>{$this->row->ModeInfo->name}</td>
                </tr>
                <tr>
                    <td>机器码</td>
                    <td>{$this->row->machine_code}</td>
                </tr>
                <tr>
                    <td>关键词</td>
                    <td>{$this->row->keyword}</td>
                </tr>
                <tr>
                    <td>匹配商品名</td>
                    <td>{$this->row->matching_name}</td>
                </tr>
                <tr>
                    <td>关联商品名</td>
                    <td>{$this->row->relation_name}</td>
                </tr>
                <tr>
                    <td>所属用户ID</td>
                    <td>{$this->row->user_id}</td>
                </tr>
                <tr>
                    <td>备注</td>
                    <td>{$this->row->note}</td>
                </tr>

            </table>
      </b>
      </div>
    </div>
  </div>
</div>
EOT;

    }
}


