layui.use(['jquery','layer','form'], function(args){

    // 定义对象获取器
    var self = this;
    $ = function (name) {
        return self[name];
    };

    // 欢迎信息
    $('layer').tips('欢迎登录MySoa服务治理中心！', '#tips',{
        time:false
    });

    // 提交表单
    $('form').on('submit(go)',function(data){
        $('jquery').ajax({
            type: 'POST',
            url: data.form.action,
            data:data.field,
            dataType: 'json',
            success: function(data){
                var url = data.url;
                if (data.code === 1){
                    $('layer').tips(data.msg, '#tips',{
                        time:1500,
                        success:function (data) {
                            setTimeout(function(){
                                //window.location.href = url;
                            },1000);
                        }
                    });
                }else{
                    $('layer').tips(data.msg, '#tips',{});
                }
            },
            error: function(xhr){
                $('layer').tips('登录失败！', '#tips',{});
            }
        });

        return false;
    });

});