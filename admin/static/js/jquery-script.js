let currentPUDefault = 1;
let currentPADefault = 1;
let currentPSDefault = 1;
let currentPPDefault = 1;

$(".logout-btn").click(function() {
    $.get('./templates/controller.php', {action:"logout"} , function(res) {
        if (res==true) {
            window.location = './templates/login.php';
        }
    })
})

$("#top-menu-btn").click(function() {
    location.href = "./index.php";
})
$(".view-info-btn").click(function() {
    location.href = "?action=view-info-user";
})
$(".change-password-btn").click(function() {
    location.href = "?action=change-password";
})
$(".dashboard-content-box").click(function() {
    var indx = $(this).index();
    var link = "";
    if (indx == 0) link = "#customers";
    if (indx == 1) link = "#users";
    if (indx == 2) link = "#sales";
    if (indx == 3) link = "#products";
    location.href = link;
})
// Dafault page
$('.dashboard-menu-items li').click(function(){
    action = $(this).text().trim();
    if (action == 'Manage Permission') {
        location.href = '?action=manage-permission';
    }

    if (action == 'Manage Products') {
        location.href = '?action=manage-products';
    }

    if (action == 'Manage Employees') {
        location.href = '?action=manage-employee';
    }

    if (action == 'Manage Customers') {
        location.href = '?action=manage-customers';
    }

    if (action == 'Import Products') {
        location.href = '?action=import-products';
    }

    if (action == 'Manage Import') {
        location.href = '?action=manage-import';
    }

    if (action == 'Track Invoice') {
        location.href = '?action=track-invoice';
    }

    if (action == 'Manage cProducts') {
        location.href = '?action=manage-cproduct';
    }

    if (action == 'Activity') {
        location.href = '?action=activity';
    }

    if (action == 'Manage Providers') {
        location.href = '?action=manage-providers';
    }

    if (action == 'Manage gProducts') {
        location.href = '?action=manage-gproduct';
    }

    if (action == 'Mail') {
        location.href = '?action=mail';
    }

    if (action == 'Help') {
        location.href = '?action=help';
    }

    if (action == 'Track Sales') {
        location.href = '?action=track-sales';
    }
})



// Customers
$('.default-users-pagination').first().click(function() {
    if ($('.default-users-pagination').length!=1) {
        $('#previous-btn-users').addClass('disable');
        $('#next-btn-users').removeClass('disable');
    }
})
$('.default-users-pagination').last().click(function() {
    if ($('.default-users-pagination').length!=1) {
        $('#next-btn-users').addClass('disable');
        $('#previous-btn-users').removeClass('disable');
    }
})

$('#previous-btn-users').click(function() {
    currentPUDefault -= 1;
    $('#next-btn-users').removeClass('disable');
    setSelectedP(currentPUDefault-1);
    $.get('handle/hDefault-content.php', {cid:currentPUDefault}, function(data) {
        $('.dashboard-content-table-item').eq(0).html(data);
        if (currentPUDefault == 1) {
            $('#previous-btn-users').addClass('disable');
        }
    })
})
$('#next-btn-users').ready(function() {             
    if($('.default-users-pagination').length==1) {
        $('#next-btn-users').addClass('disable');
    }
})
$('#next-btn-users').click(function() {
    currentPUDefault = parseInt(currentPUDefault) + 1;
    $('#previous-btn-users').removeClass('disable');
    setSelectedP(currentPUDefault-1);
    $.get('handle/hDefault-content.php', {cid:currentPUDefault}, function(data) {
        $('.dashboard-content-table-item').eq(0).html(data);
        if (currentPUDefault == $('.default-users-pagination').length) {
            $('#next-btn-users').addClass('disable');
        }
    })
})

$('.default-users-pagination').click(function() {
    currentPUDefault = $(this).text();
    $('.default-users-pagination').removeClass('dashboard-content-table-pagination-btn-selected');
    $(this).addClass('dashboard-content-table-pagination-btn-selected');
    if($(this)[0] != $('.default-users-pagination').first()[0] && $(this)[0] != $('.default-users-pagination').last()[0]){
        $('#previous-btn-users').removeClass('disable');
        $('#next-btn-users').removeClass('disable');
    }
    $.get('handle/hDefault-content.php', {cid:$(this).text()}, function(data) {
        $('.dashboard-content-table-item').eq(0).html(data);
    })
})

$('.dashboard-content-table-item').eq(0).ready(function() {
    $.get('handle/hDefault-content.php', {cid:'1'}, function(res) {
        if (res==false) {
            $('.no-things-available').eq(0).html("<span>No customers is available !</span>");
            $('.dashboard-content-table-pagination').eq(0).html('');
        } else {
            $('.dashboard-content-table-item').eq(0).html(res);
        }
    })
})

function setSelectedP(current) {
    $('.default-users-pagination').removeClass('dashboard-content-table-pagination-btn-selected');
    $('.default-users-pagination').eq(current).addClass('dashboard-content-table-pagination-btn-selected');
}

// Users-managers
$('.default-admin-pagination').first().click(function() {
    if ($('.default-admin-pagination').length!=1) {
        $('#previous-btn-admin').addClass('disable');
        $('#next-btn-admin').removeClass('disable');
    }
})
$('.default-admin-pagination').last().click(function() {
    if ($('.default-admin-pagination').length!=1) {
        $('#next-btn-admin').addClass('disable');
        $('#previous-btn-admin').removeClass('disable');
    }
})

