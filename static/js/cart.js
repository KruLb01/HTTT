function countUp(e)
{
    var qty = Number(e.parentElement.children[1].value);
    qty = qty+1;
    var idsp=e.parentElement.parentElement.children[0].id;
    $.ajax({
        type:"POST",
        url:"xulygiohang.php",
        data:{
            act:"update",
            idsp:idsp,
            qty:qty
        },
        success:function(data)
        {
            var getData = JSON.parse(data);
            if(getData.msg===""){
                e.parentNode.children[1].setAttribute("value",getData.qty);
                $(".cart-content > .cart-total span").html(getData.total);
                e.parentNode.parentNode.children[5].innerHTML=getData.subtotal;
            }
            else{
                alert(getData.msg);
            }
        }
    });
}
function countDown(e)
{
    var qty = Number(e.parentElement.children[1].value);
    var idsp=e.parentElement.parentElement.children[0].id;
    if(qty===1){
        if(confirm("Khi số lượng là 1, việc giảm số lượng sẽ làm xóa sản phẩm. Bạn có đồng ý để tiếp tục?")){
            $.ajax({
                type:"POST",
                url:"xulygiohang.php",
                data:{
                    act:"remove",
                    idsp:idsp
                },
                success:function(data)
                {
                    var getData = JSON.parse(data);
                    if(getData.msg===""){
                        e.parentNode.parentNode.remove();
                         $(".cart-content > .cart-total span").html(getData.total);
                    }
                    else{
                        alert(getData.msg);
                    }
                }
            });
        }
    }
    else
    {
        qty = qty-1;
        $.ajax({
            type:"POST",
            url:"xulygiohang.php",
            data:{
                act:"update",
                idsp:idsp,
                qty:qty
            },
            success:function(data)
            {
                var getData = JSON.parse(data);
                if(getData.msg===""){
                    e.parentNode.children[1].setAttribute("value",getData.qty);
                    $(".cart-content > .cart-total span").html(getData.total);
                    e.parentNode.parentNode.children[5].innerHTML=getData.subtotal;
                }
                else{
                    alert(getData.msg);
                }
            }
        });
    }
}
function remove(e)
{
    if(confirm("Bạn có chắc muốn xóa sản phẩm này chứ?")){
        var idsp = e.parentElement.parentElement.children[0].id;
        $.ajax({
            type:"POST",
            url:"xulygiohang.php",
            data:{
                act:"remove",
                idsp:idsp
            },
            success:function(data)
            {
                var getData = JSON.parse(data)
                if(getData.msg===""){
                    e.parentNode.parentNode.remove();
                    $(".cart-content > .cart-total span").html(getData.total);
                }
                else{
                    alert(getData.msg);
                }
            }
        });
    }
}
function goPurchase()
{
    if($("tr.product-item").length<1)
    {
        alert("Giỏ hàng hiện tại đang trống");
    }
    else{
        location.href="thanhtoan.php";
    }
}

