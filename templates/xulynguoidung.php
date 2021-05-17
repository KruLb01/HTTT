<?php
    session_start();
    include 'ConnectionDB.php';
    $con = new ConnectionDB('');
    if(isset($_POST['user_act']))
    {
        $user_act = $_POST['user_act'];
        switch ($user_act)
        {
            case "update":
            {
                $id_nguoidung = $_SESSION['id_nguoidung'];
                $addr = $_POST['address'];
                $other_info = $_POST['other-info'];
                $email = $_POST['email'];
                $password = md5($_POST['password']);
                $sql = "Update nguoi_dung,khach_hang"
                      ." set nguoi_dung.mat_khau='$password',"
                      ." nguoi_dung.email='$email',"
                      ." khach_hang.dia_chi='$addr',"
                      ." khach_hang.thong_tin_khac='$other_info'"
                      ." where nguoi_dung.id_nguoidung=khach_hang.id_nguoidung"
                      ." and nguoi_dung.id_nguoidung='$id_nguoidung'";
                if($con->preparedExecuteDatabase($sql))
                {
                    $data = array("address" => $addr,"other-info" => $other_info,"email" => $email,"password" => $password,"msg"=>'');
                    echo json_encode($data);
                }
                else{
                    $data = array("msg" => 'Lỗi khi cập nhật thông tin');
                    echo json_encode($data);
                }
            }
            break;
            case "add":
            {
                function checkExistEmail($email)
                {
                    $conn = new ConnectionDB('');
                    $sql = "select id_nguoidung from nguoi_dung where nguoi_dung.email='$email'";
                    $result = $conn->preparedSelect($sql);
                    if(mysqli_num_rows($result)>0)
                    {
                        return true;
                    }
                    return false;
                }
                function checkExistUsername($username)
                {
                    $conn = new ConnectionDB('');
                    $sql = "select id_nguoidung from nguoi_dung where nguoi_dung.tai_khoan='$username'";
                    $result = $conn->preparedSelect($sql);
                    if(mysqli_num_rows($result)>0)
                    {
                        return true;
                    }
                    return false;
                }
                function checkExistPhoneNumber($phonenumber)
                {
                    $conn = new ConnectionDB('');
                    $sql = "select nguoi_dung.id_nguoidung from nguoi_dung where nguoi_dung.so_dien_thoai='$phonenumber'";
                    $result = $conn->preparedSelect($sql);
                    if(mysqli_num_rows($result)>0)
                    {
                        return true;
                    }
                    return false;
                }
                $taikhoan = $_POST['tendangnhap'];
                $hoten = $_POST['hoten'];
                $matkhau = md5($_POST['password']);
                $sodienthoai = $_POST['sodienthoai'];
                $thong_tin_khac = $_POST['thongtinkhac'];
                $diachi = $_POST['diachi'];
                $email = $_POST['email'];
                $isExistUserName = checkExistUsername($taikhoan);
                $isExistEmail = checkExistEmail($email);
                $isExistPhoneNumber = checkExistPhoneNumber($sodienthoai);
                if(!$isExistEmail && !$isExistUserName && !$isExistPhoneNumber)
                {
                    $sql1 = "insert into nguoi_dung\n
                             select concat('KH',count(id_nguoidung)+1),'$taikhoan','$matkhau','$email','$sodienthoai','customer','1'
                             from nguoi_dung where nguoi_dung.quyen = 'customer'";
                    if($con->preparedExecuteDatabase($sql1))
                    {
                        $sql3 = "SELECT id_nguoidung FROM `nguoi_dung` where quyen = 'customer' ORDER by id_nguoidung DESC limit 1";
                        $result3 = $con->preparedSelect($sql3);
                        $row3 = mysqli_fetch_array($result3);
                        $last_id = $row3[0];
                        $sql2 = "insert into khach_hang values ('$last_id','$hoten','$diachi','$thong_tin_khac')";
                        if($con->preparedExecuteDatabase($sql2)){
                            $_SESSION['id_nguoidung'] = $last_id;
                            $_SESSION['hoten'] = $hoten;
                            $data = array("msg" => "Đăng kí thành công!","success" => 1);
                            echo json_encode($data);
                        }
                        else
                        {
                            $data = array("msg" => "Lỗi khi đăng kí tài khoản!","success" => 0);
                            echo json_encode($data);
                        }
                    }
                    else{
                        $data = array("msg" => "Lỗi khi đăng kí tài khoản!","success" => 0);
                        echo json_encode($data);
                    }
                }
                else if($isExistUserName){
                    $data = array("msg" => "Tài khoản đã tồn tại!","success" => 0);
                    echo json_encode($data);
                }
                else if($isExistEmail){
                    $data = array("msg" => "Email đã tồn tại!","success" => 0);
                    echo json_encode($data);
                }
                else{
                    $data = array("msg" => "Số điện thoại đã tồn tại!","success" => 0);
                    echo json_encode($data);
                }
            }
            break;
        }
    }

