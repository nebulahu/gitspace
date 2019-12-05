<?php
$ws = new swoole_websocket_server('0.0.0.0',9502);
$ws->on('open',function($ws,$request){
	var_dump($request->fd);
	$ws->push($request->fd,"hello,welcome.\n");
});
$ws->on('message',function($ws,$frame){
	echo "Message:{$frame->$data}\n";
	$ws->push($frame->fd,"Server:{$frame->data}");
});
$ws->on('close',function($ws,$fd){
	echo "close-{$fd} is closed\n";
});
$ws->start();
?>