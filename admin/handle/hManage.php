<?php
    if(isset($_GET['page'])) {
        $page = $_GET['page'];
        if (isset($_GET['num'])) $numShow = $_GET['num'];
        if (isset($_GET['pag'])) $pag = ($_GET['pag']-1) * $numShow;

        include('../templates/connectData.php');
        session_start();
        $conn = new connectData('');
        $sql =  '';
        $show = '';

        
        if ($page == 'Manage Permission'){


            if (isset($_GET['numPag'])) {
                $numPag = $_GET['numPag'];
                if (isset($_GET['textShow'])) {
                    $sum = mysqli_fetch_array($conn->selectData('select count(*) as count from quyen where id_quyen != "customer"'))['count'];
                    echo "( ".($pag+1)." - ".($numShow+$pag)." of $sum results )";
                    return;
                }
                echo $count = ceil(mysqli_fetch_array($conn->selectData('select count(*) as count from quyen where id_quyen != "customer"'))['count']/$numShow);
                return;
            }

            if (isset($_GET['idView'])) {
                $id = $_GET['idView'];
                $idRes = $conn->selectData("SELECT chuc_nang.ten_chucnang as i
                                FROM chuc_nang, chitiet_quyen_chucnang, quyen 
                                WHERE chuc_nang.id_chucnang = chitiet_quyen_chucnang.id_chucnang 
                                and chitiet_quyen_chucnang.id_quyen = quyen.id_quyen
                                AND chitiet_quyen_chucnang.id_quyen = '$id'");
                while ($line = mysqli_fetch_array($idRes)) echo $line['i'].'/';
                return;
            }

            if (isset($_GET['add'])) {
                if (isset($_GET['valCB'])) {
                    $valCB = explode("-",$_GET['valCB']);
                }
                if (isset($_GET['valText'])) {
                    $valText = explode("-",$_GET['valText']);
                }
                $resAdd = $conn->executeQuery("insert into quyen(id_quyen, ten_quyen, mieuta) values('".$valText[0]."', N'".$valText[1]."', N'".$valText[2]."')");
                for ($i = 0; $i < sizeof($valCB); $i ++) {
                    $resAdd = $conn->executeQuery("insert into chitiet_quyen_chucnang(id_quyen, id_chucnang) values('".$valText[0]."', '".$valCB[$i]."')");
                }
                echo $resAdd;
                return;
            }

            if (isset($_GET['update'])) {
                if (isset($_GET['val'])) {
                    $val = explode("~",$_GET['val']);
                }

                if ($val[0]== 'text') {
                    $resUpdate = $conn->executeQuery("update quyen set ten_quyen = '".$val[2]."', mieuta = '".$val[3]."' where id_quyen = '".$val[1]."'");
                    echo $resUpdate;
                    return;
                }
                if ($val[0]== 'checkbox') {
                    if ($val[2]=='insert') {
                        $resUpdate = $conn->executeQuery("INSERT INTO `chitiet_quyen_chucnang`(`id_quyen`, `id_chucnang`) 
                        VALUES ('".$val[3]."',(SELECT chuc_nang.id_chucnang FROM chuc_nang WHERE chuc_nang.ten_chucnang = '".$val[1]."'))");
                    } else if ($val[2]=='delete') {
                        $resUpdate = $conn->executeQuery("DELETE FROM `chitiet_quyen_chucnang` 
                        WHERE id_quyen = '".$val[3]."' and id_chucnang = (SELECT id_chucnang FROM chuc_nang WHERE ten_chucnang = '".$val[1]."')");
                    }
                    echo $resUpdate;
                    return;
                }
                if ($val[0]=='delete') {
                    $resUpdate = $conn->executeQuery("delete from quyen where id_quyen = '".$val[1]."'");
                    $resUpdate = $conn->executeQuery("delete from chitiet_quyen_chucnang where id_quyen = '".$val[1]."'");
                    echo $resUpdate;
                    return;
                }
            }
            
            $sql = "SELECT *
            FROM quyen
            WHERE id_quyen != 'customer' 
            ORDER by ";
            if (isset($_GET['title'])&&isset($_GET['sort'])&&$_GET['title']!="") {
                $title = $_GET['title'];
                $sort = $_GET['sort'];
                if ($title=="Id Permission") {
                    $sql .= "cast(id_quyen as unsigned) $sort ";
                } else if ($title=="Name Permission") {
                    $sql .= "ten_quyen $sort ";
                } else if ($title=="Note Permission") {
                    $sql .= "mieuta $sort ";
                } else if ($title=="Quantity of Accounts") {
                    $sql .= "so_luong $sort ";
                }
            } else $sql .= "cast(id_quyen as unsigned) ";
            $sql .= " LIMIT $pag,$numShow";

            if (isset($_GET['search'])) {
                if (isset($_GET['val'])) {
                    $val = explode("-",$_GET['val']);
                }
                if ($val[0] != 'none') {
                    $sql = "SELECT *
                    FROM quyen
                    WHERE " . $val[0] . " like '%" . $val[1] .  "%' 
                    and id_quyen != 'customer'
                    ORDER by cast(id_quyen as unsigned)
                    LIMIT $pag,$numShow";
                }
            }

            $res = $conn->selectData($sql);
            $show = "
            <tr>
                <th>Id Permission</th>
                <th>Name Permission</th>
                <th>Note Permission</th>
                <th>Quantity of Accounts</th>
                <th>Action</th>
            </tr>
            ";

            if (isset($_GET['popUp'])) {
                $show = '';
                while($line=mysqli_fetch_array($res)) {
                    $show .= "
                    <div class='dashboard-manage-pop-up'>
                        <div class='dashboard-manage-pop-up-items'>
                            <i class='fas fa-times dm-pop-up-close-btn'></i>
                            <div class='dashboard-manage-pop-up-info'>
                                <span>Id Permission : <input type='text' class='disable' value='".$line['id_quyen']."'></span>
                                <span>Name Permission : <input type='text' class='dm-can-del' placeholder='".$line['ten_quyen']."'></span>
                                <span>Note Permission : <input type='text' class='dm-can-del' placeholder='".$line['mieuta']."'></span>
                                <div class='dm-pop-up-btn disable-copy'>
                                    <span class='dm-pop-up-save-btn'>Save</span>
                                    <span class='dm-pop-up-reset-btn'>Reset</span>
                                </div>
                            </div>
                            <div class='dashboard-manage-pop-up-act'>
                                <span>Set permission : </span>
                                <div class='dashboard-manage-pop-up-act-checkbox'>";
                    $temp = $conn->selectData('select * from chuc_nang order by vi_tri');   
                    while ($tmpLine=mysqli_fetch_array($temp)) {
                        $show .= "<span class='dm-pop-up-cbox";
                        if ((int)$tmpLine['vi_tri']%1000==0) {
                            $show .= " dm-pop-up-main";
                        }
                        $show .= "'><input type=checkbox ";
                        $show .= ">".$tmpLine['ten_chucnang']."</span>";
                    }
                        $show .="</div>
                            </div>
                        </div>
                    </div>
                    ";
                }
                echo $show;
                return;
            }

            $countPos = 0;
            while($line=mysqli_fetch_array($res)) {
                $show .= "
                <tr>
                    <td>".$line['id_quyen']."</td>
                    <td>".$line['ten_quyen']."</td>
                    <td>".$line['mieuta']."</td>
                    <td>".$line['so_luong']."</td>
                    <td>
                        <div class='dashboard-manage-table-action disable-copy' id='action-$countPos'>
                            <ul class='dashboard-manage-table-action-items'>
                                <li>Update</li>
                                <li>Delete</li>
                            </ul>
                        </div>
                    </td>
                </tr>
                ";
                $countPos++;
            }
        }

        if ($page == 'Manage Products'){

            if (isset($_GET['numPag'])) {
                $numPag = $_GET['numPag'];
                if (isset($_GET['textShow'])) {
                    $sum = mysqli_fetch_array($conn->selectData('select count(*) as count from nhom_san_pham'))['count'];
                    echo "( ".($pag+1)." - ".($numShow+$pag)." of $sum results )";
                    return;
                }
                echo $count = ceil(mysqli_fetch_array($conn->selectData('select count(*) as count from nhom_san_pham'))['count']/$numShow);
                return;
            }

            if (isset($_GET['idView'])) {
                $id = $_GET['idView'];
                $idRes = $conn->selectData("SELECT gioi_tinh as i
                                FROM nhom_san_pham
                                WHERE id_nhomsanpham = '$id'");
                while ($line = mysqli_fetch_array($idRes)) echo $line['i'].'/';
                return;
            }

            if (isset($_GET['add'])) {
                if (isset($_GET['valCB'])) {
                    $valCB = explode("-",$_GET['valCB']);
                    $gender = $valCB[0] == true ? 'Male' : 'Female';
                }
                if (isset($_GET['valText'])) {
                    $valText = explode("-",$_GET['valText']);
                }
                $resAdd = $conn->executeQuery("insert into nhom_san_pham(id_nhomsanpham, ten_nhomsanpham, gioi_tinh, mieuta, mau_sanpham, id_dongsanpham)
                                                values('".$valText[0]."', '".$valText[1]."', '$gender', '".$valText[3]."', '".$valText[2]."', '".$valText[4]."')");
                echo $resAdd;
                return;
            }

            if (isset($_GET['update'])) {
                if (isset($_GET['val'])) {
                    $val = explode("~",$_GET['val']);
                }

                if ($val[0]== 'text') {
                    $resUpdate = $conn->executeQuery("update nhom_san_pham set ten_nhomsanpham = '".$val[2]."', mau_sanpham = '".$val[3]."', mieuta = '".$val[4]."' where id_nhomsanpham = '".$val[1]."'");
                    // add sale
                    $resUpdate = $conn->executeQuery("delete from chitiet_sale where id_nhomsanpham = '".$val[1]."'");
                    $resUpdate = $conn->executeQuery("insert into chitiet_sale(id_sale, id_nhomsanpham) values('".$val[7]."', '".$val[1]."')");
                    echo $resUpdate;
                    return;
                }
                if ($val[0]== 'checkbox') {
                    $statusAccount = $val[1] == 0 ? "'Male'" : "'Female'";
                    $resUpdate = $conn->executeQuery("update nhom_san_pham set gioi_tinh = $statusAccount where id_nhomsanpham = '".$val[2]."'");
                    echo $resUpdate;
                    return;
                }
                if ($val[0]=='delete') {
                    $resUpdate = $conn->executeQuery("delete from nhom_san_pham where id_nhomsanpham = '".$val[1]."'");
                    $resUpdate = $conn->executeQuery("delete from san_pham where id_nhomsanpham = '".$val[1]."'");
                    echo $resUpdate;
                    return;
                }
            }

            $sql = "select * 
                    from nhom_san_pham
                    order by ";
            if (isset($_GET['title'])&&isset($_GET['sort'])&&$_GET['title']!="") {
                $title = $_GET['title'];
                $sort = $_GET['sort'];
                if ($title=="Id Products") {
                    $sql .= "cast(id_nhomsanpham as unsigned) $sort ";
                } else if ($title=="Name Products") {
                    $sql .= "ten_nhomsanpham $sort ";
                } else if ($title=="Gender") {
                    $sql .= "gioi_tinh $sort ";
                } else if ($title=="Stars Rated") {
                    $sql .= "sosao_danhgia $sort ";
                } else if ($title=="Buyed") {
                    $sql .= "id_nhomsanpham $sort ";
                }
            } else $sql .= "cast(id_nhomsanpham as unsigned) ";
            $sql .= " limit $pag, $numShow";
            
            if (isset($_GET['search'])) {
                if (isset($_GET['val'])) {
                    $val = explode("-",$_GET['val']);
                }
                if ($val[0] != 'none') {
                    $sql = "SELECT*
                        FROM nhom_san_pham
                        WHERE " . $val[0] . " like '%" . $val[1] .  "%' 
                        ORDER by id_nhomsanpham
                        LIMIT $pag,$numShow";
                }
            }

            $res = $conn->selectData($sql);
            $show = "
            <tr>
                <th>Id Products</th>
                <th>Name Products</th>
                <th>Gender</th>
                <th>Stars Rated</th>
                <th>Buyed</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            ";

            if (isset($_GET['popUp'])) {
                $show = '';
                while($line=mysqli_fetch_array($res)) {
                    $show .= "
                    <div class='dashboard-manage-pop-up'>
                        <div class='dashboard-manage-pop-up-items'>
                            <i class='fas fa-times dm-pop-up-close-btn'></i>
                            <div class='dashboard-manage-pop-up-info'>
                                <span>Id Product : <input type='text' class='disable' value='".$line['id_nhomsanpham']."'></span>
                                <span>Name Product : <input type='text' class='dm-can-del' placeholder='".$line['ten_nhomsanpham']."'></span>
                                <span>Color Product : <input type='text' class='dm-can-del' placeholder='".$line['mau_sanpham']."'></span>
                                <span>Description : <input type='text' class='dm-can-del' placeholder='".$line['mieuta']."'></span>
                                <span>
                                    Sale :
                                    <select>
                                        ";
                        $res1 = $conn->selectData("select * from sale order by ten_sale");
                        $res2 = $conn->selectData("select sale.id_sale, ten_sale from chitiet_sale, sale where chitiet_sale.id_sale = sale.id_sale and id_nhomsanpham = '".$line['id_nhomsanpham']."'");
                        $id_current = "";
                        if (mysqli_num_rows($res2)==0) {
                            $show .="<option value=''>-</option>";
                        } else {
                            $fetch = mysqli_fetch_array($res2);
                            $id_current = $fetch['id_sale'];
                            $show .= "<option value='".$id_current."'>".$fetch['ten_sale']."</option>";
                        }
                        while ($row = mysqli_fetch_array($res1)) {
                            if ($row['id_sale']==$id_current) continue;
                            $show .= "<option value='".$row['id_sale']."'>".$row['ten_sale']."</option>";
                        }
                        $show .= "
                                    </select>
                                </span>
                                <div class='dm-pop-up-btn disable-copy'>
                                    <span class='dm-pop-up-save-btn'>Save</span>
                                    <span class='dm-pop-up-reset-btn'>Reset</span>
                                </div>
                            </div>";
                    $show .= "
                            <div class='dashboard-manage-pop-up-act'>
                                <span>Gender : </span>
                                <div class='dashboard-manage-pop-up-act-checkbox'>
                                    <span class='dm-pop-up-cbox'><input type=radio value='Male' name='gender'> Male</span>
                                    <span class='dm-pop-up-cbox'><input type=radio value='Female' name='gender'> Female</span>
                                </div>

                            </div>";
               
                        $show .="
                        </div>
                    </div>
                    ";
                }
                echo $show;
                return;
            }
            
            $countPos = 0;
            while($line=mysqli_fetch_array($res)) {
                $total = mysqli_fetch_array($conn->selectData("select sum(so_luong) as tong from nhom_san_pham, san_pham where nhom_san_pham.id_nhomsanpham = san_pham.id_nhomsanpham and nhom_san_pham.id_nhomsanpham = '".$line['id_nhomsanpham']."'"))['tong'];
                if ($total == "") $total = 0;
                $gender = '<i class="fas fa-mars" style="color:blue;font-size:24px"></i>';
                if ($line['gioi_tinh'] == 'Female') {
                    $gender = '<i class="fas fa-venus" style="color:pink;font-size:24px"></i>';
                }

                $show .= "
                <tr>
                    <td>".$line['id_nhomsanpham']."</td>
                    <td>".$line['ten_nhomsanpham']."</td>
                    <td>".$gender."</td>
                    <td>".$line['sosao_danhgia']." <i class='fas fa-star' style='color:orange'></i></td>
                    <td>0</td>
                    <td>$total</td>
                    <td>
                        <div class='dashboard-manage-table-action disable-copy' id='action-$countPos'>
                            <ul class='dashboard-manage-table-action-items'>
                                <li>Update</li>
                                <li>Delete</li>
                            </ul>
                        </div>
                    </td>
                </tr>
                ";
                $countPos++;
            }
        }

        if ($page == 'Manage Employees'){
            if (isset($_GET['numPag'])) {
                $numPag = $_GET['numPag'];
                if (isset($_GET['textShow'])) {
                    $sum = mysqli_fetch_array($conn->selectData('select count(*) as count from admin,nguoi_dung where admin.id_nguoidung=nguoi_dung.id_nguoidung'))['count'];
                    echo "( ".($pag+1)." - ".($numShow+$pag)." of $sum results )";
                    return;
                }
                echo $count = ceil(mysqli_fetch_array($conn->selectData('select count(*) as count from admin,nguoi_dung where admin.id_nguoidung=nguoi_dung.id_nguoidung'))['count']/$numShow);
                return;
            }

            if (isset($_GET['idView'])) {
                $id = $_GET['idView'];
                $idRes = mysqli_fetch_array($conn->selectData("SELECT tinh_trang_taikhoan as i
                                                        FROM nguoi_dung
                                                        WHERE id_nguoidung = '$id'"))['i'] == 0 ? 'Block' : 'Active';
                echo $idRes.'/';
                return;
            }

            if (isset($_GET['add'])) {
                if (isset($_GET['valCB'])) {
                    $valCB = explode("-",$_GET['valCB']);
                }
                if (isset($_GET['valText'])) {
                    $valText = explode("-",$_GET['valText']);
                    $pass = md5($valText[4]);
                }
                $resAdd = $conn->executeQuery("insert into nguoi_dung(id_nguoidung, tai_khoan, mat_khau, email, so_dien_thoai, quyen, tinh_trang_taikhoan) 
                                                values('".$valText[0]."', '".$valText[3]."', '".$pass."', '".$valText[2]."', '".$valText[5]."', '".$valText[6]."', ".$valCB[0].")");
                $resAdd = $conn->executeQuery("insert into admin(id_nguoidung, ho_ten, thong_tin_khac) values('".$valText[0]."', '".$valText[1]."', '')");
                $resAdd = $conn->executeQuery("update quyen set so_luong = so_luong + 1 where id_quyen = '".$valText[6]."'");
                echo $resAdd;
                return;
            }

            if (isset($_GET['update'])) {
                if (isset($_GET['val'])) {
                    $val = explode("~",$_GET['val']);
                }

                if ($val[0]== 'text') {
                    $resUpate = $conn->executeQuery("update admin,nguoi_dung set admin.ho_ten = N'".$val[2]."', nguoi_dung.so_dien_thoai = '".$val[3]."', nguoi_dung.email ='".$val[4]."', nguoi_dung.mat_khau ='".md5($val[5])."', nguoi_dung.quyen = '".$val[7]."' where admin.id_nguoidung = '".$val[1]."' and nguoi_dung.id_nguoidung='".$val[1]."'");
                    echo $resUpate;
                    return;
                }
                if ($val[0]== 'checkbox') {
                    $statusAccount = $val[1] == 0 ? 'true' : 'false';
                    $resUpdate = $conn->executeQuery("update nguoi_dung set tinh_trang_taikhoan = $statusAccount where id_nguoidung = '".$val[2]."'");
                    echo $resUpdate;
                    return;
                }
                if ($val[0]=='delete') {
                    $resUpdate = $conn->executeQuery("update quyen set so_luong = so_luong - 1 where id_quyen = (select quyen from nguoi_dung where id_nguoidung = '".$val[1]."')");
                    $resUpdate = $conn->executeQuery("delete from admin where id_nguoidung = '".$val[1]."'");
                    $resUpdate = $conn->executeQuery("delete from nguoi_dung where id_nguoidung = '".$val[1]."'");
                    echo $resUpdate;
                    return;
                }
            }    
            
            $sql = "select *
            from admin,nguoi_dung
            where admin.id_nguoidung = nguoi_dung.id_nguoidung 
            ORDER by ";
            if (isset($_GET['title'])&&isset($_GET['sort'])) {
                $title = $_GET['title'];
                $sort = $_GET['sort'];
                if ($title=="") $sql .= "cast(admin.id_nguoidung as unsigned) ";
                if ($title=="Id Employees") {
                    $sql .= "admin.id_nguoidung $sort ";
                } else if ($title=="Name Employees") {
                    $sql .= "ho_ten $sort ";
                } else if ($title=="Phone") {
                    $sql .= "so_dien_thoai $sort ";
                } else if ($title=="Permission") {
                    $sql .= "quyen $sort ";
                }
            }
            else {
                $sql .= "cast(admin.id_nguoidung as unsigned) ";
            }
            $sql .= " LIMIT $pag,$numShow";

            if (isset($_GET['search'])) {
                if (isset($_GET['val'])) {
                    $val = explode("-",$_GET['val']);
                }
                if ($val[0] != 'none') {
                    if ($val[0]=='id_nguoidung'){
                        $sql = "SELECT *
                        FROM admin,nguoi_dung
                        WHERE admin.id_nguoidung=nguoi_dung.id_nguoidung and 
                        nguoi_dung." . $val[0] . " like '%" . $val[1] .  "%' 
                        ORDER by cast(nguoi_dung.id_nguoidung as unsigned)
                        LIMIT $pag,$numShow";
                    } else {
                        $sql = "SELECT *
                        FROM admin,nguoi_dung
                        WHERE admin.id_nguoidung=nguoi_dung.id_nguoidung and 
                        " . $val[0] . " like '%" . $val[1] .  "%' 
                        ORDER by cast(nguoi_dung.id_nguoidung as unsigned)
                        LIMIT $pag,$numShow";
                    }
                }
            }

            // echo $sql;
            // return;
            
            $res = $conn->selectData($sql);
            $show = "
            <tr>
                <th>Id Employees</th>
                <th>Name Employees</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Permission</th>
                <th>Action</th>
            </tr>
            ";

            if (isset($_GET['popUp'])) {
                $show = '';
                while($line=mysqli_fetch_array($res)) {
                    $show .= "
                    <div class='dashboard-manage-pop-up'>
                        <div class='dashboard-manage-pop-up-items'>
                            <i class='fas fa-times dm-pop-up-close-btn'></i>
                            <div class='dashboard-manage-pop-up-info'>
                                <span>Id Employee : <input type='text' class='disable' value='".$line['id_nguoidung']."'></span>
                                <span>Name Employee : <input type='text' class='dm-can-del' placeholder='".$line['ho_ten']."'></span>
                                <span>Phone Employee : <input type='text' class='dm-can-del' placeholder='".$line['so_dien_thoai']."'></span>
                                <span>Email Employee : <input type='text' class='dm-can-del' placeholder='".$line['email']."'></span>
                                <span>Password Employee : <input type='text' class='dm-can-del' placeholder='*****'></span>
                                <span>
                                    Permission Employee :
                                    <select>
                                        ";
                        $res1 = $conn->selectData("select * from quyen where id_quyen = '".$line['quyen']."'");
                        while ($row = mysqli_fetch_array($res1)) {
                            $show .= "<option value='".$row['id_quyen']."'>".$row['ten_quyen']."</option>";
                        }

                        $res2 = $conn->selectData("select * from quyen where id_quyen != 'customer' and id_quyen != '".$line['quyen']."' order by id_quyen");
                        while ($row = mysqli_fetch_array($res2)) {
                            $show .= "<option value='".$row['id_quyen']."'>".$row['ten_quyen']."</option>";
                        }
                        $show .= "
                                    </select>
                                </span>
                                <div class='dm-pop-up-btn disable-copy'>
                                    <span class='dm-pop-up-save-btn'>Save</span>
                                    <span class='dm-pop-up-reset-btn'>Reset</span>
                                </div>
                            </div>";
                    $show .= "
                    <div class='dashboard-manage-pop-up-act'>
                        <span>Set login : </span>
                        <div class='dashboard-manage-pop-up-act-checkbox'>
                            <span class='dm-pop-up-cbox'><input type=radio name='status'> Active</span>
                            <span class='dm-pop-up-cbox'><input type=radio name='status'> Block</span>
                        </div>
                    </div>
                    ";
                    $show .="
                        </div>
                    </div>
                    ";
                }
                echo $show;
                return;
            }

            $countPos = 0;
            while($line=mysqli_fetch_array($res)) {
                $status = $line['tinh_trang_taikhoan'] == true ? 'Activing': 'Blocked';
                $show .= "
                <tr>
                    <td>".$line['id_nguoidung']."</td>
                    <td>".$line['ho_ten']."</td>
                    <td>".$line['so_dien_thoai']."</td>
                    <td>".$status."</td>
                    <td>".$line['quyen']."</td>
                    <td>
                        <div class='dashboard-manage-table-action disable-copy' id='action-$countPos'>
                            <ul class='dashboard-manage-table-action-items'>
                                <li>Update</li>
                                <li>Delete</li>
                            </ul>
                        </div>
                    </td>
                </tr>
                ";
                $countPos++;
            }   
        }

        if ($page == 'Manage Customers'){
            if (isset($_GET['numPag'])) {
                $numPag = $_GET['numPag'];
                if (isset($_GET['textShow'])) {
                    $sum = mysqli_fetch_array($conn->selectData('select count(*) as count from khach_hang,nguoi_dung where khach_hang.id_nguoidung=nguoi_dung.id_nguoidung'))['count'];
                    echo "( ".($pag+1)." - ".($numShow+$pag)." of $sum results )";
                    return;
                }
                echo $count = ceil(mysqli_fetch_array($conn->selectData('select count(*) as count from khach_hang,nguoi_dung where khach_hang.id_nguoidung=nguoi_dung.id_nguoidung'))['count']/$numShow);
                return;
            }

            if (isset($_GET['idView'])) {
                $id = $_GET['idView'];
                $idRes = mysqli_fetch_array($conn->selectData("SELECT tinh_trang_taikhoan as i
                                                        FROM nguoi_dung
                                                        WHERE id_nguoidung = '$id'"))['i'] == 0 ? 'Block' : 'Active';
                echo $idRes.'/';
                return;
            }
            
            if (isset($_GET['add'])) {
                if (isset($_GET['valCB'])) {
                    $valCB = explode("-",$_GET['valCB']);
                }
                if (isset($_GET['valText'])) {
                    $valText = explode("-",$_GET['valText']);
                    $pass = md5($valText[4]);
                }
                $resAdd = $conn->executeQuery("insert into nguoi_dung(id_nguoidung, tai_khoan, mat_khau, email, so_dien_thoai, quyen, tinh_trang_taikhoan) 
                                                values('".$valText[0]."', '".$valText[3]."', '".$pass."', '".$valText[2]."', '".$valText[6]."', 'customer', ".$valCB[0].")");
                $resAdd = $conn->executeQuery("insert into khach_hang(id_nguoidung, ho_ten, dia_chi) values('".$valText[0]."', '".$valText[1]."', '".$valText[5]."')");
                $resAdd = $conn->executeQuery("update quyen set so_luong = so_luong + 1 where id_quyen 'customer'");
                echo $resAdd;
                return;
            }

            if (isset($_GET['update'])) {
                if (isset($_GET['val'])) {
                    $val = explode("~",$_GET['val']);
                }

                if ($val[0]== 'text') {
                    $password=md5($val[4]);
                    $resUpate = $conn->executeQuery("update nguoi_dung,khach_hang set khach_hang.ho_ten = N'".$val[2]."', nguoi_dung.email = '".$val[3]."', nguoi_dung.mat_khau='".$password."', khach_hang.dia_chi='".$val[5]."', nguoi_dung.so_dien_thoai='".$val[6]."' where khach_hang.id_nguoidung = '".$val[1]."' and nguoi_dung.id_nguoidung='".$val[1]."'");
                    echo $resUpate;
                    return;
                }
                if ($val[0]== 'checkbox') {
                    $statusAccount = $val[1] == 0 ? 'true' : 'false';
                    $resUpdate = $conn->executeQuery("update nguoi_dung set tinh_trang_taikhoan = $statusAccount where id_nguoidung = '".$val[2]."'");
                    echo $resUpdate;
                    return;
                }
                if ($val[0]=='delete') {
                    $resUpdate = $conn->executeQuery("delete from nguoi_dung where id_nguoidung = '".$val[1]."'");
                    $resUpdate = $conn->executeQuery("delete from khach_hang where id_nguoidung = '".$val[1]."'");
                    $resUpdate = $conn->executeQuery("update quyen set so_luong = so_luong - 1 where id_quyen = 'customer'");
                    echo $resUpdate;
                    return;
                }
           
                
            }
            
            $sql="select * 
                from khach_hang,nguoi_dung 
                where khach_hang.id_nguoidung = nguoi_dung.id_nguoidung 
                ORDER by ";
            if (isset($_GET['title'])&&isset($_GET['sort'])&&$_GET['title']!="") {
                $title = $_GET['title'];
                $sort = $_GET['sort'];
                if ($title=="Id Customers") {
                    $sql .= "cast(khach_hang.id_nguoidung as unsigned) $sort ";
                } else if ($title=="Name Customers") {
                    $sql .= "ho_ten $sort ";
                } else if ($title=="Address Customers") {
                    $sql .= "dia_chi $sort ";
                } else if ($title=="Phone Number") {
                    $sql .= "so_dien_thoai $sort ";
                }
            } else $sql .= "cast(khach_hang.id_nguoidung as unsigned) ";
            $sql .= " LIMIT $pag,$numShow";
            
            if (isset($_GET['search'])) {
                if (isset($_GET['val'])) {
                    $val = explode("-",$_GET['val']);
                }
                if ($val[0] != 'none') {
                    if ($val[0]=='id_nguoidung'){
                        $sql = "SELECT*
                        FROM khach_hang,nguoi_dung
                        WHERE khach_hang.id_nguoidung=nguoi_dung.id_nguoidung and 
                        nguoi_dung." . $val[0] . " like '%" . $val[1] .  "%' 
                        ORDER by cast(nguoi_dung.id_nguoidung as unsigned)
                        LIMIT $pag,$numShow";
                    } else {
                        $sql = "SELECT*
                        FROM khach_hang,nguoi_dung
                        WHERE khach_hang.id_nguoidung=nguoi_dung.id_nguoidung and 
                        " . $val[0] . " like '%" . $val[1] .  "%' 
                        ORDER by cast(nguoi_dung.id_nguoidung as unsigned)
                        LIMIT $pag,$numShow";
                    }
                }
            }

            $res = $conn->selectData($sql);
            $show = "
            <tr>
                <th>Id Customers</th>
                <th>Name Customers</th>
                <th>Address Customers</th>
                <th>Phone Number</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            ";

            if (isset($_GET['popUp'])) {
                $show = '';
                while($line=mysqli_fetch_array($res)) {
                    $show .= "
                    <div class='dashboard-manage-pop-up'>
                        <div class='dashboard-manage-pop-up-items'>
                            <i class='fas fa-times dm-pop-up-close-btn'></i>
                            <div class='dashboard-manage-pop-up-info'>
                                <span>Id Customer : <input type='text' class='disable' value='".$line['id_nguoidung']."'></span>
                                <span>Name Customer : <input type='text' class='dm-can-del' placeholder='".$line['ho_ten']."'></span>
                                <span>Email Customer : <input type='text' class='dm-can-del' placeholder='".$line['email']."'></span>
                                <span>Password Customer : <input type='text' class='dm-can-del' placeholder='*****'></span>
                                <span>Address Customer : <input type='text' class='dm-can-del' placeholder='".$line['dia_chi']."'></span>
                                <span>Phone number Customer : <input type='text' class='dm-can-del' placeholder='".$line['so_dien_thoai']."'></span>
                                <div class='dm-pop-up-btn disable-copy'>
                                    <span class='dm-pop-up-save-btn'>Save</span>
                                    <span class='dm-pop-up-reset-btn'>Reset</span>
                                </div>
                            </div>";
                        $show .=  "
                            <div class='dashboard-manage-pop-up-act'>
                                <span>Set permission : </span>
                                <div class='dashboard-manage-pop-up-act-checkbox'>
                                    <span class='dm-pop-up-cbox'><input type=radio name='status'> Active</span>
                                    <span class='dm-pop-up-cbox'><input type=radio name='status'> Block</span>
                                </div>
                            </div>";
                        $show .="
                        </div>
                    </div>
                    ";
                }
                echo $show;
                return;
            }

            $countPos = 0;
            while($line=mysqli_fetch_array($res)) {
                $status = $line['tinh_trang_taikhoan'] == true ? 'Activing': 'Blocked';
                $show .= "
                <tr>
                    <td>".$line['id_nguoidung']."</td>
                    <td>".$line['ho_ten']."</td>
                    <td>".$line['dia_chi']."</td>
                    <td>".$line['so_dien_thoai']."</td>
                    <td>".$status."</td>
                    <td>
                        <div class='dashboard-manage-table-action disable-copy' id='action-$countPos'>
                            <ul class='dashboard-manage-table-action-items'>
                                <li>Update</li>
                                <li>Delete</li>
                            </ul>
                        </div>
                    </td>
                </tr>
                ";
                $countPos++;
            }
        }

        if ($page == "Manage Import") {
            if (isset($_GET['numPag'])) {
                $numPag = $_GET['numPag'];
                if (isset($_GET['textShow'])) {
                    $sum = mysqli_fetch_array($conn->selectData('select count(*) as count from phieu_nhap'))['count'];
                    echo "( ".($pag+1)." - ".($numShow+$pag)." of $sum results )";
                    return;
                }
                echo $count = ceil(mysqli_fetch_array($conn->selectData('select count(*) as count from phieu_nhap'))['count']/$numShow);
                return;
            }
            if (isset($_GET['popUp']) && isset($_GET['clickPos'])) {
                $click = $_GET['clickPos'];
                $show = '';
                $res = $conn->selectData("select * from chitiet_phieunhap where id_phieunhap ='".$click."'");

                $sum = 0;

                $show = "
                    <span id='dm-popup-title'>View details of $click</span>
                    <i class='fas fa-times dm-pop-up-close-btn'></i>
                    <div class='dm-details-content'>
                    <table class='dm-details-content-items'>
                    <tr>
                        <th>Name Products</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Cost</th>
                        <th>Total</th>
                    </tr>
                ";
                while ($line = mysqli_fetch_array($res)) {
                    $so_luong = (int) $line['so_luong'];
                    $gia_nhap = (int) $line['gia_nhap'];
                    $total = $so_luong * $gia_nhap;
                    $sum += $total;

                    $name = mysqli_fetch_array($conn->selectData("select ten_nhomsanpham from nhom_san_pham where id_nhomsanpham = ( SELECT id_nhomsanpham FROM san_pham WHERE id_sanpham = '".$line['id_sanpham']."' )"))['ten_nhomsanpham'];
                    $size = mysqli_fetch_array($conn->selectData("select size from san_pham where id_sanpham = '".$line['id_sanpham']."'"))['size'];

                    $show .= "
                    <tr>
                        <td>$name</td>
                        <td>$size</td>
                        <td>".number_format($so_luong)."</td>
                        <td>".number_format($gia_nhap)." VNĐ</td>
                        <td>".number_format($total)." VNĐ</td>
                    </tr>
                    ";
                }
                $sql = "select id_nhanviennhap, id_nhacungcap from phieu_nhap where id_phieunhap ='$click'";
                
                $nv = mysqli_fetch_array($conn->selectData($sql))['id_nhanviennhap'];
                $ncc = mysqli_fetch_array($conn->selectData($sql))['id_nhacungcap'];

                $show .= "
                    </table>
                    </div>
                    <div class='dm-details-more'>
                        <div class='dm-d-left'>
                            <span>Id importer: $nv</span>
                            <span>Id provider: $ncc</span>
                        </div>
                        <div class='dm-d-right'>
                            <span>Total: ".number_format($sum)." VNĐ</span>
                        </div>
                    </div>
                ";
                echo $show;
                return;
            }
            if (isset($_GET['popUp'])) return;

            if (isset($_GET['update'])) {
                if (isset($_GET['val'])) {
                    $val = explode("~",$_GET['val']);
                }

                if ($val[0]=='delete') {
                    $sqlHandle = "SELECT * FROM san_pham, 
                                        (SELECT id_sanpham, so_luong 
                                        FROM phieu_nhap, chitiet_phieunhap 
                                        WHERE phieu_nhap.id_phieunhap = chitiet_phieunhap.id_phieunhap 
                                        AND phieu_nhap.id_phieunhap = '".$val[1]."') as b 
                            WHERE san_pham.id_sanpham = b.id_sanpham";
                    $resHandle = $conn->selectData($sqlHandle);
                    while ($row = mysqli_fetch_array($resHandle)) {
                        $conn->executeQuery("update san_pham set san_pham.so_luong = san_pham.so_luong - ".$row['so_luong']." where id_sanpham = '".$row['id_sanpham']."'");
                    }
                    $resUpdate = $conn->executeQuery("delete from phieu_nhap where id_phieunhap = '".$val[1]."'");
                    $resUpdate = $conn->executeQuery("delete from chitiet_phieunhap where id_phieunhap = '".$val[1]."'");
                    echo $resUpdate;
                    return;
                }
            }

            $sql="select *
            from phieu_nhap
            ORDER by ";
            if (isset($_GET['title'])&&isset($_GET['sort'])&&$_GET['title']!="") {
                $title = $_GET['title'];
                $sort = $_GET['sort'];
                if ($title=="Id Imports") {
                    $sql .= "id_phieunhap $sort ";
                } else if ($title=="Id Importers") {
                    $sql .= "id_nhanviennhap $sort ";
                } else if ($title=="Id Providers") {
                    $sql .= "id_nhacungcap $sort ";
                } else if ($title=="Date") {
                    $sql .= "ngay_nhap $sort ";
                } else if ($title=="Total") {
                    $sql .= "tong_gia_nhap $sort ";
                }
            } else $sql .= "ngay_nhap desc ";
            $sql .= " LIMIT $pag,$numShow";

            if (isset($_GET['search'])) {
                if (isset($_GET['val'])) {
                    $val = explode("-",$_GET['val']);
                }
                if ($val[0] != 'none') {
                    if ($val[0]=='ngay_nhap') {
                        if (count($val)==4) $val[1] = $val[3] . "-" . $val[2] . "-" . $val[1];
                        if (count($val)==3) $val[1] = $val[2] . "-" . $val[1];
                    }
                    $sql = "SELECT*
                    FROM phieu_nhap
                    WHERE " . $val[0] . " like '%" . $val[1] .  "%' 
                    ORDER by ngay_nhap desc
                    LIMIT $pag,$numShow";
                }
            }

            $res = $conn->selectData($sql);
            $show = "
            <tr>
                <th>Id Imports</th>
                <th>Id Importers</th>
                <th>Id Providers</th>
                <th>Date</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            ";

            $countPos = 0;
            while($line=mysqli_fetch_array($res)) {
                $date = explode('-',$line['ngay_nhap']);
                $timeConvert = mktime(0,0,0,(int)$date[1],(int)$date[2],(int)$date[0]);
                $time = date("M d, Y", $timeConvert);
                $show .= "
                <tr>
                    <td>".$line['id_phieunhap']."</td>
                    <td>".$line['id_nhanviennhap']."</td>
                    <td>".$line['id_nhacungcap']."</td>
                    <td>".$time."</td>
                    <td>".number_format((int)$line['tong_gia_nhap'])." VNĐ</td>
                    <td>
                        <div class='dashboard-manage-table-action disable-copy' id='action-$countPos'>
                            <ul class='dashboard-manage-table-action-items'>
                                <li>Details</li>
                                <li>Delete</li>
                            </ul>
                        </div>
                    </td>
                </tr>
                ";
                $countPos++;
            }
        }

        if ($page == 'Track Invoice') {
            if (isset($_GET['numPag'])) {
                $numPag = $_GET['numPag'];
                if (isset($_GET['textShow'])) {
                    $sum = mysqli_fetch_array($conn->selectData('select count(*) as count from hoa_don'))['count'];
                    echo "( ".($pag+1)." - ".($numShow+$pag)." of $sum results )";
                    return;
                }
                echo $count = ceil(mysqli_fetch_array($conn->selectData('select count(*) as count from hoa_don'))['count']/$numShow);
                return;
            }

            if (isset($_GET['popUp']) && isset($_GET['clickPos']) && isset($_GET['status'])) {
                $click = $_GET['clickPos'];
                $status = $_GET['status'];
                $show = '';
                $res = $conn->selectData("select * from chitiet_hoadon where id_hoadon ='".$click."'");

                $sum = 0;
                $delivery_method = mysqli_fetch_array($conn->selectData("select ten_phuongthuc from phuongthuc_giaohang 
                                                                    where id_phuongthuc = (select phuongthuc_giaohang 
                                                                                            from chitiet_giaohang 
                                                                                            where id_hoadon = '$click')"))['ten_phuongthuc'];

                $show = "
                    <span id='dm-popup-title'>View details of $click ($delivery_method)</span>
                    <i class='fas fa-times dm-pop-up-close-btn'></i>
                    <div class='dm-details-content'>
                    <table class='dm-details-content-items'>
                    <tr>
                        <th>Name Products</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Cost</th>
                        <th>Total</th>
                    </tr>
                ";
                while ($line = mysqli_fetch_array($res)) {
                    $so_luong = (int) $line['so_luong'];
                    $total = (int) $line['gia'];
                    $gia_nhap = $total / $so_luong;
                    $sum += $total;

                    $name = mysqli_fetch_array($conn->selectData("select ten_nhomsanpham from nhom_san_pham where id_nhomsanpham = ( SELECT id_nhomsanpham FROM san_pham WHERE id_sanpham = '".$line['id_sanpham']."' )"))['ten_nhomsanpham'];
                    $size = mysqli_fetch_array($conn->selectData("select size from san_pham where id_sanpham = '".$line['id_sanpham']."'"))['size'];

                    $show .= "
                    <tr>
                        <td>$name</td>
                        <td>$size</td>
                        <td>".number_format($so_luong)."</td>
                        <td>".number_format($gia_nhap)." VNĐ</td>
                        <td>".number_format($total)." VNĐ</td>
                    </tr>
                    ";
                }
                $sql = "select id_nguoidung, id_nhanvienban from hoa_don where id_hoadon ='$click'";
                
                $nv = mysqli_fetch_array($conn->selectData($sql))['id_nguoidung'];
                $ncc = mysqli_fetch_array($conn->selectData($sql))['id_nhanvienban'];

                $show .= "
                    </table>
                    </div>
                    <div class='dm-details-more'>
                        <div class='dm-d-left'>
                            <span>Id customer: $nv</span>
                            <span>Id seller: $ncc</span>
                        </div>
                        <div class='dm-d-right'>
                            <span>Total: ".number_format($sum)." VNĐ</span>";
                if ($status == "Waiting") $show .= "<button id='handle-btn'>Delivery</button>";
                if ($status == "Delivering") $show .= "<button id='handle-btn'>Delivered</button>";
                $show .="</div>
                    </div>
                ";
                echo $show;
                return;
            }
            if (isset($_GET['popUp'])) return;

            if (isset($_GET['update'])) {
                if (isset($_GET['val'])) {
                    $val = explode("~",$_GET['val']);
                }

                if ($val[0]== 'text') {
                    if ($val[1]=="Delivery") {
                        $resUpdate = $conn->executeQuery("update hoa_don set id_nhanvienban = '".$_SESSION['user']['id']."' where id_hoadon = '".$val[2]."'");
                        $resUpdate = $conn->executeQuery("update chitiet_giaohang set tinhtrang_giaohang = 2 where id_hoadon = '".$val[2]."'");
                    } else if ($val[1]=="Delivered") {
                        $resUpdate = $conn->executeQuery("update chitiet_giaohang set tinhtrang_giaohang = 3, ngay_giao = '".date("Y-m-d")."' where id_hoadon = '".$val[2]."'");
                    }
                    echo $resUpdate;
                    return;
                }
                if ($val[0]=='delete') {
                    $sqlHandle = "SELECT * FROM san_pham, 
                                        (SELECT id_sanpham, so_luong 
                                        FROM hoa_don, chitiet_hoadon 
                                        WHERE hoa_don.id_hoadon = chitiet_hoadon.id_hoadon 
                                        AND hoa_don.id_hoadon = '".$val[1]."') as b 
                            WHERE san_pham.id_sanpham = b.id_sanpham";
                    $resHandle = $conn->selectData($sqlHandle);
                    while ($row = mysqli_fetch_array($resHandle)) {
                        $conn->executeQuery("update san_pham set san_pham.so_luong = san_pham.so_luong + ".$row['so_luong']." where id_sanpham = '".$row['id_sanpham']."'");
                    }
                    $resUpdate = $conn->executeQuery("delete from hoa_don where hoa_don.id_hoadon = '".$val[1]."'");
                    $resUpdate = $conn->executeQuery("delete from chitiet_hoadon where chitiet_hoadon.id_hoadon = '".$val[1]."'");
                    $resUpdate = $conn->executeQuery("delete from chitiet_giaohang where chitiet_giaohang.id_hoadon = '".$val[1]."'");

                    echo $resUpdate;
                    return;
                }
            }

            $sql="select *
            from hoa_don";
            if (isset($_GET['filter'])&&isset($_GET['condition'])&&isset($_GET['filter_value'])) {
                $condition = $_GET['condition'];
                $filter_value = $_GET['filter_value'];
                

                if ($condition == "Total") { 
                    if ($filter_value != "-") {
                        $sql .= " where tong_gia $filter_value ";
                    }
                } else if ($condition == "Status") {
                    if ($filter_value != "-") {
                        $sql .= ", chitiet_giaohang where hoa_don.id_hoadon = chitiet_giaohang.id_hoadon and chitiet_giaohang.tinhtrang_giaohang = '";
                        if ($filter_value=="waiting") {
                            $sql .= "1'";
                        } else if ($filter_value == "delivering") {
                            $sql .= "2' ";
                        } else if ($filter_value == "delivered") {
                            $sql .= "3' ";
                        }
                    }
                } else if ($condition == "ngay_mua") {
                    $temp = explode("~", $filter_value);
                    $sql .= " where ngay_mua >= '".$temp[0]."' and ngay_mua <= '".$temp[1]."'";
                } else if ($condition == "ngay_giao") {
                    $temp = explode("~", $filter_value);
                    $sql .= ", chitiet_giaohang where hoa_don.id_hoadon = chitiet_giaohang.id_hoadon 
                    and ngay_giao != '0000-00-00' 
                    and ngay_giao >= '".$temp[0]."' and ngay_giao <= '".$temp[1]."'";
                }
            }
            $sql .= " ORDER by ";
            if (isset($_GET['title'])&&isset($_GET['sort'])&&$_GET['title']!="") {
                $title = $_GET['title'];
                $sort = $_GET['sort'];
                if ($title=="Id Invoices") {
                    $sql .= "cast(id_hoadon as unsigned) $sort ";
                } else if ($title=="Id Customers") {
                    $sql .= "cast(id_nguoidung as unsigned)  $sort ";
                } else if ($title=="Id Sellers") {
                    $sql .= "id_nhanvienban  $sort ";
                } else if ($title=="Date Bought") {
                    $sql .= "ngay_mua $sort ";
                } else if ($title=="Total") {
                    $sql .= "tong_gia $sort ";
                }
            } else $sql .= "ngay_mua desc ";
            $sql .= " LIMIT $pag,$numShow";

            if (isset($_GET['search'])) {
                if (isset($_GET['val'])) {
                    $val = explode("-",$_GET['val']);
                }
                if ($val[0] != 'none') {
                    if ($val[0]=='ngay_mua') {
                        if (count($val)==4) $val[1] = $val[3] . "-" . $val[2] . "-" . $val[1];
                        if (count($val)==3) $val[1] = $val[2] . "-" . $val[1];
                    }
                    $sql = "SELECT*
                    FROM hoa_don
                    WHERE " . $val[0] . " like '%" . $val[1] .  "%' 
                    ORDER by ngay_mua desc
                    LIMIT $pag,$numShow";
                }
            }

            $res = $conn->selectData($sql);
            $show = "
            <tr>
                <th>Id Invoices</th>
                <th>Id Customers</th>
                <th>Id Sellers</th>
                <th>Date Bought</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date Delivered</th>
                <th>Action</th>
            </tr>
            ";

            $countPos = 0;
            // Format ngay
            function convertTime($time) {   
                if ($time == "0000-00-00") return "";
                $date = explode('-',$time);
                $timeConvert = mktime(0,0,0,(int)$date[1],(int)$date[2],(int)$date[0]);
                $time = date("M d, Y", $timeConvert);
                return $time;
            }
            while($line=mysqli_fetch_array($res)) {
                // Get status
                $query = $conn->selectData("select * from chitiet_giaohang, hoa_don 
                                        where chitiet_giaohang.id_hoadon = hoa_don.id_hoadon 
                                        and hoa_don.id_hoadon = '".$line['id_hoadon']."'");
                $ngay_giao = "";
                if (mysqli_num_rows($query) == 0)  {
                    $status = "Waiting";
                } else {
                    $row = mysqli_fetch_array($query);
                    $status = "Waiting";
                    if ($row['tinhtrang_giaohang']==2) $status = "Delivering";
                    else if ($row['tinhtrang_giaohang']==3) $status = "Delivered";
                    $ngay_giao = convertTime($row['ngay_giao']);
                }

                $show .= "
                <tr>
                    <td>".$line['id_hoadon']."</td>
                    <td>".$line['id_nguoidung']."</td>
                    <td>".$line['id_nhanvienban']."</td>
                    <td>".convertTime($line['ngay_mua'])."</td>
                    <td>".number_format((int)$line['tong_gia'])." VNĐ</td>
                    <td>$status</td>
                    <td>".$ngay_giao."</td>
                    <td>
                        <div class='dashboard-manage-table-action disable-copy' id='action-$countPos'>
                            <ul class='dashboard-manage-table-action-items'>
                                <li>Details</li>
                                <li>Delete</li>
                            </ul>
                        </div>
                    </td>
                </tr>
                ";
                $countPos++;
            }
        }

        if ($page == 'Manage cProducts') {
            if (isset($_GET['numPag'])) {
                $numPag = $_GET['numPag'];
                if (isset($_GET['textShow'])) {
                    $sum = mysqli_fetch_array($conn->selectData('select count(*) as count from san_pham'))['count'];
                    echo "( ".($pag+1)." - ".($numShow+$pag)." of $sum results )";
                    return;
                }
                echo $count = ceil(mysqli_fetch_array($conn->selectData('select count(*) as count from san_pham'))['count']/$numShow);
                return;
            }

            if (isset($_GET['popUp']) && isset($_GET['clickPos'])) {
                $click = $_GET['clickPos'];
                $nameInput = explode("&",$click)[0];
                $sizeInput = explode("&",$click)[1];
                $show = '';
                $res = $conn->selectData("select * from san_pham 
                                where id_nhomsanpham = (select id_nhomsanpham from nhom_san_pham where ten_nhomsanpham = N'$nameInput')
                                and size = $sizeInput");

                $show = "
                    <span id='dm-popup-title'>View details of $nameInput size $sizeInput</span>
                    <i class='fas fa-times dm-pop-up-close-btn'></i>
                    <div class='dm-details-content'>
                    <table class='dm-details-content-items'>
                    <tr>
                        <th>Name Products</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Save</th>
                    </tr>
                ";
                while ($line = mysqli_fetch_array($res)) {
                    $so_luong = (int) $line['so_luong'];
                    $gia_sanpham = (int) $line['gia_sanpham'];
                    
                    $show .= "
                    <tr>
                        <td>$nameInput</td>
                        <td>$sizeInput</td>
                        <td><input type='text' name='quantity' value='".number_format($so_luong)."'></td>
                        <td><input type='text' name='price' value='".number_format($gia_sanpham)." VNĐ'></td>
                        <td><button class=save-btn>Save</button></td>
                    </tr>
                    ";
                }
                $show .= "
                    </table>
                    </div>
                ";
                echo $show;
                return;
            }
            if (isset($_GET['popUp'])) return;
            
            if (isset($_GET['add'])) {
                // if (isset($_GET['valCB'])) {
                //     $valCB = explode("-",$_GET['valCB']);
                // }
                if (isset($_GET['valText'])) {
                    $valText = explode("~",$_GET['valText']);
                }
                $resAdd = $conn->executeQuery("insert into san_pham(id_sanpham, id_nhomsanpham, size, gia_sanpham, so_luong) values('".$valText[0]."', (select id_nhomsanpham from nhom_san_pham where ten_nhomsanpham = N'".$valText[1]."'), '".$valText[2]."', '".$valText[4]."', '".$valText[3]."')");
                echo $resAdd;
                return;
            }

            if (isset($_GET['update'])) {
                if (isset($_GET['val'])) {
                    $val = explode("~",$_GET['val']);
                }

                if ($val[0]== 'text') {
                    $resUpdate = $conn->executeQuery("update san_pham set so_luong = '".$val[3]."', gia_sanpham = '".$val[4]."' where id_nhomsanpham = (select id_nhomsanpham from nhom_san_pham where ten_nhomsanpham = '".$val[1]."') and size = '".$val[2]."'");
                    echo $resUpdate;
                    return;
                }
                if ($val[0]=='delete') {
                    $resUpdate = $conn->executeQuery("delete from san_pham where id_nhomsanpham = (select id_nhomsanpham from nhom_san_pham where ten_nhomsanpham = '".$val[1]."') and size = '".$val[2]."'");
                    echo $resUpdate;
                    return;
                }
            }
            

            $sql="select *
            from nhom_san_pham, san_pham
            where nhom_san_pham.id_nhomsanpham = san_pham.id_nhomsanpham
            ORDER by ";
            if (isset($_GET['title'])&&isset($_GET['sort'])&&$_GET['title']!="") {
                $title = $_GET['title'];
                $sort = $_GET['sort'];
                if ($title=="Size") {
                    $sql .= "size $sort ";
                } else if ($title=="Name Products") {
                    $sql .= "ten_nhomsanpham $sort ";
                } else if ($title=="Price") {
                    $sql .= "gia_sanpham $sort ";
                } else if ($title=="In stock") {
                    $sql .= "so_luong $sort ";
                }
            } else $sql .= "ten_nhomsanpham, size asc ";
            $sql .= " LIMIT $pag,$numShow";

            if (isset($_GET['search'])) {
                if (isset($_GET['val'])) {
                    $val = explode("-",$_GET['val']);
                }
                if ($val[0] != 'none') {
                    if ($val[0] == 'ten_nhomsanpham') {
                        $sql = "select *
                        from nhom_san_pham, san_pham
                        where nhom_san_pham.id_nhomsanpham = san_pham.id_nhomsanpham
                        and nhom_san_pham.ten_nhomsanpham LIKE '%".$val[1]."%'
                        ORDER by ten_nhomsanpham, size asc
                        LIMIT $pag,$numShow";
                    }
                    else {
                        $sql = "SELECT*
                        from nhom_san_pham, san_pham
                        where nhom_san_pham.id_nhomsanpham = san_pham.id_nhomsanpham
                        and " . $val[0] . " like '%" . $val[1] .  "%' 
                        ORDER by ten_nhomsanpham, size asc
                        LIMIT $pag,$numShow";
                    }
                }
            }

            $res = $conn->selectData($sql);
            $show = "
            <tr>
                <th>Name Products</th>
                <th>Size</th>
                <th>Price</th>
                <th>In stock</th>
                <th>Action</th>
            </tr>
            ";

            $countPos = 0;
            while($line=mysqli_fetch_array($res)) {
                $show .= "
                <tr>
                    <td>".$line['ten_nhomsanpham']."</td>
                    <td>".$line['size']."</td>
                    <td>".$line['gia_sanpham']."</td>
                    <td>".$line['so_luong']."</td>
                    <td>
                        <div class='dashboard-manage-table-action disable-copy' id='action-$countPos'>
                            <ul class='dashboard-manage-table-action-items'>
                                <li>Details</li>
                                <li>Delete</li>
                            </ul>
                        </div>
                    </td>
                </tr>
                ";
                $countPos++;
            }
        }

        if ($page == "Manage Providers") {
            if (isset($_GET['numPag'])) {
                $numPag = $_GET['numPag'];
                if (isset($_GET['textShow'])) {
                    $sum = mysqli_fetch_array($conn->selectData('select count(*) as count from nha_cung_cap'))['count'];
                    echo "( ".($pag+1)." - ".($numShow+$pag)." of $sum results )";
                    return;
                }
                echo $count = ceil(mysqli_fetch_array($conn->selectData('select count(*) as count from nha_cung_cap'))['count']/$numShow);
                return;
            }

            if (isset($_GET['popUp']) && isset($_GET['clickPos'])) {
                $click = $_GET['clickPos'];
                $idInput = explode("&",$click)[0];
                $nameInput = explode("&",$click)[1];
                $addressInput = explode("&",$click)[2];
                $show = '';
                $res = $conn->selectData("select * from nha_cung_cap 
                                where id_nhacungcap = '$idInput'");

                $show = "
                    <span id='dm-popup-title'>View details of $nameInput</span>
                    <i class='fas fa-times dm-pop-up-close-btn'></i>
                    <div class='dm-details-content'>
                    <table class='dm-details-content-items'>
                    <tr>
                        <th>Id Provider</th>
                        <th>Name Provider</th>
                        <th>Address Provider</th>
                        <th>Save</th>
                    </tr>
                ";
                while ($line = mysqli_fetch_array($res)) {
                    $show .= "
                    <tr>
                        <td>$idInput</td>
                        <td><input type='text' name='name' value='$nameInput'></td>
                        <td><input type='text' name='address' value='$addressInput'></td>
                        <td><button class=save-btn>Save</button></td>
                    </tr>
                    ";
                }
                $show .= "
                    </table>
                    </div>
                ";
                echo $show;
                return;
            }
            if (isset($_GET['popUp'])) return;

            if (isset($_GET['add'])) {
                if (isset($_GET['valText'])) {
                    $valText = explode("-",$_GET['valText']);
                }
                $resAdd = $conn->executeQuery("insert into nha_cung_cap(id_nhacungcap, ten_nhacungcap, diachi_nhacungcap) values('".$valText[0]."', '".$valText[1]."', '".$valText[2]."')");
                echo $resAdd;
                return;
            }

            if (isset($_GET['update'])) {
                if (isset($_GET['val'])) {
                    $val = explode("~",$_GET['val']);
                }

                if ($val[0]== 'text') {
                    $resUpdate = $conn->executeQuery("update nha_cung_cap set ten_nhacungcap = N'".$val[2]."', diachi_nhacungcap = N'".$val[3]."' where id_nhacungcap = '".$val[1]."'");
                    echo $resUpdate;
                    return;
                }
                if ($val[0]=='delete') {
                    $resUpdate = $conn->executeQuery("delete from nha_cung_cap where id_nhacungcap = '".$val[1]."'");
                    echo $resUpdate;
                    return;
                }
            }

            $sql="select *
            from nha_cung_cap
            ORDER by ";
            if (isset($_GET['title'])&&isset($_GET['sort'])&&$_GET['title']!="") {
                $title = $_GET['title'];
                $sort = $_GET['sort'];
                if ($title=="Id Providers") {
                    $sql .= "id_nhacungcap $sort ";
                } else if ($title=="Name Providers") {
                    $sql .= "ten_nhacungcap $sort ";
                } else if ($title=="Address Providers") {
                    $sql .= "diachi_nhacungcap $sort ";
                }
            } else $sql .= "id_nhacungcap asc ";
            $sql .= " LIMIT $pag,$numShow";

            if (isset($_GET['search'])) {
                if (isset($_GET['val'])) {
                    $val = explode("-",$_GET['val']);
                }
                if ($val[0] != 'none') {
                    $sql = "select * from nha_cung_cap where ".$val[0]." like '%".$val[1]."%' order by id_nhacungcap limit $pag, $numShow";
                }
            }

            $res = $conn->selectData($sql);
            $show = "
            <tr>
                <th>Id Providers</th>
                <th>Name Providers</th>
                <th>Address Providers</th>
                <th>Action</th>
            </tr>
            ";

            $countPos = 0;
            while($line=mysqli_fetch_array($res)) {
                $show .= "
                <tr>
                    <td>".$line['id_nhacungcap']."</td>
                    <td>".$line['ten_nhacungcap']."</td>
                    <td>".$line['diachi_nhacungcap']."</td>
                    <td>
                        <div class='dashboard-manage-table-action disable-copy' id='action-$countPos'>
                            <ul class='dashboard-manage-table-action-items'>
                                <li>Details</li>
                                <li>Delete</li>
                            </ul>
                        </div>
                    </td>
                </tr>
                ";
                $countPos++;
            }
        }

        if ($page == "Manage gProducts") {
            if (isset($_GET['numPag'])) {
                $numPag = $_GET['numPag'];
                if (isset($_GET['textShow'])) {
                    $sum = mysqli_fetch_array($conn->selectData('select count(*) as count from dong_san_pham'))['count'];
                    echo "( ".($pag+1)." - ".($numShow+$pag)." of $sum results )";
                    return;
                }
                echo $count = ceil(mysqli_fetch_array($conn->selectData('select count(*) as count from dong_san_pham'))['count']/$numShow);
                return;
            }

            if (isset($_GET['popUp']) && isset($_GET['clickPos'])) {
                $click = $_GET['clickPos'];
                $idInput = explode("&",$click)[0];
                $nameInput = explode("&",$click)[1];
                $brandInput = explode("&",$click)[2];
                $show = '';
                $res = $conn->selectData("select * from dong_san_pham 
                                where id_dongsanpham = '$idInput'");

                $show = "
                    <span id='dm-popup-title'>View details of $nameInput</span>
                    <i class='fas fa-times dm-pop-up-close-btn'></i>
                    <div class='dm-details-content'>
                    <table class='dm-details-content-items'>
                    <tr>
                        <th>Id gProduct</th>
                        <th>Name gProduct</th>
                        <th>Brand gProduct</th>
                        <th>Save</th>
                    </tr>
                ";
                while ($line = mysqli_fetch_array($res)) {
                    $show .= "
                    <tr>
                        <td>$idInput</td>
                        <td><input type='text' name='name' value='$nameInput'></td>
                        <td><input type='text' name='brand' value='$brandInput'></td>
                        <td><button class=save-btn>Save</button></td>
                    </tr>
                    ";
                }
                $show .= "
                    </table>
                    </div>
                ";
                echo $show;
                return;
            }
            if (isset($_GET['popUp'])) return;

            if (isset($_GET['add'])) {
                if (isset($_GET['valText'])) {
                    $valText = explode("-",$_GET['valText']);
                }
                $resAdd = $conn->executeQuery("insert into dong_san_pham(id_dongsanpham, ten_dongsanpham, thuonghieu_sanpham) values('".$valText[0]."', N'".$valText[1]."', N'".$valText[2]."')");
                echo $resAdd;
                return;
            }

            if (isset($_GET['update'])) {
                if (isset($_GET['val'])) {
                    $val = explode("~",$_GET['val']);
                }

                if ($val[0]== 'text') {
                    $resUpdate = $conn->executeQuery("update dong_san_pham set ten_dongsanpham = N'".$val[2]."', thuonghieu_sanpham = N'".$val[3]."' where id_dongsanpham = '".$val[1]."'");
                    echo $resUpdate;
                    return;
                }
                if ($val[0]=='delete') {
                    $resUpdate = $conn->executeQuery("delete from dong_san_pham where id_dongsanpham = '".$val[1]."'");
                    echo $resUpdate;
                    return;
                }
            }

            $sql="select * 
            from dong_san_pham 
            ORDER by ";
            if (isset($_GET['title'])&&isset($_GET['sort'])&&$_GET['title']!="") {
                $title = $_GET['title'];
                $sort = $_GET['sort'];
                if ($title=="Id gProducts") {
                    $sql .= "id_dongsanpham $sort ";
                } else if ($title=="Name gProducts") {
                    $sql .= "ten_dongsanpham $sort ";
                } else if ($title=="Brand") {
                    $sql .= "thuonghieu_sanpham $sort ";
                } else if ($title=="Quantity Products") {
                    $sql .= "id_dongsanpham $sort ";
                }
            } else $sql .= "id_dongsanpham asc ";
            $sql .= " LIMIT $pag,$numShow";

            if (isset($_GET['search'])) {
                if (isset($_GET['val'])) {
                    $val = explode("-",$_GET['val']);
                }
                if ($val[0] != 'none') {
                    $sql = "select * from dong_san_pham where ".$val[0]." like '%".$val[1]."%' order by id_dongsanpham limit $pag, $numShow";
                }
            }

            $res = $conn->selectData($sql);
            $show = "
            <tr>
                <th>Id gProducts</th>
                <th>Name gProducts</th>
                <th>Brand</th>
                <th>Quantity Products</th>
                <th>Action</th>
            </tr>
            ";

            $countPos = 0;
            while($line=mysqli_fetch_array($res)) {
                $query = $conn->selectData("select count(*) as count 
                                                        from dong_san_pham, nhom_san_pham 
                                                        where dong_san_pham.id_dongsanpham = nhom_san_pham.id_dongsanpham 
                                                        and dong_san_pham.id_dongsanpham = '".$line['id_dongsanpham']."'");
                $qtt = mysqli_num_rows($query) == 0 ? 0 : mysqli_fetch_array($query)['count'];
                $show .= "
                <tr>
                    <td>".$line['id_dongsanpham']."</td>
                    <td>".$line['ten_dongsanpham']."</td>
                    <td>".$line['thuonghieu_sanpham']."</td>
                    <td>".$qtt."</td>
                    <td>
                        <div class='dashboard-manage-table-action disable-copy' id='action-$countPos'>
                            <ul class='dashboard-manage-table-action-items'>
                                <li>Details</li>
                                <li>Delete</li>
                            </ul>
                        </div>
                    </td>
                </tr>
                ";
                $countPos++;
            }
        }

        if ($page == "Track Sales") {
            if (isset($_GET['numPag'])) {
                $numPag = $_GET['numPag'];
                if (isset($_GET['textShow'])) {
                    $sum = mysqli_fetch_array($conn->selectData('select count(*) as count from sale'))['count'];
                    echo "( ".($pag+1)." - ".($numShow+$pag)." of $sum results )";
                    return;
                }
                echo $count = ceil(mysqli_fetch_array($conn->selectData('select count(*) as count from sale'))['count']/$numShow);
                return;
            }

            if (isset($_GET['popUp']) && isset($_GET['clickPos'])) {
                $click = $_GET['clickPos'];
                $idInput = explode("&",$click)[0];
                $nameInput = explode("&",$click)[1];
                $show = '';
                $res = $conn->selectData("select * from sale 
                                where id_sale = '$idInput'");

                $show = "
                    <span id='dm-popup-title'>View details of $nameInput</span>
                    <i class='fas fa-times dm-pop-up-close-btn'></i>
                    <div class='dm-details-content'>
                    <table class='dm-details-content-items'>
                    <tr>
                        <th>Id Sale</th>
                        <th>Time start</th>
                        <th>Time end</th>
                        <th>Decrease %</th>
                        <th>Decrease VNĐ</th>
                        <th>Save</th>
                    </tr>
                ";
                while ($line = mysqli_fetch_array($res)) {
                    $show .= "
                    <tr>
                        <td>$idInput</td>
                        <td><input type='text' name='timestart' value='".$line['ngay_bat_dau']."'></td>
                        <td><input type='text' name='timeend' value='".$line['ngay_ket_thuc']."'></td>
                        <td><input type='text' name='giampercent' value='".$line['giam_theo_percent']."'></td>
                        <td><input type='text' name='giamcurrent' value='".$line['giam_theo_vnd']."'></td>
                        <td><button class=save-btn>Save</button></td>
                    </tr>
                    ";
                }
                $show .= "
                    </table>
                    </div>
                ";
                echo $show;
                return;
            }
            if (isset($_GET['popUp'])) return;

            if (isset($_GET['add'])) {
                if (isset($_GET['valText'])) {
                    $valText = explode("~",$_GET['valText']);
                }
                $resAdd = $conn->executeQuery("insert into sale(id_sale, ten_sale, ngay_bat_dau, ngay_ket_thuc, giam_theo_percent, giam_theo_vnd) 
                                        values('".$valText[0]."', N'".$valText[1]."', '".$valText[2]."', '".$valText[3]."', '".$valText[4]."', '".$valText[5]."')");
                echo $resAdd;
                return;
            }

            if (isset($_GET['update'])) {
                if (isset($_GET['val'])) {
                    $val = explode("~",$_GET['val']);
                }

                if ($val[0]== 'text') {
                    $resUpdate = $conn->executeQuery("update sale set ngay_bat_dau = '".$val[2]."', ngay_ket_thuc = '".$val[3]."', giam_theo_percent = '".$val[4]."', giam_theo_vnd = '".$val[5]."' where id_sale = '".$val[1]."'");
                    echo $resUpdate;
                    return;
                }
                if ($val[0]=='delete') {
                    $resUpdate = $conn->executeQuery("delete from sale where id_sale = '".$val[1]."'");
                    echo $resUpdate;
                    return;
                }
            }

            $sql="select * 
            from sale 
            ORDER by ";
            if (isset($_GET['title'])&&isset($_GET['sort'])&&$_GET['title']!="") {
                $title = $_GET['title'];
                $sort = $_GET['sort'];
                if ($title=="Id Sales") {
                    $sql .= "id_sale $sort ";
                } else if ($title=="Name Sales") {
                    $sql .= "ten_sale $sort ";
                } else if ($title=="Start") {
                    $sql .= "ngay_bat_dau $sort ";
                } else if ($title=="End") {
                    $sql .= "ngay_ket_thuc $sort ";
                } else if ($title=="Decrease as %") {
                    $sql .= "giam_theo_percent $sort ";
                } else if ($title=="Decrease as VNĐ") {
                    $sql .= "giam_theo_vnd $sort ";
                }
            } else $sql .= "id_sale asc ";
            $sql .= " LIMIT $pag,$numShow";

            if (isset($_GET['search'])) {
                if (isset($_GET['val'])) {
                    $val = explode("-",$_GET['val']);
                }
                if ($val[0] != 'none') {
                    $sql = "select * from sale where ".$val[0]." like '%".$val[1]."%' order by id_sale limit $pag, $numShow";
                }
            }

            $res = $conn->selectData($sql);
            $show = "
            <tr>
                <th>Id Sales</th>
                <th>Name Sales</th>
                <th>Start</th>
                <th>End</th>
                <th>Decrease as %</th>
                <th>Decrease as VNĐ</th>
                <th>Effect on</th>
                <th>Action</th>
            </tr>
            ";

            // Format ngay
            function convertTime($time) {   
                if ($time == "0000-00-00") return "";
                $date = explode('-',$time);
                $timeConvert = mktime(0,0,0,(int)$date[1],(int)$date[2],(int)$date[0]);
                $time = date("M d, Y", $timeConvert);
                return $time;
            }

            $countPos = 0;
            while($line=mysqli_fetch_array($res)) {
                $query = $conn->selectData("select count(*) as count 
                                                        from chitiet_sale 
                                                        where id_sale = '".$line['id_sale']."'");
                $qtt = mysqli_num_rows($query) == 0 ? 0 : mysqli_fetch_array($query)['count'];
                $show .= "
                <tr>
                    <td>".$line['id_sale']."</td>
                    <td>".$line['ten_sale']."</td>
                    <td>".convertTime($line['ngay_bat_dau'])."</td>
                    <td>".convertTime($line['ngay_ket_thuc'])."</td>
                    <td>".$line['giam_theo_percent']."%</td>
                    <td>".number_format($line['giam_theo_vnd']). " VNĐ</td>
                    <td>".$qtt." products</td>
                    <td>
                        <div class='dashboard-manage-table-action disable-copy' id='action-$countPos'>
                            <ul class='dashboard-manage-table-action-items'>
                                <li>Details</li>
                                <li>Delete</li>
                            </ul>
                        </div>
                    </td>
                </tr>
                ";
                $countPos++;
            }
        }

        echo $show;
    }

?>