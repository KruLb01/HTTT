<?php 
    session_start();
    include 'ConnectionDB.php';
    $con = new ConnectionDB('');
?>
<html>
    <head>
        <title>HKP Store | Danh mục sản phẩm</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="../static/js/jquery-3.6.0.min.js"></script>
        <script src="../static/js/post_method.js"></script>
        <LINK REL="SHORTCUT ICON" HREF="../static/images/favicon.ico">
        <link rel="stylesheet" type="text/css" href="../static/css/index.css">
        <link rel="stylesheet" type="text/css" href="../static/css/danhmucsanpham.css">
        <link rel="stylesheet" type="text/css" href="../static/css/all.css">
        <link rel="stylesheet" type="text/css" href="../plugin/bootstrap-4.5.3-dist/css/bootstrap.css">
        <script src="../plugin/bootstrap-4.5.3-dist/js/bootstrap.min.js"></script>
        <style>
            .mid{
                flex-direction: row;
                margin:0;
                padding:10px;
                background:linear-gradient(to right,#42275a,#734b6d);
            }
            .prod-image{
                padding:15px;
            }
            .prod-item{
                font-size:13px;
            }
            .prod-name h4{
                font-size:15px;
            }
            .my-pagination{
                padding-bottom:10px;
            }
        </style>
        <?php global $items_per_page; 
          $items_per_page = 6;
        ?>
    </head>
    <body>
        <div class="wrap">
            <div class="header">
                <?php include './header1.php'; ?>
            </div>
            <div class="mid">
                <div class="sidebar shadow p-3 mb-5 bg-white rounded">
                    <?php include './menuleft_danhmucsanpham.php' ?>
                    <script>
                    $(document).ready(function(){
                        $(".productbrand-item").each(function(){
                            if($(this).children(".list-productline").length)
                            {
                               $(this).find("div.productbrand-name").append(" <i class='fa fa-caret-down'></i>");
                            }
                        });
                        $(".list-productbrand > .productbrand-item").click(function(){
                            $(this).find(".list-productline").toggleClass("active");
                            if($(this).find("div.productbrand-name").find("i").hasClass("fa fa-caret-down")){
                                $(this).find("div.productbrand-name").find("i").removeClass("fa fa-caret-down");
                                $(this).find("div.productbrand-name").find("i").addClass("fa fa-caret-up");
                            }
                            else{
                                $(this).find("div.productbrand-name").find("i").removeClass("fa fa-caret-up");
                                $(this).find("div.productbrand-name").find("i").addClass("fa fa-caret-down");
                            }
                        });
                    });
                    </script>
                </div>
                <div class="content shadow p-3 mb-5 bg-white rounded">
                    
                </div>
                <script>
                    function loadPageContent(page){
                        $(document).ready(function(){
                            var items_per_page = <?php echo $items_per_page;?>;
                            var thuonghieu = '<?php if(!isset($_GET['thuonghieu'])){echo '';}else{echo $_GET['thuonghieu'];}?>';
                            var ma_dongsp = '<?php if(!isset($_GET['ma_dongsp'])){echo '';}else{echo $_GET['ma_dongsp'];}?>';
                            var ten_sp = '<?php if(!isset($_GET['ten_sp'])){echo '';}else{echo $_GET['ten_sp'];}?>';
                            if(thuonghieu !== ""){
                                $("input[id="+thuonghieu+"]").prop("checked",true);
                            }
                            if(ma_dongsp !== ""){
                                $("input[id="+ma_dongsp+"]").prop("checked",true);
                            }
                            $("input[id='search_name']").val(ten_sp);
                            $.ajax({
                                url:"phantrangdanhmuc.php",
                                data:{ten_sp:ten_sp,thuonghieu:thuonghieu,ma_dongsp:ma_dongsp,items_per_page:items_per_page,page:page},
                                success:function(data)
                                {
                                    $("div.content").html(data);
                                    pageLoad(page);
                                }
                            });
                        });
                    }
                    loadPageContent(1);
                    function pageLoad(page)
                    {
                        $(".page").eq(page-1).addClass("active");
                        $(document).ready(function(){
                            $(".page").click(function(e){
                                e.preventDefault();
                                $('html, body').animate({scrollTop: $(".list-prods-square").offset().top},1000);
                                loadPageContent($(this).contents().text());
                            });
                        });
                    }
                </script>
            </div>
            <div class="footer">
                <?php include './footer1.php'; ?>
            </div>
        </div>
    </body>
</html>