<?php
    include('../templates/connectData.php');
    $conn = new connectData('');
    $sql = '';
    $res = '';

    if (isset($_GET['cid'])) {
        $cid = $_GET['cid'];
        $pos = ($cid - 1 ) * 10;
        $sql = "select * from khach_hang, nguoi_dung where khach_hang.id_nguoidung = nguoi_dung.id_nguoidung limit $pos, 10";
        
        $list = $conn->selectData($sql);
        $res = "                        
        <tr style='border:none'>
            <th>Id Customers</th>
            <th>Name Customers</th>
            <th>Address Customers</th>
            <th>Phone Customers</th>
            <th>Email Customers</th>
        </tr>";

        while ($line=mysqli_fetch_array($list)) {
            $res .= "
            <tr>
                <td>".$line['id_nguoidung']."</td>
                <td>".$line['ho_ten']."</td>
                <td>".$line['dia_chi']."</td>
                <td>".$line['so_dien_thoai']."</td>
                <td>".$line['email']."</td>
            </tr>";
        }
        
        $countC = mysqli_num_rows($list);
        if ($countC == 0) {
            $res = false;
        }
        echo $res;
    }

    if (isset($_GET['uid'])) {
        $uid = $_GET['uid'];
        $pos = ($uid - 1 ) * 10;
        $sql = "select * from admin, nguoi_dung where admin.id_nguoidung = nguoi_dung.id_nguoidung limit $pos, 10";
        
        $list = $conn->selectData($sql);
        $res = "                        
        <tr style='border:none'>
            <th>Id Users</th>
            <th>Name Users</th>
        </tr>";

        while ($line=mysqli_fetch_array($list)) {
            $res .= "
            <tr>
                <td>".$line['id_nguoidung']."</td>
                <td>".$line['ho_ten']."</td>
            </tr>";
        }

        $countU = mysqli_num_rows($list);
        if ($countU == 0) {
            $res = false;
        }
        echo $res;
    }

    if (isset($_GET['sid'])) {
        $sid = $_GET['sid'];
        $pos = ($sid - 1 ) * 10;
        $sql = "select * from sale limit $pos, 10";
        
        $list = $conn->selectData($sql);
        $res = "                        
        <tr style='border:none'>
            <th>Id Sales</th>
            <th>Name Sales</th>
            <th>Status</th>
        </tr>";

        while ($line=mysqli_fetch_array($list)) {
            $currentDate = (int) date("Ymj");
            $dayStart = (int) implode('',explode('-',$line['ngay_bat_dau']));
            $dayEnd = (int) implode('',explode('-',$line['ngay_ket_thuc']));
            $status = 'Launching';

            if ($currentDate > $dayEnd)  {
                $status = 'Expired';
            }
            if ($currentDate < $dayStart) {
                $status = 'Waiting';
            }   

            $res .= "
            <tr>
                <td>".$line['id_sale']."</td>
                <td>".$line['ten_sale']."</td>
                <td>".$status."</td>
            </tr>";
        }

        $countS = mysqli_num_rows($list);
        if ($countS == 0) {
            $res = false;
        }
        echo $res;
    }
    
    if (isset($_GET['pid'])) {
        $pid = $_GET['pid'];
        $pos = ($pid - 1 ) * 10;
        $sql = "select * from nhom_san_pham limit $pos, 10";
        
        $list = $conn->selectData($sql);
        $res = "                        
        <tr style='border:none'>
            <th>Id Products</th>
            <th>Name Products</th>
            <th>Gender</th>
            <th>Star of Rates</th>
            <th>Number of rates</th>
        </tr>";

        while ($line=mysqli_fetch_array($list)) {
            $gender = '<i class="fas fa-mars" style="color:blue;font-size:24px"></i>';
            if ($line['gioi_tinh'] == 'Female') {
                $gender = '<i class="fas fa-venus" style="color:pink;font-size:24px"></i>';
            }

            $res .= "
            <tr>
                <td>".$line['id_nhomsanpham']."</td>
                <td>".$line['ten_nhomsanpham']."</td>
                <td>".$gender."</td>
                <td>".$line['sosao_danhgia']." <i class='fas fa-star' style='color:orange'></i></td>
                <td>".$line['soluot_danhgia']."</td>
            </tr>";
        }

        $countP = mysqli_num_rows($list);
        if ($countP == 0) {
            $res = false;
        }
        echo $res;
    }
?>