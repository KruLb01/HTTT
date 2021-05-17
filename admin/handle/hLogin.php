<?php
    if (!isset($_POST['username'])&&!isset($_POST['password'])) {
        header('Location: index.php');
    }
    else {
        session_start();
        $user = $_POST['username'];
        $pass = md5($_POST['password']);;
    
        include('../templates/connectData.php');
        $conn = new connectData('');
    
        $sql = "select * from nguoi_dung, admin where nguoi_dung.id_nguoidung = admin.id_nguoidung and nguoi_dung.tai_khoan = rtrim('" . $user . "')";
    
        $res = $conn->selectData($sql);

        while ($row = mysqli_fetch_array($res)) {
            if ($row['tai_khoan'] == $user && $row['mat_khau'] == $pass && $row['tinh_trang_taikhoan'] == true) {
                $_SESSION['user']['id'] = $row['id_nguoidung'];
                $_SESSION['user']['username'] = $row['tai_khoan'];
                $_SESSION['user']['pass'] = $row['mat_khau'];
                $_SESSION['user']['email'] = $row['email'];
                $_SESSION['user']['phone'] = $row['so_dien_thoai'];
                $_SESSION['user']['permission'] = strtoupper($row['quyen'][0]) . strtolower(substr($row['quyen'],1));
                $_SESSION['user']['status'] = $row['tinh_trang_taikhoan'];
                $_SESSION['user']['name'] = $row['ho_ten'];
                $_SESSION['user']['other'] = $row['thong_tin_khac'];
                echo "success";
                return;
            }
        }
        echo 'failed';
    }
?>