$('#previous-btn-admin').click(function() {
    currentPADefault -= 1;
    $('#next-btn-admin').removeClass('disable');
    setSelectedA(currentPADefault-1);
    $.get('handle/hDefault-content.php', {uid:currentPADefault}, function(data) {
        $('.dashboard-content-table-item').eq(1).html(data);
        if (currentPADefault == 1) {
            $('#previous-btn-admin').addClass('disable');
        }
    })
})
$('#next-btn-admin').ready(function() {             
    if($('.default-admin-pagination').length==1) {
        $('#next-btn-admin').addClass('disable');
    }
})
$('#next-btn-admin').click(function() {    
    currentPADefault = parseInt(currentPADefault) + 1;
    $('#previous-btn-admin').removeClass('disable');
    setSelectedA(currentPADefault-1);
    $.get('handle/hDefault-content.php', {uid:currentPADefault}, function(data) {
        $('.dashboard-content-table-item').eq(1).html(data);
        if (currentPADefault == $('.default-admin-pagination').length) {
            $('#next-btn-admin').addClass('disable');
        }
    })
})

$('.default-admin-pagination').click(function() {
    currentPADefault = $(this).text();
    $('.default-admin-pagination').removeClass('dashboard-content-table-pagination-btn-selected');
    $(this).addClass('dashboard-content-table-pagination-btn-selected');
    if($(this)[0] != $('.default-admin-pagination').first()[0] && $(this)[0] != $('.default-admin-pagination').last()[0]){
        $('#previous-btn-admin').removeClass('disable');
        $('#next-btn-admin').removeClass('disable');
    }
    $.get('handle/hDefault-content.php', {uid:$(this).text()}, function(data) {
        $('.dashboard-content-table-item').eq(1).html(data);
    })
})

$('.dashboard-content-table-item').eq(1).ready(function() {
    $.get('handle/hDefault-content.php', {uid:'1'}, function(res) {
        if (res==false) {
            $('.no-things-available').eq(1).html("<span>No employees is available !</span>");
            $('.dashboard-content-table-pagination').eq(1).html('');
        } else {
            $('.dashboard-content-table-item').eq(1).html(res);
        }
    })
})

function setSelectedA(current) {
    $('.default-admin-pagination').removeClass('dashboard-content-table-pagination-btn-selected');
    $('.default-admin-pagination').eq(current).addClass('dashboard-content-table-pagination-btn-selected');
}

// Sales
$('.default-sales-pagination').first().click(function() {
    if ($('.default-sales-pagination').length!=1) {
        $('#previous-btn-sales').addClass('disable');
        $('#next-btn-sales').removeClass('disable');
    }
})
$('.default-sales-pagination').last().click(function() {
    if ($('.default-sales-pagination').length!=1) {
        $('#next-btn-sales').addClass('disable');
        $('#previous-btn-sales').removeClass('disable');
    }
})

$('#previous-btn-sales').click(function() {
    currentPSDefault -= 1;
    $('#next-btn-sales').removeClass('disable');
    setSelectedS(currentPSDefault-1);
    $.get('handle/hDefault-content.php', {sid:currentPSDefault}, function(data) {
        $('.dashboard-content-table-item').eq(2).html(data);
        if (currentPSDefault == 1) {
            $('#previous-btn-sales').addClass('disable');
        }
    })
})
$('#next-btn-sales').ready(function() {             
    if($('.default-sales-pagination').length==1) {
        $('#next-btn-sales').addClass('disable');
    }
})
$('#next-btn-sales').click(function() {    
    currentPSDefault = parseInt(currentPSDefault) + 1;
    $('#previous-btn-sales').removeClass('disable');
    setSelectedS(currentPSDefault-1);
    $.get('handle/hDefault-content.php', {sid:currentPSDefault}, function(data) {
        $('.dashboard-content-table-item').eq(2).html(data);
        if (currentPSDefault == $('.default-sales-pagination').length) {
            $('#next-btn-sales').addClass('disable');
        }
    })
})

$('.default-sales-pagination').click(function() {
    currentPSDefault = $(this).text();
    $('.default-sales-pagination').removeClass('dashboard-content-table-pagination-btn-selected');
    $(this).addClass('dashboard-content-table-pagination-btn-selected');
    if($(this)[0] != $('.default-sales-pagination').first()[0] && $(this)[0] != $('.default-sales-pagination').last()[0]){
        $('#previous-btn-sales').removeClass('disable');
        $('#next-btn-sales').removeClass('disable');
    }
    $.get('handle/hDefault-content.php', {sid:$(this).text()}, function(data) {
        $('.dashboard-content-table-item').eq(2).html(data);
    })
})

$('.dashboard-content-table-item').eq(2).ready(function() {
    $.get('handle/hDefault-content.php', {sid:'1'}, function(res) {
        if (res==false) {
            $('.no-things-available').eq(2).html("<span>No sales is available !</span>");
            $('.dashboard-content-table-pagination').eq(2).html('');
        } else {
            $('.dashboard-content-table-item').eq(2).html(res);
        }
    })
})


