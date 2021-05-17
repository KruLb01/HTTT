<div class="dashboard-manage-container">
    <div class="dashboard-manage-title-bar disable-copy">
        <span id='dm-title'>Manage cProducts</span>
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

            <!-- add popup -->
            <div class="dashboard-manage-pop-up-add">
                <div class="dashboard-manage-pop-up-add-items">
                    <i class='fas fa-times dm-pop-up-close-add-btn'></i>
                    <div class="dashboard-manage-pop-up-add-info" style="border:none;width:100%">
                        <span>
                            Id cProduct :
                            <input type="text" placeholder='Id Product'>
                        </span>
                        <span>
                            Name Product :
                            <input type="text" placeholder='Name Product'>
                        </span>
                        <span>
                            Size Product :
                            <input type="text" placeholder='Size Product'>
                        </span>
                        <span>
                            Quantity cProduct :
                            <input type="text" placeholder='Quantity Product'>
                        </span>
                        <span>
                            Price cProduct :
                            <input type="text" placeholder='Price Product'>
                        </span>
                        <div class="dm-pop-up-add-btn disable-copy">
                            <span class="dm-pop-up-add-save-btn">Add new product</span>
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
                        <option value="ten_nhomsanpham">Name Product</option>
                        <option value="size">Size</option>
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
                    $count = ceil(mysqli_fetch_array($conn->selectData('select count(*) as count from san_pham'))['count']/10);
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
        just_click = $(this).find('td').eq(0).text().trim()+"&"+$(this).find('td').eq(1).text().trim();
    })
    $(document).on("click" , ".dashboard-manage-table-action-items li" , function() {
        if ($(this).text().trim() == 'Details') {
            $('.dashboard-manage-pop-up').css('display','block');
            $.get('handle/hManage.php', {page:'Manage cProducts',popUp:'true',clickPos:just_click}, function(res){
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

    $(document).on("click", ".dm-popup-details", function(e) {
        if (e.target==$(this).find('.save-btn').eq(0)[0]) {
            var val1 = $(this).find('td').eq(0).text().trim();
            var val2 = $(this).find('td').eq(1).text().trim();
            var val3 = $(this).find('input').eq(0).val().trim();
            var val4 = $(this).find('input').eq(1).val().trim();
        
            if (val3 == '' || val4 == '') {
                alert("Please fill input");
                return;
            }

            if (confirm("Really update this product ?!")==false) return;
            
            // Convert 
            val4 = val4.replace(/[VNĐ]|,/g,'').trim();

            $.get("handle/hManage.php", {page:"Manage cProducts",update:'true',val:'text~'+val1+'~'+val2+'~'+val3+'~'+val4}, function(res) {
                if (res.trim()==true) {
                    alert("Updated successfully !");

                    var num = $('#dm-select-show').val();
                    $.get('handle/hManage.php',{page:"Manage cProducts",num:num,pag:'1'},function(res) {
                        $('.dashboard-manage-table-items').html(res);
                    });
                }
                else {
                    alert("Failed");
                }
            })
        }
    })
    $(document).on("keyup", ".dm-popup-details input", function(e) {
        if (e.target == $(".dm-popup-details").find('input').eq(0)[0]) {
            var current = $(this).val();
            if (!isNumeric(current)) {
                $(".dm-popup-details").find('input').eq(0).css('border-bottom','1px solid red');
                $(".dm-popup-details").find('.save-btn').eq(0).addClass('dm-disable-btn');
            } else {
                $(".dm-popup-details").find('input').eq(0).css('border-bottom','1px solid coral');
                $(".dm-popup-details").find('.save-btn').eq(0).removeClass('dm-disable-btn');
            }
        } else if (e.target == $(".dm-popup-details").find('input').eq(1)[0]) {
            var current = $(this).val().replace(/[VNĐ]|,/g,'').trim(); 
            if (!isNumeric(current)) {
                $(".dm-popup-details").find('input').eq(1).css('border-bottom','1px solid red');
                $(".dm-popup-details").find('.save-btn').eq(0).addClass('dm-disable-btn');
            } else {
                $(".dm-popup-details").find('input').eq(1).css('border-bottom','1px solid coral');
                $(".dm-popup-details").find('.save-btn').eq(0).removeClass('dm-disable-btn');
            }
        }
    })
    function isNumeric(value) {
        return /^\d+$/.test(value);
    }

    // Check before add
    var general = $('.dashboard-manage-pop-up-add-info input');
    let flagc = {
        0:false,
        1:false,
        2:false,
        3:false,
        4:false,
    };
    // $('.dashboard-manage-pop-up-add-info input').eq(0).keyup(function(){
    //     var id = general.eq(0).val().trim();
    //     $.get("handle/validateAdd.php", {page:'cproducts',id:id}, function(res) {
    //         if (res.trim()=='Error')  {
    //             setDisable(0);
    //         } else {
    //             setEnable(0);
    //         }
    //     })  
    // })
    $('.dashboard-manage-pop-up-add-info input').keyup(function(e) {
        var id = general.eq(0).val().trim();
        var name = general.eq(1).val().trim();
        var size = general.eq(2).val().trim();
        var quantity = general.eq(3).val().trim();
        var price = general.eq(4).val().replace(/[VNĐ]|,/g,'').trim();

        // Check
        if (e.target==general.eq(0)[0]) {
            $.get("handle/validateAdd.php", {page:'cproducts',id:id}, function(res) {
                if (res.trim()=='Error')  {
                    setDisable(0);
                    flagc[0] = false;
                } else {
                    setEnable(0);
                    flagc[0] = true;
                }
            })  
        }

        if (e.target==general.eq(1)[0]) {
            $.get("handle/validateAdd.php", {page:'cproducts1',id:name}, function(res) {
                if (res.trim()=='Continue')  {
                    setDisable(1);
                    flagc[1] = false;
                } else {
                    setEnable(1);
                    flagc[1] = true;
                }
            })  
        }

        if (e.target==general.eq(2)[0]) {
            if (!isNumeric(size)) {
                setDisable(2);
                flagc[2] = false;
            } else {
                setEnable(2);
                flagc[2] = true;
            }
        }

        if (e.target==general.eq(3)[0]) {
            if (!isNumeric(quantity)) {
                setDisable(3);
                flagc[3] = false;
            } else {
                setEnable(3);
                flagc[3] = true;
            }
        }

        if (e.target==general.eq(4)[0]) {
            if (!isNumeric(price)) {
                setDisable(4);
                flagc[4] = false;
            } else {
                setEnable(4);
                flagc[4] = true;
            }
        }
    })

    $('.dm-pop-up-add-save-btn').click(function(){
        var id = general.eq(0).val().trim();
        var name = general.eq(1).val().trim();
        var size = general.eq(2).val().trim();
        var quantity = general.eq(3).val().trim();
        var price = general.eq(4).val().replace(/[VNĐ]|,/g,'').trim();

        if (id!=''&&name!=''&&size!=''&&quantity!=''&&price!='') {
            for (var i = 0; i < 5; i++) {
                if (flagc[i]==false) {
                    alert("Unvalid input");
                    return;
                }
            }
        } else return;

        $.get('handle/hManage.php', {page:'Manage cProducts',add:'true',valText:id+'~'+name+'~'+size+'~'+quantity+'~'+price}, function(res) {
            if (res.trim() == true) {
                alert('Add new cproducts successfully !');
                var num = $('#dm-select-show').val();
                var pag = $('.dm-selected').text().trim();
    
                $.get('handle/hManage.php',{page:'Manage cProducts',num:num,pag:pag},function(res) {
                    $('.dashboard-manage-table-items').html(res);
                })

                $.get('handle/hManage.php',{page:'Manage cProducts',num:num,pag:pag,numPag:'true',textShow:'true'},function(res) {
                    $('#dm-show-number').html(res);
                })

                resetField();
            } else alert('Failed');
        })
    })

    function resetField() {
        general.eq(0).val("");
        general.eq(1).val("");
        general.eq(2).val("");
        general.eq(3).val("");
        general.eq(4).val("");
    }

    function setDisable(pos) {
        general.eq(pos).css('border','1px solid red');
        // $('.dm-pop-up-add-save-btn').addClass('dm-disable');
    }
    function setEnable(pos) {
        general.eq(pos).css('border','1px solid rgb(177, 177, 177)');
        // $('.dm-pop-up-add-save-btn').removeClass('dm-disable');
    }
</script>