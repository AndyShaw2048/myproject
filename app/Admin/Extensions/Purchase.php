<?php

namespace App\Admin\Extensions;

use Encore\Admin\Admin;

class Purchase
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    protected function script()
    {
        return <<<SCRIPT

$('.grid-check-row').on('click', function () {

    // Your code.
    var id = $(this).data('id');

    swal({
      title: "确认购买?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "确认",
      closeOnConfirm: false,
      cancelButtonText: "取消"
    },
    function(){
        $.ajax({
            method: 'post',
            url: '/admin/dla/' + id,
            data: {

            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success: function (data) {
                if(data['code'] == 2000)
                {
                    swal(data['msg'], '', 'success');
                    $.pjax.reload('#pjax-container');
                }
                else
                {
                    swal(data['msg'], '', 'warning');
                }
            }
        });
    });

});

SCRIPT;
    }

    protected function render()
    {
        Admin::script($this->script());

        return "<a class='btn btn-xs  fa fa-money grid-check-row' data-id='{$this->id}'></a>";
    }

    public function __toString()
    {
        return $this->render();
    }
}