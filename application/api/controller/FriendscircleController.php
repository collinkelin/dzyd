<?php 
namespace app\api\controller;

use app\api\controller\BaseController;

class FriendscircleController extends BaseController{
	
	// 留言
	public function makeMessage(){
		$data = model('FriendsCircleMessage')->makeMessage();
		return json($data);
	}
	
	// 评论
	public function makeComment(){
		$data = model('FriendsCircleComment')->makeComment();
		return json($data);
	}
	
	// 删除留言及评论
	public function deleteMessage(){
		$data = model('FriendsCircleMessage')->deleteMessage();
		return json($data);
	}
	
	// 获取留言及评论列表
	public function getMessageList(){
		$data = model('FriendsCircleMessage')->getMessageList();
		return json($data);
	}
	
	// 留言点赞开关
	public function switchThumbsup(){
		$data = model('FriendsCircleMessage')->switchThumbsup();
		return json($data);
	}
	
	// 设置留言状态
	/*
	public function	setMessageStatus(){
		$data = model('FriendsCircleMessage')->setMessageStatus();
		return json($data);
	}
	*/
	
	//获取朋友列表
	public function getfriendslist(){
		$data = model('FriendsCircleMessage')->getfriendslist();
		return json($data);
	}
	
	//获取朋友信息
	public function getfriendsinfo(){
		$data = model('FriendsCircleMessage')->getfriendsinfo();
		return json($data);
	}

	
}