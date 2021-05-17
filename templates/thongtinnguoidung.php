<?php
session_start();
include 'ConnectionDB.php';
$con = new ConnectionDB('');

?>
<html>
    <head>
        <title>HKP Store | Thông tin người dùng </title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="../static/js/jquery-3.6.0.min.js"></script>
        <script src="../static/js/post_method.js"></script>
        <LINK REL="SHORTCUT ICON" HREF="../static/images/favicon.ico">
        <link rel="stylesheet" type="text/css" href="../static/css/index.css">
        <link rel="stylesheet" type="text/css" href="../static/css/thongtinnguoidung.css">
        <link rel="stylesheet" type="text/css" href="../static/css/all.css">
        <link rel="stylesheet" type="text/css" href="../plugin/bootstrap-4.5.3-dist/css/bootstrap.css">
        <script src="../plugin/bootstrap-4.5.3-dist/js/bootstrap.min.js"></script>
    </head>
    <body>
        <script>
            if(<?php if(isset($_SESSION['id_nguoidung'])){echo 1;}else{echo 0;}?>){
                //do nothing
            }
            else post_to_url("Login.php",{next:window.location.href});
        </script>
        <div class="wrap">
            <div class="header">
                <?php include './header1.php' ?>
            </div>
            <div class="mid">
                <?php
                    $id_nguoidung = $_SESSION['id_nguoidung'];
                    $sql = "SELECT ho_ten,dia_chi,thong_tin_khac,nguoi_dung.email,mat_khau"
                         . " from nguoi_dung,khach_hang where nguoi_dung.id_nguoidung=khach_hang.id_nguoidung"
                         . " and nguoi_dung.id_nguoidung='$id_nguoidung'";
                    $result = $con->preparedSelect($sql);
                    $row = mysqli_fetch_array($result);
                ?>
                <div class="container-form shadow p-3 mb-5 bg-white rounded">
                    <div class="header-form">
                        <h4>Thông tin người dùng</h4>
                    </div>
                    <div class="form-detail-user">
                        <form method="POST">
                            <input type="hidden" name="user_act" value="update">
                            <div class="detail-user">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 title">Tên người dùng:</div>
                                    <div class="col-xl-8 col-lg-8"><?php echo $row[0]?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 title">Địa chỉ:</div>
                                    <div class="col-xl-6 col-lg-6">
                                        <input id="diachi" type="text" name="address" value="<?php echo $row[1]?>" disabled="disabled"/>
                                    </div>
                                    <div class="col-xl-2 col-lg-2">  
                                        <button class="btn btn-warning">Chỉnh sửa</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 title">Thông tin khác:</div>
                                    <div class="col-xl-6 col-lg-6">
                                        <input id="other-info" type="text" name="other-info" value="<?php echo $row[2]?>" disabled="disabled"/>
                                    </div>
                                    <div class="col-xl-2 col-lg-2">  
                                        <button class="btn btn-warning">Chỉnh sửa</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 title">Email:</div>
                                    <div class="col-xl-6 col-lg-6">
                                        <input id="email" type="text" name="email" value="<?php echo $row[3]?>" disabled="disabled"/>  
                                    </div>
                                    <div class="col-xl-2 col-lg-2">
                                        <button class="btn btn-warning">Chỉnh sửa</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 title">Mật khẩu</div>
                                    <div class="col-xl-6 col-lg-6">
                                        <input id="password" type="password" name="password" value="<?php echo md5($row[4],false)?>" disabled="disabled"/>  
                                    </div>
                                    <div class="col-xl-2 col-lg-2">
                                        <button class="btn btn-warning">Chỉnh sửa</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="submit-button">
                                            <input class="btn btn-danger" type="submit" value="Lưu thay đổi"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function(){
                    $("div.detail-user button").click(function(e)
                    {
                        e.preventDefault();
                        var inputField = $(this).parent().parent().children().eq(1);
                        var inputField = inputField.children().eq(0); 
                        if(inputField.attr("disabled")==="disabled")
                        {
                            inputField.prop("disabled",false);
                            $(this).prop("disabled",true);
                        }
                    });
                    function isEmail(email)
                    {
                        var regex = /^([a-zA-Z0-9_])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9\-]){2,}$/;
                        if(regex.test(email))
                        {
                            return true;
                        }
                        return false;
                    }
                    $("input[type='submit']").click(function(e){
                        e.preventDefault();
                        var email = $("#email").val();
                        var password = $("#password").val();
                        if(!isEmail(email))
                        {
                            alert("Sai định dạng email");
                            return;
                        }
                        if(password.length<4)
                        {
                            alert("Mật khẩu có độ dài không được dưới 4");
                        }
                        else
                        {
                            $("div.detail-user input").prop("disabled",false);
                            $.ajax({
                                type:"POST",
                                url:"xulynguoidung.php",
                                data:$("form").serialize(),
                                success:function(data){
                                    $("div.detail-user input[type='text'],div.detail-user input[type='password']").prop("disabled",true);
                                    $("div.detail-user button").prop("disabled",false);
                                    var getData = JSON.parse(data);
                                    if(getData.msg==='')
                                    {
                                        alert("Cập nhật thành công");
                                       $("#diachi").val(getData.address);
                                       $("#other-info").val(getData.other-info);
                                       $("#email").val(getData.email);
                                       $("#password").val(getData.password);
                                    }
                                    else{
                                        alert(getData.msg);
                                    }
                                }
                            });
                        }
                    });
                });
            </script>
            <div class='footer'>
                <?php include './footer1.php' ?>
            </div>
        </div>
    </body>
</html>