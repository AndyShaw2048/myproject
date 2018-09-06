<?php

namespace App\Admin\Extensions;

use App\AdminUser;
use Encore\Admin\Admin;
use Encore\Admin\Grid\Displayers\AbstractDisplayer;

class Drop extends AbstractDisplayer
{
    public function display($model = null)
    {
        $user = AdminUser::find($this->row->user_id);

        $name = null;
        if(is_null($user))
        {
            $name = $this->row->user_id;
        }
        else
        {
            $name = $user->name;
        }
        if($model == 'amazon')
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
      <div class="modal-body" style="margin-top:200px;color:#000;">
      <b>
            <table class="table table-bordered table-hover" style="table-layout:fixed;">
                <tr>
                    <td>ID</td>
                    <td>{$this->row->id}</td>
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
                    <td>关联关键词</td>
                    <td>{$this->row->relation_kw}</td>
                </tr>
                <tr>
                    <td>匹配商品名</td>
                    <td>{$this->row->matching_name}</td>
                </tr>
                <tr>
                    <td>匹配商品名(Prime)</td>
                    <td>{$this->row->m_prime}</td>
                </tr>
                <tr>
                    <td>关联商品名</td>
                    <td>{$this->row->relation_name}</td>
                </tr>
                <tr>
                    <td>关联商品名(Prime)</td>
                    <td>{$this->row->r_prime}</td>
                </tr>
                <tr>
                    <td>所属用户</td>
                    <td>{$name}</td>
                </tr>
                <tr>
                    <td>间隔时间</td>
                    <td>{$this->row->interval_time}</td>
                </tr>
                <tr>
                    <td>备注</td>
                    <td>{$this->row->note}</td>
                </tr>
                <tr>
                    <td>到期时间</td>
                    <td>{$this->row->end_time}</td>
                </tr>

            </table>
      </b>
      </div>
    </div>
  </div>
</div>
EOT;
        }
        if($model == 'facebook')
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
      <div class="modal-body" style="margin-top:50px;color:#000;">
      <b>
            <table class="table table-bordered table-hover" style="table-layout:fixed;">
                <tr>
                    <td>ID</td>
                    <td>{$this->row->id}</td>
                </tr>
                <tr>
                    <td>地区</td>
                    <td>{$this->row->area}</td>
                </tr>
                <tr>
                    <td>加好友(Bool)</td>
                    <td>{$this->row->addfriend_bool}</td>
                </tr>
                <tr>
                    <td>加好友(数量)</td>
                    <td>{$this->row->addfriend_num}</td>
                </tr>
                <tr>
                    <td>接受请求(Bool)</td>
                    <td>{$this->row->acceptrequest_bool}</td>
                </tr>
                <tr>
                    <td>接受请求(数量)</td>
                    <td>{$this->row->acceptrequest_num}</td>
                </tr>
                <tr>
                    <td>拉进小组(Bool)</td>
                    <td>{$this->row->intogroup_bool}</td>
                </tr>
                <tr>
                    <td>拉进小组(名字)</td>
                    <td>{$this->row->intogroup_groupname}</td>
                </tr>
                <tr>
                    <td>拉进小组(人数)</td>
                    <td>{$this->row->intogroup_number}</td>
                </tr>
                <tr>
                    <td>点赞(Bool)</td>
                    <td>{$this->row->pointzan_bool}</td>
                </tr>
                <tr>
                    <td>点赞(数量)</td>
                    <td>{$this->row->pointzan_num}</td>
                </tr>
                <tr>
                    <td>共同好友(Bool)</td>
                    <td>{$this->row->mutualfriend_bool}</td>
                </tr>
                <tr>
                    <td>共同好友(数量)</td>
                    <td>{$this->row->mutualfriend_num}</td>
                </tr>
                <tr>
                    <td>指定小组(Bool)</td>
                    <td>{$this->row->appointgroup_bool}</td>
                </tr>
                <tr>
                    <td>指定小组(名字)</td>
                    <td>{$this->row->appointgroup_name}</td>
                </tr>
                <tr>
                    <td>指定小组(人数)</td>
                    <td>{$this->row->appointgroup_number}</td>
                </tr>
                <tr>
                    <td>通讯录(Bool)</td>
                    <td>{$this->row->contactadd_bool}</td>
                </tr>
                <tr>
                    <td>通讯录(人数)</td>
                    <td>{$this->row->contactadd_number}</td>
                </tr>
                <tr>
                    <td>间隔时长</td>
                    <td>{$this->row->intervaltime_num}</td>
                </tr>
                <tr>
                    <td>所属用户</td>
                    <td>{$name}</td>
                </tr>
                <tr>
                    <td>备注</td>
                    <td>{$this->row->note}</td>
                </tr>
                <tr>
                    <td>到期时间</td>
                    <td>{$this->row->end_time}</td>
                </tr>

