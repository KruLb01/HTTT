<?php
    // include('connectData.php');
    // $conn = new connectData('1');
    
    $countCustomers = mysqli_fetch_array($conn->selectData('select count(*) as quantity from khach_hang, nguoi_dung where khach_hang.id_nguoidung = nguoi_dung.id_nguoidung'))['quantity'];
    $countUsers = mysqli_fetch_array($conn->selectData('select count(*) as quantity from admin, nguoi_dung where admin.id_nguoidung = nguoi_dung.id_nguoidung'))['quantity'];
    $countProducts = mysqli_fetch_array($conn->selectData('select count(*) as quantity from nhom_san_pham'))['quantity'];
    $countSales = mysqli_fetch_array($conn->selectData('select count(*) as quantity from sale'))['quantity'];

?>

<span>Welcome back : <?php echo $_SESSION['user']['permission'] . ' ' . $_SESSION['user']['name'] ?></span>
            <div class="dashboard-content-box-container disable-copy">
                <div class="dashboard-content-box">
                    <i class="fas fa-users" style='background-color:#f3e354'></i>
                    <div class="dashboard-content-box-item">
                        <span>Total Customers</span>
                        <span><?php echo $countCustomers ?> people</span>
                    </div>
                </div>
                <div class="dashboard-content-box">
                    <i class="fas fa-user-tie" style='background:#81f354'></i>
                    <div class="dashboard-content-box-item">
                        <span>Total Users</span>
                        <span><?php echo $countUsers ?> people</span>
                    </div>
                </div>
                <div class="dashboard-content-box">
                    <i class="fas fa-cubes"></i>
                    <div class="dashboard-content-box-item">
                        <span>Total Products</span>
                        <span><?php echo $countProducts ?> products</span>
                    </div>
                </div>
                <div class="dashboard-content-box">
                    <i class="fas fa-money-bill" style='background:#e054f3'></i>
                    <div class="dashboard-content-box-item">
                        <span>Total Sale Actived</span>
                        <span><?php echo $countSales ?> sales</span>
                    </div>
                </div>
            </div>

            <div class="dashboard-content-table-container">
                <div class="dashboard-content-table" style='width:100%' id='customers'>
                    <div class="dashboard-content-table-header disable-copy">
                        <span>Customers List</span>
                    </div>
                    <div class="no-things-available">
                    </div>
                    <table class="dashboard-content-table-item">
                    </table>
                    <div class="dashboard-content-table-pagination disable-copy">
                        <div class="dashboard-content-table-pagination-btn">
                            <span id='previous-btn-users' class='disable' style='border-top-left-radius: 5px;border-bottom-left-radius: 5px;'>Previous</span>
                            <?php
                                $maxP = ceil($countCustomers/10);

                                if ($maxP > 4) {
                                    echo "<span class='default-users-pagination dashboard-content-table-pagination-btn-selected'>1</span>";
                                    echo "<span class='default-users-pagination-more'>...</span>";
                                    for ($i = 2; $i < $maxP; $i++) {
                                        echo "<span class='default-users-pagination'>$i</span>";
                                    }
                                    echo "<span class='default-users-pagination-more'>...</span>";
                                    echo "<span class='default-users-pagination'>$maxP</span>";
                                } else {
                                    echo "<span class='default-users-pagination dashboard-content-table-pagination-btn-selected'>1</span>";
                                    for ($i = 2; $i <= $maxP; $i ++) {
                                        
                                        echo "<span class='default-users-pagination'>$i</span>";
                                    }
                                } 
                            ?>
                            <span id='next-btn-users' style='border-top-right-radius: 5px;border-bottom-right-radius: 5px;'>Next</span>
                        </div>
                    </div>
                </div>
                <!--Users list-->
                <div class="dashboard-content-table" style='width:48%' id='users'>
                    <div class="dashboard-content-table-header">
                        <span>Users List</span>
                    </div>
                    <div class="no-things-available">
                    </div>
                    <table class="dashboard-content-table-item">
                    </table>
                    <div class="dashboard-content-table-pagination disable-copy">
                        <div class="dashboard-content-table-pagination-btn">
                            <span id='previous-btn-admin' class='disable' style='border-top-left-radius: 5px;border-bottom-left-radius: 5px;'>Previous</span>
                            <?php
                                $maxP = ceil($countUsers/10);

                                if ($maxP > 4) {
                                    echo "<span class='default-admin-pagination dashboard-content-table-pagination-btn-selected'>1</span>";
                                    echo "<span class='default-admin-pagination-more'>...</span>";
                                    for ($i = 2; $i < $maxP; $i++) {
                                        echo "<span class='default-admin-pagination'>$i</span>";
                                    }
                                    echo "<span class='default-admin-pagination-more'>...</span>";
                                    echo "<span class='default-admin-pagination'>$maxP</span>";
                                } else {
                                    echo "<span class='default-admin-pagination dashboard-content-table-pagination-btn-selected'>1</span>";
                                    for ($i = 2; $i <= $maxP; $i ++) {
                                        
                                        echo "<span class='default-admin-pagination'>$i</span>";
                                    }
                                } 
                            ?>
                            <span id='next-btn-admin' style='border-top-right-radius: 5px;border-bottom-right-radius: 5px;'>Next</span>
                        </div>
                    </div>
                </div>
                <!--Sale list--->
                <div class="dashboard-content-table" style='width:48%' id='sales'>
                    <div class="dashboard-content-table-header">
                        <span>Sales List</span>
                    </div>
                    <div class="no-things-available">
                    </div>
                    <table class="dashboard-content-table-item">
                    </table>
                    <div class="dashboard-content-table-pagination disable-copy">
                        <div class="dashboard-content-table-pagination-btn">
                            <span id='previous-btn-sales' class='disable' style='border-top-left-radius: 5px;border-bottom-left-radius: 5px;'>Previous</span>
                            <?php
                                $maxP = ceil($countSales/10);

                                if ($maxP > 4) {
                                    echo "<span class='default-sales-pagination dashboard-content-table-pagination-btn-selected'>1</span>";
                                    echo "<span class='default-sales-pagination-more'>...</span>";
                                    for ($i = 2; $i < $maxP; $i++) {
                                        echo "<span class='default-sales-pagination'>$i</span>";
                                    }
                                    echo "<span class='default-sales-pagination-more'>...</span>";
                                    echo "<span class='default-sales-pagination'>$maxP</span>";
                                } else {
                                    echo "<span class='default-sales-pagination dashboard-content-table-pagination-btn-selected'>1</span>";
                                    for ($i = 2; $i <= $maxP; $i ++) {
                                        
                                        echo "<span class='default-sales-pagination'>$i</span>";
                                    }
                                } 
                            ?>
                            <span id='next-btn-sales' style='border-top-right-radius: 5px;border-bottom-right-radius: 5px;'>Next</span>
                        </div>
                    </div>
                </div>
                <!--Product list-->
                <div class="dashboard-content-table" style='width:100%' id='products'>
                    <div class="dashboard-content-table-header">
                        <span>Products List</span>
                    </div>
                    <div class="no-things-available">
                    </div>
                    <table class="dashboard-content-table-item">
                    </table>
                    <div class="dashboard-content-table-pagination disable-copy">
                        <div class="dashboard-content-table-pagination-btn">
                            <span id='previous-btn-products' class='disable' style='border-top-left-radius: 5px;border-bottom-left-radius: 5px;'>Previous</span>
                            <?php
                                $maxP = ceil($countProducts/10);

                                if ($maxP > 4) {
                                    echo "<span class='default-products-pagination dashboard-content-table-pagination-btn-selected'>1</span>";
                                    echo "<span class='default-products-pagination-more'>...</span>";
                                    for ($i = 2; $i < $maxP; $i++) {
                                        echo "<span class='default-products-pagination'>$i</span>";
                                    }
                                    echo "<span class='default-products-pagination-more'>...</span>";
                                    echo "<span class='default-products-pagination'>$maxP</span>";
                                } else {
                                    echo "<span class='default-products-pagination dashboard-content-table-pagination-btn-selected'>1</span>";
                                    for ($i = 2; $i <= $maxP; $i ++) {
                                        
                                        echo "<span class='default-products-pagination'>$i</span>";
                                    }
                                } 
                            ?>
                            <span id='next-btn-products' style='border-top-right-radius: 5px;border-bottom-right-radius: 5px;'>Next</span>
                        </div>
                    </div>
                </div>
            </div>
