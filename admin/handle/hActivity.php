<?php
    if (isset($_GET['data'])) {
        include('../templates/connectData.php');
        $conn = new connectData('');
        $input = $_GET['data'];

        $show = "
            <tr>
                <th>Id</th>
                <th>Type</th>
                <th>Name</th>
            </tr>
        ";

        if ($input != "all") {
            if ($input == "") return;
            $data = explode("~", $input);

            if (count($data)>1) {
                $sql = "select * from dong_san_pham, nhom_san_pham
                        where dong_san_pham.id_dongsanpham = nhom_san_pham.id_dongsanpham ";
                for ($i=0;$i<count($data);$i++) {
                    $val = explode(":", $data[$i])[1];
                    $select = explode(":", $data[$i])[0];

                    if ($select=="gProducts") {
                        $sql .= "and ten_dongsanpham like '%$val%' ";
                    } else if ($select=="products") {
                        $sql .= "and ten_nhomsanpham like '%$val%' ";
                    }
                }
                $res = $conn->selectData($sql);
                $show .= $sql;
                while ($row = mysqli_fetch_array($res)) {
                    $show .= "
                        <tr>
                            <td>".$row['id_nhomsanpham']."</td>
                            <td>Nhóm sản phẩm</td>
                            <td>".$row['ten_nhomsanpham']."</td>
                        </tr>
                    ";
                }
                echo $show;
                return;
            }

            for ($i=0;$i<count($data);$i++) {
                $val = explode(":",$data[$i])[1];
                $select = explode(":",$data[$i])[0];

                if ($select=="gProducts") {
                    $res = $conn->selectData("select * from dong_san_pham where ten_dongsanpham like '%$val%'");
                    while ($row = mysqli_fetch_array($res)) {
                        $show .= "
                            <tr>
                                <td>".$row['id_dongsanpham']."</td>
                                <td>Dòng sản phẩm</td>
                                <td>".$row['ten_dongsanpham']."</td>
                            </tr>
                        ";
                    }
                } else if ($select=="products") {
                    $res = $conn->selectData("select * from nhom_san_pham where ten_nhomsanpham like '%$val%'");
                    while ($row = mysqli_fetch_array($res)) {
                        $show .= "
                            <tr>
                                <td>".$row['id_nhomsanpham']."</td>
                                <td>Nhóm sản phẩm</td>
                                <td>".$row['ten_nhomsanpham']."</td>
                            </tr>
                        ";
                    }
                }
            }
        }
        else if ($input == "all") {
            $data = $input;

            $res = $conn->selectData("select * from dong_san_pham order by id_dongsanpham");
            while ($row = mysqli_fetch_array($res)) {
                $show .= "
                    <tr>
                        <td>".$row['id_dongsanpham']."</td>
                        <td>Dòng sản phẩm</td>
                        <td>".$row['ten_dongsanpham']."</td>
                    </tr>
                ";
            }

            $res = $conn->selectData("select * from nhom_san_pham order by id_nhomsanpham");
            while ($row = mysqli_fetch_array($res)) {
                $show .= "
                    <tr>
                        <td>".$row['id_nhomsanpham']."</td>
                        <td>Nhóm sản phẩm</td>
                        <td>".$row['ten_nhomsanpham']."</td>
                    </tr>
                ";
            }
        }
        echo $show;
    }
?>