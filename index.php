<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php 
    session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>HKP Store | Trang chủ</title>
        <link type="text/css" href="../DoanWeb2/bootstrap-4.5.3-dist/css/bootstrap.css">
        <link type="text/css" href="../DoanWeb2/bootstrap-4.5.3-dist/css/bootstrap-grid.css">
        <link type="text/css" href="../DoanWeb2/glyphicon.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>    
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            .navbar-nav > .nav-item > .nav-link{
               color:white; 
            }
            .navbar-nav > .nav-item > .nav-link:hover{
               color:orange; 
            }
            body{
                font-size:14px;
            }
            .logo-brand{
                width:110px;
            }
            .logo-brand img{
                width:100%;
            }
        </style>
    </head>
    <body>
        <div class="header">
            <nav class="navbar navbar-expand-md bg-info navbar-light">    
                <div class="logo-brand">
                    <a class="navbar-brand" href="index.php">
                    <img src="../DoanWeb2/images/logo/logo-ngang-trans.png" alt="Logo" width="110px">
                    </a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                  <li class="nav-item">
                    <a class="nav-link" href="index.php">Trang chủ</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Liên hệ</a>
                  </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <?php 
                        if(isset($_SESSION['id_nguoidung']) && isset($_SESSION['hoten']))
                        {
                            $id = $_SESSION['id_nguoidung'];
                            $hoten = $_SESSION['hoten'];
                            echo '<li class="nav-item dropdown">
                                    <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      Xin chào, '.$hoten.'('.$id.')
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                      <a class="dropdown-item" href="#">Đăng xuất</a>';
                            echo '</li>';
                        }
                    ?>
                </ul>
              </div>
              </nav>
        </div>
    </body>
</html>
