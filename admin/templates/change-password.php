<div class="view-info-user-container">
    <div class="view-info-user-avatar disable-copy">
        <span>Profile picture</span>
        <img src="static/images/logo-user.jpg" alt="logo-user">
    </div>

    <form id='change-password-form' class="view-info-user-content">
        <span style='margin-top:20px'>User id : <input name='user-id' type="text" class='disable' value='<?php echo $_SESSION['user']['id'] ?>'></span>
        <span>Old password : 
            <input class='password-cont' name='old-password' type="password">
            <i class="fas fa-eye-slash position"></i>
        </span>
        <span>New password : 
            <input class='password-cont' name='new-password' type="password">
            <i class="fas fa-eye-slash position"></i>
        </span>
        <span>Retype new password : 
            <input class='password-cont disable' name='retype-password' type="password">
            <i class="fas fa-eye-slash position"></i>
        </span>
        <span class='error'></span>
        <button type='submit' id='change-password-btn'>Change password</button>
    </form>
</div>