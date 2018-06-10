<?php

namespace App\Admin\Extensions;

use Encore\Admin\Admin;

class Renewal
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
    console.log($(this).data('id'));
    id = $(this).data('id');
    window.setTimeout("window.location.href='renewal/'+id",0);

});

SCRIPT;
    }

    protected function render()
    {
        Admin::script($this->script());

        return "<a class='btn btn-xs  fa fa-credit-card grid-check-row' data-id='{$this->id}' title='续费'></a>";
    }

    public function __toString()
    {
        return $this->render();
    }
}