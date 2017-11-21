<?php

// +----------------------------------------------------------------------
// | MySoa 后台导航设置
// +----------------------------------------------------------------------

return [

    //服务治理
    "service"   =>  [
        [
            "name"      =>  "服务治理",
            "url"       =>  "index/index",
            "ico"       =>  "615",
            "display"   =>  1
        ],[
            "name"      =>  "扩容缩容",
            "url"       =>  "Service/deploy",
            "ico"       =>  "615",
            "display"   =>  0
        ],[
            "name"      =>  "服务鉴权",
            "url"       =>  "Service/deploy",
            "ico"       =>  "615",
            "display"   =>  0
        ],[
            "name"      =>  "路由规则",
            "url"       =>  "Service/deploy",
            "ico"       =>  "615",
            "display"   =>  0
        ],[
            "name"      =>  "服务测试",
            "url"       =>  "Service/deploy",
            "ico"       =>  "615",
            "display"   =>  0
        ]
    ],

    //监控中心
    "monitor"   =>  [

    ],

    //系统设置
    "system"    =>  [
        [
            "name"      =>  "分组设置",
            "url"       =>  "System/index",
            "ico"       =>  "615",
            "display"   =>  1
        ],[
            "name"      =>  "管理员设置",
            "url"       =>  "Service/index",
            "ico"       =>  "615",
            "display"   =>  1
        ],
    ]
];
