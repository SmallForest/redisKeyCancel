<?php
/**
 * Created by PhpStorm.
 * User: dada
 * Date: 2018/11/20
 * Time: 19:40
 */

//ini_set('default_socket_timeout', -1);  //不超时

require_once 'Redis2.class.php';
require_once 'db.class.php';

$redis = new Redis2();
$redis->select(1);
// 解决Redis客户端订阅时候超时情况
$redis->setOption();

//创建事件监听，__keyevent@1__:expired，数字1代表数据库序号
$r = $redis->psubscribe(array('__keyevent@1__:expired'), 'keyCallback');
// 回调函数,这里写处理逻辑
function keyCallback($redis, $pattern, $chan, $msg)
{
    $mysql = new \mysql();
    $mysql->connect();
    $where = "ordersn = '" . $msg . "'";
    $mysql->select('order', '', $where);
    $finds = $mysql->fetchAll();

    if (isset($finds[0]['status']) && $finds[0]['status'] == 0) {
        $data  = array('status' => 3, 'updatetime' => date('Y-m-d H:i:s', time()));
        $where = "id = " . $finds[0]['id'];
        $mysql->update('order', $data, $where);
    }
}