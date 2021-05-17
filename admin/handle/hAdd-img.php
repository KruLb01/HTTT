<?php
    include('../templates/connectData.php');
    $conn = new connectData('');

    if (isset($_POST['update'])) {
        $allowed_type = array('jpg','png','jpeg');
        $current_type = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
        
        if (isset($_POST['current'])) $current = $_POST['current'];
        if (isset($_POST['pos'])) $pos = $_POST['pos'];

        if (in_array($current_type, $allowed_type)) {
            $name = uniqid($current.'-',true).'.'. $current_type;
            $link = "images/".$name;
            move_uploaded_file($_FILES['file']['tmp_name'], '../../' . $link);
            
            $res = $conn->executeQuery("insert into hinh_anh(id_hinhanh, link_hinhanh) 
            values('$name', '$link')");
            $res = $conn->executeQuery("update hinh_nhomsanpham 
                set id_hinh = '$name' 
                where id_nhomsanpham = (select id_nhomsanpham from nhom_san_pham where ten_nhomsanpham = '$current')
                and id_hinh = (select id_hinh from hinh_nhomsanpham where id_nhomsanpham = (select id_nhomsanpham from nhom_san_pham where ten_nhomsanpham = '$current') limit $pos,1)");

            if ($res == true) echo 'Save success '.$name;
            else echo "Save failed";

        } else {
            echo 'Error: Unvalid type image';
        }
        return;
    }

    if (isset($_GET['delete'])) {
        $name = $_GET['nc'];
        $img = $_GET['ic'];
        $sql = "delete from hinh_nhomsanpham 
            where id_nhomsanpham = (select id_nhomsanpham from nhom_san_pham where ten_nhomsanpham = N'$name')
            and id_hinh = (select id_hinh from hinh_nhomsanpham where id_nhomsanpham = (select id_nhomsanpham from nhom_san_pham where ten_nhomsanpham = N'$name') limit $img,1)";
        $res = $conn->executeQuery($sql);
        if ($res == true) echo 'Success';
        else 'Failed';
    }

    if (isset($_GET['id']) && isset($_GET['name'])) {
        
        $id = $_GET['id'];
        $name = $_GET['name'];
        $current = '';
        
        $sql = "select ten_nhomsanpham from nhom_san_pham 
        where id_nhomsanpham like '%$id%'
        and ten_nhomsanpham like '%$name%'";
        $res = mysqli_num_rows($conn->selectData($sql));
        
        if (isset($_GET['getCurrent'])) {
            $current = mysqli_fetch_array($conn->selectData($sql))['ten_nhomsanpham'];
            echo $current;
            return;
        }
        
        if ($res == 1) {
            $sql = "select nhom_san_pham.id_nhomsanpham, link_hinhanh
            from nhom_san_pham, hinh_nhomsanpham, hinh_anh
                where nhom_san_pham.id_nhomsanpham like '%$id%'
                and ten_nhomsanpham like '%$name%'
                and nhom_san_pham.id_nhomsanpham = hinh_nhomsanpham.id_nhomsanpham
                and hinh_nhomsanpham.id_hinh = hinh_anh.id_hinhanh";
                $res = $conn->selectData($sql);
                $show = '';
                while ($line = mysqli_fetch_array($res)) {
                    $show .= '<div class="dm-image-show-img">';
                    $show .= '<img class="show-img" src="../'.$line['link_hinhanh'].'">';
                    $show .= '<span class="del-img">Delete</span>
                    <input type="file" class="show-browse-img" accept=".jpg, .png, .jpeg">
                    </div>';
                }
                if (mysqli_num_rows($res)!=5) {
                    $show .= '                            
                    <div class="dm-image-add-img">
                    <img src="./static/images/add-img.png" id="add-img">
                    <input type="file" id="browse-img" accept=".jpg, .png, .jpeg">
                    </div>';
                }
                echo $show;
            } else {
                echo 'error';
                return;
            }
    } else if(isset($_POST['current'])) {
        if ( $_FILES['file']['error'] > 0) {
            echo 'Error: ' . $_FILES['file']['error'] . '<br>';
        }
        else {
            $allowed_type = array('jpg','png','jpeg');
            $current_type = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
            
            if (isset($_POST['current'])) $current = $_POST['current'];

            if (in_array($current_type, $allowed_type)) {
                $name = uniqid($current.'-',true).'.'. $current_type;
                $link = "images/".$name;
                move_uploaded_file($_FILES['file']['tmp_name'], '../../' . $link);
                
                $res = $conn->executeQuery("insert into hinh_anh(id_hinhanh, link_hinhanh) 
                values('$name', '$link')");
                $res = $conn->executeQuery("insert into hinh_nhomsanpham(id_nhomsanpham, id_hinh)
                values((select id_nhomsanpham from nhom_san_pham where ten_nhomsanpham = N'$current'), '$name')");
                
                if ($res == true) echo 'Save success '.$name;
                else echo "Save failed";
            } else {
                echo 'Error: Unvalid type image';
            }
        }
    }
    
?>