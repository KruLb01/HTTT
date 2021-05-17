<?php
    include('../templates/connectData.php');
    $conn = new connectData('');

    if (isset($_GET['search']) && isset($_GET['type'])) {
        $search = $_GET['search'];
        $type = $_GET['type'];

        $temp = explode('_',$type)[1];
        if ($temp=='nhacungcap') {
            $res = $conn->selectData("select * from nha_cung_cap where $type ='$search'");
            $show = '<tr><th>Id</th><th>Name</th><th>Address</th></tr>';
            if (mysqli_num_rows($res)==0) {
                echo 'error';
                return;
            }
            
            while ($row = mysqli_fetch_array($res)) {
                $show .= "
                    <tr>
                        <td>".$row['id_nhacungcap']."</td>
                        <td>".$row['ten_nhacungcap']."</td>
                        <td>".$row['diachi_nhacungcap']."</td>
                    </tr>
                ";
            }
            echo $show;
        } else {
            $res = $conn->selectData("select * from san_pham, nhom_san_pham where san_pham.id_nhomsanpham = nhom_san_pham.id_nhomsanpham and $type = '$search'");
            $show = '<tr><th>Id Product</th><th>Id Group Product</th><th>Name Group Product</th><th>Size Product</th></tr>';

            if (mysqli_num_rows($res)==0) {
                echo 'error';
                return;
            }

            while ($row = mysqli_fetch_array($res)) {
                $show .= "
                    <tr>
                        <td>".$row['id_sanpham']."</td>
                        <td>".$row['id_nhomsanpham']."</td>
                        <td>".$row['ten_nhomsanpham']."</td>
                        <td>".$row['size']."</td>
                    </tr>
                ";
            }
            echo $show;
        }
    }

    if (isset($_POST['product']) && isset($_POST['provider']) && isset($_POST['total'])) {
        session_start();
        date_default_timezone_set("Asia/Ho_Chi_Minh");

        $provider = $_POST['provider'];
        $name_provider = '';

        $products = json_decode($_POST['product'],true);
        $total = $_POST['total'];

        $id_imp = uniqid('PN-',true);
        $date = date('Y-m-d');

        // Add to session
        if (!isset($_SESSION['import'])) {
            $_SESSION['import']['products'] = array();
        }

        // Import Receiving Transaction
        $rees = $conn->executeQuery("insert into phieu_nhap(id_phieunhap, id_nhanviennhap, id_nhacungcap, ngay_nhap, tong_gia_nhap) 
                                values ('$id_imp','".$_SESSION['user']['id']."','$provider','$date','$total')");
        
        // Import products
        $sum_qtt = 0;
        for ($i=0;$i<count($products);$i++) {
            // Handle
            $sum_qtt += (int)$products[$i]['quantity'];
            $res = $conn->executeQuery("insert into chitiet_phieunhap(id_phieunhap,id_sanpham,so_luong,gia_nhap)
                                values ('$id_imp','".$products[$i]['id']."','".$products[$i]['quantity']."','".$products[$i]['cost']."')");
            $res = $conn->executeQuery("update san_pham set so_luong = so_luong + ".$products[$i]['quantity']." where id_sanpham = '".$products[$i]['id']."'");
        }

        // Get name provider
        $name_provider = mysqli_fetch_array($conn->selectData("select ten_nhacungcap from nha_cung_cap where id_nhacungcap = '$provider'"))['ten_nhacungcap'];
        
        // Add to session
        array_push($_SESSION['import']['products'], array($id_imp, $name_provider, $sum_qtt, date("h:i:s"), number_format($total)));


        if ($res = true) echo "
            <tr>
                <td>$id_imp</td>
                <td>$name_provider</td>
                <td>$sum_qtt</td>
                <td>".date('h:i:s')."</td>
                <td>".number_format($total)." VNĐ</td>
            </tr>    
        ";
        else echo 'failed';
    }
?>