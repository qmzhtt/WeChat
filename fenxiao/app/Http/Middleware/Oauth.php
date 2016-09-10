<?php

namespace App\Http\Middleware;
use EasyWeChat\Foundation\Application;

use Closure;

class Oauth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    protected $except = [
        'wx','login'
    ];

    protected function shouldPassThrough($request)
    {
        foreach ($this->except as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->is($except)) {
                return true;
            }
        }

        return false;
    }

    public function handle($request, Closure $next)
    {
        if($this->shouldPassThrough($request)){
            return $next($request);
        }
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
        $app = new Application($options);

        if(!session()->has('user')){
            $oauth = $app->oauth;
            session()->put('target_url',$request->path());
            return $oauth->redirect();
        }
        return $next($request);
    }
}
