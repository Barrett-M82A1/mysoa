layui.use(['form','element','table','jquery','layer'], function(args){
    // 定义对象获取器
    var self = this;
    $ = function (name) {
        return self[name];
    };

    // 服务名称
    var name = $('jquery')('#service-name').html();

    /**
     * 获取服务信息
     */
    $('jquery').ajax({
        type: 'POST',
        url: '/service/queryInfo',
        data:{name:name},
        dataType: 'json',
        success: function(data){
            $('jquery')(".layui-badge").each(function(i,el){
                var key = el.id.substring(8);
                $('jquery')(el).html(data.data[key]);
            });
        },
        error: function(xhr){
            $('layer').msg('服务信息获取失败！');
        }
    });

    /**
     * 实例列表
     */
    $('table').render({
        elem: '#service-list',
        //数据接口
        url: '/service/exampleList',
        //开启分页
        page: true,
        response: {
            statusName: 'code',
            statusCode: 1,
            msgName: 'msg',
            countName: 'total',
            dataName: 'data'
        },
        limit:5,
        where: {name:name},
        cols: [[
            {field: 'ip', title: 'IP',sort: true},
            {field: 'port', title: '端口'},
            {field: 'authors_name', title: '开发者'},
            {field: 'account', title: '帐号'},
            {field: 'out_time', title: '超时时间(ms)',edit:'text'},
            {field: 'weight', title: '权重(100以内正整数)',edit:'text'},
            {field: 'status',title: '操作', align:'center', toolbar: '#barDemo'}
        ]]
    });

    /**
     * 消费者列表
     */
    $('table').render({
        elem: '#consumer-list',
        //数据接口
        url: '/service/consumerList',
        //开启分页
        page: true,
        response: {
            statusName: 'code',
            statusCode: 1,
            msgName: 'msg',
            countName: 'total',
            dataName: 'data'
        },
        limit:5,
        where: {name:name},
        cols: [[
            {field: 'app_name', title: '消费者名称'},
            {field: 'ip', title: 'IP',sort: true},
            {field: 'port', title: 'RPC端口'},
            {field: 'notify_port', title: '通知端口'}
        ]]
    });

    /**
     * 监听上下线操作
     */
    $('form').on('switch(setStatus)', function(obj){
        layer.load(1);
        var status;
        (obj.elem.checked) ? status = "1" : status ="0";
        $('jquery').ajax({
            type: 'POST',
            url: '/service/setExample',
            data:{id:obj.value,status:status},
            dataType: 'json',
            success: function(data){
                $('layer').closeAll('loading');
                $('layer').msg(data.msg);
            },
            error: function(xhr){
                $('layer').closeAll('loading');
                $('layer').msg('操作失败！');
            }
        });
    });

    /**
     * 监听单元格编辑
     */
    $('table').on('edit(service)', function(obj){
        layer.load(1);
        $('jquery').ajax({
            type: 'POST',
            url: '/service/setExample',
            data:{id:obj.data.id,weight:obj.value},
            dataType: 'json',
            success: function(data){
                $('layer').closeAll('loading');
                $('layer').msg(data.msg);
            },
            error: function(xhr){
                $('layer').closeAll('loading');
                $('layer').msg('操作失败！');
            }
        });
    });
});