<?php
    if(isset($_GET['page']) && $_GET['page'] && isset($_GET['items_per_page']) && $_GET['items_per_page']){
        $page = $_GET['page'];
        include './ConnectionDB.php';
        $con = new ConnectionDB('');
        $items_per_page = $_GET['items_per_page'];
        $from = ($page-1)*$items_per_page;
        $sql = "SELECT * "
                . " from nhom_san_pham "
                . " "
                . "group by nhom_san_pham.id_nhomsanpham "
                . "limit $items_per_page offset $from"; 
        $result = $con->preparedSelect($sql);
        if($result!==null)
        {
            while($row = mysqli_fetch_array($result)){
                $gender = $row['gioi_tinh'] == "Male" ? "Nam" : "Nữ";
                $result1 = $con->preparedSelect("select link_hinhanh from hinh_anh, hinh_nhomsanpham where hinh_anh.id_hinhanh = hinh_nhomsanpham.id_hinh and hinh_nhomsanpham.id_nhomsanpham = '".$row['id_nhomsanpham']."'");
                $url = "./static/images/logos/logo-doc.png";
                if(mysqli_num_rows($result1)>0)
                {
                    $row1 = mysqli_fetch_array($result1);
                    $url = $row1[0];
                }
                echo '<li class="prod-item">
                    <div class="prod-image">
                        <a href="./templates/chitietsanpham.php?id_nhomsp='.$row['id_nhomsanpham'].'"><img src="./'.$url.'"/></a>
                            <div class="prod-image-logo">
                                <img src="./static/images/logos/logo-ngang-trans.png"/>
                            </div> 
                    </div>
                    <div class="prod-name">
                        <h4>'.$row['ten_nhomsanpham'].'</h4>
                    </div>
                    <div class="prod-info">
                        <div class="prod-gender">
                            <span>Giới tính: '.$gender.'</span>
                        </div>
                        <div class="prod-color">
                            <span>Màu: '.$row['mau_sanpham'].'</span>
                        </div>
                    </div>
                    <div class="prod-detailbtn">
                        <button onclick="location.href='.("'./templates/chitietsanpham.php?id_nhomsp=".$row['id_nhomsanpham']."'").'" class="btn btn-dark">Xem chi tiết</button>
                    </div>
                </li>';
            }
        }
    }
