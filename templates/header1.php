<div class="logo">
    <img src="../static/images/logos/logo-ngang-trans.png" onclick="location.href='../index.php';">
        </div>
        <div class="links">
            <ul class="menu">
                <li class="menu-item"><a href="../templates/danhmucsanpham.php">Danh mục sản phẩm</a>
                    <?php
                            $sql1 = "select thuonghieu_sanpham from dong_san_pham group by thuonghieu_sanpham";
                            $result = $con->preparedSelect($sql1);
                            if($result!==null)
                            {
                                echo '<ul class="sub-menu">';
                                while ($row = mysqli_fetch_array($result)) {
                                    echo '<li><a href="../templates/danhmucsanpham.php?thuonghieu='.$row[0].'">'.$row[0].'</a></li>';
                                }
                                echo '</ul>';
                            }
                    ?>
                </li>
                <li class="menu-item"><a href="../index.php">Home</a></li>
                <li class="menu-item"><a href="">Tin tức</a></li>
                <li class="menu-item"><a href="">Giới thiệu</a></li>
            </ul>
            <ul class="others">
                <?php if(isset($_SESSION['id_nguoidung'])){
                echo '<li><span> Welcome Back, <strong>'.$_SESSION['hoten'].'</strong></span>
                    <ul class="sub-menu">
                        <li><a href="./thongtinnguoidung.php">Thông tin người dùng</a></li>
                        <li><a href="./hoadon.php">Xem các hóa đơn</a></li>
                        <li><a href="./logout.php">Đăng xuất</a></li>
                    </ul>
                </li>
                <li><a href="cart.php"><i class="fas fa-shopping-cart"></i> Giỏ hàng</a></li>';
                }else{
                    echo '<li><a href="./Login.php"><i class="fas fa-user"></i> Đăng nhập</a></li>
                    <li><a href="./dangky.php"><i class="fas fa-user"></i> Đăng ký</a></li>';
                }
                ?>
            </ul>
        </div>
        <div class="burger">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
        <script type="text/javascript" src="../static/js/menu.js"></script>