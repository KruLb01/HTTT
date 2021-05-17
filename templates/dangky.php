<?php
    session_start();
    include 'ConnectionDB.php';
    $con = new ConnectionDB('');
?>    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="../static/js/jquery-3.6.0.min.js"></script>
        <script src="../static/js/post_method.js"></script>
        <link rel="stylesheet" type="text/css" href="../static/css/index.css">
        <link rel="stylesheet" type="text/css" href="../static/css/dangki.css">
        <link rel="stylesheet" type="text/css" href="../static/css/all.css">
        <link rel="stylesheet" type="text/css" href="../plugin/bootstrap-4.5.3-dist/css/bootstrap.css">
        <script src="../plugin/bootstrap-4.5.3-dist/js/bootstrap.min.js"></script>
        <title>HKP | Đăng kí</title>
    </head>
    <body>
    <div class="wrap">
        <div class="header">
            <?php include '../templates/header1.php'?>
        </div>
        <div class="mid">
            <div class="container-form-register shadow mb-5 bg-white">
                <div class="header-form">
                    <h3>Đăng kí</h3>
                </div>
                <form method="POST">
                    <div class="container-form">
                        <div class="row">
                            <div class="col-xl-4 col-sm-4"><strong>Họ tên : </strong></div>
                            <div class="col-xl-8 col-sm-8"><input type="text" name="hoten" /></div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 col-sm-4"><strong>Địa chỉ : </strong></div>
                            <div class="col-xl-8 col-sm-8"><input type="text" name="diachi" /></div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 col-sm-4"><strong>Số điện thoại : </strong></div>
                            <div class="col-xl-8 col-sm-8"><input type="text" name="sodienthoai" /></div>
                        </div>
                        <div class="row">                       
                            <div class="col-xl-4 col-sm-4"><strong>Thông tin khác : <span class="text-error">(*) Mục này không cần thiết</span></strong></div>
                            <div class="col-xl-8 col-sm-8"><input type="text" name="thongtinkhac"></div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 col-sm-4"><strong>Tên đăng nhập: </strong></div>
                            <div class="col-xl-8 col-sm-8"><input type="text" name="tendangnhap"/></div>  
                        </div>
                        <div class="row">
                            <div class="col-xl-4 col-sm-4"><strong>Email : </strong></div>
                            <div class="col-xl-8 col-sm-8"><input type="email" placeholder="ví dụ: abc123@gmail.xyz" name="email"/></div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 col-sm-4"><strong>Mật khẩu : </strong></div>
                            <div class="col-xl-8 col-sm-8"><input type="password" name="password"/></div>   
                        </div>
                        <div class="row">
                            <div class="col-xl-12"><input type="submit" value="Đăng ký"/></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="footer">
            <?php include '../templates/footer1.php' ?>
        </div>
    </div>
        <script>
            $(document).ready(function(){
                function isPhoneNumber(number)
                {
                    var regex = /^(0[3579])(\d{8})$/;
                    if(regex.test(number))
                    {
                        return true;
                    }
                    return false;
                }
                function isEmail(email)
                {
                    var regex = /^([a-zA-Z0-9_])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9\-]){2,}$/;
                    if(regex.test(email))
                    {
                        return true;
                    }
                    return false;
                }
                function hasEmptyValues(data)
                {
                    for(var i=0;i<data.length;i++)
                    {
                        if(i===3)
                        {
                            continue;
                        }
                        if(data.eq(i).val()===""){
                            return true;
                        }
                    }
                    return false;
                }
                $(".container-form-register form input[type='submit']").click(function(e){
                    e.preventDefault();
                    var ArrayInput = $(".container-form-register form input[type='text'],input[type='password'],input[type='email'");
                    console.log(hasEmptyValues(ArrayInput));
                    if(hasEmptyValues(ArrayInput)){
                        alert("Vui lòng điền hết mục trống");
                        return;
                    }
                    if(ArrayInput.eq(0).val().length<3)
                    {
                        alert("Họ và tên không được dưới 3 kí tự");
                        return;
                    }
                    if(ArrayInput.eq(1).val().length<10)
                    {
                        alert("Địa chỉ không dưới quá 10 kí tự");
                        return;
                    }
                    if(!isPhoneNumber(ArrayInput.eq(2).val()))
                    {
                        alert("Đây không phải là số điện thoại");
                        return;
                    }
                    if(!isEmail(ArrayInput.eq(5).val()))
                    {
                        alert("Đây không phải là địa chỉ email");
                        return;
                    }
                    else{
                        $.ajax({
                            type:"POST",
                            url:"xulynguoidung.php",
                            data:"user_act=add&"+$(".container-form-register form").serialize(),
                            success:function(data)
                            {
                                var getData = JSON.parse(data);
                                alert(getData.msg)
                                if(getData.success===1)
                                {
                                    location.href ="../index.php";
                                }
                            }
                        });
                    }
                });
            });
        </script>
    </body>
</html>