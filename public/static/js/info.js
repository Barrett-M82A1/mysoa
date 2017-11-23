layui.use(['form','element','table'], function(args){
    // 定义对象获取器
    var self = this;
    $ = function (name) {
        return self[name];
    };

    $('form').render();

    //第一个实例
    $('table').render({
        elem: '#demo',
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
        where: {name: 'StudentUserService'},
        cols: [[
            {field: 'id',type:'checkbox'},
            {field: 'ip', title: 'IP',sort: true},
            {field: 'port', title: '端口'},
            {field: 'authors_name', title: '开发者'},
            {field: 'account', title: '帐号'},
            {field: 'out_time', title: '超时时间(ms)'},
            {field: 'weight', title: '权重'},
            {field: 'status', title: '状态'}
        ]]
    });
});