            </table>
      </b>
      </div>
    </div>
  </div>
</div>
EOT;
        }
        if($model == 'messenger')
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
      <div class="modal-body" style="margin-top:50px;color:#000;">
      <b>
            <table class="table table-bordered table-hover" style="table-layout:fixed;">
                <tr>
                    <td>ID</td>
                    <td>{$this->row->id}</td>
                </tr>
                <tr>
                    <td>接受请求(Bool)</td>
                    <td>{$this->row->acceptrequest_bool}</td>
                </tr>
                <tr>
                    <td>接受请求(数量)</td>
                    <td>{$this->row->acceptrequest_num}</td>
                </tr>
                <tr>
                    <td>发送请求(Bool)</td>
                    <td>{$this->row->sendmessage_bool}</td>
                </tr>
                <tr>
                    <td>发送请求(数量)</td>
                    <td>{$this->row->sendmessage_num}</td>
                </tr>
                <tr>
                    <td>添加朋友(Bool)</td>
                    <td>{$this->row->addfriend_bool}</td>
                </tr>
                <tr>
                    <td>添加朋友(数量)</td>
                    <td>{$this->row->addfriend_num}</td>
                </tr>
                <tr>
                    <td>发送内容</td>
                    <td>{$this->row->content}</td>
                </tr>
                <tr>
                    <td>共同朋友</td>
                    <td>{$this->row->mutualfriend_num}</td>
                </tr>
                <tr>
                    <td>间隔时长</td>
                    <td>{$this->row->intervaltime}</td>
                </tr>
                <tr>
                    <td>所属用户</td>
                    <td>{$name}</td>
                </tr>
                <tr>
                    <td>备注</td>
                    <td>{$this->row->note}</td>
                </tr>
                <tr>
                    <td>到期时间</td>
                    <td>{$this->row->end_time}</td>
                </tr>
            </table>
      </b>
      </div>
    </div>
  </div>
</div>
EOT;
        }
        if($model == 'wish')
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
      <div class="modal-body" style="margin-top:50px;color:#000;">
      <b>
            <table class="table table-bordered table-hover" style="table-layout:fixed;">
                <tr>
                    <td>ID</td>
                    <td>{$this->row->id}</td>
                </tr>
                <tr>
                    <td>是否注册</td>
                    <td>{$this->row->isRegister}</td>
                </tr>
                <tr>
                    <td>是否自动点赞</td>
                    <td>{$this->row->isAutoLike}</td>
                </tr>
                <tr>
                    <td>是否添加地址</td>
                    <td>{$this->row->isAddAddress}</td>
                </tr>
                <tr>
                    <td>是否自动购买</td>
                    <td>{$this->row->isAutoBuy}</td>
                </tr>
                <tr>
                    <td>商品名称</td>
                    <td>{$this->row->goodsName}</td>
                </tr>
                <tr>
                    <td>商品清单</td>
                    <td>{$this->row->goodsList}</td>
                </tr>
                <tr>
                    <td>间隔时长</td>
                    <td>{$this->row->intervalTime}</td>
                </tr>
                <tr>
                    <td>所属用户</td>
                    <td>{$name}</td>
                </tr>
                <tr>
                    <td>备注</td>
                    <td>{$this->row->note}</td>
                </tr>
                <tr>
                    <td>到期时间</td>
                    <td>{$this->row->end_time}</td>
                </tr>
            </table>
      </b>
      </div>
    </div>
  </div>
