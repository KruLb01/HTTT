<?php
    include 'ConnectionDB.php';
    if(isset($_POST['username']) && isset($_POST['password']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $conn = new ConnectionDB('');
        $sql = "select nguoi_dung.id_nguoidung,khach_hang.ho_ten from nguoi_dung,khach_hang where tai_khoan = '$username' and mat_khau = '$password'";        
        if($conn->preparedSelect($sql)!==null){
            $data['passedLogin']=true;
            session_start();
            $row = mysqli_fetch_array($conn->preparedSelect($sql));
            $_SESSION['id_nguoidung'] = $row[0];
            $_SESSION['hoten'] = $row[1];
            echo json_encode($data);
        }
        else
        {
            $data['passedLogin']=false;
            echo json_encode($data);
        }
    }
