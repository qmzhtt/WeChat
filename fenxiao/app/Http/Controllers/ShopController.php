<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\User;
use Cart;
use App\Order;
use App\Item;
use App\Fee;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Payment\Order as WxOrder;


class ShopController extends Controller
{
   
    $options = [
        // 前面的appid什么的也得保留哦
        'app_id' => 'xxxx',
        // ...
        // payment
        'payment' => [
            'merchant_id'        => 'your-mch-id',
            'key'                => 'key-for-signature',
            'cert_path'          => 'path/to/your/cert.pem', // XXX: 绝对路径！！！！
            'key_path'           => 'path/to/your/key',      // XXX: 绝对路径！！！！
            'notify_url'         => '默认的订单回调地址',       // 你也可以在下单时单独设置来想覆盖它
            ''
            // 'device_info'     => '013467007045764',
            // 'sub_app_id'      => '',
            // 'sub_merchant_id' => '',
            // ...
        ],
    ];
    $app = new Application($options);
    


	protected $goods = [
		1=>['goods_id'=>1,'goods_name'=>'Cherry','description'=>'原厂信仰','price'=>235.6],
		2=>['goods_id'=>2,'goods_name'=>'Filco','description'=>'做工信仰','price'=>235.7],
		3=>['goods_id'=>3,'goods_name'=>'赛睿','description'=>'钢厂信仰','price'=>235.8],
		4=>['goods_id'=>4,'goods_name'=>'雷蛇','description'=>'灯厂信仰','price'=>235.9],
	];
    public function index(){
    	return view('index',['goods'=>$this->goods]);
    }
    public function goods($id){
    	return view('goods',['gd'=>$this->goods[$id]]);
    }
    public function buy($id){
    	$g = $this->goods[$id];
    	Cart::add(array(
		    'id' => $id,
		    'name' => $g['goods_name'],
		    'price' => $g['price'],
		    'quantity' => 1,
		    'attributes' => array()
		));
		return redirect('/cart');
    }
    public function cart(Request $req){
    	if(!$req->session()->has('user')){
    		
    		return redirect('/center');
    	}
    	$goods = Cart::getContent();
    	$sub = Cart::getSubTotal();
        return view('cart',['goods'=>$goods,'sub'=>$sub]);
    }
    public function clear(){
    	Cart::clear();
    }
    public function order(Request $req){
    	$goods = Cart::getContent();
    	if(empty($goods)){
    		return '购物车为空';
    	}
    	$order = new Order();
    	$order->ordsn = date('Ymd').mt_rand(1000000,9999999);
    	//$order->uid = session()->get('user')['uid'];
    	$order->openid = session()->get('user')['id'];
    	$order->address = $req->address;
    	$order->name = $req->name;
    	$order->tel = $req->tel;
    	$order->money = Cart::getTotal();
    	$order->ordtime = time();
    	$order->ispay = 0;
    	$order->save();

    	foreach($goods as $g){
	    	$item = new Item();
	        $item->oid = $order->oid;
	        $item->gid = $g->id;
	        $item->goods_name = $g->name;
	        $item->price = $g->price;
	        $item->amount = $g->quantity;

	        $item->save();
    	}
     	$money = Cart::getTotal();
        //创建微信应用
        //1.创建支付对象
        $payment = $this->app->payment;
        //2.创建订单对象
        $attributes = [
            'trade_type'       => 'JSAPI', // JSAPI，NATIVE，APP...
            'body'             => 'iPad mini 16G 白色',
            'detail'           => 'iPad mini 16G 白色',
            'out_trade_no'     => '1217752501201407033233368018',
            'total_fee'        => 5388,//价格以分表示的
            'notify_url'       => 'http://xxx.com/order-notify', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'openid'           => $order->openid,
            // ...
        ];
        $wxorder = new WxOrder($attributes);
        //3.预处理
        $result = $payment->prepare($wxorder);
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
            $prepayId = $result->prepay_id;
        }
        //4.得到支付的JSAPI配置
        $json = $payment->configForPayment($prepayId); // 返回 json 字符串，如果想返回数组，传第二个参数 false



    	Cart::clear();
    	return view('pay',['ord'=>$order->ordsn,'money'=>$money,'json'=>$json]);
        
    }
    public function payok(Request $req){
        $order = Order::where('ordsn',$req->ordsn)->first();
        if(!$order){
        	return redirect('/');
        }
        $order->ispay = 1;
        $order->save();//支付成功;

        $openid = session()->get('user')['id'];
        $user = User::where('openid',$openid)->first();
        if(!$user){
        	return '支付';
        }
        $ps =  [$user->p1 => 0.5 ,$user->p2 => 0.25 ,$user->p3 => 0.1];
        foreach($ps as $p=>$v){
        	if($p == 0){
        		break;
        	}
        	$fee = new Fee();
        	$fee->oid = $order->oid;
        	$fee->byid = $user->uid;
        	$fee->uid = $p;
 			$fee->money = $order->money*$v;
 			$fee->save();
            
        }
 		return '支付成功';
    }

    	

}
