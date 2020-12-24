<?php 
namespace app\api\controller;

use app\api\controller\BaseController;
use think\facade\Log;

class OrderController extends BaseController{
    
    /**
	 * 回调
	 */
	public function callBack(){
	    $callback_ip = get_client_ip();
	    $ip_whitelist = [
	        '119.167.182.109',
	        '124.156.19.131',
	        '45.207.63.12',
	        '45.207.63.13',
	        '45.207.62.42',
	        '119.28.250.51', //提现回调ip,以上是充值回调
	        '156.230.4.79'
        ];

        $data = input('param.');
        //var_dump($data);exit;
        if(in_array($callback_ip,$ip_whitelist)){
            $data = input('param.');
            Log::write("孟加支付异步通知====\r\n参数：".var_export($data,true)."\r\n");
            if (!$data) {
                echo 'failed';die;
            }
            if(is_array($data)){
                $data_arr = $data;
            }
            if(is_string($data)){
                $data_arr = json_decode($data,true);
            }
            
            $callback_order = model('UserRecharge')->where('order_number',$data_arr['sh_order'])->find();
            if(!empty($callback_order)){
                model('manage/UserRecharge')->rechargeDispose($callback_order);
            }
            model('UserWithdrawals')->where('order_number',$data_arr['sh_order'])->setField('state',1);
            echo 'success';die;
        }
        echo 'failed';die;
	}
	
	//创建订单接口
	//返回支付页面 paymentUrl
	//直接创建订单 跳转 页面提交入库
	public function createOrder(){
		$data = model('Order')->createOrder();
		return json($data);
	}

	//订单详细
	public function orderDetail(){

		$data = model('Order')->orderDetail();
		return json($data);

	}
	
	//订单列表
	public function orderList(){

		$data = model('Order')->orderList();
		return json($data);
		
	}
	
	//付息还本记录
	public function orderRecordList(){

		$data = model('Order')->orderRecordList();
		return json($data);
		
	}
	
	//合同
	public function hetong(){

		$data = model('Order')->hetong();
		return json($data);
		
	}
	
	//付息还本
	public function repayMent(){

		$data = model('Order')->repayMent();
		return json($data);
		
	}
	
}