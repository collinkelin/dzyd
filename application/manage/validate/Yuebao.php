<?php

namespace app\manage\validate;

use think\Validate;

class Yuebao extends Validate
{
    protected $rule =   [
        //活动添加
        'title'             =>  'require',
        'lilv'              =>  'require',
        'time'              =>  'require',
    ];

    protected $message =   [
        'title.require'             =>  '标题必须填写',
        'lilv.require'              =>  '利率必须填写',
        'time.require'              =>  '时间必须填写',
    ];

//    protected $scene = [
//        'activityadd'           =>  ['title','date_range','sort','state','explain'],
//        'everyday'              =>  ['date'],
//        'between'               =>  ['startdate','enddate'],
//    ];
}