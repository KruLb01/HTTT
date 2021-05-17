<div class="dashboard-manage-container">
    <div class="dashboard-manage-title-bar disable-copy">
        <span id='dm-title'>Track Invoice</span>
    </div>
    <div class="dashboard-manage-show-bar disable-copy">
        <div class="dashboard-manage-show-bar-showfnc">
            <span>Show 
                <select name="" id="dm-select-show">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                entries
            </span>
            <span id='dm-show-number'>( 10 - 20 of 100 results )</span>
        </div>
        <div class="dashboard-manage-show-bar-fnc">
            <!-- <a id='dm-add-btn'><i class="fas fa-plus-circle"></i> Add Import</a> -->
            <i class="fas fa-file-export"></i>
        </div>
    </div>
    <div class="dashboard-manage-line"></div>
    <div class="dashboard-manage-search-bar disable-copy">
        <div class="dashboard-manage-search-bar-fnc">
            <span><i class="fas fa-filter"></i></span>
            <div class="dashboard-manage-search-bar-filter filter-only">
                <span>
                    Status:
                    <select name="" id="">
                        <option value="-">-</option>
                        <option value="waiting">Waiting</option>
                        <option value="delivering">Delivering</option>
                        <option value="delivered">Delivered</option>
                    </select>
                </span>
            </div>
            <div class="dashboard-manage-search-bar-filter filter-only">
                <span>
                    Total: 
                    <select name="" id="">
                        <option value="-">-</option>
                        <option value="<1000000">< 1,000,000 VNĐ</option>
                        <option value=">1000000">> 1,000,000 VNĐ</option>
                        <option value=">5000000">> 5,000,000 VNĐ</option>
                        <option value=">10000000">> 10,000,000 VNĐ</option>
                    </select>
                </span>
            </div>
        </div>
        <div class="dashboard-manage-search-bar-fnc">
            <div class="dashboard-manage-search-bar-filter">
                <span>
                    <input type="text" placeholder='Search...'>as 
                    <select name="" id="" style='color:#8aa8f7'>
                        <option value="none">-</option>
                        <option value="id_hoadon">Id Invoice</option>
                        <option value="id_nguoidung">Id Customer</option>
                        <option value="id_nhanvienban">Id Seller</option>
                        <option value="ngay_mua">Date</option>
                    </select>
                </span>
            </div>
        </div>
    </div>
    <div class="dashboard-manage-line"></div>
    <div class="dashboard-manage-fromto">
        <span>From <input type="date"></span>
        <span>To <input type="date" value="<?php echo date("Y-m-d");?>"></span>
        <span>as <select name="" id="">
            <option value="ngay_mua">Date Bought</option>
            <option value="ngay_giao">Date Delivered</option>
        </select></span>
        <button id="fromto-btn">Filter</button>
    </div>
    <div class="dashboard-manage-line"></div>
    <div class="dashboard-manage-table">
        <table class="dashboard-manage-table-items">
            <!--Import-->
        </table>
        <div class="dashboard-manage-pop-up-container"></div>
        <div class="dashboard-manage-table-pagination disable-copy">
            <div class="dashboard-manage-table-pagination-items">
                <span id='dm-first-btn' class='dm-disable'><i class="fas fa-fast-backward"></i> First</span>
                <?php
                    $count = ceil(mysqli_fetch_array($conn->selectData('select count(*) as count from hoa_don'))['count']/10);
                    echo "<span class='dm-pagination-items dm-selected'>1</span>";
                    for ($i = 2; $i <= $count; $i ++) {
                        echo '<span class="dm-pagination-items">'.$i.'</span>';
                    }
                ?>
                <span id='dm-last-btn'>Last <i class="fas fa-fast-forward"></i></span>
            </div>
        </div>
    </div>
</div>

<div class="dashboard-manage-pop-up">
    <div class="dm-popup-details">

    </div>
</div>

