<?php
    if (isset($_GET['ds'])&&isset($_GET['de'])&&isset($_GET['total'])) {
        include('../templates/connectData.php');
        $conn = new connectData('');
        
        $ds = $_GET['ds'];
        $de = $_GET['de'];

        // Declare function
        function handle($day) {
            if ($day == "") return "đầu";

            $time = explode("-",$day);
            return "ngày ".date("d-m-Y",mktime(0,0,0,$time[1],$time[2],$time[0]));
        }
        
        // Chart 1 : Analyze total import and total sold
        // Get tong nhap
        $sql = "select sum(so_luong) as tong_nhap from chitiet_phieunhap, phieu_nhap where chitiet_phieunhap.id_phieunhap = phieu_nhap.id_phieunhap
                and phieu_nhap.ngay_nhap >= '$ds' and phieu_nhap.ngay_nhap <= '$de'";

        $res = $conn->selectData($sql);
        $qtt_imp = (int)mysqli_fetch_array($res)['tong_nhap'];

        // Get tong ban'
        $sql = "select sum(so_luong) as tong_mua 
        from chitiet_hoadon, hoa_don, chitiet_giaohang  
        where chitiet_hoadon.id_hoadon = hoa_don.id_hoadon and chitiet_giaohang.id_hoadon = hoa_don.id_hoadon and chitiet_giaohang.tinhtrang_giaohang = 3 
                and hoa_don.ngay_mua >= '$ds' and hoa_don.ngay_mua <= '$de'";

        $res = $conn->selectData($sql);
        $qtt_sold = (int)mysqli_fetch_array($res)['tong_mua'];

        // Create chart
        $show = '
            <div class="pie-chart">
                <canvas id="total-pie"></canvas>
            </div>';
        $show .= "
        <script>
            var total_pie = {
                labels: [
                    'Total Imported',
                    'Total Sold'
                ],
                datasets: [{
                    label: 'Analyze product',
                    data: [$qtt_imp, $qtt_sold],
                    backgroundColor: [
                    'rgb(255, 99, 132)',    
                    'rgb(54, 162, 235)'
                    ],
                    hoverOffset: 4
                }]
            };
            var config_totalpie = {
                type: 'pie',
                data: total_pie,
            };
            var myChart = new Chart(
                document.getElementById('total-pie'),
                config_totalpie
            );
        </script>
        ";

        // Chart 2 : Analyze total size was bought
        $sql = "SELECT size, SUM(chitiet_hoadon.so_luong) as sl
        FROM san_pham, chitiet_hoadon, hoa_don, chitiet_giaohang  
        WHERE san_pham.id_sanpham = chitiet_hoadon.id_sanpham 
        and chitiet_giaohang.id_hoadon = hoa_don.id_hoadon 
        and chitiet_giaohang.tinhtrang_giaohang = 3 
        and chitiet_hoadon.id_hoadon = hoa_don.id_hoadon 
        and hoa_don.ngay_mua >= '$ds' 
        and hoa_don.ngay_mua <= '$de' 
        group by size 
        order by size desc";

        $res = $conn->selectData($sql);
        $size_str = "";
        $qtt_str = "";
        $first = true;
        while ($row = mysqli_fetch_array($res)) {
            if ($first != true) {
                $size_str .= ", ";
                $qtt_str .= ", ";
            } else if ($first == true) $first = false;
            $size_str .= "'Size ".$row['size']."'";
            $qtt_str .= $row['sl'];
        }

        // Create chart
        $show .= '
                <div class="pie-chart">
                    <canvas id="total-size"></canvas>
                </div>';
        $show .= "
        <script>
            var total_size = {
                labels: [
                    $size_str
                ],
                datasets: [{
                    label: 'Analyze product',
                    data: [$qtt_str],
                    backgroundColor: [
                    'rgb(255, 99, 132)',    
                    'rgb(54, 162, 235)',
                    'rgb(108, 250, 89)',
                    'rgb(243, 217, 71)',
                    'rgb(250, 89, 250)',
                    'rgb(151, 89, 250)',
                    ],
                    hoverOffset: 4
                }]
            };
            var config_totalsize = {
                type: 'pie',
                data: total_size,
            };
            var myChart = new Chart(
                document.getElementById('total-size'),
                config_totalsize
            );
        </script>
        ";

        // Chart 3 : Total import and sold as current
        // Get tong nhap
        $sql = "select sum(tong_gia_nhap) as tong_nhap from phieu_nhap where phieu_nhap.ngay_nhap >= '$ds' and phieu_nhap.ngay_nhap <= '$de'";

        $res = $conn->selectData($sql);
        $qtt_imp = (int)mysqli_fetch_array($res)['tong_nhap'];

        // Get tong ban 
        $sql = "select sum(tong_gia) as tong_mua from chitiet_hoadon, hoa_don, chitiet_giaohang  
                where chitiet_hoadon.id_hoadon = hoa_don.id_hoadon 
                and chitiet_giaohang.id_hoadon = hoa_don.id_hoadon 
                and chitiet_giaohang.tinhtrang_giaohang = 3 
                and hoa_don.ngay_mua >= '$ds' and hoa_don.ngay_mua <= '$de'";

        $res = $conn->selectData($sql);
        $qtt_sold = (int)mysqli_fetch_array($res)['tong_mua'];
        $show .= '
            <div class="line-chart">
                <canvas id="chart_imp_sold_current"></canvas>
                <span id="span-total-chart">Tổng doanh thu = '.number_format($qtt_sold).' VNĐ - '.number_format($qtt_imp).' VNĐ = '.number_format($qtt_sold-$qtt_imp).' VNĐ</span>
            </div>';
        $show .= "
        <script>
        var chart_imp_sold_current = {
          labels: ['Tổng giá nhập', 'Tổng giá bán'],
          datasets: [{
            label: 'Tổng chi phí, doanh thu (đơn vị: VNĐ)',
            data: [$qtt_imp, $qtt_sold],
            backgroundColor: [
                'rgb(".rand(0,255).", ".rand(0,255).", ".rand(0,255).", 0.4)',
                'rgb(".rand(0,255).", ".rand(0,255).", ".rand(0,255).", 0.4)'
            ],
            borderColor: [
                'rgb(".rand(0,255).", ".rand(0,255).", ".rand(0,255).")',
                'rgb(".rand(0,255).", ".rand(0,255).", ".rand(0,255).")'
            ],
            borderWidth: 1
          }]
        };
        var config_chart_imp_sold_current = {
          type: 'bar',
          data: chart_imp_sold_current,
          options: {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          },
        };
        var myChart = new Chart(
                        document.getElementById('chart_imp_sold_current'),
                        config_chart_imp_sold_current
                    );
        </script>
        ";

        // Chart 4 : Bar chart Top 10 products most seller
        $sql = "SELECT ten_nhomsanpham, SUM(chitiet_hoadon.so_luong) as sl 
            FROM chitiet_hoadon, san_pham, nhom_san_pham, hoa_don, chitiet_giaohang   
            WHERE chitiet_hoadon.id_sanpham = san_pham.id_sanpham 
            and chitiet_giaohang.id_hoadon = hoa_don.id_hoadon 
            and chitiet_giaohang.tinhtrang_giaohang = 3 
            and chitiet_hoadon.id_hoadon = hoa_don.id_hoadon 
            and hoa_don.ngay_mua >= '$ds' and hoa_don.ngay_mua <= '$de' 
            AND san_pham.id_nhomsanpham = nhom_san_pham.id_nhomsanpham 
            GROUP BY ten_nhomsanpham 
            ORDER BY sl DESC 
            LIMIT 0, 10";

        $res = $conn->selectData($sql);
        $name_str = "";
        $sold_str = "";
        $first = true;
        while ($row = mysqli_fetch_array($res)) {
            if ($first != true) {
                $name_str .= ", ";
                $sold_str .= ", ";
            } else if ($first == true) $first = false;
            $name_str .= "'".$row['ten_nhomsanpham']."'";
            $sold_str .= $row['sl'];
        }
        $show .= '
            <div class="line-chart">
                <canvas id="total-top"></canvas>
            </div>';
        $show .= "
        <script>
        var total_top = {
          labels: [$name_str],
          datasets: [{
            label: 'Top 10 bán chạy nhất từ ".handle($ds)." tới ".handle($de)."',
            data: [$sold_str],
            backgroundColor: [
                'rgb(255, 99, 132, 0.4)',    
                'rgb(54, 162, 235, 0.4)',
                'rgb(108, 250, 89, 0.4)',
                'rgb(243, 217, 71, 0.4)',
                'rgb(250, 89, 250, 0.4)',
                'rgb(151, 89, 250, 0.4)',
                'rgba(201, 203, 207, 0.4)',
                'rgb(255, 149, 62, 0.4)',
                'rgb(62, 255, 245, 0.4)',
                'rgb(255, 62, 62, 0.4)'
            ],
            borderColor: [
                'rgb(255, 99, 132)',    
                'rgb(54, 162, 235)',
                'rgb(108, 250, 89)',
                'rgb(243, 217, 71)',
                'rgb(250, 89, 250)',
                'rgb(151, 89, 250)',
                'rgb(201, 203, 207)',
                'rgb(255, 149, 62)',
                'rgb(62, 255, 245)',
                'rgb(255, 62, 62)'
            ],
            borderWidth: 1
          }]
        };
        var config_totaltop = {
          type: 'bar',
          data: total_top,
          options: {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          },
        };
        var myChart = new Chart(
                        document.getElementById('total-top'),
                        config_totaltop
                    );
        </script>
        ";

        echo $show;
    }
?>