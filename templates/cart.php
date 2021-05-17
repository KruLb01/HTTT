<?php
session_start();
include 'ConnectionDB.php';
$con = new ConnectionDB('');

?>
<html>
    <head>
        <title>HKP Store | Giỏ hàng </title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="../static/js/jquery-3.6.0.min.js"></script>
        <script src="../static/js/post_method.js"></script>
        <link rel="stylesheet" type="text/css" href="../static/css/index.css">
        <link rel="stylesheet" type="text/css" href="../static/css/cart.css">
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
                <div class="cart-container">
                    <div class="cart">
                        <div class="cart-title bg-dark">
                            <span>Giỏ hàng</span>
                        </div>
                        <div class="cart-content">
                            <div class="shopping-table">
                                <table>
                                    <tr class="tbl-header">
                                        <th>Tên sản phẩm</th>
                                        <th>Hình sản phẩm</th>
                                        <th>Kích cỡ</th>
                                        <th>Giá sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                    <?php
                                        $sum=0;
                                        $id_nguoidung = $_SESSION['id_nguoidung'];
                                        $sql = "SELECT san_pham.id_sanpham,nhom_san_pham.ten_nhomsanpham,c.url,san_pham.size,san_pham.gia_sanpham,gio_hang.so_luong,gio_hang.so_luong*san_pham.gia_sanpham FROM gio_hang,nhom_san_pham,san_pham,hinh_nhomsanpham,(select IFNULL(hinh_anh.link_hinhanh,'') as url,b.id_nhomsanpham from (select nhom_san_pham.id_nhomsanpham,hinh_nhomsanpham.id_hinh from nhom_san_pham left join hinh_nhomsanpham on nhom_san_pham.id_nhomsanpham = hinh_nhomsanpham.id_nhomsanpham) as b LEFT JOIN hinh_anh on b.id_hinh = hinh_anh.id_hinhanh) as c where gio_hang.id_sanpham=san_pham.id_sanpham and nhom_san_pham.id_nhomsanpham = c.id_nhomsanpham and nhom_san_pham.id_nhomsanpham=san_pham.id_nhomsanpham and gio_hang.id_nguoidung='$id_nguoidung' group by san_pham.id_sanpham";
                                        $result=$con->preparedSelect($sql);
                                        if($result!==null)
                                        {
                                            while($row = mysqli_fetch_array($result))
                                            {
                                                $sum+=$row[6];
                                                $subtotal=number_format($row[6],0,",",".")."<sup>đ</sup>";
                                                $prod_price=number_format($row[4],0,",",".")."<sup>đ</sup>";
                                                echo "<tr class='product-item'>"
                                                        ."<td class='product_name' id='$row[0]'>$row[1]</td>"
                                                        ."<td class='product_image'><img src='../$row[2]'/></td>"
                                                        ."<td class='product_size' title='Kích cỡ'>$row[3]</td>"
                                                        ."<td class='product_price' title='Giá sản phẩm'>$prod_price</td>"
                                                        ."<td class='product_quantity' title='Số lượng'><button class='plus' onclick='countUp(this)' class='my-button'>+</button><input class='amount' value='$row[5]'/><button class='abstract' onclick='countDown(this)' class='my-button'>-</button></td>"
                                                        ."<td class='product_subtotal' title='Thành tiền'>$subtotal</td>"
                                                        ."<td><button onclick='remove(this)' class='btn btn-danger'>Xoá</button</td>"
                                                    ."</tr>";
                                            }
                                        }
                                    ?>
                                    </table>
                                </div>
                                <div class="cart-total">
                                    <span><?php echo number_format($sum,0,",",".")."<sup>đ</sup>" ?></span></span>
                                </div>
                                <div class="cart-purchase">
                                    <button id="purchase-btn" onclick='goPurchase()'>Thanh toán</button>
                                </div>
                            <script type='text/javascript' src='../admin/static/js/cart.js'></script>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer">
                <?php include './footer1.php' ?>
            </div>
        </div>
    </body>
</html>
