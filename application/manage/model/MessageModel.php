<?php
namespace app\manage\model;

use think\Model;

class MessageModel extends Model{
	//表名
	protected $table = 'ly_message';

	public function secret(){
		if(!request()->isAjax()) return '非法提交';
		$param = input('post.','','trim');//获取参数
		if (!$param) return '提交失败';

		//数据验证
		// $validate = validate('app\manage\validate\Users');
		// if (!$validate->scene('secretAdd')->check($param)) return $validate->getError();
		
		$param['add_time'] = time();
		$res = $this->insertGetId($param);
		if (!$res) return '提交失败';

		return 1;
	}
}