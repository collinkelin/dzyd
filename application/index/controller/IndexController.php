<?php
namespace app\index\controller;

use think\Controller;

class IndexController extends Controller{
    public function index()
    {
        $data = model('Setting')->getFieldsById();
        
        $url = "http://".$_SERVER['SERVER_NAME']."/".$data['fengge'].'/index.html';
        
     
        
        $this->redirect($url);
       
    }
}
