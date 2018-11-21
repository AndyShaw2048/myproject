<div class="am-panel am-panel-primary" style="border: none;padding: 0px  16px">
    <div class="am-panel-hd" style="background-color: white;color: black">
        <div style="float: left"><input id="checkAllGroup" type="checkbox" class="checkbix" data-text="" onclick="changeState(this.checked)"></div>
        分组列表 <a class="rename-btn" style="padding-left: 32px"></a></div>
    <div class="am-panel-bd">
        <div class="group">
            <div style="float: left"><input id="1" type="checkbox" class="checkbix checkbox-group" data-text="" name="checkbox-group"></div>
            分组一
            <a class="am-btn am-btn-primary am-btn-xs rename-btn" style="float: right">重命名</a>
        </div>
        <div class="group">
            <div style="float: left;"><input id="2" type="checkbox" class="checkbix checkbox-group" data-text="" name="checkbox-group"></div>
            分组一
            <a class="am-btn am-btn-primary am-btn-xs rename-btn" style="float: right">重命名</a>
        </div>
        <div class="group">
            <div style="float: left"><input id="3" type="checkbox" class="checkbix checkbox-group" data-text="" name="checkbox-group"></div>
            分组一
            <a class="am-btn am-btn-primary am-btn-xs rename-btn" style="float: right">重命名</a>
        </div>
    </div>
</div>
<div style="position: absolute;bottom: 0px;height: 36px;border-top: solid 1px lightgray;width: 100%;padding: 10px auto;">
    <a class="am-btn am-btn-success am-btn-xs" id="addGroup">添加分组</a>
    <a class="am-btn am-btn-warning am-btn-xs" onclick="delGroup()">删除分组</a>
</div>

{{--添加分组弹出层--}}
<div class="am-modal am-modal-prompt" tabindex="-1" id="addGroupPrompt">
    <div class="am-modal-dialog">
        {{--<div class="am-modal-hd">Amaze UI</div>--}}
        <div class="am-modal-bd">
            请输入分组名称
            <input type="text" class="am-modal-prompt-input">
        </div>
        <div class="am-modal-footer">
            <span class="am-modal-btn" data-am-modal-cancel>取消</span>
            <span class="am-modal-btn" data-am-modal-confirm>提交</span>
        </div>
    </div>
</div>
<script>
    //添加分组
    $(function() {
        $('#addGroup').on('click', function() {
            $('#addGroupPrompt').modal({
                relatedTarget: this,
                onConfirm: function(e) {
                    var _data = {
                        model:'facebook',
                        name: e.data
                    }
                    http("put","addgroup",_data,function(data){
                        console.log(data)
                    });
                },
                onCancel: function(e) {

                }
            });
        });
    });

    //删除分组
    function delGroup(){
        var ids = new Array();
        $("input[name='checkbox-group']:checked").each(function(){
            ids.push($(this).attr("id"))
        })
        if(ids.length==0){
            alert('请选择删除的分组');
            return;
        }
        var _data = {
            array : ids
        }

        http("delete","delgroup",_data,function(data){
            console.log(data)
        })
    }

    function showGroup(){
        http("get","showgroup",{model:"facebook"},function(data){
            console.log(data)
        })
    }
    showGroup();
</script>