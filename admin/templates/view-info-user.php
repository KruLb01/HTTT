<div class="view-info-user-container">
    <div class="view-info-user-avatar disable-copy">
        <span>Profile picture</span>
        <img src="static/images/logo-user.jpg" alt="logo-user">
    </div>

    <form id='view-info-user-form' class="view-info-user-content">
        <span style='margin-top:20px'>User id : <input name='user-id' type="text" class='disable' value='<?php echo $_SESSION['user']['id'] ?>'></span>
        <span>Username : <input name='username' type="text" value='<?php echo $_SESSION['user']['name'] ?>'></span>
        <span>User email : <input name='user-email' type="text" value='<?php echo $_SESSION['user']['email'] ?>'></span>
        <span>User phone : <input name='user-phone' type="text" value='<?php echo $_SESSION['user']['phone'] ?>'></span>
        <span>User permission : <input name='user-permission' type="text" class='disable' value='<?php echo $_SESSION['user']['permission'] ?>'></span>
        <span>Other information : <textarea name="other-information" id="other-information" cols="30" rows="4"><?php echo $_SESSION['user']['other'] ?></textarea></span>
        <span class='error'></span>
        <button type='submit' id='update-profile-btn'>Update profile</button>
    </form>
</div>