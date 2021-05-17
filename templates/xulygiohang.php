<?php
include 'ConnectionDB.php';
session_start();
if(isset($_POST['act']))
    {
        $act = $_POST['act'];
        $id_nguoidung = $_SESSION['id_nguoidung'];
        $idsp = $_POST['idsp'];
        switch($act)
        {
            case "add":
            {
                $qty = $_POST['qty'];
                $con = new ConnectionDB('');
                $sql_append = "select * from gio_hang where id_nguoidung='$id_nguoidung' and id_sanpham='$idsp'";
                $result = $con->preparedSelect($sql_append);
                if(!isNotAppropriateQuantity($idsp, $qty))
                {
                    if(mysqli_num_rows($result)===0){
                        $sql = "insert into gio_hang values('$id_nguoidung','$idsp','$qty')";
                        if($con->preparedExecuteDatabase($sql))
                        {
                            DisplayProductAdded($id_nguoidung, $idsp);
                        }
                        else{ 
                            $data = array("msg" => "Lỗi khi thực hiện thêm vào sản phẩm");
                            echo json_encode($data);
                        }
                    }
                    else{
                        $row = mysqli_fetch_array($result);
                        $new_qty = $row[2]+$qty;
                        if(!isNotAppropriateQuantity($idsp,$new_qty))
                        {
                            $sql = "update gio_hang set so_luong=$new_qty where id_nguoidung='$id_nguoidung' and id_sanpham='$idsp'";
                            if($con->preparedExecuteDatabase($sql))
                            {
                                DisplayProductAdded($id_nguoidung, $idsp);
                            }
                            else{ 
                                $data = array("msg" => "Lỗi khi thực hiện cập nhật sản phẩm");
                                echo json_encode($data);
                            }
                        }
                        else{
                            $data = array("msg" => "Số lượng đã vượt quá số lượng hiện có");
                            echo json_encode($data);
                        }
                    }
                }
                else{
                    $data = array("msg" => "Số lượng thêm vào không thể vượt quá số lượng của sản phẩm hiện có");
                    echo json_encode($data);
                }
            }
            break;
            case 'update':
            {
                $qty = $_POST['qty'];
                $con = new ConnectionDB('');
                $sql = "Update gio_hang"
                    ." set so_luong='$qty'"
                    ." where gio_hang.id_nguoidung='$id_nguoidung'"
                    ." and gio_hang.id_sanpham='$idsp'";
                if(!isNotAppropriateQuantity($idsp, $qty))
                {
                    if($con->preparedExecuteDatabase($sql)){
                        $data = array("qty" => $qty,"subtotal" => getSubtotal($id_nguoidung, $idsp),"total" => getTotal($id_nguoidung),"msg"=>"");
                        echo json_encode($data);
                    }
                    else
                    {
                        $data = array("msg" => "Lỗi khi thực hiện quá trình cập nhật");
                        echo json_encode($data);
                    }
                }
                else{
                    $data = array("msg" => "Số lượng thêm vào không thể vượt quá số lượng của sản phẩm hiện có");
                    echo json_encode($data);
                }
            }
            break;
            case 'remove':
            {
                $con = new ConnectionDB('');
                $sql = "Delete from gio_hang"
                    ." where gio_hang.id_nguoidung='$id_nguoidung'"
                    ." and gio_hang.id_sanpham='$idsp'";
                if($con->preparedExecuteDatabase($sql)){
                    $total = getTotal($id_nguoidung);
                    $data = array("total" => $total,"msg" => "");
                    echo json_encode($data);
                }
                else
                {
                    $data = array("msg" => "Lỗi khi thực hiện xóa sản phẩm");
                    echo json_encode($data);
                }
            }
            break;
        }
    }
    function isNotAppropriateQuantity($idsp,$qty) //function check if the quantity of a product's over amounts of this product having [Hàm kiểm tra xem số lượng thêm vào có vượt quá số lượng đang có hay không]
    {
        $con = new ConnectionDB('');
        $sql = "Select so_luong from san_pham where san_pham.id_sanpham='$idsp'";
        $result = $con->preparedSelect($sql);
        $row = mysqli_fetch_array($result);
        $max_quantity = $row[0];
        if($qty>$max_quantity)
        {
            return true;
        }
        else 
        {
            return false;
        }
    }
    function getSubtotal($idnd,$idsp)
    {
        $con = new ConnectionDB('');
        $sql = "select gio_hang.so_luong*san_pham.gia_sanpham"
              ." from gio_hang,san_pham"
              ." where gio_hang.id_sanpham=san_pham.id_sanpham and gio_hang.id_nguoidung='$idnd'"
              ." and gio_hang.id_sanpham='$idsp'";
        $result = $con->preparedSelect($sql);
        if($result)
        {
            $row = mysqli_fetch_array($result);
            return number_format($row[0],0,",",".")."<sup>đ</sup>";
        }
        else{
            return number_format(0,0,",",".")."<sup>đ</sup>";
        }
    }
    function getTotal($idnd)
    {
        $con = new ConnectionDB('');
        $sql = "select sum(gio_hang.so_luong*san_pham.gia_sanpham)"
              ." from gio_hang,san_pham"
              ." where gio_hang.id_sanpham=san_pham.id_sanpham and gio_hang.id_nguoidung='$idnd'";
        $result = $con->preparedSelect($sql);
        if($result!==null){
            $row = mysqli_fetch_array($result);
            return number_format($row[0],0,",",".")."<sup>đ</sup>";
        }
        else{ 
            return number_format(0,0,",",".")."<sup>đ</sup>";
        }
    }
    function DisplayProductAdded($id_nguoidung,$idsp){
        $con = new ConnectionDB('');
        $sql = "SELECT san_pham.id_sanpham,nhom_san_pham.ten_nhomsanpham,c.url,san_pham.size,san_pham.gia_sanpham,gio_hang.so_luong,gio_hang.so_luong*san_pham.gia_sanpham FROM gio_hang,nhom_san_pham,san_pham,hinh_nhomsanpham,(select IFNULL(hinh_anh.link_hinhanh,'') as url,b.id_nhomsanpham from (select nhom_san_pham.id_nhomsanpham,hinh_nhomsanpham.id_hinh from nhom_san_pham left join hinh_nhomsanpham on nhom_san_pham.id_nhomsanpham = hinh_nhomsanpham.id_nhomsanpham) as b LEFT JOIN hinh_anh on b.id_hinh = hinh_anh.id_hinhanh) as c where gio_hang.id_sanpham=san_pham.id_sanpham and nhom_san_pham.id_nhomsanpham = c.id_nhomsanpham and nhom_san_pham.id_nhomsanpham=san_pham.id_nhomsanpham and gio_hang.id_nguoidung='$id_nguoidung' and gio_hang.id_sanpham='$idsp' group by san_pham.id_sanpham";
                $result1 = $con->preparedSelect($sql);
                $row = mysqli_fetch_array($result1);
                $idsp1 = $row[0];
                $tennhomsp = $row[1];
                $hinh = $row[2];
                $size = $row[3];
                $prod_price=number_format($row[4],0,",",".");
                $soluong = $row[5];
                $subtotal=number_format($row[6],0,",",".");
                $data = array("idsp" => $idsp1 ,"tennhom" => $tennhomsp,"hinh" => $hinh,"size" => $size,"giasp" => $prod_price,"soluong" => $soluong,"thanhtien" => $subtotal,"msg" => "");
                echo json_encode($data);
    }