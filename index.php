<?php 
    session_start();
    include './templates/ConnectionDB.php';
    $con = new ConnectionDB('./data.properties.php'); 
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HKP | Trang chính</title>
    <script src="./static/js/jquery-3.6.0.min.js"></script>
    <LINK REL="SHORTCUT ICON" HREF="./static/images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="./static/css/index.css">
    <link rel="stylesheet" type="text/css" href="./static/css/all.css">
    <link rel="stylesheet" type="text/css" href="./plugin/bootstrap-4.5.3-dist/css/bootstrap.css">
    <?php global $items_per_page; 
          $items_per_page = 8;?>
    </head>
<body>
    <div class="wrap">
    <div class="header">
        <?php include './templates/header.php'?>
    </div>
    <div class="mid">
        <div class="my-carousel">
            <div class="slide-container">
                <div class="slides">
                    <div class="slide">
                        <img src="./static/images/others/slide1.jpg"/>
                    </div>
                    <div class="slide">
                        <img src="./static/images/others/slide2.jpg"/>
                    </div>
                    <div class="slide">
                        <img src="./static/images/others/slide4.jpg"/>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="./static/js/carousel.js"></script>
        <div class="list-prods-square">
            <h3>Tất cả sản phẩm</h3>
            <div class="list-container">
                <ul class="list-prods">
                </ul>
            </div>
        </div>
        <div class="my-pagination">
            <?php
                $sql = "select id_nhomsanpham from nhom_san_pham";
                if($items_per_page>0)
                {
                    $totalpage=0;
                    $totalsp = mysqli_num_rows($con->preparedSelect($sql));
                    if($totalsp%$items_per_page!==0 && $totalsp>$items_per_page)
                    {
                        $totalpage=$totalsp/$items_per_page+1;
                    }
                    else if($totalsp>$items_per_page){
                        $totalpage=$totalsp/$items_per_page;
                    }
                    for($i = 1;$i <= $totalpage; $i++)
                    {
                        ?><a class="page" href="javascript:void(0)"><?php echo $i?></a><?php
                    }
                }
            ?>
        </div>
    </div>
    <script type="text/javascript">
        var items_per_page = <?php echo $items_per_page;?>;
        $(document).ready(function(){
        function loadPage(page)
        {
            $.get({
                url:'./templates/phantrangindex.php',
                data:{page:page,items_per_page: items_per_page},
                success:function(data)
                {
                    $(".list-prods").html(data);
                }
            });
            }
            if($(".page").length>0)
            {
                $(".page").get(0).className+=" active";
            }
            loadPage(1);
            $(".page").click(function(e){
                e.preventDefault();
                $('html, body').animate({scrollTop: $(".list-prods-square").offset().top},500);
                if(!$(this).hasClass("active"))
                {
                    $(".page").removeClass("active");
                    $(this).addClass("active");
                }
                loadPage($(this).contents().text());
            });
        });
    </script>
    <div class="footer">
         <?php include './templates/footer.php' ?>   
    </div>
    </div>
</body>
</html>