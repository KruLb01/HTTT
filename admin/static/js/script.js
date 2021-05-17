let minimize = false;
function minimizeMenubar() {
    if (minimize === false) {
        document.getElementsByClassName('menu-dashboard')[0].style = 'transform: translateX(-300px);width:0%;transition: 0.5s';
        document.getElementsByClassName('content-dashboard')[0].style = 'width:100%';
        if (window.matchMedia('(max-width: 700px)').matches) {
            document.getElementsByClassName('menu-dashboard')[0].style = 'transform: translateX(-300px);width:0%;transition: 0.5s';
            setTimeout(() => {
                document.getElementsByClassName('menu-dashboard')[0].style = 'display:none';
            }, 500);
            document.getElementsByClassName('content-dashboard')[0].style = 'width:100%';
        }
        minimize = true;
    }
    else {
        document.getElementsByClassName('menu-dashboard')[0].style = 'transform: translateX(0);width:20%;transition: 0.5s';
        document.getElementsByClassName('content-dashboard')[0].style = 'width:80%';
        if (window.matchMedia('(max-width: 700px)').matches) {
            document.getElementsByClassName('menu-dashboard')[0].style = 'transform: translateX(-500px);width:100%';
            setTimeout(() => {
                document.getElementsByClassName('menu-dashboard')[0].style = 'transform: translateX(0);width:100%;transition: 0.5s';
            }, 100);
            document.getElementsByClassName('content-dashboard')[0].style = 'width:100%';
        }
        minimize = false;
    }
}

function showFunctionSearch() {
    const currentPosition = window.getComputedStyle(document.getElementById('header-search-user-container')).transform.replace(/\w+\(\d+,\s\d+,\s\d,\s\d.\s\d,\s|\)/g,(x)=>"");
    if (window.matchMedia('(max-width: 700px)').matches) {
        console.log("was here");
        if (currentPosition == -90) {
            document.getElementById('header-search-user-container').style = 'transform: translateY(120px);transition:1s';
        } else {
            document.getElementById('header-search-user-container').style = 'transform: translateY(-90px);transition:1s';
        }
    } else {
        if (currentPosition == -90) {
            document.getElementById('header-search-user-container').style = 'transform: translateY(0px);transition:1s';
        } else {
            document.getElementById('header-search-user-container').style = 'transform: translateY(-90px);transition:1s';
        }
    }
}

function showDetailUser() {
    if (document.getElementsByClassName('header-detail-user')[0].style.display == "" || document.getElementsByClassName('header-detail-user')[0].style.display == "none") {
        document.getElementsByClassName('header-detail-user')[0].style = "display:block";
    } else {
        document.getElementsByClassName('header-detail-user')[0].style = "display:none";
    }
}

function minimizieSubmenu(value) {
    try {
        let position = value.split('-')[1];
        let current = document.getElementById('submenu-'+position);
        let order1;
        if (current.style.display==""||current.style.display=="block") {
            order1 = 'opacity:0;transform:translateY(-50px);transition:0.5s';
            current.style = order1;
            
            setTimeout(() => {
                current.style = 'display:none';  
            }, 500);
        } else if (current.style.display=="none") {
            order1 = 'display:block;opacity:0.5;transform:translateY(-50px)';
            current.style = order1;
            setTimeout(() => {
                order1 = 'opacity:1;transform:translateY(0px);transition:0.5s';
                current.style = order1;
            }, 0);
        }
    } catch (err) {
        // do no thing
    }
}

function logOut() {
    console.log(123);
}

function setNotification() {
    // document.getElementsByClassName('header-notification')[0].style = 'display:block';
}