function setSelectedS(current) {
    $('.default-sales-pagination').removeClass('dashboard-content-table-pagination-btn-selected');
    $('.default-sales-pagination').eq(current).addClass('dashboard-content-table-pagination-btn-selected');
}

// Products
$('.default-products-pagination').first().click(function() {
    if ($('.default-products-pagination').length!=1) {
        $('#previous-btn-products').addClass('disable');
        $('#next-btn-products').removeClass('disable');
    }
})
$('.default-products-pagination').last().click(function() {
    if ($('.default-products-pagination').length!=1) {
        $('#next-btn-products').addClass('disable');
        $('#previous-btn-products').removeClass('disable');
    }
})

$('#previous-btn-products').click(function() {
    currentPPDefault -= 1;
    $('#next-btn-products').removeClass('disable');
    setSelectedPr(currentPPDefault-1);
    $.get('handle/hDefault-content.php', {pid:currentPPDefault}, function(data) {
        $('.dashboard-content-table-item').eq(3).html(data);
        if (currentPPDefault == 1) {
            $('#previous-btn-products').addClass('disable');
        }
    })
})
$('#next-btn-products').ready(function() {             
    if($('.default-products-pagination').length==1) {
        $('#next-btn-products').addClass('disable');
    }
})
$('#next-btn-products').click(function() {    
    currentPPDefault = parseInt(currentPPDefault) + 1;
    $('#previous-btn-products').removeClass('disable');
    setSelectedPr(currentPPDefault-1);
    $.get('handle/hDefault-content.php', {pid:currentPPDefault}, function(data) {
        $('.dashboard-content-table-item').eq(3).html(data);
        if (currentPPDefault == $('.default-products-pagination').length) {
            $('#next-btn-products').addClass('disable');
        }
    })
})

$('.default-products-pagination').click(function() {
    currentPPDefault = $(this).text();
    $('.default-products-pagination').removeClass('dashboard-content-table-pagination-btn-selected');
    $(this).addClass('dashboard-content-table-pagination-btn-selected');
    if($(this)[0] != $('.default-products-pagination').first()[0] && $(this)[0] != $('.default-products-pagination').last()[0]){
        $('#previous-btn-products').removeClass('disable');
        $('#next-btn-products').removeClass('disable');
    }
    $.get('handle/hDefault-content.php', {pid:$(this).text()}, function(data) {
        $('.dashboard-content-table-item').eq(3).html(data);
    })
})

$('.dashboard-content-table-item').eq(3).ready(function() {
    $.get('handle/hDefault-content.php', {pid:'1'}, function(res) {
        if (res==false) {
            $('.no-things-available').eq(3).html("<span>No products is available !</span>");
            $('.dashboard-content-table-pagination').eq(3).html('');
        } else {
            $('.dashboard-content-table-item').eq(3).html(res);
        }
    })
})


function setSelectedPr(current) {
    $('.default-products-pagination').removeClass('dashboard-content-table-pagination-btn-selected');
    $('.default-products-pagination').eq(current).addClass('dashboard-content-table-pagination-btn-selected');
}


// View info user
$('#update-profile-btn').click(function(event) {
    event.preventDefault();
    if(!checkEmptyUpdateInfoUser()) {
        $('.error').eq(0).html("Error : Input can't be gaped !");
        $('.error').eq(0).css('display','block');
        return;   
    } else {
        $('.error').eq(0).html('');
        $('.error').eq(0).css('display','none');
    }
    $.ajax({
        method:'get',
        url:'handle/hView-info-user.php',
        data: $('#view-info-user-form').serialize()+'&action=view',
        success: function(res) {
            if (res == 1) {
                alert('Update information successfully !');
                $('.header-info-user span').eq(0).html(document.getElementsByName('username')[0].value);
            } else if (res == 0) {
                alert('Failed when update information !');
            }
        }
    }) 
})

function checkEmptyUpdateInfoUser() {
    if (document.getElementsByName('username')[0].value == '' || document.getElementsByName('user-email')[0].value == '' ||
    document.getElementsByName('user-phone')[0].value == '' || document.getElementsByName('other-information')[0].value == '' ) return false;

    return true
}

let flag_checkNewPassword_ChangePassword = true;
var flag = 0;
$('#change-password-btn').click(function(event) {
    event.preventDefault();
    field1 = document.getElementsByName('old-password')[0].value;
    field2 = document.getElementsByName('new-password')[0].value;
    field3 = document.getElementsByName('retype-password')[0].value;
    if(!checkEmptyChangePassword()) {
        $('.error').eq(0).html("Error : Input can't be gaped !");
        $('.error').eq(0).css('display','block');
        return;   
    } else if (!flag_checkNewPassword_ChangePassword) {
        return;   
    } else {
        $('.error').eq(0).html('');
        $('.error').eq(0).css('display','none');
    }
    $.ajax({
        method:'post',
        url:'handle/hView-info-user.php',
        data: $('#change-password-form').serialize()+'&action=change-password',
        success:function(res) {
            if (res == 1) {
                alert('Change password successfully !');
            } else if (res == 0) {
                alert('Failed when change password !');
            } else if (res.trim() == 'incorrect') {
                alert('Old password is not correct !');
                flag++;
                if (flag == 5) {
                    var count = 30;
                    $('#change-password-btn').css('background','rgb(201, 201, 201)');
                    $('#change-password-btn').css('color','#f35454');
                    $('#change-password-btn').css('pointer-events','none');
                    $('#change-password-btn').html('Can change password in '+count);
                    var status = countUnlockBtnChangePass(count-1);
                    flag = 0;
                }
            }
        }
    })
})

