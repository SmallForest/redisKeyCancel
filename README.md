### 应用背景
1. 订单下单30分钟内未支付，取消订单
2. 发布的求租 求购 拼团超时需求无人响应，退回押金
3. 各种可以使用超时来实现的业务  
### 应用原理
1. Redis setex 设置一个指定时间的key,setex order_no 1800 1  
2. 开启psubscribe监听key过期事件。注意setex psubscribe需要在同一个Redis db里面
###业务实现
1. 根据callback中的key,去处理业务~这里随意  
### Linux配置
1. 设置守护进程 nohup php psubscribe.php &
2. 关闭进程 ps aux | grep "nohup php psubscribe.php &" 找到pid 然后kill  
3. 设置自动启动  
### 参考地址
https://my.oschina.net/marhal/blog/1924622
