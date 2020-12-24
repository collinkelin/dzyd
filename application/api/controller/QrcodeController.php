<?php 
namespace app\api\controller;

use think\Cache;

use app\api\controller\BaseController;

class QrcodeController extends BaseController{
	
	public function addQrcode(){
		$data = model('Qrcode')->addQrcode();
		return json($data);
	}
	
	
	public function getQrcodeList(){
		$data = model('Qrcode')->getQrcodeList();
		return json($data);
	}
	
	
	public function getQrcodeInfo(){
		$data = model('Qrcode')->getQrcodeInfo();
		return json($data);
	}
	
	
	public function changeQrcodeInfo(){
		$data = model('Qrcode')->changeQrcodeInfo();
		return json($data);
	}
}