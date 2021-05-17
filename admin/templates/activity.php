<?php
    $today = date("Y-m-d");
?>
<div class="activity disable-copy">
    <div class="activity-title">
        <span>Analyze activity</span>
    </div>
    <div class="activity-choose">
        <div class="ac-product">
            <input type="text" disabled><i class="fas fa-folder-open"></i>
            <span>From <input type="date"></span>
            <span>To <input type="date" value="<?php echo $today; ?>"></span>
            <button class="analyze-btn">Analyze</button>
        </div>
        <div class="ac-product">
            <input type="text" disabled><i class="fas fa-folder-open"></i>
            <span>From <input type="date"></span>
            <span>To <input type="date" value="<?php echo $today; ?>"></span>
            <button class="analyze-btn">Analyze</button>
        </div>
    </div>
    <div class="activity-compare">
        <span>From <input type="date"></span>
        <span>To <input type="date" value="<?php echo $today; ?>"></span>
        <button id='add-btn'>Add</button>
        <button id='compare-btn'>Compare</button>
        <button id='total-btn'>Total</button>
    </div>
    <div id="chart">
        <span></span>
        <div id="chart-container">
        </div>
    </div>
</div>

<!--Total/Default charts-->
<script>
    $(document).ready(function(){
        $("#chart").find("span").eq(0).html("Đang phân tích tổng thể tất cả sản phẩm");
        var day_start = $(".activity-compare").find("input[type=date]").eq(0).val().trim();
        var day_end = $(".activity-compare").find("input[type=date]").eq(1).val().trim();

        $.get("handle/hTotalChart.php", {ds:day_start,de:day_end,total:true}, function(res) {
            $("#chart-container").html(res);
        })
    })
    $("#total-btn").click(function() {
        $("#chart").find("span").eq(0).html("Đang phân tích tổng thể tất cả sản phẩm");
        var day_start = $(".activity-compare").find("input[type=date]").eq(0).val().trim();
        var day_end = $(".activity-compare").find("input[type=date]").eq(1).val().trim();

        if (day_start>day_end) return;

        $.get("handle/hTotalChart.php", {ds:day_start,de:day_end,total:true}, function(res) {
            $("#chart-container").html(res);
        })
    })
</script>

<div class="activity-popup disable-copy">
    <div class="ap-container">
        <div class="ap-search">
            <span>Search <input type="text" placeholder="Search.." disabled> as
                <select>
                    <option value="null">-</option>
                    <option value="all">All</option>
                    <option value="gProducts">G.Products</option>
                    <option value="products">Products</option>
                </select>
                <i class="fas fa-times"></i>
            </span>
        </div>
        <div class="ap-more">
            <button id="ap-add-btn"><i class="fas fa-plus"></i> Add</button>
            <button id="ap-search-btn"><i class="fas fa-search"></i> Search</button>
            <button id="ap-close-btn"><i class="fas fa-window-close"></i> Close</button>
        </div>
        <div class="ap-result">
            <table>
                <tr>
                    <th>Id</th>
                    <th>Type</th>
                    <th>Name</th>
                </tr>
            </table>
        </div>
    </div>
</div>

