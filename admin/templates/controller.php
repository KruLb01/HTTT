<?php
    $flag = false;

    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        if ($action == 'logout') {
            session_start();
            // unset($_SESSION['user']);
            session_destroy();
            $flag = true;
        } else if ($action == 'view-info-user') {
            include('view-info-user.php');
        } else if ($action == 'change-password') {
            include('change-password.php');
        } else if ($action == 'manage-permission') {
            include('manage-permission.php');
        } else if ($action == 'manage-products') {
            include('manage-products.php');
        } else if ($action == 'manage-employee') {
            include('manage-employee.php');
        } else if ($action == 'manage-customers') {
            include('manage-customer.php');
        } else if ($action == 'import-products') {
            include('import-product.php');
        } else if ($action == 'manage-import') {
            include('manage-import.php');
        } else if ($action == 'track-invoice') {
            include('track-invoice.php');
        } else if ($action == 'manage-cproduct') {
            include('manage-cproduct.php');
        } else if ($action == 'activity') {
            include('activity.php');
        } else if ($action == 'manage-providers') {
            include('manage-providers.php');
        } else if ($action == 'manage-gproduct') {
            include('manage-gproduct.php');
        } else if ($action == 'mail') {
            include('mail.php');
        } else if ($action == 'help') {
            include('help.php');
        } else if ($action == 'track-sales') {
            include('manage-sales.php');
        }
    } else include('default-content.php');
    echo $flag;
?>