<div class="import-product-container">
    <div class="import-product">
        <div class="importer">
            <span>Id Employee: <input type="text" disabled value='<?php echo $_SESSION['user']['id'] ?>'></span>
            <span>Id Provider: <input type="text" disabled value=''><i class="fas fa-folder-open"></i></span>
        </div>
        <div class="import-product-content">
            <div class="ip-content-item">
                <span>Id Product: <i class="fas fa-folder-open"></i><input type="text" disabled></span>
                <span>Name Product: <input type="text" disabled></span>
                <span>Size: <input type="text" disabled></span>
                <span>Quantity: <input type="number" class='quantity'></span>
                <span>Cost: <input type="number" class='cost'></span>
                <span>Total: <input type="text" class='total' disabled></span>
            </div>
        </div>
        <div class="import-total">
            <i class="fas fa-plus-square disable-copy"> Add more</i>
            <span id='total-import'>Total: 0 VNĐ</span>
        </div>
        <div class="ip-pop-up-container">
            <div class="ip-pop-up">
                <div class="ip-pop-up-search">
                    <span><i class="fas fa-search"></i> Search: <input id='val-search' type="text" placeholder='Search here...'></span>
                    <select id="search">
                    </select>
                    <button id='search-btn'>Search</button>
                    <i class="fas fa-times" style='font-size:20px' id='close-btn'></i>
                </div>
                <div class="ip-pop-up-result">
                    <table id='ip-result'>

                    </table>
                </div>
            </div>
        </div>
        <div class="import-ip-area">
            <i class="fas fa-upload"> Import Products</i>
        </div>
    </div>
    <div class="import-view">
        <div class="ip-view-title disable-copy">
            <span>History</span>
        </div>
        <div class="ip-view-content">
            <table id='ip-history'>
                <tr>
                    <th>Id of Notes</th>
                    <th>Name Provider</th>
                    <th>Quantity</th>
                    <th>Time</th>
                    <th>Total</th>
                </tr>
                <?php
                    if (isset($_SESSION['import'])) {
                        for ($i=0; $i<count($_SESSION['import']['products']); $i++) {
                            echo "
                                <tr>
                                    <td>".$_SESSION['import']['products'][$i][0]."</td>
                                    <td>".$_SESSION['import']['products'][$i][1]."</td>
                                    <td>".$_SESSION['import']['products'][$i][2]."</td>
                                    <td>".$_SESSION['import']['products'][$i][3]."</td>
                                    <td>".$_SESSION['import']['products'][$i][4]." VNĐ</td>
                                </tr>
                            ";
                        }
                    }
                ?>
            </table>
        </div>
    </div>
</div>

