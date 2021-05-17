<?php
session_start();
if(isset($_SESSION['id_nguoidung']))
{
    unset($_SESSION['id_nguoidung']);
    unset($_SESSION['hoten']);
}
// sleep(1);
header("location: ../index.php");

