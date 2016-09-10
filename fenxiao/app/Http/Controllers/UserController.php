<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use EasyWeChat\Foundation\Application;
use App\User;

class UserController extends Controller
{
	protected $app; 
	public function __construct(){
	    $options = [
	        'debug'  => true,
	        'app_id' => 'wxbab5c90ecf5a7af3',
	        'secret' => '61a4377cfb8d1e5582945e20f6902b8b',
	        'token'  => 'qqtest',
	        // 'aes_key' => null, // 可选
	        'log' => [
	            'level' => 'debug',
	            'file'  => 'F:/xampp/htdocs/fenxiao/public/wechat.log', // XXX: 绝对路径！！！！
	        ],
	        'oauth' => [
			    'scopes'   => ['snsapi_userinfo'],
			    'callback' => '/login',
		    ]
	    ];
	    //新建一个项目
        $this->app = new Application($options);
	}
	
    public function login(){
    	$oauth = $this->app->oauth;
    	//微信提供的用户信息,并放入数组
    	$user = $oauth->user()->toArray();
    	// 查出用户表中用户的uid,并存入session
    	$userinfo = User::where('openid',$user['id'])->first();
    	if(!$userinfo){
    		$user['uid'] = $userinfo->uid;
    	}else{
    		$user['uid'] = 0;
    	}
    	session()->put('user',$user);
    	$targetUrl = (session()->has('target_url')) ? (session()->get('target_url')) : 'center';
        return redirect($targetUrl);
    }
    public function logout(){
    	session()->forget('user');
    }
    public function center(Request $req){
    	if(!$req->session()->has('user')){
    		$oauth = $this->app->oauth;
    		session()->put('target_url','center');
    		return $oauth->redirect();
    	}
    	return '登录成功';
    }
}
