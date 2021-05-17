<?php
    if (isset($_GET['id'])&&isset($_GET['type'])&&isset($_GET['ds'])&&isset($_GET['de'])) {
        include('../templates/connectData.php');
        $conn = new connectData('');

        $id = $_GET['id'];
        $type = $_GET['type'];
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
                and phieu_nhap.ngay_nhap >= '$ds' and phieu_nhap.ngay_nhap <= '$de' 
                and id_sanpham in 
                    ( select id_sanpham from nhom_san_pham, san_pham 
                    where nhom_san_pham.id_nhomsanpham = san_pham.id_nhomsanpham 
                    and ";
        if (trim($type)=="Dòng sản phẩm") {
            $sql .= "nhom_san_pham.id_dongsanpham = '$id')";
        } else if (trim($type)=="Nhóm sản phẩm") {
            $sql .= "nhom_san_pham.id_nhomsanpham = '$id')";
        }

        $res = $conn->selectData($sql);
        $qtt_imp = (int)mysqli_fetch_array($res)['tong_nhap'];

        // Get tong ban'
        $sql = "select sum(so_luong) as tong_mua from chitiet_hoadon, hoa_don, chitiet_giaohang  
                where chitiet_hoadon.id_hoadon = hoa_don.id_hoadon 
                and chitiet_giaohang.id_hoadon = hoa_don.id_hoadon 
                and chitiet_giaohang.tinhtrang_giaohang = 3 
                and hoa_don.ngay_mua >= '$ds' and hoa_don.ngay_mua <= '$de' 
                and id_sanpham in 
                    ( select id_sanpham from nhom_san_pham, san_pham 
                    where nhom_san_pham.id_nhomsanpham = san_pham.id_nhomsanpham 
                    and ";
        if (trim($type)=="Dòng sản phẩm") {
            $sql .= "nhom_san_pham.id_dongsanpham = '$id')";
        } else if (trim($type)=="Nhóm sản phẩm") {
            $sql .= "nhom_san_pham.id_nhomsanpham = '$id')";
        }
        $res = $conn->selectData($sql);
        $qtt_sold = (int)mysqli_fetch_array($res)['tong_mua'];

        // Create chart
        $show = '
                <div class="pie-chart">
                    <canvas id="chart_imp_sold"></canvas>
                </div>';
        $show .= "
        <script>
            var chart_imp_sold = {
                labels: [
                    'Imported',
                    'Sold'
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
            var config_chart_is = {
                type: 'pie',
                data: chart_imp_sold,
            };
            var myChart = new Chart(
                document.getElementById('chart_imp_sold'),
                config_chart_is
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
        and san_pham.id_sanpham in 
            ( select id_sanpham from nhom_san_pham, san_pham 
            where nhom_san_pham.id_nhomsanpham = san_pham.id_nhomsanpham 
            and ";
        if (trim($type)=="Dòng sản phẩm") {
            $sql .= "nhom_san_pham.id_dongsanpham = '$id') GROUP BY size";
        } else if (trim($type)=="Nhóm sản phẩm") {
            $sql .= "nhom_san_pham.id_nhomsanpham = '$id') GROUP BY size";
        }

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
                    <canvas id="chart_size"></canvas>
                </div>';
        $show .= "
        <script>
            var chart_size = {
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
            var config_chart_size = {
                type: 'pie',
                data: chart_size,
            };
            var myChart = new Chart(
                document.getElementById('chart_size'),
                config_chart_size
            );
        </script>
        ";

        // Chart 3 : Total import and sold as current
        // Get tong nhap
        $sql = "select so_luong, gia_nhap from chitiet_phieunhap, phieu_nhap where chitiet_phieunhap.id_phieunhap = phieu_nhap.id_phieunhap
                and phieu_nhap.ngay_nhap >= '$ds' and phieu_nhap.ngay_nhap <= '$de' 
                and id_sanpham in 
                    ( select id_sanpham from nhom_san_pham, san_pham 
                    where nhom_san_pham.id_nhomsanpham = san_pham.id_nhomsanpham 
                    and ";
        if (trim($type)=="Dòng sản phẩm") {
            $sql .= "nhom_san_pham.id_dongsanpham = '$id')";
        } else if (trim($type)=="Nhóm sản phẩm") {
            $sql .= "nhom_san_pham.id_nhomsanpham = '$id')";
        }

        $res = $conn->selectData($sql);
        $qtt_imp = 0;
        while ($row = mysqli_fetch_array($res)) {
            $qtt_imp += (int)$row['so_luong'] * (int)$row['gia_nhap'];
        }

        // Get tong ban'
        $sql = "select sum(tong_gia) as tong_mua from chitiet_hoadon, hoa_don, chitiet_giaohang  
                where chitiet_hoadon.id_hoadon = hoa_don.id_hoadon 
                and chitiet_giaohang.id_hoadon = hoa_don.id_hoadon 
                and chitiet_giaohang.tinhtrang_giaohang = 3 
                and hoa_don.ngay_mua >= '$ds' and hoa_don.ngay_mua <= '$de' 
                and id_sanpham in 
                    ( select id_sanpham from nhom_san_pham, san_pham 
                    where nhom_san_pham.id_nhomsanpham = san_pham.id_nhomsanpham 
                    and ";
        if (trim($type)=="Dòng sản phẩm") {
            $sql .= "nhom_san_pham.id_dongsanpham = '$id')";
        } else if (trim($type)=="Nhóm sản phẩm") {
            $sql .= "nhom_san_pham.id_nhomsanpham = '$id')";
        }

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

        // Chart 4 :
        if (trim($type)=="Dòng sản phẩm") {
            $sql = "SELECT ten_nhomsanpham, SUM(chitiet_hoadon.so_luong) as sl 
            FROM chitiet_hoadon, san_pham, nhom_san_pham, chitiet_giaohang  
            WHERE chitiet_hoadon.id_sanpham = san_pham.id_sanpham 
            and chitiet_giaohang.id_hoadon = chitiet_hoadon.id_hoadon 
            and chitiet_giaohang.tinhtrang_giaohang = 3 
            AND san_pham.id_nhomsanpham = nhom_san_pham.id_nhomsanpham 
            AND nhom_san_pham.id_dongsanpham = '$id' 
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
                    <canvas id="top-products"></canvas>
                </div>';
            $show .= "
            <script>
            var top_products = {
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
            var config_top = {
              type: 'bar',
              data: top_products,
              options: {
                scales: {
                  y: {
                    beginAtZero: true
                  }
                }
              },
            };
            var myChart = new Chart(
                            document.getElementById('top-products'),
                            config_top
                        );
            </script>
            ";
        }
        
        if ($qtt_imp==""&&$qtt_sold==""&&trim($size_str)==""&&trim($qtt_str)=="") {
            return;
        }

        echo $show;
    }

    if (isset($_GET['inputs'])&&isset($_GET['type'])&&isset($_GET['ds'])&&isset($_GET['de'])) {
        include('../templates/connectData.php');
        $conn = new connectData('');

        $inputs = explode("~",$_GET['inputs']);
        $type = explode("~",$_GET['type']);
        $ds = $_GET['ds'];
        $de = $_GET['de'];

        $show = "";

        function gapBetween2days($Tstart, $Tend) {
            $start = strtotime($Tstart);
            $end = strtotime($Tend);
            $gap = abs($start - $end);
            return floor($gap/(60*60*24));
        }

        function makeLabels($ds, $de, $gap) {
            $tmp = 0;
            $labels = "";
            if ($gap > 8) {
                $tmp = floor((int)$gap/8);
                $start = explode("-",$ds);
                $end = explode("-",$de);
                for ($i=0;$i<8;$i++) {
                    if ($i == 7) {
                        $labels .= "'".date("d-m-Y",mktime(0,0,0,$end[1],$end[2],$end[0]))."',";
                        break;
                    }
                    $labels .= "'".date("d-m-Y",mktime(0,0,0,$start[1],$start[2],$start[0]))."',";
                    $start[2] += $tmp;
                }
            } else {
                $start = explode("-",$ds);
                $end = explode("-",$de);
                for ($i=0;$i<=$gap;$i++) {
                    $labels .= "'".date("d-m-Y",mktime(0,0,0,$start[1],$start[2],$start[0]))."',";
                    $start[2] += 1; 
                }
            }
            return $labels;
        }

        if (($gap = gapBetween2days($ds, $de))>8) {
            $show .= '
            <div class="line-chart">
                <canvas id="compare"></canvas>
            </div>';
            $show .= "
            <script>
            var compare = {
                labels: [".trim(makeLabels($ds, $de, gapBetween2days($ds, $de)),",")."],
                datasets: [";


            // Add data
            for ($i=0;$i<count($inputs);$i++) {
                $show .= "{
                    label: 'Id = $inputs[$i]',
                    data: [";
                //s
                $de_str = explode(",", makeLabels($ds, $de, gapBetween2days($ds, $de)));
        
                $value = "";
    
                for ($j=0;$j<8;$j++) {
                    $tmp = explode("-",trim($de_str[$j], "'"));
                    $time_tmp = date("Y-m-d",mktime(0,0,0,$tmp[1],$tmp[0],$tmp[2]));
                    $sql = "SELECT ten_nhomsanpham, SUM(chitiet_hoadon.so_luong) as sl 
                    FROM chitiet_hoadon, san_pham, nhom_san_pham, hoa_don, chitiet_giaohang  
                    WHERE chitiet_hoadon.id_sanpham = san_pham.id_sanpham 
                    and chitiet_giaohang.id_hoadon = hoa_don.id_hoadon 
                    and chitiet_giaohang.tinhtrang_giaohang = 3 
                    AND san_pham.id_nhomsanpham = nhom_san_pham.id_nhomsanpham 
                    and hoa_don.id_hoadon = chitiet_hoadon.id_hoadon 
                    AND hoa_don.ngay_mua >= '$ds' AND hoa_don.ngay_mua <= '$time_tmp' ";
                    if ($type[$i]=='Dòng sản phẩm') {
                        $sql .= "AND nhom_san_pham.id_dongsanpham = '$inputs[$i]' ";
                    } else if ($type[$i]=='Nhóm sản phẩm') {
                        $sql .= "AND nhom_san_pham.id_nhomsanpham = '$inputs[$i]' ";
                    }
                    $sql .= "
                    GROUP BY ten_nhomsanpham
                    ORDER BY sl DESC
                    ";
        
                    if ($type[$i]=='Nhóm sản phẩm') {
                        $res = $conn->selectData($sql);
                        if (mysqli_num_rows($res)==0) $value .= "0, ";
                        else {
                            $value .= mysqli_fetch_array($res)['sl'].", ";
                        }
                    } else if ($type[$i]=='Dòng sản phẩm') {
                        $res = $conn->selectData($sql);
                        if (mysqli_num_rows($res)==0) $value .= "0, ";
                        else {
                            $temp = 0;
                            while ($line = mysqli_fetch_array($res)) {
                                $temp += (int) $line['sl'];
                            }
                            $value .= $temp.", ";
                        }
                    }
                }
                $show .= $value;
                //e

                $show .= "],
                    fill: false,
                    borderColor: 'rgb(".rand(0,255).", ".rand(0,255).", ".rand(0,255).")',
                    tension: 0.1
                }";
                if ($i != (count($inputs)-1)) $show .= ", ";
            }


            $show .= "]
            };
            var config_compare = {
                type: 'line',
                data: compare,
            };
            var myChart = new Chart(
                document.getElementById('compare'),
                config_compare
            );
            </script>
            ";
        } else {
            $show .= '
            <div class="line-chart">
                <canvas id="compare"></canvas>
            </div>';
            $show .= "
            <script>
            var compare = {
                labels: [".trim(makeLabels($ds, $de, gapBetween2days($ds, $de)),",")."],
                datasets: [";


            // Add data
            for ($i=0;$i<count($inputs);$i++) {
                $show .= "{
                    label: 'Id = $inputs[$i]',
                    data: [";
                //s
                $de_str = explode(",", makeLabels($ds, $de, gapBetween2days($ds, $de)));
        
                $value = "";
    
                for ($j=0;$j<=gapBetween2days($ds, $de);$j++) {
                    $tmp = explode("-",trim($de_str[$j], "'"));
                    $time_tmp = date("Y-m-d",mktime(0,0,0,$tmp[1],$tmp[0],$tmp[2]));
                    $sql = "SELECT ten_nhomsanpham, SUM(chitiet_hoadon.so_luong) as sl 
                    FROM chitiet_hoadon, san_pham, nhom_san_pham, hoa_don, chitiet_giaohang  
                    WHERE chitiet_hoadon.id_sanpham = san_pham.id_sanpham 
                    and chitiet_giaohang.id_hoadon = hoa_don.id_hoadon 
                    and chitiet_giaohang.tinhtrang_giaohang = 3 
                    AND san_pham.id_nhomsanpham = nhom_san_pham.id_nhomsanpham 
                    and hoa_don.id_hoadon = chitiet_hoadon.id_hoadon 
                    AND hoa_don.ngay_mua >= '$ds' AND hoa_don.ngay_mua <= '$time_tmp' ";
                    if ($type[$i]=='Dòng sản phẩm') {
                        $sql .= "AND nhom_san_pham.id_dongsanpham = '$inputs[$i]' ";
                    } else if ($type[$i]=='Nhóm sản phẩm') {
                        $sql .= "AND nhom_san_pham.id_nhomsanpham = '$inputs[$i]' ";
                    }
                    $sql .= "
                    GROUP BY ten_nhomsanpham
                    ORDER BY sl DESC
                    ";
        
                    if ($type[$i]=='Nhóm sản phẩm') {
                        $res = $conn->selectData($sql);
                        if (mysqli_num_rows($res)==0) $value .= "0, ";
                        else {
                            $value .= mysqli_fetch_array($res)['sl'].", ";
                        }
                    } else if ($type[$i]=='Dòng sản phẩm') {
                        $res = $conn->selectData($sql);
                        if (mysqli_num_rows($res)==0) $value .= "0, ";
                        else {
                            $temp = 0;
                            while ($line = mysqli_fetch_array($res)) {
                                $temp += (int) $line['sl'];
                            }
                            $value .= $temp.", ";
                        }
                    }
                }
                $show .= $value;
                //e

                $show .= "],
                    fill: false,
                    borderColor: 'rgb(".rand(0,255).", ".rand(0,255).", ".rand(0,255).")',
                    tension: 0.1
                }";
                if ($i != (count($inputs)-1)) $show .= ", ";
            }


            $show .= "]
            };
            var config_compare = {
                type: 'line',
                data: compare,
            };
            var myChart = new Chart(
                document.getElementById('compare'),
                config_compare
            );
            </script>
            ";
        }
        
        // echo makeValues($ds, makeLabels($ds, $de, gapBetween2days($ds, $de)), $inputs[0], $type[0]);
        echo $show;
    }
?>