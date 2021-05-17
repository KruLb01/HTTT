<?php
    $sql = "Select thuonghieu_sanpham from dong_san_pham group by thuonghieu_sanpham";
    $result = $con->preparedSelect($sql);
    if($result!==null)
    {
        echo '<ul class="list-productbrand">';
        while ($row = mysqli_fetch_array($result)) 
        {
            echo '<li class="productbrand-item" id="'.$row[0].'"><div class="productbrand-name"><a href="danhmucsanpham.php?thuonghieu='.$row[0].'">'.$row[0].'</a></div>';
            $sql1 = "select id_dongsanpham,ten_dongsanpham from dong_san_pham where thuonghieu_sanpham='$row[0]'";
            $result1 = $con->preparedSelect($sql1);
            if($result1!==null)
            {
                echo '<ul class="list-productline">';
                while($row1 = mysqli_fetch_array($result1))
                {
                    echo '<li id='.$row1[0].' class="productline-item"><i class="fa fa-caret-right"></i> <a href="danhmucsanpham.php?thuonghieu='.$row[0].'&ma_dongsp='.$row1[0].'">'.$row1[1].'</a></li>';
                }
                echo '</ul>';
            }
            echo '</li>';
        }
        echo '</ul>';
 }
?>
 <div class="container-search">
    <h3>Tìm kiếm</h3>
    <form>
        <div class="search-input">
            <div>
                <input type="text" id="search_name" placeholder="Nhập tên sản phẩm" name="ten_sp" value=""/>
            </div>
            <div>
                <input type="submit" value="Tìm kiếm &#x1F50E;"/>
            </div>
        </div>
        <div class="advanced-search-container">
            <div class="advanced-search-item">
                <div>
                    <strong>Thương hiệu</strong>
                </div>
                <div class="radiobox-item">
                    <input id="all-brand" name="thuonghieu" type="radio" value="" checked/>
                    <label for="all-brand">Tất cả sản phẩm</label>
                </div>
                <?php $sql2="select thuonghieu_sanpham from dong_san_pham group by thuonghieu_sanpham";
                    $result2 = $con->preparedSelect($sql2);
                    if(mysqli_num_rows($result2)>0)
                    {
                        while($row = mysqli_fetch_array($result2)){
                        echo '<div class="radiobox-item">
                                <input name="thuonghieu" type="radio" value="'.$row[0].'"" id="'.$row[0].'"/>
                                <label for="'.$row[0].'">'.$row[0].'</label>
                              </div>';
                        }
                    }
                ?>
            </div>
            <div class="advanced-search-item">
                <div>
                    <strong>Dòng sản phẩm</strong>
                </div>
                <div class="radiobox-item">
                    <input id="all-product-line" name="ma_dongsp" type="radio" value="" checked/>
                    <label for="all-product-line">Tất cả dòng sản phẩm</label>
                </div>
                <?php $sql3="select id_dongsanpham,ten_dongsanpham from dong_san_pham";
                    $result3 = $con->preparedSelect($sql3);
                    if(mysqli_num_rows($result3)>0)
                    {
                        while($row = mysqli_fetch_array($result3)){
                        echo '<div class="radiobox-item">
                                <input name="ma_dongsp" type="radio" value="'.$row[0].'"" id="'.$row[0].'"/>
                                <label for="'.$row[0].'">'.$row[1].'</label>
                              </div>';
                        }
                    }
                ?>
            </div>
        </div>
    </form>
 </div>