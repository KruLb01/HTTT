<?php 
session_start();
include 'ConnectionDB.php';
$con = new ConnectionDB('');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>HKP Store | Thanh toán giỏ hàng </title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="../static/js/jquery-3.6.0.min.js"></script>
        <script src="../static/js/post_method.js"></script>
        <link rel="stylesheet" type="text/css" href="../static/css/index.css">
        <link rel="stylesheet" type="text/css" href="../static/css/thanhtoan.css">
        <link rel="stylesheet" type="text/css" href="../static/css/all.css">
        <link rel="stylesheet" type="text/css" href="../plugin/bootstrap-4.5.3-dist/css/bootstrap.css">
        <script src="../plugin/bootstrap-4.5.3-dist/js/bootstrap.min.js"></script>
    </head>
    <body>
        <script type="text/javascript">
            if(<?php if(isset($_SESSION['id_nguoidung'])){echo 1;}else{echo 0;}?>){
                //do nothing
            }
            else post_to_url("Login.php",{next:window.location.href});
        </script>
        <div class="wrap">
            <div class="header">
                <?php include './header1.php'?>
            </div>
            <div class="mid">
                <div class="container-cart-checkout shadow p-3 mb-5 bg-white rounded">
                    <div class="notification-box border border-danger">
                        <p>Vui lòng khách hàng kiểm tra kĩ các thông tin trước khi thanh toán và điền vào các ô trống. Nếu muốn
                        thay đổi thông tin thì nhấp vào <a href="thongtinnguoidung.php">đây</a></p> 
                    </div>
                    <div class="container-user-cart-infos">
                        <div class="container-user-info col-xl-5 col-md-4 col-sm-12">
                            <div class="header-title">
                                <p>Thông tin của bạn</p>
                            </div>
                            <?php
                                $id_nguoidung = $_SESSION['id_nguoidung'];
                                $sql= "SELECT ho_ten,dia_chi,nguoi_dung.so_dien_thoai,nguoi_dung.email"
                                    . " from nguoi_dung,khach_hang where nguoi_dung.id_nguoidung=khach_hang.id_nguoidung"
                                    . " and nguoi_dung.id_nguoidung='$id_nguoidung'";
                                $result = $con->preparedSelect($sql);
                                $row = mysqli_fetch_array($result);
                            ?>
                            <div class="row">
                                <div class="col-xl-4 col-title"><strong>Họ tên</strong></div>
                                <div class="col-xl-8 col-content"><div><?php echo $row[0]?></div></div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 col-title"><strong>Địa chỉ</strong></div>
                                <div class="col-xl-8 col-content"><div><?php echo $row[1]?></div></div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 col-title"><strong>Số điện thoại</strong></div>
                                <div class="col-xl-8 col-content"><div><?php echo $row[2]?></div></div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 col-title"><strong>Email</strong></div>
                                <div class="col-xl-8 col-content"><div><?php echo $row[3]?></div></div>
                            </div>
                        </div>
                        <div class="container-cart-info col-xl-7 col-md-8 col-sm-12">
                            <div class="header-title">
                                <p>Giỏ hàng của bạn</p>
                            </div>
                            <?php
                                $sql1= "SELECT san_pham.id_sanpham,nhom_san_pham.ten_nhomsanpham,c.url,san_pham.size,san_pham.gia_sanpham,gio_hang.so_luong,gio_hang.so_luong*san_pham.gia_sanpham FROM `gio_hang`,`nhom_san_pham`,`san_pham`,(select IFNULL(hinh_anh.link_hinhanh,'') as url,b.id_nhomsanpham from (select nhom_san_pham.id_nhomsanpham,hinh_nhomsanpham.id_hinh from nhom_san_pham left join hinh_nhomsanpham on nhom_san_pham.id_nhomsanpham = hinh_nhomsanpham.id_nhomsanpham) as b LEFT JOIN hinh_anh on b.id_hinh = hinh_anh.id_hinhanh) as c where gio_hang.id_sanpham=san_pham.id_sanpham and nhom_san_pham.id_nhomsanpham=san_pham.id_nhomsanpham and c.id_nhomsanpham = nhom_san_pham.id_nhomsanpham and gio_hang.id_nguoidung='$id_nguoidung' group by san_pham.id_sanpham";
                                $result1 = $con->preparedSelect($sql1);
                                $total=0;
                                $output='';
                                if($result1!==null){
                                    $output.="<table>"
                                             ."  <tr class='row-header'>
                                                    <th>Tên sản phẩm</th>
                                                    <th>Hình sản phẩm</th>
                                                    <th>Kích cỡ</th>
                                                    <th>Giá sản phẩm</th>
                                                    <th>Số lượng</th>
                                                    <th>Thành tiền</th>
                                                </tr>";
                                    while($row = mysqli_fetch_array($result1))
                                    {
                                        $subtotal=number_format($row[6],0,",",".")."<sup>đ</sup>";
                                        $prod_price=number_format($row[4],0,",",".")."<sup>đ</sup>";
                                        $output.="<tr class='row-product-item'>"
                                                    ."<td class='product_name' id='$row[0]'>$row[1]</td>"
                                                    ."<td class='product_image'><img src='../$row[2]'/></td>"
                                                    ."<td class='product_size' title='Kích cỡ'>$row[3]</td>"
                                                    ."<td class='product_price' title='Giá sản phẩm'>$prod_price</td>"
                                                    ."<td class='product_quantity' title='Số lượng'>$row[5]</td>"
                                                    ."<td class='product_subtotal' title='Thành tiền'>$subtotal</td>"
                                                    ."</tr>";
                                        $total+=$row[6];
                                    }
                                    $output.="</table>";
                                }
                            ?>
                            <div class="container-list-product-incart">
                                <?php echo $output?>
                            </div>
                            <div class="total-price-all-products">
                                <span><?php echo number_format($total,0,",",".")."<sup>đ</sup>";?></span>
                            </div>
                        </div>
                    </div>
                    <form method="POST">
                        <div class="container-message-fill-in">
                            <span>(*) Điền vào các mục này</span>
                        </div>
                        <div class="radiobox-container">
                            <div class="radiobox-title">
                                <span>Chọn phương thức giao hàng</span>
                            </div>
                            <?php 
                                $sql2 = "select * from phuongthuc_giaohang";
                                $result2 = $con->preparedSelect($sql2);
                                if($result2!==null)
                                {
                                    while($row = mysqli_fetch_array($result2))
                                    {
                                        echo '<div class="radiobox-item">
                                                <input name="ship_method" type="radio" value="'.$row[0].'"" id="'.$row[0].'"/>
                                                <label for="'.$row[0].'">'.$row[1].' ( '.$row[2].' )</label>
                                            </div>';
                                    }
                                }
                                else{
                                    echo '<div class="no-shipping-methods">
                                            <span>Hiện tại chưa có phương thức giao hàng
                                        </div>';
                                }
                            ?>
                        </div>
                        <div class="container-sale-input">
                            <div class="row">
                                <div class="col-xl-4">
                                    <span>Nhập mã sale để được giảm giá cho hóa đơn</span>
                                </div>
                                <div class="col-xl-8">
                                    <input type="text" name="sale-code" id="input-sale-code" value=""/>
                                    <div class="show-error-sale-code">
                                        <span></span>
                                    </div>
                                    <div class="new-update-total">
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                            <script>
                                $(document).ready(function(){
                                    $("#input-sale-code").keyup(function(){
                                        if($(this).val()==="")
                                        {
                                            $(".container-sale-input .show-error-sale-code span").text("");
                                            $(".container-sale-input .show-error-sale-code span").removeClass("active-text");
                                            $(".container-sale-input .show-error-sale-code span").removeClass("error-text");
                                            $(".container-sale-input .new-update-total span").html("");
                                        }
                                        else{
                                            $.ajax({
                                                type:"POST",
                                                url:"xulymasale.php",
                                                data:{
                                                    act:"check",
                                                    code:$(this).val(),
                                                    total:<?php echo $total;?>
                                                },
                                                success:function(data)
                                                {
                                                    var getData = JSON.parse(data);
                                                    if(!getData.isValid)
                                                    {
                                                        $(".container-sale-input .show-error-sale-code span").text("Mã sale không hợp lệ");
                                                        $(".container-sale-input .show-error-sale-code span").removeClass("active-text");
                                                        $(".container-sale-input .show-error-sale-code span").addClass("error-text");
                                                        $(".container-sale-input .new-update-total span").html("");
                                                    }
                                                    else{
                                                        $(".container-sale-input .show-error-sale-code span").text("Mã sale khớp ["+getData.tensale+"]");
                                                        $(".container-sale-input .show-error-sale-code span").removeClass("error-text");
                                                        $(".container-sale-input .show-error-sale-code span").addClass("active-text");
                                                        $(".container-sale-input .new-update-total span").html(getData.new_total);
                                                    }
                                                }
                                            });
                                        }
                                    });
                                });
                            </script>
                        </div>
                        <div class="submit-checkout">
                            <input type="submit" class="btn btn-success" value="Thanh toán"/>
                        </div>
                    </form>
                    <script>
                        $(document).ready(function(){
                            $("input[type='radio']").click(function(){
                                if($("input[type='radio']").is(":checked")){
                                    $("input[type='radio']").prop("checked",false);
                                    $(this).prop("checked",true);
                                }
                                else $(this).prop("checked",true);
                            });
                            $("input[type='submit']").click(function(e){
                                e.preventDefault();
                                if($(".container-cart-info table .row-product-item").length>0)
                                    if(".radiobox-item".length<1)
                                    {
                                        alert("Hiện tại shop đang cập nhật phương thức giao hàng");
                                        return;
                                    }
                                    else{
                                        if(!$("input[type='radio']").is(":checked"))
                                        {
                                            alert("Vui lòng chọn phương thức giao hàng");
                                            return;
                                        }
                                        if($(".container-sale-input .show-error-sale-code span").hasClass("error-text"))
                                        {
                                            $("html,body").animate({scrollTop: $(".container-sale-input .show-error-sale-code span").offset().top},500);
                                        }
                                        else{
                                            $.ajax({
                                                url:"xulyhoadon.php",
                                                type:"POST",
                                                data: "act=add&"+$("form").serialize()+"&total="+'<?php echo $total;?>',
                                                success:function(data)
                                                {
                                                    var getData = JSON.parse(data);
                                                    alert(getData.msg);
                                                    if(getData.success===1)
                                                    {
                                                        $(".container-list-product-incart table .row-product-item").remove();
                                                        $(".container-sale-input .show-error-sale-code span").removeClass("error-text");
                                                        $(".container-sale-input .show-error-sale-code span").removeClass("active-text");
                                                        $(".container-sale-input .show-error-sale-code span").text("");
                                                        $(".total-price-all-products span").html("0<sup>đ</sup>");
                                                        $("#input-sale-code").val("");
                                                        $(".new-update-total span").html("");
                                                    }    
                                                }
                                            });
                                        }
                                    }
                                else{
                                    alert("Giỏ hàng của bạn đang trống");
                                }
                            });
                        });
                    </script>
                </div>
            </div>
            <div class="footer">
                <?php include '../templates/footer1.php'?>
            </div>
        </div>
    </body>
</html>