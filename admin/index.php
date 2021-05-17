<?php session_start() ;
    if (!isset($_SESSION['user'])) {
        header("Location: ./templates/login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="static/css/style.css">
    <link rel="stylesheet" href="../static/css/all.css">
    <LINK REL="SHORTCUT ICON" HREF="./static/images/favicon.ico">
    <script src="static/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="static/js/jquery-3.6.0.min.js"></script>
    <script>
        $.getScript('./static/js/jquery-script.js', function(data, status, j) {})
    </script>
    <title>Admin Dashboard</title>
</head>
<body onload="setNotification()">
    <!--Header include here-->
    <?php require_once('./templates/header.php') ?>

    <!--Dashboard & Content Area here-->
    <div class="dashboard">
        <div class="menu-dashboard disable-copy">
            <div class="logo-dashboard">
                <img src="static/images/logo-doc-trans.png" alt="logo-dashboard">
            </div>
            <ul class="dashboard-menu-items">
                <?php
                    require_once('./templates/connectData.php');
                    $conn = new connectData('1');

                    $res = $conn->selectData("select * from chitiet_quyen_chucnang, chuc_nang 
                                where id_quyen = '".$_SESSION['user']['permission']."' and chitiet_quyen_chucnang.id_chucnang = chuc_nang.id_chucnang order by vi_tri");
                    $show = '';
                    $pos = 0;
                    $flag = true;
                    while ($row = mysqli_fetch_array($res)) {

                        if ((int)$row['vi_tri'] % 1000 == 0) {
                            $pos++;
                            if ($flag == false) {
                                $show .= "</ul><li id='menu-$pos' onclick='minimizieSubmenu(this.id)'><a class='bold-title'>
                                ".$row['icon'].$row['ten_chucnang']."</a></li>";
                                $flag = true;
                            } 
                            else {
                                $show .= "<li id='menu-$pos' onclick='minimizieSubmenu(this.id)'";
                                if ($row['ten_chucnang'] == 'Log out') {
                                    $show .= " class='logout-btn'";
                                }
                                $show .= "><a class='bold-title'>
                                ".$row['icon'].$row['ten_chucnang']."</a></li>";
                                $flag = true;
                            }
                        }
                        else {
                            if ($flag == false) {
                                $show .= "<li><a>".$row['ten_chucnang']."</a></li>";
                            }
                            else {
                                $show .= "<ul class='dashboard-submenu-items' id='submenu-$pos'>
                                            <li><a>".$row['ten_chucnang']."</a></li>";
                                $flag = false;
                            }
                        }
                    }   
                    echo $show;
                ?>
                
                <div class="space"></div>
            </ul>
        </div>

        <div class="content-dashboard">
            <?php include('./templates/controller.php') ?>
        </div>
    </div>
</body>
</html>