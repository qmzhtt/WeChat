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
                <table class="table">
                    <tr>
                        <th>商品</th>
                        <th>价格</th>
                        <th>数量</th>
                    </tr>
                    @forelse($goods as $gs)
                    <tr>
                        <td>{{$gs['name']}}</td>
                        <td>{{$gs['price']}}</td>
                        <td>{{$gs['quantity']}}</td>
                    </tr>
                    @empty
                    <a href="{{url('/')}}">购物车空空如也,块去选购吧!</a>
                    @endforelse
                    
                    <tr>
                        <td colspan="3">共计:&yen;{{$sub}}元</td>
                    </tr>
                </table>
                <form action="{{url('order')}}" method="post">
                    {{csrf_field()}}
                    <div class="form-group">
                      <input type="text" class="form-control" name="address" placeholder="收货地址">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" name="name" placeholder="收货人姓名">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" name="tel" placeholder="手机号">
                    </div>
                    <input class="btn btn-primary" type="submit" value="确认下单">
                </form>
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
<script src="http://libs.useso.com/js/jquery/2.1.0/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
</html>