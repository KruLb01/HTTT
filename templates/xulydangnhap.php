<?php
    session_start();
    include 'ConnectionDB.php';
    if(isset($_POST['username']) && isset($_POST['password']))
    {
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $conn = new ConnectionDB('');
        $sql = "select nguoi_dung.id_nguoidung,khach_hang.ho_ten from nguoi_dung,khach_hang where tai_khoan = '$username' and mat_khau = '$password' and nguoi_dung.id_nguoidung = khach_hang.id_nguoidung and tinh_trang_taikhoan = true";
        $result =  $conn->preparedSelect($sql);      
        if(mysqli_num_rows($result)>0){
            $data['passedLogin']=1;
            $row = mysqli_fetch_array($result);
            $_SESSION['id_nguoidung'] = $row[0];
            $_SESSION['hoten'] = $row[1];
            echo json_encode($data);
        }
        else
        {
            $data['passedLogin']=0;
            echo json_encode($data);
        }
    }