<script>
    let total_import = 0;
    let id_provider;
    let open_pos;
    $('.fa-plus-square').click(function(){
        var add = '<div class="ip-content-item"><span>Id Product: <i class="fas fa-folder-open"></i><input type="text" disabled></span><span>Name Product: <input type="text" disabled></span><span>Size: <input type="text" disabled></span><span>Quantity: <input type="number" class="quantity"></span><span>Cost: <input type="number" class="cost"></span><span>Total: <input type="text" class="total" disabled></span></div>';
        $('.import-product-content').append(add);
    })
    $('.fa-upload').click(function() {
        var provider = $('.importer').find('input').eq(1).val().trim();
        if (provider == '') {
            alert('Please fill input !');
            return;
        }
        num_total = $('.import-product-content').find('.total').length;
        for (i=0;i<num_total;i++) {
            var val_total = $('.import-product-content').find('.total').eq(i).val().trim();
            if (val_total=='' || val_total=='0 VNĐ') {
                alert('Please fill input !');
                return;
            }
        }

        // form_data = new FormData();
        // form_data.append('provider',provider);

        var arr_imp = [];
        for (i=0;i<$('.ip-content-item').length;i++) {
            var temp = $('.ip-content-item').eq(i).find('input');
            arr_imp.push({
                'id':temp.eq(0).val().trim(),
                'quantity':temp.eq(3).val().trim(),
                'cost':temp.eq(4).val().trim()
            });
        }
        // form_data.append('product',arr_imp);

        $.ajax({
            url:'handle/hImport-product.php',
            type:'post',
            data:'product='+JSON.stringify(arr_imp)+'&provider='+provider+'&total='+total_import,
            success:function(res) {
                if (res.trim()=='failed') {
                    alert('Import failed !');
                } else {
                    alert('Import successfully !');
                    $('#ip-history').append(res);

                    var add = '<div class="ip-content-item"><span>Id Product: <i class="fas fa-folder-open"></i><input type="text" disabled></span><span>Name Product: <input type="text" disabled></span><span>Size: <input type="text" disabled></span><span>Quantity: <input type="number" class="quantity"></span><span>Cost: <input type="number" class="cost"></span><span>Total: <input type="text" class="total" disabled></span></div>';
                    $('.import-product-content').html(add);
                }
            }
        })
    })
    $(document).on("keyup",".ip-content-item", function(e) {
        var quantity = $(this).find('.quantity').val();
        var cost = $(this).find('.cost').val();
        if (cost=='') cost = 0;
        if (quantity=='') quantity = 0;

        var total = cost*quantity;
        $(this).find('.total').val(total.toLocaleString()+' VNĐ');
    })
    $('.importer').click(function(e) {
        open_pos = '';
        if (e.target.className.split(' ')[1]=='fa-folder-open') {
            $('.ip-pop-up-container').css('display','block');
            $('#search').html('<option value="id_nhacungcap">as Id</option><option value="ten_nhacungcap">as Name</option><option value="diachi_nhacungcap">as Address</option>');
            $('#ip-result').html('<tr><th>Id</th><th>Name</th><th>Address</th></tr>')
        }
    }) 
    $('.import-product-content').click(function(e) {
        if (e.target.className.split(' ')[1]=='fa-folder-open') {
            $('.ip-pop-up-container').css('display','block');
            $('#search').html('<option value="san_pham.id_nhomsanpham">as Id Group Product</option><option value="san_pham.id_sanpham">as Id Product</option><option value="nhom_san_pham.ten_nhomsanpham">as Name Group Product</option>');
            $('#ip-result').html('<tr><th>Id Group Product</th><th>Id Product</th><th>Name Group Product</th><th>Size Product</th></tr>')
        }
    })
    $(document).on("click",".import-product-content .ip-content-item", function(){
        open_pos = $(this);
    })
    $(document).on("keyup",".import-product-content", function() {
        num_total =  $(this).find('.total').length;
        arr_total = [];
        for (i=0;i<num_total;i++) {
            temp = $(this).find('.total').eq(i).val().split(' ')[0].split(',').join('');
            if (temp=='') temp = 0;
            arr_total.push(parseInt(temp));
        }
        total_import = arr_total.reduce((a,b)=>a+b);
        $('#total-import').html('Total: '+total_import.toLocaleString()+' VNĐ');
    })
    $(document).on("click", "#search-btn", function() {
        var search_val = $('#val-search').val();
        var search_type = $('#search').val();

        if (search_val == '') {
            alert('Please fill input');
            return;
        } else {
            $.get('handle/hImport-product.php', {search:search_val,type:search_type}, function(res) {
                if (res.trim()=='error') {
                    $('#ip-result').html('<div class="error" style="display:block;font-size:20px">Unvalid input !</div>');
                } else {
                    $('#ip-result').html(res);
                }
            })
        }
    })
    $(document).on("dblclick",".ip-pop-up-container tr", function(){
        id_provider = $(this).find("td").eq(0).text();
        if (open_pos != '') {
            name_product = $(this).find("td").eq(2).text();
            size_product = $(this).find("td").eq(3).text();

            open_pos.find('input').eq(0).val(id_provider);
            open_pos.find('input').eq(1).val(name_product);
            open_pos.find('input').eq(2).val(size_product);
            
            $('.ip-pop-up-container').css('display','none');
            return;
        }
        $('.ip-pop-up-container').css('display','none');
        $('.importer').find('input').eq(1).val(id_provider);

    })
    $('#close-btn').click(function() {
        $('.ip-pop-up-container').css('display','none');
    })
    $(window).click(function(e){
        if (e.target==$('.ip-pop-up-container')[0]) {
            $('.ip-pop-up-container').css('display','none');
        }
    })
</script>