<?php session_start();
    if (isset($_SESSION['user'])) {
        header("Location: ../index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/css/style.css">
    <script src="../static/js/jquery-3.6.0.min.js"></script>
    <LINK REL="SHORTCUT ICON" HREF="../static/images/favicon.ico">
    <title>Login Admin</title>
</head>
<body>
    <div class="login">
        <div class="login-container">
            <div class="logo">
                <img src="../static/images/logo-doc-trans.png" alt="logo">
            </div>

            <div class="content-login">
                <form id='login-form'>
                    <span>Username<input type="text" name='username' value='<?php if(isset($_POST['username'])) echo $_POST['username'] ?>'></span>
                    <span>Password  <input type="password" name='password' value='<?php if(isset($_POST['username'])) echo $_POST['password'] ?>'></span>
                    <a class="error">Error print here</a>
                    <div class="submit-container">
                        <button type='submit' id='login-btn'>Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<script>
    flag = 0;

    function validateLogin() {
        let username = document.getElementsByName("username")[0].value;
        let password = document.getElementsByName("password")[0].value;
        if (username == "" || password == "") {
            document.getElementsByClassName('error')[0].innerHTML = 'Vui lòng nhập vào username và password'
            document.getElementsByClassName('error')[0].style = 'display:block;';
        } else {
            return true;
        }
        return false;
    }

    $('.submit-container button').click(function(e) {
        e.preventDefault();
        if (status = validateLogin()) {
            $.ajax({
                method:'post',
                url:'../handle/hLogin.php',
                data:$('#login-form').serialize(),
                success:function(res) {
                    if (res.trim() == 'success') {
                        $('.error').css('display','none');
                        window.location = '../index.php';
                    } else {
                        $('.error').html('Tài khoản hoặc mật khẩu không đúng !');
                        $('.error').css('display','block');

                        flag ++;
                        if (flag == 5) {
                            var count = 30;
                            $('#login-btn').css('background','rgb(201, 201, 201)');
                            $('#login-btn').css('color','#f35454');
                            $('#login-btn').css('pointer-events','none');
                            $('#login-btn').html('Can login again in '+count);
                            var status = countUnlockLoginBtn(count-1);
                            flag = 0;
                        }
                    }
                }
            })
        }
    })

    function countUnlockLoginBtn(count) {
        if (count == -1) {
            $('#login-btn').css('background','#169981')
            $('#login-btn').css('color','white')
            $('#login-btn').css('pointer-events','unset')
            $('#login-btn').html('Login');
            return true;
        }
        setTimeout(() => {
            $('#login-btn').html('Can login again in '+count);
            countUnlockLoginBtn(count-1);
        }, 1000);
    };
</script>

