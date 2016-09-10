<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<link rel="stylesheet" href="/css/bootstrap.min.css">
<style>
.goods {
    margin: 2% 0;
}
.goods img {
    width:90%;
}
#navb li {
    float: left;
    width: 33%;
    text-align: center;
    list-style: none;
    line-height: 50px;
}
body{
    padding-bottom: 70px;
}
</style>
<body>
    <center>
        <h1>发家致富全靠骗</h1>
    </center>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 goods">
                <center>
                    <h2>购物车结算</h2>
                </center>
                <center><br><br><br>
                <form action="{{url('payok')}}" method="post">
                    {{csrf_field()}}
                    <div class="form-group">

                      <input type="hidden" class="form-control" name="ordsn" value="{{$ord}}">
                    </div>
                    <div class="form-group">
                     订单号:{{$ord}}
                    </div>
                    <div class="form-group">
                      <input type="hidden" class="form-control" name="money" value="{{$money}}">
                    </div>
                    <div class="form-group">
                      合计:{{$money}}元;
                    </div>
                    <input class="btn btn-primary" type="submit" value="立即支付" id="pay">
                </form>
            </center>
            </div>
        </div>
        <div class="col-xs-12 navbar-fixed-bottom">
          <ul class="navbar-fixed-bottom navbar-default row" id="navb">
            <li><a href="/">首页</a></li>
            <li><a href="/home">个人中心</a></li>
            <li><a href="">帮助</a></li>
          </ul>
        </div>
    </div>
</body>
<script>
    $('form').submit(function(){
        'getBrandWCPayRequest', {!!$json!!},
            function(res){
                if(res.err_msg == "get_brand_wcpay_request：ok" ) {
                    // 使用以上方式判断前端返回,微信团队郑重提示：
                    // res.err_msg将在用户支付成功后返回
                    // ok，但并不保证它绝对可靠。
                }
            }
  
        return false;
    });
WeixinJSBridge.invoke(
       
</script>
<script src="http://libs.useso.com/js/jquery/2.1.0/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
