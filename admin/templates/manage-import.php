<div class="dashboard-manage-container">
    <div class="dashboard-manage-title-bar disable-copy">
        <span id='dm-title'>Manage Import</span>
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
            <div class="dashboard-manage-search-bar-filter">
                <span>
                    Id:
                    <select name="" id="">
                        <option value="all">All</option>
                    </select>
                </span>
            </div>
            <div class="dashboard-manage-search-bar-filter">
                <span>
                    Name: 
                    <select name="" id="">
                        <option value="">All</option>
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
                        <option value="id_phieunhap">Id Import</option>
                        <option value="id_nhanviennhap">Id Importer</option>
                        <option value="id_nhacungcap">Id Provider</option>
                        <option value="ngay_nhap">Date</option>
                    </select>
                </span>
            </div>
        </div>
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
                    $count = ceil(mysqli_fetch_array($conn->selectData('select count(*) as count from phieu_nhap'))['count']/10);
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
    $(document).on("click", ".dashboard-manage-table-items tr", function(){
        just_click = $(this).find('td').eq(0).text().trim();
    })
    $(document).on("click" , ".dashboard-manage-table-action-items li" , function() {
        if ($(this).text().trim() == 'Details') {
            $('.dashboard-manage-pop-up').css('display','block');
            $.get('handle/hManage.php', {page:'Manage Import',popUp:'true',clickPos:just_click}, function(res){
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
</script>