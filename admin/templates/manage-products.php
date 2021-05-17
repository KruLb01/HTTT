<div class="dashboard-manage-container">
    <div class="dashboard-manage-title-bar disable-copy">
        <span id='dm-title'>Manage Products</span>
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
            <a id='dm-add-btn'><i class="fas fa-plus-circle"></i> Add Product</a>

            <!--add popup-->
            <div class="dashboard-manage-pop-up-add">
                <div class="dashboard-manage-pop-up-add-items">
                    <i class='fas fa-times dm-pop-up-close-add-btn'></i>
                    <div class="dashboard-manage-pop-up-add-info">
                        <span>
                            Id Product :
                            <input type="text" placeholder='Id Product'>
                        </span>
                        <span>
                            Name Product :
                            <input type="text" placeholder='Name Product'>
                        </span>
                        <span>
                            Color Product :
                            <input type="text" placeholder='Color Product'>
                        </span>
                        <span>
                            Description Product :
                            <input type="text" placeholder='Description Product'>
                        </span>
                        <span>
                            Id gProduct :
                            <select name="" id="">
                                <?php
                                    $res = $conn->selectData("select * from dong_san_pham order by ten_dongsanpham");
                                    while ($line = mysqli_fetch_array($res)) {
                                        echo "<option value='".$line['id_dongsanpham']."'>".$line['ten_dongsanpham']."</option>";
                                    }
                                ?>
                            </select>
                        </span>
                        <div class="dm-pop-up-add-btn disable-copy">
                            <span class="dm-pop-up-add-save-btn">Add new product</span>
                        </div>
                    </div>
                    <div class="dashboard-manage-pop-up-add-act">
                        <span>Set gender : </span>
                        <div class="dashboard-manage-pop-up-add-act-checkbox">
                            <span class='dm-pop-up-cbox'><input type=radio name='status' value='true'> Male</span>
                            <span class='dm-pop-up-cbox'><input type=radio name='status' value='false'> Female</span>
                        </div>
                    </div>
                </div>
            </div>
            <!--end popup-->    

            <i class="fas fa-images" style='border-right: 1px solid rgb(153, 153, 153); line-height:26px'></i>
            <!--image popup-->
            <div class="dashboard-manage-pop-up-image">
                <div class="dashboard-manage-pop-up-image-items">
                    <i id="close-img" class='fas fa-times dm-pop-up-close-image-btn'></i>
                    <div class="dashboard-manage-pop-up-image-info">
                        <span>
                            <i class="fas fa-search"></i> Id Product :
                            <input type="text" placeholder='Id Product'  id='id-pro'>
                        </span>
                        <span>
                            <i class="fas fa-search"></i> Name Product :
                            <input type="text" placeholder='Name Product' id='name-pro'>
                        </span>
                        <div class="error" style='padding:8px'>Error: Non product was found</div>
                        <div class="dm-pop-up-image-btn disable-copy">
                            <span class="dm-pop-up-image-save-btn">Save</span>
                        </div>
                    </div>
                    <div class="dashboard-manage-pop-up-image-act">
                        <span id='current'>Set Pictures : </span>
                        <div class="dashboard-manage-pop-up-image-act-checkbox">

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
                        <option value="id_nhomsanpham">Id</option>
                        <option value="ten_nhomsanpham">Name</option>
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
                    $count = ceil(mysqli_fetch_array($conn->selectData('select count(*) as count from nhom_san_pham'))['count']/10);
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
        $.get('handle/validateAdd.php', {page:'product',id:value_id}, function(res) {
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

<script>
    let current, numCurrent;
    $('.fa-images').eq(0).click(function() {
        $('.dashboard-manage-pop-up-image').css('display','block');
    })
    $('#close-img').click(function() {
        $('.dashboard-manage-pop-up-image').css('display','none');
    })
    $(window).click(function(e) {
        if (e.target == $('.dashboard-manage-pop-up-image').eq(0)[0]) {
            $('.dashboard-manage-pop-up-image').eq(0).css('display','none');
        }
    })
    $('#id-pro').keyup(function() {
        var id_val = $(this).val();
        var name_val = $('#name-pro').val();
        $.get('handle/hAdd-img.php', {id:id_val,name:name_val}, function(res) {
            if (res.trim()=='error') {
                $('.error').eq(0).css('display','block');
            }
            else {
                $('.error').eq(0).css('display','none');
                $('.dashboard-manage-pop-up-image-act-checkbox').eq(0).html(res);

                // numCurrent = $('.dashboard-manage-pop-up-image-act-checkbox').find('.show-img').length;

                $.get('handle/hAdd-img.php', {id:id_val,name:name_val,getCurrent:true}, function(res) {
                    current = res.trim();
                    $('#current').html('Set pictures for : ' + current);
                })
            }
        })
    })
    $('#name-pro').keyup(function() {
        var id_val = $('#id-pro').val();
        var name_val = $(this).val();
        $.get('handle/hAdd-img.php', {id:id_val,name:name_val}, function(res) {
            if (res.trim()=='error') {
                $('.error').eq(0).css('display','block');
            }
            else {
                $('.error').eq(0).css('display','none');
                $('.dashboard-manage-pop-up-image-act-checkbox').eq(0).html(res);

                // numCurrent = $('.dashboard-manage-pop-up-image-act-checkbox').find('.show-img').length;

                $.get('handle/hAdd-img.php', {id:id_val,name:name_val,getCurrent:true}, function(res) {
                    current = res.trim();
                    $('#current').html('Set pictures for : ' + current);
                })
            }
        })
    })
    let count = 0;
    $(document).on("change", "#browse-img", function(event) {
        event.preventDefault();
        count ++;
        if ($(this).prop('files') && $(this).prop('files')[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
            $('#img-'+count).attr('src', e.target.result);
            }
            reader.readAsDataURL($(this).prop('files')[0]);
            $('#img-'+count).css('display','inline-block');
        }

        var file_data = $(this).prop('files')[0];
        var form_data = new FormData();                  
        form_data.append('file', file_data);
        form_data.append('current', current);
        console.log(file_data);
        $.ajax({
            url: 'handle/hAdd-img.php', 
            dataType: 'text',  
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,                         
            type: 'post',
            success: function(res){
                var id_val = $('#id-pro').val();
                var name_val = $('#name-pro').val();
                $.get('handle/hAdd-img.php', {id:id_val,name:name_val}, function(res2) {
                    $('.dashboard-manage-pop-up-image-act-checkbox').eq(0).html(res2);
                })
            }
        })
    })
    let pos_;
    $(document).on("click",".dashboard-manage-pop-up-image-act-checkbox .dm-image-show-img", function(event) {
        var current_img = $(this).index();
        pos_ = current_img;
        if (event.target == $('.del-img').eq(current_img)[0]) {
            if (confirm('Do you really want to delete this picture ?!')) {
                $.get('handle/hAdd-img.php', {nc:current,ic:current_img,delete:'true'}, function(res) {
                    if (res.trim()=='Success') {
                        alert('Deleted successfully');
                        var id_val = $('#id-pro').val();
                        var name_val = $('#name-pro').val();
                        $.get('handle/hAdd-img.php', {id:id_val,name:name_val}, function(res2) {
                            $('.dashboard-manage-pop-up-image-act-checkbox').eq(0).html(res2);
                        })
                    } else alert('Failed');
                })
            }
        }
    })
    $(document).on("change",".dashboard-manage-pop-up-image-act-checkbox .show-browse-img", function() {
        var file_data = $(this).prop('files')[0];
        var form_data = new FormData();                  
        form_data.append('file', file_data);
        form_data.append('update', 'true');
        form_data.append('current', current);
        form_data.append('pos', pos_);
        $.ajax({
            url: 'handle/hAdd-img.php', 
            dataType: 'text',  
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,                         
            type: 'post',
            success: function(res){
                var id_val = $('#id-pro').val();
                var name_val = $('#name-pro').val();
                $.get('handle/hAdd-img.php', {id:id_val,name:name_val}, function(res2) {
                    $('.dashboard-manage-pop-up-image-act-checkbox').eq(0).html(res2);
                })
            }
        })
    })
</script>