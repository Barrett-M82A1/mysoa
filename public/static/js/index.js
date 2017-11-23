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
        url: '/service/serviceList',
        //开启分页
        page: true,
        response: {
            statusName: 'code',
            statusCode: 1,
            msgName: 'msg',
            countName: 'total',
            dataName: 'data'
        },
        limit:10,
        cols: [[
            {field: 'id',type:'checkbox'},
            {field: 'name', title: '服务名称',sort: true,templet: '#titleTpl'},
            {field: 'num', title: '服务实例(个)',align: 'center'},
            {field: 'qq', title: '所属分组',sort: true},
            {field: 'group', title: '备注信息'}
        ]]
    });
});