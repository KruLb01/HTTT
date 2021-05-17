<?php
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        if (isset($_GET['id'])) $id = $_GET['id'];

        include('../templates/connectData.php');
        $conn = new connectData('');

        if ($page == 'employee') {
            $res = $conn->selectData("select * from admin, nguoi_dung 
                                    where admin.id_nguoidung = nguoi_dung.id_nguoidung
                                    and admin.id_nguoidung = '$id'");
        }

        if ($page == 'customer') {
            $res = $conn->selectData("select * from khach_hang, nguoi_dung 
                                    where khach_hang.id_nguoidung = nguoi_dung.id_nguoidung
                                    and khach_hang.id_nguoidung = '$id'");
        }

        if ($page == 'permission') {
            $res = $conn->selectData("select * from quyen
                                    where id_quyen = '$id'");
        }

        if ($page == 'product') {
            $res = $conn->selectData("select * from nhom_san_pham
                                    where id_nhomsanpham = '$id'");
        }

        if ($page == 'cproducts') {
            $res = $conn->selectData("select * from san_pham 
                                    where id_sanpham = '$id'");
        }

        if ($page == 'cproducts1') {
            $res = $conn->selectData("select id_nhomsanpham from nhom_san_pham 
                                    where ten_nhomsanpham = N'$id'");
        }

        if ($page == 'providers') {
            $res = $conn->selectData("select * from nha_cung_cap 
                                    where id_nhacungcap = '$id'");
        }

        if ($page == 'providers1') {
            $res = $conn->selectData("select * from nha_cung_cap 
                                    where ten_nhacungcap = '$id'");
        }

        if ($page == 'gproducts') {
            $res = $conn->selectData("select * from dong_san_pham 
                                    where id_dongsanpham = '$id'");
        }

        if ($page == 'gproducts1') {
            $res = $conn->selectData("select * from dong_san_pham 
                                    where ten_dongsanpham = '$id'");
        }

        if ($page == 'sales') {
            $res = $conn->selectData("select * from sale 
                                    where id_sale = '$id'");
        }

        if ($page == 'sales1') {
            $res = $conn->selectData("select * from sale 
                                    where ten_sale = '$id'");
        }

        if (mysqli_num_rows($res)!=0) {
            echo 'Error';
        } else echo 'Continue';
    }
?>