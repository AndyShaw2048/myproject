<div class="layui-collapse">
    <div class="layui-colla-item">
        <h2 class="layui-colla-title" style="border-radius: 10px;background-color: #dde1e6">批量修改（<span style="color: darkcyan">留空则不修改当前项的值</span>）</h2>
        <div class="layui-colla-content">
            <form class="layui-form" action="" method="post">
                {{csrf_field()}}
                <p style="font-size: 14px;margin-top: 10px;margin-left: 20px;font-weight: bold">所属机器码</p>
                <hr>
                <div class="layui-form-item">
                    <label class="layui-form-label">备&nbsp;&nbsp;&nbsp;注</label>
                    <div class="layui-input-block">
                        <input type="text" name="note" autocomplete="off" class="layui-input">
                    </div>
                </div>

                <p style="font-size: 14px;margin-top: 10px;margin-left: 20px;font-weight: bold">功能勾选</p>
                <hr>
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width: 165px;">第一次执行功能</label>
                    <div class="layui-input-inline">
                        <select name="first_run">
                            <option value=""></option>
                            <option value="0">未选择</option>
                            <option value="1">自动购买</option>
                            <option value="2">强制关联</option>
                            <option value="3">点击广告</option>
                            <option value="4">关键词上首页</option>
                            <option value="5">删除差评</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width: 165px;">第二次执行功能</label>
                    <div class="layui-input-inline">
                        <select name="second_run">
                            <option value=""></option>
                            <option value="0">未选择</option>
                            <option value="1">自动购买</option>
                            <option value="2">强制关联</option>
                            <option value="3">点击广告</option>
                            <option value="4">关键词上首页</option>
                            <option value="5">删除差评</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width: 165px;">第三次执行功能</label>
                    <div class="layui-input-inline">
                        <select name="third_run">
                            <option value=""></option>
                            <option value="0">未选择</option>
                            <option value="1">自动购买</option>
                            <option value="2">强制关联</option>
                            <option value="3">点击广告</option>
                            <option value="4">关键词上首页</option>
                            <option value="5">删除差评</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width: 165px;">第四次执行功能</label>
                    <div class="layui-input-inline">
                        <select name="fourth_run">
                            <option value=""></option>
                            <option value="0">未选择</option>
                            <option value="1">自动购买</option>
                            <option value="2">强制关联</option>
                            <option value="3">点击广告</option>
                            <option value="4">关键词上首页</option>
                            <option value="5">删除差评</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width: 165px;">第五次执行功能</label>
                    <div class="layui-input-inline">
                        <select name="fifth_run">
                            <option value=""></option>
                            <option value="0">未选择</option>
                            <option value="1">自动购买</option>
                            <option value="2">强制关联</option>
                            <option value="3">点击广告</option>
                            <option value="4">关键词上首页</option>
                            <option value="5">删除差评</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width: 165px;">运行速度</label>
                    <div class="layui-input-inline">
                        <select name="run_speed">
                            <option value=""></option>
                            <option value="2">正常</option>
                            <option value="1">快</option>
                            <option value="3">慢</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">运行次数</label>
                    <div class="layui-input-block">
                        <input type="text" name="run_times" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">定时运行</label>
                    <div class="layui-input-inline">
                        <input style="width: 70px;margin-left: 10px" type="text" name="timing_run_hours"  placeholder="" autocomplete="off" class="layui-input">
                    </div>
                    时
                    <div class="layui-input-inline">
                        <input style="width: 70px" type="text" name="timing_run_minutes"  placeholder="" autocomplete="off" class="layui-input">
                    </div>
                    分
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">等待时间</label>
                    <div class="layui-input-block">
                        <input type="text" name="each_time_interval" autocomplete="off" class="layui-input">
                    </div>
                </div>

                <p style="font-size: 14px;margin-top: 10px;margin-left: 20px;font-weight: bold">功能编辑</p>
                <hr>
                <div class="layui-collapse" lay-accordion="">
                    <div class="layui-colla-item">
                        <h2 class="layui-colla-title">自动购买</h2>
                        <div class="layui-colla-content layui-show">
                            <div class="layui-inline">
                                <div class="layui-input-inline">
                                    <input type="checkbox" name="auto_buy_prime" title="Prime">
                                </div>
                                <div class="layui-inline">
                                    <label class="layui-form-label" style="width: 130px">关键词</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="auto_buy_keyword" placeholder="" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-inline">
                                    <label class="layui-form-label" style="width: 130px">匹配商品</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="auto_buy_item" placeholder="" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-colla-item">
                        <h2 class="layui-colla-title">强制关联</h2>
                        <div class="layui-colla-content">
                            <div class="layui-inline">
                                <div class="layui-input-inline">
                                    <input type="checkbox" name="relevance_item_prime" title="Prime">
                                </div>
                                <div class="layui-inline">
                                    <label class="layui-form-label" style="width: 130px">关键词1</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="relevance_item_keyword_one" placeholder="" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-inline">
                                    <label class="layui-form-label" style="width: 130px">匹配商品1</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="relevance_item_item_one" placeholder="" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <br>
                                <div class="layui-inline">
                                    <label class="layui-form-label" style="width: 130px;margin-left: 102px">关键词2</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="relevance_item_keyword_two" placeholder="" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-inline">
                                    <label class="layui-form-label" style="width: 130px">匹配商品2</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="relevance_item_item_two" placeholder="" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-colla-item">
                        <h2 class="layui-colla-title">点击广告</h2>
                        <div class="layui-colla-content">
                            <div class="layui-inline">
                                <div class="layui-input-inline">
                                    <input type="checkbox" name="sponsored_prime" title="Prime">
                                </div>
                                <div class="layui-inline">
                                    <label class="layui-form-label" style="width: 130px">关键词</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="sponsored_keyword" placeholder="" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-colla-item">
                        <h2 class="layui-colla-title">关键词上首页</h2>
                        <div class="layui-colla-content">
                            <div class="layui-inline">
                                <div class="layui-input-inline">
                                    <input type="checkbox" name="keyword_top_prime" title="Prime">
                                </div>
                                <div class="layui-inline">
                                    <label class="layui-form-label" style="width: 130px">关键词</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="keyword_top_keyword" placeholder="" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-inline">
                                    <label class="layui-form-label" style="width: 130px">匹配商品</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="keyword_top_item" placeholder="" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-colla-item">
                        <h2 class="layui-colla-title">删除差评</h2>
                        <div class="layui-colla-content">
                            <div class="layui-inline">
                                <div class="layui-input-inline">
                                    <input type="checkbox" name="delete_review_prime" title="Prime">
                                </div>
                                <div class="layui-inline">
                                    <label class="layui-form-label" style="width: 130px">关键词</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="delete_review_keyword" placeholder="" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-inline">
                                    <label class="layui-form-label" style="width: 130px">匹配商品</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="delete_review_item" placeholder="" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="editForm">立即提交</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    //注意：折叠面板 依赖 element 模块，否则无法进行功能性操作
    layui.use('element', function(){
        var element = layui.element;
        element.render();
        //…
    });
    //Demo
    layui.use('form', function(){
        var form = layui.form;
        form.render();
        //监听提交
        form.on('submit(editForm)', function(data){
//            layer.msg(JSON.stringify(data.field));
            //获取多选框的值
            obj = document.getElementsByClassName('grid-row-checkbox');
            check_val = [];
            for(k in obj){
                if(obj[k].checked)
                    check_val.push(obj[k].getAttribute('data-id'));
            }
            console.log(check_val);

            if (check_val.length == 0)
            {
                toastr.warning('请勾选需要修改的信息');
            }
            else {
                $.ajax({
                    type: 'POST',
                    url: '/amazonThr',
                    data: {multi:check_val,
                        data:data.field},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(data){
                        window.setTimeout("window.location='/admin/amazonThr'",2000);
                        toastr.success('更新成功');
                    },
                    error: function(xhr, type){
                        toastr.error('更新失败');
                    }
                });
            }

            return false;
        });
    });
</script>