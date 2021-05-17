<?php
    session_start();
    if (isset($_GET['action'])) $action = $_GET['action'];
    if (isset($_POST['action'])) $action = $_POST['action'];

    include('../templates/connectData.php');
    $conn = new connectData('');

    if ($action == 'view') {
        $id = $_GET['user-id'];
        $username = $_GET['username'];
        $email = $_GET['user-email'];
        $phone = $_GET['user-phone'];
        $other = $_GET['other-information'];
    
        $sql = "update admin, nguoi_dung set admin.ho_ten = N'$username', 
                nguoi_dung.email = '$email', 
                admin.thong_tin_khac = N'$other',
                nguoi_dung.so_dien_thoai = '$phone'
                where admin.id_nguoidung = '$id' and nguoi_dung.id_nguoidung = '$id'";
        
        echo $res = $conn->executeQuery($sql) == true ? '1' : '0';
        $_SESSION['user']['name'] = $username;
        $_SESSION['user']['email'] = $email;
        $_SESSION['user']['phone'] = $phone;
        $_SESSION['user']['other'] = $other;
    } else if ($action == 'change-password') {
        $id = $_POST['user-id'];
        $old = trim($_POST['old-password']);
        $new = trim($_POST['new-password']);

        $current = trim($conn->executeQuery("select mat_khau from nguoi_dung where id_nguoidung = '$id'"));

        if ($current != $old) {
            echo 'incorrect';
            return;
        }
        $sql = "update nguoi_dung set mat_khau = '" . md5($new) . "' where id_nguoidung = '$id'";
        echo $res = $conn->executeQuery($sql) == true ? '1' : '0';
    }

?>