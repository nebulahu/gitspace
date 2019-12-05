<?php
$serv = new Swoole\Server("127.0.0.1",9501);

$serv->on('Connect',function($serv,$fd){
	echo "Cilent:Connect.\n";
});

$serv->on('Receive',function($serv,$fd,$from_id,$data){
	$serv->send($fd,"Server:".$data);
});

$serv->on('Close',function($serv,$fd){
	echo "Client:Close.\n";
});

$serv->start();
?>
