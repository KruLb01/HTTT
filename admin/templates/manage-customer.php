<div class="dashboard-manage-container">
    <div class="dashboard-manage-title-bar disable-copy">
        <span id='dm-title'>Manage Customers</span>
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
            <a id='dm-add-btn'><i class="fas fa-plus-circle"></i> Add Customer</a>
            <!--add popup-->
            <div class="dashboard-manage-pop-up-add">
                <div class="dashboard-manage-pop-up-add-items">
                    <i class='fas fa-times dm-pop-up-close-add-btn'></i>
                    <div class="dashboard-manage-pop-up-add-info">
                        <span>
                            Id Customer :
                            <input type="text" placeholder='Id Customer'>
                        </span>
                        <span>
                            Name Customer :
                            <input type="text" placeholder='Name Customer'>
                        </span>
                        <span>
                            Email Customer :
                            <input type="text" placeholder='Email Customer'>
                        </span>
                        <span>
                            Username Customer :
                            <input type="text" placeholder='Username Customer'>
                        </span>
                        <span>
                            Password Customer :
                            <input type="password" placeholder='Password Customer'>
                        </span>
                        <span>
                            Address Customer :
                            <input type="text" placeholder='Address Customer'>
                        </span>
                        <span>
                            Phone number Customer :
                            <input type="text" placeholder='Phone number Customer'>
                        </span>
                        <div class="dm-pop-up-add-btn disable-copy">
                            <span class="dm-pop-up-add-save-btn">Add new customer</span>
                        </div>
                    </div>
                    <div class="dashboard-manage-pop-up-add-act">
                        <span>Set permission : </span>
                        <div class="dashboard-manage-pop-up-add-act-checkbox">
                            <span class='dm-pop-up-cbox'><input type=radio name='status' value='true'> Active</span>
                            <span class='dm-pop-up-cbox'><input type=radio name='status' value='false'> Block</span>
                        </div>
                    </div>
                </div>
            </div>
            <!--end popup-->
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
                        <option value="id_nguoidung">Id</option>
                        <option value="ho_ten">Name</option>
                        <option value="dia_chi">Address</option>
                        <option value="so_dien_thoai">Phone</option>
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
                    $count = ceil(mysqli_fetch_array($conn->selectData('select count(*) as count from khach_hang,nguoi_dung where khach_hang.id_nguoidung=nguoi_dung.id_nguoidung'))['count']/10);
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

<script>
    $('.dashboard-manage-pop-up-add-info input').eq(0).keyup(function() {
        var value_id = $(this).val().trim();
        $.get('handle/validateAdd.php', {page:'customer',id:value_id}, function(res) {
            if (res.trim()=='Error') {
                $('.dm-pop-up-add-save-btn').eq(0).addClass('dm-disable');
                $('.dashboard-manage-pop-up-add-info input').eq(0).css('border','1px solid red');
            } else {
                $('.dm-pop-up-add-save-btn').eq(0).removeClass('dm-disable');
                $('.dashboard-manage-pop-up-add-info input').eq(0).css('border','1px solid #6485da');
            }
        })
    })
</script>