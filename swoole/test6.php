<?php
$client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC); //异步非阻塞

$client->_count = 0;
$client->on("connect", function(swoole_client $cli) {
    $cli->send("GET / HTTP/1.1\r\n\r\n");
});

$client->on("receive", function(swoole_client $cli, $data){
    echo "Receive: $data";
    $cli->_count++;
    if ($cli->_count > 5)
    {
        //睡眠模式，不再接收新的数据
        echo "count=10, sleep(5000ms)\n";
        $cli->sleep();
        $cli->_count = 0;
        swoole_timer_after(5000, function() use ($cli) {
            //唤醒
            $cli->wakeup();
        });
        return;
    }
    else
    {
        $cli->send(str_repeat('A', 100)."\n");
    }
});

$client->on("error", function(swoole_client $cli){
    echo "error\n";
});

$client->on("close", function(swoole_client $cli){
    echo "Connection close\n";
});

$client->connect('127.0.0.1', 9501,1);
