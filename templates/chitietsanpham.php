<?php 
    session_start();
    include 'ConnectionDB.php';
    $con = new ConnectionDB('');
?>
<html>
    <head>
        <title>HKP Store | Chi tiết sản phẩm</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <LINK REL="SHORTCUT ICON" HREF="../static/images/favicon.ico">
        <script src="../static/js/jquery-3.6.0.min.js"></script>
        <script src="../static/js/post_method.js"></script>
        <link rel="stylesheet" type="text/css" href="../static/css/cart.css">
        <link rel="stylesheet" type="text/css" href="../static/css/chitietsanpham.css">
        <link rel="stylesheet" type="text/css" href="../static/css/index.css">
        <link rel="stylesheet" type="text/css" href="../static/css/all.css">
        <link rel="stylesheet" type="text/css" href="../plugin/bootstrap-4.5.3-dist/css/bootstrap.css">
        <script src="../plugin/bootstrap-4.5.3-dist/js/bootstrap.min.js"></script>
        <style>
            .cart-content{
                height: auto
            }
            @media (min-width:576px){
                .modal-dialog{
                    max-width:1000px;
                }
            }
        </style>
    </head>
    <body>
        <div class="wrap">
            <div class="header">
                <?php include './header1.php'?>
            </div>
            <div class="mid">
                <?php if(isset($_GET['id_nhomsp']))
                {
                    $idnsp = $_GET['id_nhomsp'];
                    $sql = "SELECT nhom_san_pham.ten_nhomsanpham,gioi_tinh,mieuta,sosao_danhgia,soluot_danhgia,ten_dongsanpham,mau_sanpham FROM `nhom_san_pham`,`dong_san_pham` WHERE nhom_san_pham.id_nhomsanpham = '$idnsp' and dong_san_pham.id_dongsanpham = nhom_san_pham.id_dongsanpham";
                    $result = $con->preparedSelect($sql);
                    if($result!==null)
                    {
                        ?>
                        <div class="detail-container">
                            <div class="container-prod-image col-lg-4 col-sm-6 col-12">
                                <div class="ExtendedImage">
                                    <img src="#" />
                                </div>
                                <?php $sql1="SELECT link_hinhanh from hinh_nhomsanpham, hinh_anh where id_nhomsanpham=$idnsp and hinh_anh.id_hinhanh = hinh_nhomsanpham.id_hinh";
                                      $result1 = $con->preparedSelect($sql1);
                                      while ($row1 = mysqli_fetch_array($result1)) {
                                          $url = $row1['link_hinhanh'];
                                          ?><div class="prod-image-detail"><img src="../<?php echo $url?>"/></div><?php
                                    }?>
                                <script>
                                    $(document).ready(()=>{
                                        $(".prod-image-detail").first().addClass("img-active");
                                        $(".ExtendedImage").children().attr('src',$(".prod-image-detail").first().children().attr("src"));
                                        $(".prod-image-detail").click(function(){
                                            const image_clicked = $(this).children().attr('src');
                                            const image_showing = $(".ExtendedImage").children();
                                            image_showing.attr("src",image_clicked);
                                            if($(".prod-image-detail").hasClass("img-active")){
                                                $(".prod-image-detail").removeClass("img-active");
                                                $(this).addClass("img-active");
                                            }
                                            else{
                                                $(this).addClass("img-active");
                                            }
                                        });
                                    });
                                </script>
                            </div>
                            <div class="container-product-details col-lg-4 col-sm-6 col-12">
                                <?php $row = mysqli_fetch_array($result);?>                                
                                <div>
                                    <h4 id="product-name"><?php echo $row[0];?></h4>
                                </div>
                                <div class="rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <script>
                                            var ratedStar = <?php echo $row[3];?>;
                                            $(document).ready(function(){
                                                for($i = 0; $i < ratedStar; $i++)
                                                {
                                                    $(".fa-star").eq($i).addClass("checked");
                                                }
                                            });
                                        </script>
                                        <span><?php echo $row[3];?> sao cho <?php echo $row[4]?> lượt đánh giá</span> 
                                </div>
                                <div>
                                    <span>Giới tính: <?php echo $row[1];?></span>
                                </div>
                                <div>
                                    <span>Tên dòng sản phẩm: <?php echo $row[5];?></span>
                                </div>
                                <div>
                                    <span>Màu sắc: <?php echo $row[6];?></span>
                                </div>
                                <div class="size-info-container">
                                    <?php
                                        $sql2 = "select id_sanpham,size,gia_sanpham,so_luong from san_pham where id_nhomsanpham=$idnsp";
                                        $result2 = $con->preparedSelect($sql2);
                                        if($result2!==null)
                                        {
                                            while($row2 = mysqli_fetch_array($result2)){
                                                ?><small style="display:block">Kích cỡ giày - size <?php echo $row2[1]?>: <?php echo $row2[3]?> sản phẩm tại cửa hàng</small><?php
                                            }
                                            mysqli_data_seek($result2,0);
                                            ?>
                                            <table class="price-info">
                                                <tr class="header-black">
                                                    <td>Kích cỡ</td>
                                                    <td>Giá</td>
                                                </tr>
                                                <?php while($row2 = mysqli_fetch_array($result2)){
                                                    ?><tr>
                                                        <td class="size-col"><?php echo $row2[1]?></td>
                                                        <td><?php    
                                                                echo number_format($row2[2],0,",",".")."<sup>đ</sup>";
                                                            ?></td>
                                                    </tr><?php
                                                }?>
                                            </table>
                                            <?php
                                            mysqli_data_seek($result2,0);
                                            ?></div>
                                            <form id="formId" method="GET">
                                                <input type="hidden" name="act" value="add"/>
                                                <div class="size-container">
                                                    <span style="display:block;">Chọn kích cỡ giày:</span>
                                                    <?php
                                                        while($row2 = mysqli_fetch_array($result2)){
                                                            ?><input id="size-<?php echo $row2[1]?>" type="checkbox" name="idsp" value="<?php echo $row2[0]?>">
                                                            <label class="size" for="size-<?php echo $row2[1]?>"><?php echo $row2[1]?></label>
                                                            <?php
                                                        }
                                                    ?>
                                                </div>
                                                <div class="amount-of-a-prod">
                                                    <span>Số lượng:</span>
                                                    <button id="plus" class="btn-dark">+</button>
                                                    <input id="amount" type="text" size="5px" name="qty" value="1"/>
                                                    <button id="substract" class="btn-dark">-</button>
                                                </div>
                                                <script>
                                                    $(document).ready(function(){
                                                        $("#plus").click(function(e){
                                                            e.preventDefault();
                                                            $("#amount").prop("value",+$("#amount").val()+1);
                                                        });
                                                        $("#substract").click(function(e){
                                                            e.preventDefault();
                                                            if($("#amount").val()>1){
                                                                $("#amount").prop("value",+$("#amount").val()-1);
                                                            }
                                                        }); 
                                                    });
                                                </script>
                                                <div class="btn-buyproduct">
                                                    <input id="buy" type="submit" class="btn btn-danger" value="Đặt mua">
                                                </div>
                                            </form>
                                            <?php
                                        }
                                        ?>
                                            <script>
                                                window.onbeforeunload = function() {
                                                //unchecked your check box here.  
                                                $("input[type='checkbox']").prop('checked', false)};
                                                $(document).ready(()=>{
                                                    $(".size").click(function(){
                                                        if($(".size").hasClass("size-checked")){
                                                            $(".size").removeClass("size-checked");
                                                            $('input[id^="size-"]').prop("checked",false);
                                                            $(this).addClass("size-checked");
                                                            $(this).prop("checked",true);
                                                        }
                                                        else{
                                                            $(this).addClass("size-checked");
                                                            $(this).prop("checked",true);
                                                        }
                                                    }); 
                                                });
                                            </script>
                                        <?php
                                    ?>
                            </div>
                            <div class="policy-box">
                                <span class="title title-2">Về chất lượng sản phẩm</span>
                                <p>HKP Store đảm bảo 100% hàng nhập khẩu từ quốc tế và trong nước được xác nhận bởi bộ công thương Việt Nam.</p>
                                <span class="title title-2">Về đổi trả sản phẩm</span>
                                <p>Sản phẩm trước khi đổi trả phải còn mới, hoặc đã thử nhưng không vừa size và phải còn nguyên vẹn sản phẩm, thời hạn đổi trả trong vòng 2 tới 3 ngày kể từ ngày giao hàng. 
                                    Ngoài trường hợp trên thì phải liên hệ đến shop để được tư vấn.</p>
                                <span class="title title-2">Về phần giao hàng</span>
                                <p>Hàng sẽ được giao theo khoảng cách từ shop đến khách hàng.</p>
                            </div>
                            <div class="prod-decription">
                                <span class="title title-1">Mô tả sản phẩm</span>
                                <span><?php echo $row[2]?></span>
                            </div>
                            <div class="comment-prod">
                                <span class="title title-1">Bình luận(<?php echo $row[4];?>)</span>
                                <div class="user-comment">
                                    <strong>Tôi là ai</strong>
                                </div>
                                <div class="rating-star">
                                    <i class="fa fa-star checked"></i>
                                    <i class="fa fa-star checked"></i>
                                    <i class="fa fa-star checked"></i>
                                    <i class="fa fa-star checked"></i>
                                    <i class="fa fa-star checked"></i>
                                </div>
                                <div class="content-comment">
                                    <span>I like the way i love it</span>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    else{
                        echo 'Không tìm thấy sản phẩm';
                    }
                }
                else{
                    echo 'Không tìm thấy sản phẩm';
                }
                ?>
            </div>
        <div class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title font-weight-bold">Giỏ hàng của bạn</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="cart-content">
                        <div class="content">
                            
                        </div>
                        <table>
                            <tr class="tbl-header">
                                    <th>Tên sản phẩm</th>
                                    <th>Hình sản phẩm</th>
                                    <th>Kích cỡ</th>
                                    <th>Giá sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                            </tr>
                            <tr class='product-item'>
                                <td class='product_name' id=''></td>
                                <td class='product_image'><img src=''/></td>
                                <td class='product_size' title='Kích cỡ'></td>
                                <td class='product_price' title='Giá sản phẩm'></td>
                                <td class='product_quantity' title='Số lượng'><input class='amount' value=''/></td>
                                <td class='product_subtotal' title='Thành tiền'></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                  <button onclick="location.href='cart.php';" type="button" class="btn btn-primary">Tiến đến giỏ hàng</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tiếp tục mua sắm</button>
                </div>
              </div>
            </div>
          </div>
            <script>
                $(document).ready(()=>{
                    $("#buy").click(function(e){
                        e.preventDefault();
                        if(!$('input[id^="size-"]').is(":checked"))
                        {
                            alert("Vui lòng chọn size");
                            return;
                        }
                        if(!Number.isInteger(Number($("#amount").val())))
                        {
                            alert("Số lượng phải là số nguyên");
                            return;
                        }
                        if($("#amount").val()<1)
                        {
                            alert("Sản phẩm muốn mua không được dưới 1");
                            return;
                        }
                        else{
                            if(<?php if(isset($_SESSION['id_nguoidung'])){echo 1;}else{echo 0;}?>){
                                $.ajax({
                                    type:"POST",
                                    url:'xulygiohang.php',
                                    data:$("#formId").serialize(),
                                    success:function(data)
                                    {
                                        var getdata = JSON.parse(data);
                                        if(getdata.msg!==""){
                                            alert(getdata.msg);
                                        }
                                        else{
                                            $(".modal").modal();
                                            $(".modal-body div.content").html("<p style='text-align:left;padding:10px 0 0 10px'>Bạn vừa thêm mới sản phẩm <strong>"+getdata.tennhom+" [Size: "+getdata.size+"]</strong> vào giỏ hàng</p>");
                                            $(".modal-body tr.product-item td.product_name").text(getdata.tennhom);
                                            $(".modal-body tr.product-item td.product_name").attr("id",getdata.idsp);
                                            $(".modal-body tr.product-item td.product_size").text(getdata.size);
                                            $(".modal-body tr.product-item td.product_price").html(getdata.giasp);
                                            $(".modal-body tr.product-item td.product_subtotal").html(getdata.thanhtien);
                                            $(".modal-body tr.product-item td.product_quantity input").attr("value",getdata.soluong);
                                            $(".modal-body tr.product-item td.product_image img").attr("src","../"+getdata.hinh);
                                            setTimeout(function(){$(".modal").modal('hide');}, 10000);
                                        }
                                    }
                                });
                            }
                            else{
                                post_to_url("./Login.php",{next:window.location.href});
                            }
                        }
                    });
                });
            </script>
            <script type='text/javascript' src='../static/js/cart.js'></script>
            <div class="footer">
                <?php include './footer1.php' ?>   
            </div>
        </div>
    </body>
</html>