function countUnlockBtnChangePass(count) {
    if (count == -1) {
        $('#change-password-btn').css('background','#169981')
        $('#change-password-btn').css('color','white')
        $('#change-password-btn').css('pointer-events','unset')
        $('#change-password-btn').html('Change password');
        return true;
    }
    setTimeout(() => {
        $('#change-password-btn').html('Can change password in '+count);
        countUnlockBtnChangePass(count-1);
    }, 1000);
};

$('.password-cont').eq(1).keyup(function() {
    val = document.getElementsByName('new-password')[0].value;
    if (val.length <= 10) {
        $('.error').eq(0).html("Error : Password must be > 10 character !");
        $('.error').eq(0).css('display','block');
        flag_checkNewPassword_ChangePassword = false;
        $('.password-cont').eq(2).addClass('disable');
        return;   
    } else if (!/[A-Z]+/g.test(val)) {
        $('.error').eq(0).html("Error : Password must have at least 1 upper character !");
        $('.error').eq(0).css('display','block');
        flag_checkNewPassword_ChangePassword = false;
        $('.password-cont').eq(2).addClass('disable');
        return;  
    } else if (/[!-/|:-@|[-`|{-~]/g.test(val)) {
        $('.error').eq(0).html("Error : Password can't contain special character !");
        $('.error').eq(0).css('display','block');
        flag_checkNewPassword_ChangePassword = false;
        $('.password-cont').eq(2).addClass('disable');
        return;  
    } else {
        $('.error').eq(0).html('');
        $('.error').eq(0).css('display','none');
        flag_checkNewPassword_ChangePassword = true;
        $('.password-cont').eq(2).removeClass('disable');
    }
})

$('.password-cont').eq(2).keyup(function() {
    retypeVal = document.getElementsByName('retype-password')[0].value;
    newVal = document.getElementsByName('new-password')[0].value;
    if (retypeVal != newVal) {
        $('.error').eq(0).html("Error : Retype password must be equal new password !");
        $('.error').eq(0).css('display','block');
        flag_checkNewPassword_ChangePassword = false;
        return;  
    } else {
        $('.error').eq(0).html('');
        $('.error').eq(0).css('display','none');
        flag_checkNewPassword_ChangePassword = true;
    }
})

$('.position').click(function() {
    if ($('.position').eq(0)[0] == $(this)[0]) {
        pos = 0;
    } else if ($('.position').eq(1)[0] == $(this)[0]) {
        pos = 1;
    } else pos = 2;

    className = $(this).attr('class').split(' ');
    className.forEach(item => {
        if (item == 'fa-eye-slash') {
            $('.password-cont').eq(pos).prop('type','text')
            $(this).addClass('fa-eye')
            $(this).removeClass('fa-eye-slash')
        } else if (item == 'fa-eye') {
            $('.password-cont').eq(pos).prop('type','password')
            $(this).addClass('fa-eye-slash')
            $(this).removeClass('fa-eye')
        }
    });
})

function checkEmptyChangePassword() {
    if (document.getElementsByName('old-password')[0].value == '' || document.getElementsByName('new-password')[0].value == '' ||
    document.getElementsByName('retype-password')[0].value == '') return false;

    return true
}


// Page manage
let number_dm_pi = $('.dashboard-manage-table-pagination-items span').length;
let compareSpan = $('.dashboard-manage-table-pagination-items span');
let posAction;
let sort = "asc";
let title = "";

$('.dashboard-manage-table-items').ready(function() {
    currentPage = $('#dm-title').text().trim();
    $.get('handle/hManage.php',{page:currentPage,num:'10',pag:'1'},function(res) {
        $('.dashboard-manage-table-items').html(res);
    })

    $.get('handle/hManage.php',{page:currentPage,num:'10',pag:'1',numPag:'true',textShow:'true'},function(res) {
        $('#dm-show-number').html(res);
    })

    $.get('handle/hManage.php',{page:currentPage,num:'10',pag:'1',popUp:'true'},function(res) {
        $('.dashboard-manage-pop-up-container').html(res);
    })
})
$('#dm-last-btn').ready(function() {
    if (number_dm_pi==3) {
        $('#dm-last-btn').addClass('dm-disable');
    }
})
$('#dm-last-btn').click(function() {
    $('#dm-last-btn').addClass('dm-disable');
    $('#dm-first-btn').removeClass('dm-disable');
    compareSpan.removeClass('dm-selected');
    compareSpan.eq(number_dm_pi-2).addClass('dm-selected');

    var num = $('#dm-select-show').val();
    $.get('handle/hManage.php',{page:currentPage,num:num,pag:number_dm_pi-2,title:title,sort:sort},function(res) {
        $('.dashboard-manage-table-items').html(res);
    })

    $.get('handle/hManage.php',{page:currentPage,num:num,pag:number_dm_pi-2,numPag:'true',textShow:'true'},function(res) {
        $('#dm-show-number').html(res);
    })

    $.get('handle/hManage.php',{page:currentPage,num:num,pag:number_dm_pi-2,title:title,sort:sort,popUp:'true'},function(res) {
        $('.dashboard-manage-pop-up-container').html(res);
    })
})
$('#dm-first-btn').click(function() {
    $('#dm-first-btn').addClass('dm-disable');
    $('#dm-last-btn').removeClass('dm-disable');
    compareSpan.removeClass('dm-selected');
    compareSpan.eq(1).addClass('dm-selected');

    var num = $('#dm-select-show').val();
    $.get('handle/hManage.php',{page:currentPage,num:num,pag:'1',title:title,sort:sort},function(res) {
        $('.dashboard-manage-table-items').html(res);
    })

    $.get('handle/hManage.php',{page:currentPage,num:num,pag:'1',numPag:'true',textShow:'true'},function(res) {
        $('#dm-show-number').html(res);
    })

    $.get('handle/hManage.php',{page:currentPage,num:num,pag:'1',title:title,sort:sort,popUp:'true'},function(res) {
        $('.dashboard-manage-pop-up-container').html(res);
    })
})
$('.dashboard-manage-table-pagination-items span').click(function() {
    var currentSpan = $(this)[0];
    var num = $('#dm-select-show').val();
    var pag = $(this).text().trim();

    if (currentSpan!= compareSpan.eq(0)[0] && currentSpan!=compareSpan.eq(number_dm_pi-1)[0]) {
        $('.dashboard-manage-table-pagination-items span').removeClass('dm-selected');
        $(this).addClass('dm-selected');
        if (currentSpan!= compareSpan.eq(1)[0] && currentSpan!=compareSpan.eq(number_dm_pi-2)[0]) {
            $('#dm-first-btn').removeClass('dm-disable');
            $('#dm-last-btn').removeClass('dm-disable');
        }
        
        $.get('handle/hManage.php',{page:currentPage,num:num,pag:pag,title:title,sort:sort},function(res) {
            $('.dashboard-manage-table-items').html(res);
        })

        $.get('handle/hManage.php',{page:currentPage,num:num,pag:pag,numPag:'true',textShow:'true'},function(res) {
            $('#dm-show-number').html(res);
        })

        $.get('handle/hManage.php',{page:currentPage,num:num,pag:pag,popUp:'true',title:title,sort:sort},function(res) {
            $('.dashboard-manage-pop-up-container').html(res);
        })
    }

    if (number_dm_pi>3) {
        if (currentSpan==compareSpan.eq(number_dm_pi-2)[0]) {
            $('#dm-first-btn').removeClass('dm-disable');
            $('#dm-last-btn').addClass('dm-disable');
        } else if (currentSpan==compareSpan.eq(1)[0]) {
            $('#dm-last-btn').removeClass('dm-disable');
            $('#dm-first-btn').addClass('dm-disable');
        }

    }
})



$('#dm-select-show').change(function() {
    var num = $(this).val();

    $.get('handle/hManage.php',{page:currentPage,num:num,pag:'1',title:title,sort:sort},function(res) {
        $('.dashboard-manage-table-items').html(res);
    })

    $.get('handle/hManage.php',{page:currentPage,num:num,pag:'1',numPag:'true',textShow:'true',title:title,sort:sort},function(res) {
        $('#dm-show-number').html(res);
    })

    $.get('handle/hManage.php',{page:currentPage,num:num,numPag:'true'},function(res) {
        resNumPag = res.trim();
        $('span.dm-pagination-items').css('display','none');
        for (i = 0; i <= resNumPag-1; i ++) {
            if (resNumPag == 1) {
                $('#dm-last-btn').addClass('dm-disable');
                $('#dm-first-btn').addClass('dm-disable');
                $('span.dm-pagination-items').removeClass('dm-selected');
                $('span.dm-pagination-items').eq(0).addClass('dm-selected');
            } else {
                $('#dm-last-btn').removeClass('dm-disable');
            }
            $('span.dm-pagination-items').eq(i).css('display','block');
        }
    })
    resetCountPi();

    $.get('handle/hManage.php',{page:currentPage,num:num,pag:'1',popUp:'true',title:title,sort:sort},function(res) {
        $('.dashboard-manage-pop-up-container').html(res);
    })
})

function resetCountPi() {
    setTimeout(() => {
        number_dm_pi = $(".dashboard-manage-table-pagination-items").find("span:visible").length;
    }, 1000);
}

$(document).on("click" , ".dashboard-manage-table-items .dashboard-manage-table-action" , function() {
    status = $(this).find('ul.dashboard-manage-table-action-items').css('display');
    posAction = parseInt($(this).attr('id').split('-')[1]);

    $('ul.dashboard-manage-table-action-items').css('display','none');
    if (status == 'none') {
        $(this).find('ul.dashboard-manage-table-action-items').css('display','block');
    } else {
        $(this).find('ul.dashboard-manage-table-action-items').css('display','none');
    }
});

// // // // // Fix from here 
$(document).on("click" , ".dashboard-manage-table-action-items li" , function() {
    var id_view = $('.dashboard-manage-table-items tr').eq(posAction+1).find('td').eq(0).text();
    var num = $('#dm-select-show').val();
    if ($(this).text()=='Update') {
        $('.dashboard-manage-pop-up').eq(posAction).css('display','block');
        $.get('handle/hManage.php',{page:currentPage,idView:id_view},function(res) {
            handle = res.trim().split('/');
            handle.forEach(e => {
                if (!e.trim()=='') {
                    temp = 0;
                    while (true) {
                        if ($('.dashboard-manage-pop-up-items').eq(posAction).find('.dm-pop-up-cbox').eq(temp).text().trim()==e) {
                            $('.dashboard-manage-pop-up-items').eq(posAction).find('input[type=checkbox]').eq(temp).prop('checked', true);
                            $('.dashboard-manage-pop-up-items').eq(posAction).find('input[type=radio]').eq(temp).prop('checked', true);
                            break;
                        }
                        temp ++;
                    }
                } 
            });
        })
    } else if ($(this).text()=='Delete') {
        var size = $('.dashboard-manage-table-items tr').eq(posAction+1).find('td').eq(1).text();     
        if (currentPage == "Track Invoice") {
            var status_delivery = $('.dashboard-manage-table-items tr').eq(posAction+1).find('td').eq(5).text();     
            if (status_delivery=="Delivering" || status_delivery=="Delivered") {
                alert("Không thể xóa hóa đơn đang giao hoặc đã giao !");
                return;
            }
        }
        if (confirm('Do you really want to delete '+id_view + ' ?')) {
            $.get('handle/hManage.php',{page:currentPage,update:'true',val:'delete~'+id_view+'~'+size},function(res) {
                if (res.trim()==true) {
                    alert('Deleted successfully !');
                    $.get('handle/hManage.php',{page:currentPage,num:num,pag:'1',title:title,sort:sort},function(res) {
                        $('.dashboard-manage-table-items').html(res);
                    });
                }
                console.log(res);
            })
        }
    }
});
$(document).on("click",".dm-pop-up-close-btn", function() {
    $('.dashboard-manage-pop-up').eq(posAction).css('display','none');
})
$(window).click(function(event) {
    if (event.target == $('.dashboard-manage-pop-up').eq(posAction)[0]) {
        $('.dashboard-manage-pop-up').eq(posAction).css('display','none');
    }
    if (event.target == $('.dashboard-manage-pop-up-add').eq(0)[0]) {
        $('.dashboard-manage-pop-up-add').eq(0).css('display','none');
    }
})
// // // // $(document).on("click",".dm-pop-up-reset-btn",function() {
// // // //     // $('.dashboard-manage-pop-up-items').eq(posAction).find('input[type=checkbox]').prop('checked', false);
// // // // })
$(document).on("click",".dm-pop-up-save-btn",function() {
    valInput1 = $('.dashboard-manage-pop-up-items').eq(posAction).find('input.dm-can-del').eq(0).val();
    valInput2 = $('.dashboard-manage-pop-up-items').eq(posAction).find('input.dm-can-del').eq(1).val();   
    valInput3 = $('.dashboard-manage-pop-up-items').eq(posAction).find('input.dm-can-del').eq(2).val();   
    valInput4 = $('.dashboard-manage-pop-up-items').eq(posAction).find('input.dm-can-del').eq(3).val();   
    valInput5 = $('.dashboard-manage-pop-up-items').eq(posAction).find('input.dm-can-del').eq(4).val();  
    valInput6 = $('.dashboard-manage-pop-up-items').eq(posAction).find('select').eq(0).val();  

    if (valInput2=='' || valInput3=='' || valInput4=='' || valInput5==''){
        alert('Please fill input !');
        return;
    }

    id_view = $('.dashboard-manage-table-items tr').eq(posAction+1).find('td').eq(0).text();
    $.get('handle/hManage.php',{page:currentPage,update:'true',val:'text~'+id_view+'~'+valInput1+'~'+valInput2+'~'+valInput3+'~'+valInput4+'~'+valInput5+'~'+valInput6},function(res) {
        if (res.trim()==true) {
            alert('Update successfully !');
            var num = $('#dm-select-show').val();
            var pag = $('.dm-selected').text().trim();
            $.get('handle/hManage.php',{page:currentPage,num:num,pag:pag,title:title,sort:sort},function(res) {
                $('.dashboard-manage-table-items').html(res);
            });
            $('.dashboard-manage-pop-up-items').eq(posAction).find('input.dm-can-del').eq(0).val('');
            $('.dashboard-manage-pop-up-items').eq(posAction).find('input.dm-can-del').eq(0).prop('placeholder',valInput1);
            $('.dashboard-manage-pop-up-items').eq(posAction).find('input.dm-can-del').eq(1).val('');
            $('.dashboard-manage-pop-up-items').eq(posAction).find('input.dm-can-del').eq(1).prop('placeholder',valInput2);
            $('.dashboard-manage-pop-up-items').eq(posAction).find('input.dm-can-del').eq(2).val('');
            $('.dashboard-manage-pop-up-items').eq(posAction).find('input.dm-can-del').eq(2).prop('placeholder',valInput3);
            $('.dashboard-manage-pop-up-items').eq(posAction).find('input.dm-can-del').eq(3).val('');
            $('.dashboard-manage-pop-up-items').eq(posAction).find('input.dm-can-del').eq(3).prop('placeholder',valInput4);
            $('.dashboard-manage-pop-up-items').eq(posAction).find('input.dm-can-del').eq(4).val('');
            $('.dashboard-manage-pop-up-items').eq(posAction).find('input.dm-can-del').eq(4).prop('placeholder',valInput5);
        } else alert('Failed !');
    })
})
$(document).on("click",".dashboard-manage-pop-up-items span", function() {
    id_view = $('.dashboard-manage-table-items tr').eq(posAction+1).find('td').eq(0).text();

    if (currentPage.trim() == 'Manage Permission') {
        posUpdate = $(this).text().trim();
        actionUpdate = $(this).find('input[type=checkbox]').prop('checked') == true ? 'insert' : 'delete';
        $.get('handle/hManage.php',{page:currentPage,update:'true',val:'checkbox~'+posUpdate+'~'+actionUpdate+'~'+id_view},function(res) {
            if (res.trim()==false) {
                alert('Failed !'); 
            }
        })
    }
    else if (currentPage.trim() == 'Manage Customers' || currentPage.trim() == 'Manage Employees') {
        var cbox_pos = $(this).index();

        if ($(this).find('input').prop('type')=='radio') {
            if (!confirm('Change permission login of account '+id_view)) return;
        }
        $.get('handle/hManage.php',{page:currentPage,update:'true',val:'checkbox~'+cbox_pos+'~'+id_view},function(res) {
            if (res.trim()==false) {
                alert('Failed !'); 
            } else {
                var pag = $('.dm-selected').text().trim();
                var num = $('#dm-select-show').val();
                $.get('handle/hManage.php',{page:currentPage,num:num,pag:pag,title:title,sort:sort},function(res) {
                    $('.dashboard-manage-table-items').html(res);
                })
            }
        })
    }
    else if (currentPage.trim() == 'Manage Products') {
        var cbox_pos = $(this).index();

        if ($(this).find('input').prop('type')=='radio') {
            if (!confirm('Change gender of product '+id_view)) return;
        }

        $.get('handle/hManage.php',{page:currentPage,update:'true',val:'checkbox~'+cbox_pos+'~'+id_view},function(res) {
            if (res.trim()==false) {
                alert('Failed !'); 
            } else {
                var pag = $('.dm-selected').text().trim();
                var num = $('#dm-select-show').val();
                $.get('handle/hManage.php',{page:currentPage,num:num,pag:pag,title:title,sort:sort},function(res) {
                    $('.dashboard-manage-table-items').html(res);
                })
            }
        })
    }
})

// // // // // // // // Filter - dm
$('.dashboard-manage-search-bar-filter select').change(function() {
    // console.log($(this).val());
})

// // Search - dm
try {
    let valueFilter = $('.dashboard-manage-search-bar-fnc select').last().val().trim();
} catch(e) {
    //do nothing
}

$('.dashboard-manage-search-bar-fnc select').last().change(function() {
    valueFilter = $(this).val().trim();
})
$('.dashboard-manage-search-bar-fnc input').keyup(function() {
    var search = $(this).val();
    var num = $('#dm-select-show').val();
    if (valueFilter!='none') {
        $.get('handle/hManage.php',{page:currentPage,num:num,pag:'1',search:'true',val:valueFilter+'-'+search},function(res) {
            $('.dashboard-manage-table-items').html(res);
        })

        $.get('handle/hManage.php',{page:currentPage,num:num,pag:'1',popUp:'true',search:'true',val:valueFilter+'-'+search},function(res) {
            $('.dashboard-manage-pop-up-container').html(res);
        })
    }
})

// // // // // Add - dm 
let arrCbox_add = [];
$('#dm-add-btn').click(function() {
    $('.dashboard-manage-pop-up-add').eq(0).css('display','block');
})
$('.dashboard-manage-pop-up-add-act-checkbox input').click(function() {
    var thisVal = $(this).val();
    if ( currentPage == 'Manage Permission') {
        arrCbox_add.find(x => x == thisVal) == undefined ? arrCbox_add.push(thisVal) : arrCbox_add.splice(arrCbox_add.indexOf(thisVal),1);
    } else if ( currentPage == 'Manage Customers' || currentPage == 'Manage Employees' || currentPage == 'Manage Products') {
        arrCbox_add = [];
        arrCbox_add.push(thisVal);
    }
})
$('.dm-pop-up-close-add-btn').click(function() {
    $('.dashboard-manage-pop-up-add').eq(0).css('display','none');
})
$('.dm-pop-up-add-save-btn').click(function() {
    var general = $('.dashboard-manage-pop-up-add-info input');
    var input1 = general.eq(0).val();
    var input2 = general.eq(1).val();
    var input3 = general.eq(2).val();
    var input4 = general.eq(3).val();
    var input5 = general.eq(4).val();
    var input6 = general.eq(5).val();
    var input7 = general.eq(6).val();

    if (input1 == '' || input2 == '' || input3 == '' || input4 == '' || input5 == '' || input6 == '') {
        alert('Please fill input !');
        return;
    }

    if (currentPage == 'Manage Customers' || currentPage == 'Manage Employees') {
        if (arrCbox_add.length == 0) {
            alert('Please choose permission login');
            return;   
        }
    }

    if (currentPage == 'Manage Products') {
        if (arrCbox_add.length == 0) {
            alert('Please choose gender for product');
            return;   
        }
    }

    if (currentPage == 'Manage cProducts' || currentPage == 'Manage Providers' || currentPage == 'Manage gProducts' || currentPage == "Track Sales") return;

    // if (currentPage == 'Manage cProducts') {
    //     $.get('handle/hManage.php',{page:currentPage,add:'true',valText:input1+'-'+input2+'-'+input3+'-'+input4+'-'+input5+'-'+input6},function(res) {
    //         if (res.trim() == true) {
    //             alert('Add new employee successfully !');
    //             var num = $('#dm-select-show').val();
    //             var pag = $('.dm-selected').text().trim();
    
    //             $.get('handle/hManage.php',{page:currentPage,num:num,pag:pag},function(res) {
    //                 $('.dashboard-manage-table-items').html(res);
    //             })

    //             $.get('handle/hManage.php',{page:currentPage,num:num,pag:pag,numPag:'true',textShow:'true'},function(res) {
    //                 $('#dm-show-number').html(res);
    //             })
    //         } else alert('Failed');
    //     })
    //     return;
    // }

    if (currentPage == 'Manage Employees') {
        var add_permission = $('.dashboard-manage-pop-up-add-info select').val();
        $.get('handle/hManage.php',{page:currentPage,add:'true',valCB:arrCbox_add.join('-'),valText:input1+'-'+input2+'-'+input3+'-'+input4+'-'+input5+'-'+input6+'-'+add_permission},function(res) {
            if (res.trim() == true) {
                alert('Add new employee successfully !');
                var num = $('#dm-select-show').val();
                var pag = $('.dm-selected').text().trim();
    
                $.get('handle/hManage.php',{page:currentPage,num:num,pag:pag},function(res) {
                    $('.dashboard-manage-table-items').html(res);
                })

                $.get('handle/hManage.php',{page:currentPage,num:num,pag:pag,numPag:'true',textShow:'true'},function(res) {
                    $('#dm-show-number').html(res);
                })
            
                $.get('handle/hManage.php',{page:currentPage,num:num,pag:pag,popUp:'true'},function(res) {
                    $('.dashboard-manage-pop-up-container').html(res);
                })
            } else alert('Failed');
        })
        return;
    }

    if (currentPage == 'Manage Products') {
        var add_permission = $('.dashboard-manage-pop-up-add-info select').val();
        $.get('handle/hManage.php',{page:currentPage,add:'true',valCB:arrCbox_add.join('-'),valText:input1+'-'+input2+'-'+input3+'-'+input4+'-'+add_permission},function(res) {
            if (res.trim() == true) {
                alert('Add new product successfully !');
                var num = $('#dm-select-show').val();
                var pag = $('.dm-selected').text().trim();
    
                $.get('handle/hManage.php',{page:currentPage,num:num,pag:pag},function(res) {
                    $('.dashboard-manage-table-items').html(res);
                })

                $.get('handle/hManage.php',{page:currentPage,num:num,pag:pag,numPag:'true',textShow:'true'},function(res) {
                    $('#dm-show-number').html(res);
                })
            
                $.get('handle/hManage.php',{page:currentPage,num:num,pag:pag,popUp:'true'},function(res) {
                    $('.dashboard-manage-pop-up-container').html(res);
                })
            } else alert('Failed');
        })
        return;
    }

    $.get('handle/hManage.php',{page:currentPage,add:'true',valCB:arrCbox_add.join('-'),valText:input1+'-'+input2+'-'+input3+'-'+input4+'-'+input5+'-'+input6+'-'+input7},function(res) {
        console.log(res);
        if (res.trim() == true) {
            alert('Add new permission successfully !');
            var num = $('#dm-select-show').val();
            var pag = $('.dm-selected').text().trim();

            $.get('handle/hManage.php',{page:currentPage,num:num,pag:pag,title:title,sort:sort},function(res) {
                $('.dashboard-manage-table-items').html(res);
            })

            $.get('handle/hManage.php',{page:currentPage,num:num,pag:pag,numPag:'true',textShow:'true'},function(res) {
                $('#dm-show-number').html(res);
            })
        
            $.get('handle/hManage.php',{page:currentPage,num:num,pag:pag,popUp:'true',title:title,sort:sort},function(res) {
                $('.dashboard-manage-pop-up-container').html(res);
            })
        } else alert('Failed');
    })
})

// // End fix


// Sap xep tang/giam dan 
$(document).on("click", ".dashboard-manage-table tr th", function() {
    title = $(this).text().trim();
    var pag = $('.dm-selected').text().trim();
    var num = $('#dm-select-show').val();

    if (sort=="asc") sort = "desc";
    else sort = "asc";
    if (currentPage=="Manage Products"&&title=="Total") return;
    if (currentPage=="Track Invoice"&&title=="Date Delivered") return;
    if (currentPage=="Track Sales"&&title=="Effect on") return;
    if (title!="Action"&&title!="Status") {
        $.get('handle/hManage.php',{page:currentPage,num:num,pag:pag,title:title,sort:sort},function(res) {
            $('.dashboard-manage-table-items').html(res);
        })

        $.get('handle/hManage.php',{page:currentPage,num:num,pag:pag,title:title,sort:sort,popUp:'true'},function(res) {
            $('.dashboard-manage-pop-up-container').html(res);
        })
    }
})