<script>
    let just_click;
    let status;
    $(document).on("click", ".dashboard-manage-table-items tr", function(){
        just_click = $(this).find('td').eq(0).text().trim();
        status = $(this).find('td').eq(5).text().trim();
    })
    $(document).on("click" , ".dashboard-manage-table-action-items li" , function() {
        if ($(this).text().trim() == 'Details') {
            $('.dashboard-manage-pop-up').css('display','block');
            $.get('handle/hManage.php', {page:'Track Invoice',popUp:'true',clickPos:just_click, status:status}, function(res){
                $(".dm-popup-details").eq(0).html(res);
            })
        }
    })
    $(document).on("click", ".dm-pop-up-close-btn", function() {
        $('.dashboard-manage-pop-up').css('display','none');
    })
    $(window).click(function(e) {
        if (event.target == $('.dashboard-manage-pop-up')[0]) {
        $('.dashboard-manage-pop-up').css('display','none');
    }
    })
    $(document).on("click", ".dashboard-manage-pop-up #handle-btn", function(){
        var current_status = $(this).text().trim();
        $.get("handle/hManage.php", {page:"Track Invoice",update:'true',val:'text~'+$(this).text().trim()+`~${just_click}`}, function(res) {
            if (res.trim()==true) {
                if (current_status == "Delivery") {
                    $(".dashboard-manage-pop-up #handle-btn").text("Delivered");
                }
                if (current_status == "Delivered") $(".dm-d-right").find("#handle-btn").remove();

                alert("Updated status !");

                var num = $('#dm-select-show').val();
                $.get('handle/hManage.php',{page:"Track Invoice",num:num,pag:'1'},function(res) {
                    $('.dashboard-manage-table-items').html(res);
                });
            }
            else {
                alert("Failed");
            }
        })
    })
</script>

<!--Handle filter-->
<script>
    let condition = "";
    let filter_value = "";
    $(".filter-only").click(function() {
        condition = $(this).index() == 1 ? "Status" : "Total";
    })
    $(".filter-only select").change(function() {
        var pag = $('.dm-selected').text().trim();
        var num = $('#dm-select-show').val();

        filter_value = $(this).val().trim();
    
        $.get("handle/hManage.php", {page:"Track Invoice", filter:true, condition:condition, filter_value:filter_value, num:num, pag:pag}, function(res) {
            $('.dashboard-manage-table-items').html(res);

            if (filter_value=="-") {
                var count =  <?php echo $count?>;
                if (count!=1) {
                    $("#dm-last-btn").removeClass("dm-disable");
                    var show = `<?php  
                        echo "<span class='dm-pagination-items dm-selected'>1</span>";
                        for ($i = 2; $i <= $count; $i ++) {
                            echo '<span class="dm-pagination-items">'.$i.'</span>';
                        }
                    ?>`;
                    $('.dashboard-manage-table-pagination-items').find(".dm-pagination-items").remove();
                    $('#dm-first-btn').after(show);
                }
            } else {
                var show = "<span class='dm-pagination-items dm-selected'>1</span>";
                $('.dashboard-manage-table-pagination-items').find(".dm-pagination-items").remove();
                $('#dm-first-btn').after(show);
                $("#dm-last-btn").addClass("dm-disable");
            }
        })
    })
    $("#fromto-btn").click(function(){
        var ds = $(".dashboard-manage-fromto").find("input[type=date]").eq(0).val();
        var de = $(".dashboard-manage-fromto").find("input[type=date]").eq(1).val();
        var condition = $(".dashboard-manage-fromto").find("select").eq(0).val();
        var pag = $('.dm-selected').text().trim();
        var num = $('#dm-select-show').val();

        $.get("handle/hManage.php", {page:"Track Invoice", filter:true, condition:condition, filter_value:`${ds}~${de}`, num:num, pag:pag}, function(res){
            $('.dashboard-manage-table-items').html(res);
        })
    })
</script>