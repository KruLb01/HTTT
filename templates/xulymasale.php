<?php
	include 'ConnectionDB.php';
	$con = new ConnectionDB('');
	if(isset($_POST['act']))
	{
		$act = $_POST['act'];
		switch($act)
		{
			case "check":
			{
				$code = $_POST['code'];
				$old_total = $_POST['total'];
				$sql = "SELECT ten_sale,giam_theo_percent from sale where id_sale='$code' and CURRENT_DATE()>ngay_bat_dau and CURRENT_DATE()<ngay_ket_thuc";
				$result = $con->preparedSelect($sql);
				if(mysqli_num_rows($result)==1)
				{
					$row = mysqli_fetch_array($result,MYSQLI_BOTH);
					$subtotal_sale=$old_total * $row[1]/100;
					$new_total = ($old_total-($subtotal_sale));
					$data = array("isValid" => 1,"tensale" => $row[0],"new_total" => number_format($new_total,0,",",".")."<sup>đ</sup>");
					echo json_encode($data);
				}
				else
				{
					$data = array("isValid" => 0);
					echo json_encode($data);
				}
			}
			break;
		}
	}