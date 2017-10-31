<?php
/**
 * HTTP服务器
 * swoole_http_server 8088
 */
$http = new swoole_http_server("0.0.0.0",8088);

$http->on("start", function ($server) {
    echo "Swoole http server is started at http://127.0.0.1:8088\n";
});

$http->on("request", function ($request, $response) {
    $response->header("Content-Type", "text/plain");
    $response->end("Hello World\n".json_encode(['hello'=>'nihao'.time()]));
});

$http->start();