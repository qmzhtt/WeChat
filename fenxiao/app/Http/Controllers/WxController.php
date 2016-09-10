<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use EasyWeChat\Foundation\Application;
use App\User;

use EasyWeChat\Message\Text;


use EasyWeChat\Message\Raw;




class WxController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
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
            //...
        ];
        //新建一个项目
        $this->app = new Application($options);
    }
    public function index(){
        //创建微信服务器
        $server = $this->app->server;
        //在微信服务器上监听事件/消息
        $server->setMessageHandler(function($message){

            // 注意，这里的 $message 不仅仅是用户发来的消息，也可能是事件
            // 当 $message->MsgType 为 event 时为事件
            if ($message->MsgType == 'event'){
                if($message->Event == 'subscribe') {
                    return $this->subs($message);
                }elseif($message->Event == 'unsubscribe'){
                    return $this->unsubs($message);
                }
            }elseif($message->MsgType == 'text'){
                return $this->text();
            }elseif($message->MsgType == 'image'){
                return $this->image();
            }elseif($message->MsgType == 'voice'){
                return $this->text();
            }
        });

        // 将响应输出
        $response = $server->serve();
        return $response; // Laravel 里请使用：return $response;
    }
    public function subs($message){
        //判断数据库有没有用户信息
        $user = User::where('openid',$message->FromUserName)->first();
        if($user){
            if($user->status == 0){
                $user->status = 1;
                $user->save();
                return '再次欢迎你!我是迎风流鼻涕!!!叫上你的小伙伴一块关注我吧!';
            }
        }else{
            $user = new User();
            if(empty($message->EventKey)){
                $user->p1 = 0;
                $user->p2 = 0;
                $user->p3 = 0;
            }else{
                $pid = substr($message->EventKey,8);
                $p = User::find($pid);
                $user->p1 = $pid;
                $user->p2 = $p->p1;
                $user->p3 = $p->p2;
            }
            $userService = $this->app->user;
            $fans = $userService->get($message->FromUserName);

            $user->openid = $message->FromUserName;
            $user->name = $fans->nickname;
            $user->subtime = time();
            $user->status = 1;
            $user->save();
            //生成场景二维码
            $user->qrimg = $this->qrcode($user->uid);
            $user->save();
            return  $text = new Text(['content' => '欢迎你呀!我是迎风流鼻涕!!!叫上你的小伙伴一块关注我吧!']);
           
        }
    }
    public function unsubs($message){
        $fans = User::where('openid',$message->FromUserName)->first();
        if($fans){
            $fans->status = 0;
            $fans->save();
        }
    }
    public function text(){

        return $text = new Text(['content' => '不知道你说的什么,找小编聊聊吧,微信hh037691']);
    }
    public function image(){
        return $text = new Text(['content' => '我不认识图片,找小编聊聊吧,微信hh037691']);
    }
    public function voice(){
        return $text = new Text(['content' => '我听不懂哦,找小编聊聊吧,微信hh037691']);
    }
    
    public function qrcode($uid){
        $qrcode = $this->app->qrcode;
        $result = $qrcode->forever($uid);
        $ticket = $result->ticket; // 或者 $result['ticket']
        $url = $qrcode->url($ticket);
        //二维码保存到公众号服务器
        $img = file_get_contents($url); // 得到二进制图片内容
        $path = public_path(date('/Y/md/'));
        if(!file_exists($path)){
            mkdir($path,"0777",true);
        }
        $filename = "qrimg_{$uid}.jpg";
        file_put_contents($path.$filename, $img);
        return date('/Y/md/').$filename;

    }
       
}

    