</div>
EOT;
        }
        if($model == 'whatsapp')
        {
            return <<<EOT
<!-- Button trigger modal -->
<a style="color:#0ba8cc;font-weight:bold;cursor:pointer;" href="whatsapp/telephones/{$this->row->id}">
  {$this->row->machine_code}
</a>
EOT;

        }
        if($model == 'line')
        {
            return <<<EOT
<!-- Button trigger modal -->
<a style="color:#0ba8cc;font-weight:bold;cursor:pointer;" href="line/telephones/{$this->row->id}">
  {$this->row->machine_code}
</a>
EOT;

        }
        if($model == 'amazon2')
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
      <div class="modal-body" style="margin-top:50px;color:#000;">
      <b>
            <table class="table table-bordered table-hover" style="table-layout:fixed;">
                <tr>
                    <td>ID</td>
                    <td>{$this->row->id}</td>
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
                    <td>匹配商品名(Prime)</td>
                    <td>{$this->row->m_prime}</td>
                </tr>
                <tr>
                    <td>关联商品名</td>
                    <td>{$this->row->relation_name}</td>
                </tr>
                <tr>
                    <td>间隔时间</td>
                    <td>{$this->row->interval_minute}分{$this->row->interval_second}秒</td>
                </tr>
                <tr>
                    <td>上网工具</td>
                    <td>{$this->row->vpn}</td>
                </tr>
                <tr>
                    <td>街道</td>
                    <td>{$this->row->street}</td>
                </tr>
                <tr>
                    <td>城市名</td>
                    <td>{$this->row->city}</td>
                </tr>
                <tr>
                    <td>州名</td>
                    <td>{$this->row->state}</td>
                </tr>
                <tr>
                    <td>邮编</td>
                    <td>{$this->row->zip}</td>
                </tr>
                <tr>
                    <td>联系方式</td>
                    <td>{$this->row->contact}</td>
                </tr>
                <tr>
                    <td>卡号</td>
                    <td>{$this->row->card_num}</td>
                </tr>
                <tr>
                    <td>到期月</td>
                    <td>{$this->row->end_month}</td>
                </tr>
                <tr>
                    <td>到期年</td>
                    <td>{$this->row->end_year}</td>
                </tr>
                <tr>
                    <td>所属用户</td>
                    <td>{$name}</td>
                </tr>
                <tr>
                    <td>备注</td>
                    <td>{$this->row->note}</td>
                </tr>
                <tr>
                    <td>到期时间</td>
                    <td>{$this->row->end_time}</td>
                </tr>
            </table>
      </b>
      </div>
    </div>
  </div>
</div>
EOT;
        }
        if($model == 'instagram')
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
      <div class="modal-body" style="margin-top:50px;color:#000;">
      <b>
            <table class="table table-bordered table-hover" style="table-layout:fixed;">
                <tr>
                    <td>ID</td>
                    <td>{$this->row->id}</td>
                </tr>
                <tr>
                    <td>首次运行授权码</td>
                    <td>{$this->row->auth_code}</td>
                </tr>
                <tr>
                    <td>评论输入框</td>
                    <td>{$this->row->comment}</td>
                </tr>
                <tr>
                    <td>搜索话题</td>
                    <td>{$this->row->topic}</td>
                </tr>
                <tr>
                    <td>给粉丝发消息</td>
                    <td>{$this->row->message}</td>
                </tr>
                <tr>
                    <td>上传照片数量</td>
                    <td>{$this->row->images_num}</td>
                </tr>
                <tr>
                    <td>评论发布照片</td>
                    <td>{$this->row->comment_images}</td>
                </tr>
                <tr>
                    <td>人物点击间隔时间</td>
                    <td>{$this->row->interval_time}</td>
                </tr>
                <tr>
                    <td>每轮运行间隔</td>
                    <td>{$this->row->round_time}</td>
                </tr>
                <tr>
                    <td>所属用户</td>
                    <td>{$name}</td>
                </tr>
                <tr>
                    <td>到期时间</td>
                    <td>{$this->row->end_time}</td>
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
}


