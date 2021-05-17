<?php 
    session_start();
    include 'ConnectionDB.php';
    $con = new ConnectionDB('');
?>
<html>
    <head>
        <title>HKP Store | Hóa đơn</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="../static/js/jquery-3.6.0.min.js"></script>
        <script src="../static/js/post_method.js"></script>
        <LINK REL="SHORTCUT ICON" HREF="../static/images/favicon.ico">
        <link rel="stylesheet" type="text/css" href="../static/css/hoadon.css">
        <link rel="stylesheet" type="text/css" href="../static/css/index.css">
        <link rel="stylesheet" type="text/css" href="../static/css/all.css">
        <link rel="stylesheet" type="text/css" href="../plugin/bootstrap-4.5.3-dist/css/bootstrap.css">
        <script src="../plugin/bootstrap-4.5.3-dist/js/bootstrap.min.js"></script>
        <style>
            @media (min-width: 576px)
            {
                .modal-dialog{
                    max-width: 85%;
                }
            }
        </style>
    </head>
    <body>
        <script type="text/javascript">
            if(<?php if(isset($_SESSION['id_nguoidung'])){echo 1;}else{echo 0;}?>){
                //do nothing
            }
            else post_to_url("Login.php",{next:window.location.href});
        </script>
        <div class="wrap">
            <div class="header">
                <?php include '../templates/header1.php';?>
            </div>
            <?php
                $id_nguoidung = $_SESSION['id_nguoidung'];
                $sql = "select hoa_don.id_hoadon,ngay_mua,tong_gia-(tong_gia*giamgia/100),tinhtrang_giaohang from hoa_don,chitiet_giaohang,(select id_hoadon,IFNULL(giam_theo_percent,'0') as giamgia from hoa_don left join sale on hoa_don.id_sale = sale.id_sale) as c where hoa_don.id_hoadon= chitiet_giaohang.id_hoadon and c.id_hoadon = hoa_don.id_hoadon and hoa_don.id_nguoidung='$id_nguoidung'";
                $result = $con->preparedSelect($sql);
                $output ='';
                if(mysqli_num_rows($result)>0)
                {
                    while($row = mysqli_fetch_array($result))
                    {
                        $defaul_state_color = "text-danger";
                        switch($row[3])
                        {
                            case 1:
                            {
                                $state = "Đang xử lý";
                            }
                            break;
                            case 2:
                            {
                                $state = "Đang giao";
                                $defaul_state_color = "text-warning";
                            }
                            break;
                            case 3:
                            {
                                $state = "Đã giao hàng";
                                $defaul_state_color = "text-success";
                            }
                        }
                        $dateformat = date("d-m-Y",strtotime($row[1]));
                        $moneyformat = number_format($row[2],0,",",".")."<sup>đ</sup>";
                        $output .= "<div class='invoice-item'>
                                      <div id='$row[0]'>$row[0]</div>
                                      <div>$dateformat</div>
                                      <div>$moneyformat</div>
                                      <div class='$defaul_state_color'>$state</div>
                                      <div> 
                                            <input type='submit' class='btn btn-info' value='Xem chi tiết'/>
                                            <input type='submit' class='btn btn-danger' value='Xóa'/></div>
                                      </div>";
                    }
                }
                else{
                    $output .= '<div class="message-container">Không có hóa đơn nào gần đây</div>';
                }
            ?>
            <div class="mid">
                <div class="container-invoice-view shadow p-3 mb-5 bg-white rounded">
                    <div class="invoice-title-header">
                        <h4 style="">Hóa đơn của bạn</h4>
                    </div>
                    <div class="container-invoice-list">
                        <div class="header-container">
                            <div>Mã hóa đơn</div>
                            <div>Ngày mua</div>
                            <div>Tổng giá</div>
                            <div>Tình trạng</div>
                            <div>Thao tác</div>
                        </div>
                        <div class="invoice-list">
                            <?php echo $output; ?>
                        </div>
                    </div>
                </div>
                <div class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title font-weight-bold">Chi tiết hóa đơn</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-warning" data-dismiss="modal">Đóng</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="footer">
                <?php include '../templates/footer1.php';?>
            </div>
        </div>
        <script>
            $(document).ready(function(){
                $(".invoice-item input[type='submit']:first-child").click(function(e){
                    e.preventDefault();
                    var id_invoice = $(this).parent().parent().children().eq(0).attr("id");
                    if(id_invoice ==="undefined" || id_invoice ===""){
                        alert("Lỗi! Vui lòng reload lại trang");
                    }
                    else{
                        $.ajax({
                            type:"POST",
                            url:"xulyhoadon.php",
                            data:
                            {
                                act:"view_detail",
                                id_hoadon:id_invoice    
                            },
                            success:function(data)
                            {
                                var getData = JSON.parse(data);
                                console.log(getData);
                                if(getData.success)
                                {
                                    var output = "<div class='container-modal'>"+
                                                       "<h5>Các sản phẩm mà bạn đã mua</h5>"+
                                                    "<div class='container-product-list-modal'>"+
                                                        "<div class='header-container'>"+
                                                            "<div>Tên nhóm sản phẩm</div>"+
                                                            "<div>Hình ảnh</div>"+
                                                            "<div>Kích cỡ</div>"+
                                                            "<div>Số lượng</div>"+
                                                            "<div>Thành tiền</div>"+
                                                         "</div>";
                                    for(var key in getData.listsp){
                                        if(getData.listsp.hasOwnProperty(key))
                                        {
                                            output += "<div class='product-item'>"
                                            output += "<div class='product-name'>"+getData.listsp[key].ten_nhomsp+"</div>";
                                            output += "<div class='product-image'><img src='../"+getData.listsp[key].hinh+"'/></div>";
                                            output += "<div class='product-size'>"+getData.listsp[key].size+"</div>";
                                            output += "<div class='product-quantity'>"+getData.listsp[key].so_luong+"</div>";
                                            output += "<div class='product-subtotal'>"+getData.listsp[key].thanhtien+"</div>";
                                            output += "</div>";
                                        }
                                    }
                                    output+="</div>"+
                                                "<div class='container-modal-detail'>"+
                                                    "<div class='header-detail'>Thông tin chi tiết đơn hàng</div>"+
                                                    "<div>Phương thức giao hàng: "+getData.pt_giaohang+"</div>"+
                                                    "<div>Giá ban đầu: "+getData.total+"</div>"+
                                                    "<div>Có áp dụng chương trình khuyến mãi: "+getData.ten_sale+"</div>"+
                                                    "<div>Giảm giá(%): "+getData.giam_theo_percent+"</div>"+
                                                    "<div>Tổng tiền(vnd): "+getData.new_total+"</div>";
                                                "</div>";
                                    console.log(output);
                                    $(".modal").modal("show");
                                    $(".modal .modal-body").html(output);
                                }
                            }
                        });
                    }
                });
                $(".invoice-item input[type='submit']:nth-child(2)").click(function(e){
                    e.preventDefault();
                    var id_invoice = $(this).parent().parent().children().eq(0).attr("id");
                    if(id_invoice ==="undefined" || id_invoice ===""){
                        alert("Lỗi! Vui lòng reload lại trang");
                    }
                    else{
                        var container = $(this).parent().parent();
                        $.ajax({
                            type:"POST",
                            url:"xulyhoadon.php",
                            data:
                            {
                                act:"delete",
                                id_hoadon:id_invoice    
                            },
                            success:function(data)
                            {
                                var getData = JSON.parse(data);
                                alert(getData.msg);
                                if(getData.success==="1")
                                {
                                    container.remove();
                                    if($(".invoice-item").length===0)
                                    {
                                        $(".invoice-list").html("<div class='message-container'>Không có hóa đơn nào gần đây</div>")
                                    }
                                }   
                            }
                        });
                    }
                });
            });
        </script>
    </body>
</html>