<?php

use Encore\Admin\Grid\Column;
use App\Admin\Extensions\Drop;

Encore\Admin\Form::forget(['map', 'editor']);


app('view')->prependNamespace('admin', resource_path('views/admin'));

Column::extend('drop', Drop::class);