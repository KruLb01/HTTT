<?php
	session_start();
	include 'ConnectionDB.php';
	$con = new ConnectionDB('');
	if(isset($_POST['act']))
	{
		$act = $_POST['act'];
		$id_nguoidung = $_SESSION['id_nguoidung'];
		switch($act)
		{
			case "add":
			{
				$sale_code = $_POST['sale-code'];
				$shipmethod = $_POST['ship_method'];
				$date = date("Y-m-d");
				$id_invoice =  uniqid("HD-",true);
				$total = $_POST['total'];
				$sql = "Insert into hoa_don values ('$id_invoice','$id_nguoidung','','$date','$total','$sale_code')";
				if($con->preparedExecuteDatabase($sql))
				{
					// $last_id = mysqli_insert_id($con->getConnection());
					$sql1 = "Update san_pham INNER JOIN gio_hang on san_pham.id_sanpham = gio_hang.id_sanpham"
						   ." set san_pham.so_luong = san_pham.so_luong - gio_hang.so_luong where gio_hang.id_nguoidung='$id_nguoidung'";
					$sql2 = "Insert into chitiet_hoadon\n"
						   ."Select '$id_invoice',gio_hang.id_sanpham,gio_hang.so_luong,gio_hang.so_luong*san_pham.gia_sanpham"
						   ." from gio_hang,san_pham"
						   ." where gio_hang.id_sanpham = san_pham.id_sanpham and gio_hang.id_nguoidung='$id_nguoidung'";
				    $sql3 ="Delete from gio_hang where gio_hang.id_nguoidung='$id_nguoidung'";
				    $sql4 ="Insert into chitiet_giaohang values ('$id_invoice','$shipmethod','','1')";
					if($con->preparedExecuteDatabase($sql1) && $con->preparedExecuteDatabase($sql2) && $con->preparedExecuteDatabase($sql3) && $con->preparedExecuteDatabase($sql4))
					{
						$data = array("msg" => "Thêm mới hóa đơn thành công","success" => 1);
						echo json_encode($data);
					}
					else{
						$data = array("msg" => "Lỗi khi thêm mới hóa đơn","success" => 0);
						echo json_encode($data);
					}
				}
				else{
						$data = array("msg" => "Lỗi khi thêm mới hóa đơn","success" => 0);
						echo json_encode($data);
				}
			}
			break;
			case "view_detail":
			{
				$idhoadon = $_POST['id_hoadon'];
				$sql = "SELECT chitiet_hoadon.so_luong,chitiet_hoadon.so_luong*san_pham.gia_sanpham,nhom_san_pham.ten_nhomsanpham,size,c.url from hoa_don,chitiet_hoadon,nhom_san_pham,san_pham,(select IFNULL(hinh_anh.link_hinhanh,'') as url,b.id_nhomsanpham from (select nhom_san_pham.id_nhomsanpham,hinh_nhomsanpham.id_hinh from nhom_san_pham left join hinh_nhomsanpham on nhom_san_pham.id_nhomsanpham = hinh_nhomsanpham.id_nhomsanpham) as b LEFT JOIN hinh_anh on b.id_hinh = hinh_anh.id_hinhanh) as c where hoa_don.id_hoadon = chitiet_hoadon.id_hoadon and san_pham.id_nhomsanpham=nhom_san_pham.id_nhomsanpham and san_pham.id_sanpham=chitiet_hoadon.id_sanpham and c.id_nhomsanpham = nhom_san_pham.id_nhomsanpham and hoa_don.id_hoadon = '$idhoadon' group by nhom_san_pham.id_nhomsanpham";
				$result = $con->preparedSelect($sql);
				if(mysqli_num_rows($result)>0)
				{
					$arraydata = array();
					$total = 0;
					while($row = mysqli_fetch_array($result))
					{
						$total += $row[1];
						$money_format = number_format($row[1],0,",",".")."<sup>đ</sup>";
						$data = 
						array("hinh" => $row[4],"so_luong" =>$row[0],"thanhtien" => $money_format,"ten_nhomsp" =>$row[2],"size" => $row[3]);
						array_push($arraydata, $data);
					}
					$sql1 = "SELECT ten_phuongthuc from chitiet_giaohang,phuongthuc_giaohang where
							 chitiet_giaohang.phuongthuc_giaohang=phuongthuc_giaohang.id_phuongthuc
                             and chitiet_giaohang.id_hoadon='$idhoadon'";
					$sql2 = "SELECT IFNULL(ten_sale,'Không'),IFNULL(giam_theo_percent,'0') from hoa_don LEFT join sale on 	   hoa_don.id_sale = sale.id_sale where hoa_don.id_hoadon = '$idhoadon'";
					$result1 = $con->preparedSelect($sql1);
					$result2 = $con->preparedSelect($sql2);
					$row1 = mysqli_fetch_array($result1);
					$shipmethod = $row1[0];
					$row2 = mysqli_fetch_array($result2);
					$giam_theo_percent = $row2[1];
					$ten_sale = $row2[0];
					$subtotal_sale=$total * $row2[1]/100;
					$new_total = ($total-($subtotal_sale));
					$money_format = number_format($total,0,",",".")."<sup>đ</sup>";
					$newmoney_format = number_format($new_total,0,",",".")."<sup>đ</sup>";
					$data = array("listsp"=>$arraydata,"pt_giaohang" => $shipmethod,"ten_sale" => $ten_sale ,"giam_theo_percent" => "$giam_theo_percent%","total" => "$money_format","new_total" => "$newmoney_format","success" => 1);
					echo json_encode($data);
				}
				else
				{
					$data = array("success" => 0);
					echo json_encode($data);
				}
			}
			break;
			case "delete":
			{
				$idhoadon = $_POST['id_hoadon'];
				$sql = "select * from hoa_don,chitiet_giaohang where hoa_don.id_hoadon = chitiet_giaohang.id_hoadon
						and hoa_don.id_hoadon = '$idhoadon' and chitiet_giaohang.tinhtrang_giaohang = '1'";
				$result = $con->preparedSelect($sql);
				if(mysqli_num_rows($result)>0)
				{
					$sql1="UPDATE san_pham INNER JOIN chitiet_hoadon on san_pham.id_sanpham = chitiet_hoadon.id_sanpham "
					."set san_pham.so_luong = san_pham.so_luong + chitiet_hoadon.so_luong where chitiet_hoadon.id_hoadon='$idhoadon'";
					$sql2="DELETE from chitiet_giaohang where chitiet_giaohang.id_hoadon = '$idhoadon'";
					$sql3="DELETE from chitiet_hoadon where chitiet_hoadon.id_hoadon = '$idhoadon'";
					$sql4="DELETE from hoa_don where hoa_don.id_hoadon = '$idhoadon'";
					if($con->preparedExecuteDatabase($sql1) && $con->preparedExecuteDatabase($sql2) && $con->preparedExecuteDatabase($sql3) && $con->preparedExecuteDatabase($sql4))
					{
						$data = array("msg" => "Xóa hóa đơn thành công","success" => "1");
						echo json_encode($data);
					}
					else{
						$data = array("msg" => "Lỗi khi thực hiện xóa hóa đơn","success" => "0");
						echo json_encode($data);
					}
				}
				else{
					$data = array("msg" => "Thao tác thất bại","success" => "0");
					echo json_encode($data);
				}
			}
		}
	}