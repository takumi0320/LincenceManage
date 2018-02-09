var script = $('#script');
var loginCount = eval(JSON.parse(script.attr('data-login-flag')));
var localStorageCount = eval(localStorage.getItem("loginFailureCount"));
var value = loginCount + localStorageCount;// ログインの失敗回数
var dateNow = new Date();
//localStorageのtimeStamp
var date = localStorage.getItem("timeStamp");
var timeStamp = new Date(date);

window.onload = function () {
    if (date) {
        if(timeStamp.getTime() > dateNow.getTime()){
            document.getElementById('limit-time-over').style.display = "block";
            document.getElementById('not-match').style.display = "none";
        } else {
            // 30分経過すると失敗カウントをリセットする
            localStorage.removeItem("loginFailureCount");
            localStorage.removeItem("timeStamp");
            document.getElementById('limit-time-over').style.display = "none";
            document.getElementById('not-match').style.display = "none";
            value = 0;
        }
    }
}

// ログインのチェック
function loginCheck () {
    //localStorageのtimeStamp
    date = localStorage.getItem("timeStamp");
    timeStamp = new Date(date);
    if(value < 4){
        localStorage.setItem("loginFailureCount",value);//localStorageに失敗回数を保存する
        if (!isBlank()) {
            document.loginForm.submit();
        }
    } else if (value === 4) {
        if (date) {
            if (timeStamp.getTime() <= dateNow.getTime()) {
                // 30分経過すると失敗カウントをリセットする
                localStorage.removeItem("loginFailureCount");
                localStorage.removeItem("timeStamp");
                if (!isBlank()) {
                    document.loginForm.submit();
                }
            }
        } else {
            localStorage.setItem("loginFailureCount",value);//localStorageに失敗回数を保存する
            var time = dateNow.setMinutes(dateNow.getMinutes() + 30);
            var timeStamp =  new Date(time);
            localStorage.setItem("timeStamp",timeStamp);//localStorageにtimeStampを保存する
            if (!isBlank()) {
                document.loginForm.submit();
            }
        }
    }
}

// エンターキーを押した場合の処理
function onEnterKeyDown () {
    if( window.event.keyCode == 13 ){
        loginCheck();
    }
}

// 空値チェック
function isBlank () {
    var administratorId = document.getElementById('administrator-id').value;
    var password = document.getElementById('password').value;
    var blankFlag = false; // trueだったら空値有り
    if (!administratorId && !password) {
        blankFlag = true;
        document.getElementById('all-blank').style.display = "block";
        document.getElementById('not-match').style.display = "none";
    } else {
        document.getElementById('all-blank').style.display = "none";
        document.getElementById('not-match').style.display = "none";
        if (!administratorId) {
            blankFlag = true;
            document.getElementById('id-is-blank').style.display = "block";
            document.getElementById('not-match').style.display = "none";
        } else {
            document.getElementById('id-is-blank').style.display = "none";
            document.getElementById('not-match').style.display = "none";
        }
        if (!password) {
            blankFlag = true;
            document.getElementById('password-is-blank').style.display = "block";
            document.getElementById('not-match').style.display = "none";
        } else {
            document.getElementById('password-is-blank').style.display = "none";
            document.getElementById('not-match').style.display = "none";
        }
    }
    return blankFlag;
}
