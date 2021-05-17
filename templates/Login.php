<html>
    <head>
        <meta charset="utf-8">
        <title>Đăng nhập</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <LINK REL="SHORTCUT ICON" HREF="../static/images/favicon.ico">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>    
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="../static/js/jquery-3.6.0.min.js"></script>
        <script src="../static/js/post_method.js"></script>
        <link rel="stylesheet" type="text/css" href="../static/css/all.css">
        <link rel="stylesheet" type="text/css" href="../plugin/bootstrap-4.5.3-dist/css/bootstrap.css">
        <script src="../plugin/bootstrap-4.5.3-dist/js/bootstrap.min.js"></script>
        <style>
            .navbar-nav > .nav-item > .nav-link{
               color:white; 
            }
            .navbar-nav > .nav-item > .nav-link:hover{
               color:orange; 
            }
            body{
                font-size:16px;
            }
            .container{
                padding:0 2px 0 2px;
            }
            .login-form{
                margin:100px auto;
                background:rgba(158,158,158,0.3);
                width:70%;
                height:300px;
                display:flex;
            }
            .right-form{
                width:45%;
                padding:0px 10px 0px 10px;
            }
            .left-form{
                width:55%;
            }
            .login-form .left-form img{
                width:100%;
                height:100%;
            }
            .input-form{
                border-radius:0.3em;
                outline:none;
                border:1px;
                height: 24px;
                width:65%;
            }
            .button-submit input{
                width:50%;
                height:50px;
                background-color:orange;
                border-radius: 0.5em;
                outline:none;
                color:white;
                border:none;
            }
            .line{
                padding:5px 25px 0 25px;
                display:flex;
                align-items: center;
                text-align: center;
            }
            .line::after, .line::before{
                content:'';
                flex:1;
                height:2px;
                border-bottom: 1px solid #000;
            }
            .line small{
                margin-left:.25em;
                margin-right: .25em;
            }
            .button-submit{
                text-align: center;
            }
            .button-submit input:hover{
                border:white 1px solid;
                cursor:pointer;
            }
            .form-header{
                text-align: center;
                padding-top:10px;
            }
            .footer{
                justify-content: space-around;
                display:flex;
                width:100%;
                height:auto;
                background:rgba(158,158,158,0.3);
                flex-wrap: wrap;
            }
            .input{
                text-align: center;
                margin:15px 0 15px 0;
            }
            .footer div{
                padding:10px;
            }
            .footer div ul li{
                list-style: none;
                padding:5px;
            }
            .footer div:last-child ul li{
                display:inline-block;
                padding:0px;
            }
            .footer div ul{
                padding-left: 0px;
            }
            h3{
                font-size:19px;
            }
            .logo-brand{
                width:110px;
            }
            .logo-brand img{
                width:100%;
            }
            @media screen and (max-width:768px)
            {
                .left-form{
                    display:none;
                }
                .right-form{
                    clear:both;
                    width:100%;
                }
                .login-form{
                    height:auto;
                }
                .footer{
                    justify-content: space-between;
                }
            }
            @media screen and (max-width:320px)
            {
                
            }
            @media screen and (max-width:200px)
            {
            }
        </style>
    </head>
    <body>
    <div>
        <div class="header">
            <nav class="navbar navbar-expand-md bg-info navbar-light">    
                <div class="logo-brand">
                    <a class="navbar-brand" href="../index.php">
                    <img src="../static/images/logos/logo-ngang-trans.png" alt="Logo" width="110px">
                    </a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                  <li class="nav-item">
                    <a class="nav-link" href="../index.php">Trang chủ</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Liên hệ</a>
                  </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                  <li class="nav-item">
                    <a class="nav-link" href="../index.php"><i class="far fa-question-circle"></i> Trợ giúp</a>
                  </li>
                </ul>
              </div>
              </nav>
        </div>
        <div class="mid">
            <div class="login-form">
                <div class="left-form">
                    <div id="demo" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#demo" data-slide-to="0" class="active"></li>
                            <li data-target="#demo" data-slide-to="1"></li>
                        </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block" src="../static/images/others/image1.jpg" alt="" style="height:300px;width:100%">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block" src="../static/images/others/image2.jpg" alt="" style="height:300px;width:100%">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#demo" data-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </a>
                    <a class="carousel-control-next" href="#demo" data-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </a>
                    </div>
                </div>
                <div class="right-form">
                <form method="POST">
                    <div class="form-header">
                        <h1 style="font-size:23px">Đăng nhập</h1>
                    </div>
                    <div class="input">
                        <input id="username" type="text" class="input-form" placeholder="Tài khoản" name="username"/>
                    </div>
                    <div class="input">
                        <input id="password" type="password" class="input-form" placeholder="Mật khẩu" name="password"/>
                    </div>
                    <div class="button-submit">
                        <input id="btn-submit" type="submit" value="Đăng nhập"/>
                    </div>
                    <div class="line">
                            <small>hoặc</small>
                    </div>
                    <div style="text-align:center;font-size:13px;margin-top:10px">
                        <p>Muốn mua sản phẩm nhưng không có tài khoản? Đăng ký tại <a href="./dangky.php">đây</a></p>
                    </div>
                </form>
                <script>
                        $(document).ready(function(){
                            $("form").submit(function(e){
                            e.preventDefault();
                            var username = $("#username").val();
                            var password = $("#password").val();
                            if(username==="" || password==="")
                            {
                                alert("Vui lòng điền đầy đủ");
                            }
                            else{
                                var regex = /^[a-zA-Z0-9_]+$/;
                                if(!regex.test(username))
                                {
                                    alert("Tài khoản không được chứa kí tự đặc biệt");
                                }
                                else{
                                        $.ajax({
                                            type:'POST',
                                            url:"xulydangnhap.php",
                                            data:$("form").serialize(),
                                            success:function(rep)
                                            {
                                                var jsonData = JSON.parse(rep);
                                                if(jsonData.passedLogin===1)
                                                {
                                                    var a = <?php if(isset($_POST['next']) && $_POST['next']){echo '"'.$_POST['next'].'"';}else{echo "'../index.php'";}?>;
                                                    location.href = a;
                                                }
                                                else alert("Đăng nhập thất bại");                        
                                            }
                                        });
                                }
                            }
                            });
                        });
                </script>
                </div>
            </div>
        </div>
        <div class="footer">
            <div>
                <h3>GIỚI THIỆU</h3>
                <ul>
                    <li>Trang chủ</li>
                    <li>Giới thiệu</li>
                    <li>Sản phẩm</li> 
                </ul>
            </div>
            <div>
                <h3>CHÍNH SÁCH BẢO MẬT</h3>
                <ul>
                    <li>Chính sách bảo mật</li>
                    <li>Chính sách vận chuyển</li>
                    <li>Chính sách đổi trả, bảo hành</li>
                    <li>Quy định sử dụng</li> 
                </ul>
            </div>
            <div>
                <h3>HỖ TRỢ KHÁCH HÀNG</h3>
                <ul>
                    <li>Kiểm tra đơn hàng</li>
                    <li>Đăng nhập</li>
                    <li>Đăng ký</li>
                    <li>Giỏ hàng</li>
                </ul>
            </div>
            <div>
                <h3>CONNECT WITH US</h3>
                <ul>
                    <li><a href="https://facebook.com" target="_blank"><img src="../static/images/icons/icons8_facebook_48px_1.png" width="30px" height="30px"/></a></li>
                    <li><a href="https://www.facebook.com/messages/t/100005959088602" target="_blank"><img src="../static/images/icons/icons8_facebook_messenger_48px.png" width="30px" height="30px"/></a></li>
                    <li><a href="https://instagram.com" target="_blank"><img src="../static/images/icons/icons8_instagram_48px.png" width="30px" height="30px"/></a></li>
                    <li><a href="https://shopee.vn" target="_blank"><img src="../static/images/icons/icons8-shopee-48.png" width="30px" height="30px"/></a></li>
                </ul>
            </div>
        </div>
    </div>
    </body>
</html>