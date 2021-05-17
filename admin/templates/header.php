<div class="header disable-copy">
    <span id='top-menu-btn'>Dashboard</span>
    <i class="fas fa-bars" onclick="minimizeMenubar()"></i>
    <div class="header-user">
        <div class="header-function-user">
            <i class="fas fa-search" style="color: #98b5ff;background-color:#ecf4ff" onclick="showFunctionSearch()">
                <!-- <div class="header-notification"></div> -->
            </i>
            <div id="header-search-user-container">
                <input type="text" id='header-search-user'>
                <i class="fas fa-times" style="margin-right: 15px;color: red;background-color:rgb(255, 187, 187)"
                onclick="document.getElementById('header-search-user').value='';document.getElementById('header-search-user-container').style = 'transform: translateY(-90px);transition:1s';"></i>
            </div>
            <i class="fas fa-comments" style="color: rgb(255, 187, 0);background-color:rgb(255, 255, 179)">
                <div class="header-notification" style="left: 100px;"></div>
            </i>
            <i class="fas fa-bell" style="margin-right: 15px;color: red;background-color:rgb(255, 187, 187)">
                <div class="header-notification" style="left: 160px;"></div>
            </i>
            <div class="straight-line"></div>
        </div>
        <div class="avatar view-info-btn">
            <img src="static/images/logo-user.jpg" alt="logo-user">
        </div>
        <div class="header-info-user view-info-btn">
            <span><?php echo $_SESSION['user']['name'] ?></span>
            <span style="color:rgb(184, 184, 184)"><?php echo $_SESSION['user']['permission']?></span>
        </div>
        <div class="header-show-user">
            <i class="fas fa-chevron-down" onclick="showDetailUser()"></i>
            <div class="header-detail-user">
                <ul>
                    <li class='view-info-btn'><a style="margin-left: 0px;">            
                        <div class="header-function-user" style="justify-content: left;">
                            <div class="avatar">
                                <img src="static/images/logo-user.jpg" alt="logo-user">
                            </div>
                            <div class="header-info-user">
                                <span><?php echo $_SESSION['user']['name'] ?></span>
                                <span style="color:rgb(226, 224, 224)">View your information</span>
                            </div>
                        </div>
                    </a></li>
                    <li class='change-password-btn'><a>Change password</a></li>
                    <li><a>Settings</a></li>
                    <li class='logout-btn'><a>Log out</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>