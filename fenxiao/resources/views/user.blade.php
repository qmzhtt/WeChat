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
    <h1>简洁大气的商城</h1>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 goods">
                <h2>我的收入</h2>
                <table class="table">
                    <tr>
                        <th>购买人</th>
                        <th>金额</th>
                        <th>佣金</th>
                    </tr>
                    <tr>
                        <td>张小三</td>
                        <td>23.1</td>
                        <td>10.5</td>
                    </tr>
                    <tr>
                        <td>李小二</td>
                        <td>23.2</td>
                        <td>6</td>
                    </tr>
                    <tr>
                        <td colspan="3">小计:&yen;24.5元</td>
                    </tr>
                </table>
                <form action="">
                    <input class="btn btn-primary" type="submit" value="立即提现">
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