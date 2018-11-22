<?php
/**
 * Created by PhpStorm.
 * User: dada
 * Date: 2018/11/20
 * Time: 19:39
 */

//redis键空间通知消息详解和例子
require_once 'Redis2.class.php';
require_once 'db.class.php';

$redis2 = new \Redis2();
$redis2->select(1);
$mysql = new \mysql();
$mysql->connect();

$data = ['ordersn' => 'SN' . time() . 'T' . rand(10000000, 99999999), 'status' => 0, 'createtime' => date('Y-m-d H:i:s', time())];

$mysql->insert('order', $data);

//订单号
$order_sn = $data['ordersn'];

//设置到redis中并设置10过期
$res = $redis2->setex($order_sn, 10, $order_sn);
if($res){
    echo 'set success!'.PHP_EOL;
}