<!--Js normal-->
<script>
    var add_pattern = '<div class="ac-product"><input type="text" disabled><i class="fas fa-folder-open"></i><span style="padding: 0 3px;">From <input type="date"></span><span>To <input type="date" value="<?php echo $today; ?>"></span><button style="margin: 0 3px;" class="analyze-btn">Analyze</button></div>';
    let open_clicked;
    let type_product=[];
    let current;
    $('#add-btn').click(function() {
        $('.activity-choose').append(add_pattern);
    })
    $("#compare-btn").click(function() {
        so_luong = $(".activity-choose").find("input[type=text]").length;

        inputs = [];
        check = 0;
        for (i=0;i<so_luong;i++) {
            inputs[i] = $(".activity-choose").find("input[type=text]").eq(i).val().trim();
            if (inputs[i]!='') check++;
        }
        var day_start = $(".activity-compare").find("input[type=date]").eq(0).val().trim();
        var day_end = $(".activity-compare").find("input[type=date]").eq(1).val().trim();

        if (day_start>day_end || day_start=='' || day_end=='' || check < 2) return;

        $.get("handle/hChart.php", {inputs:inputs.join("~"),type:type_product.join("~"),ds:day_start,de:day_end}, function(res) {
            $("#chart-container").html(res);
            $("#chart").find("span").eq(0).html(`Đang so sánh số sản phẩm bán ra`);
        })
    })
    $(document).on("click", ".ac-product", function(e) {
        open_clicked = $(this);
        current = $(this).index();
        if (e.target==$(this).find(".fa-folder-open")[0]) {
            $(".activity-popup").css("display","block");
        }
        else if (e.target==$(this).find(".analyze-btn")[0]) {
            var id_analyze = $(this).find("input[type=text]").val().trim();
            var day_start = $(this).find("input[type=date]").eq(0).val().trim();
            var day_end = $(this).find("input[type=date]").eq(1).val().trim();

            if (day_start>day_end || id_analyze=='') return;

            $.get("handle/hChart.php", {id:id_analyze,type:type_product[current],ds:day_start,de:day_end}, function(res) {
                $("#chart-container").html(res);
                $("#chart").find("span").eq(0).html(`Đang phân tích ${type_product[current]} ${id_analyze}`);
            })
        }
    })

    $(".activity-choose").click(function(){

    })
</script>

<!--Js popup-->
<script>
    $("#ap-add-btn").click(function() {
        var add_pattern = '<span>Search <input type="text" placeholder="Search.." disabled> as<select style="margin: 0 11px;">    <option value="null">-</option>    <option value="all">All</option>    <option value="gProducts">G.Products</option>    <option value="products">Products</option></select><i class="fas fa-times"></i></span>';
        $(".ap-search").append(add_pattern);
    })
    $("#ap-close-btn").click(function(){
        $('.activity-popup').eq(0).css('display','none');
    })
    $(window).click(function(event) {
        if (event.target == $('.activity-popup').eq(0)[0]) {
            $('.activity-popup').eq(0).css('display','none');
        }
    })

    // disable input if select all
    let pos_changed;
    let pos_clicked;
    $(document).on("change", ".ap-search select", function() {
        if ($(this).val()=="all"||$(this).val()=='null') pos_changed.prop("disabled", true);
        else pos_changed.prop("disabled", false);
    })
    $(document).on("click", ".ap-search .fa-times", function() {
        try {
            pos_clicked.remove();
        } catch (error) {
            // do nothing
        }
    })
    $(document).on("click", ".ap-search span", function() {
        pos_changed = $(this).find("input");
        pos_clicked = $(this);
    })
    
    // multi search
    $("#ap-search-btn").click(function() {
        var data = "";

        var inp = $(".ap-search").find("span");
        var qtt_inp = inp.length;
        
        for (i=0;i<qtt_inp;i++) {
            var val = inp.eq(i).find("input").val().trim();
            var select = inp.eq(i).find("select").val().trim();

            if (select=="all") {
                data = "all";
                break;
            } else if (select=="null") {
                continue;
            }

            data += `${select}:${val}`;

            if (i!=(qtt_inp-1)) data+="~";
        }
        
        $.ajax({
            method:"get",
            url:"handle/hActivity.php",
            data:"data="+data,
            success:function(res){
                $(".ap-result table").html(res);
            }
        })
    })

    $(document).on("dblclick", ".ap-result table tr", function(){
        var val = $(this).find("td").eq(0).text().trim();
        type_product[current] = $(this).find("td").eq(1).text().trim();
        open_clicked.find("input[type=text]").val(val);
        $(".activity-popup").css("display","none");
    })
</script>