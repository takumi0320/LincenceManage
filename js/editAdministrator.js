var currentAdministratorPassword;
window.onload = function() {
    var script = $('#script');
    var getAdministratorId = JSON.parse(script.attr('data-administrator-id'));
    var method = "GetAdministratorUserPassword";
    $.ajax({
        url: '../kanrisya_front/ajax/ajaxManager.php',
        type: 'POST',
        dataType: 'json',
        data: {Method: method,
               AdministratorId: getAdministratorId
              }
    })
    .done(function(data) {
        currentAdministratorPassword = data;
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
        console.log("XMLHttpRequest : " + XMLHttpRequest.status);
        console.log("textStatus     : " + textStatus);
        console.log("errorThrown    : " + errorThrown.message);
        alert("通信エラーがおきました");
    });
}

//更新フォームチェック
function formCheck() {
    var blankFlag = true;
    blankFlag = isBlank();
    if (blankFlag) {
        return false;
    }else {
    currentPasswordCheck(inputAdministratorPassword,currentAdministratorPassword).then((result) => {
        if(result){
            blankFlag = false;
        }else{
            document.editForm.submit();
        }
    });
}
}

//項目欄が未入力チェック
function isBlank () {
    var administratorRepassword = null;
    var administratorRepassword = null;
    var blankFlag = false;
    $(function(){
    inputAdministratorPassword = $('input[name=administratorCurrentPassword]').val();
    newAdministratorPassword = $('input[name=administratorPassword]').val();
    newAdministratorRepassword = $('input[name=administratorRepassword]').val();
    });
    document.getElementById('edit-is-administrator-password').style.display = "none";
    document.getElementById('edit-is-administrator-newpassword').style.display = "none";
    document.getElementById('edit-is-administrator-repassword').style.display = "none";
    document.getElementById('not-match-administrator-newpassword').style.display = "none";
    document.getElementById('not-match-administrator-repassword').style.display = "none";
    document.getElementById('not-match-current-password').style.display = "none";

    //パスワード未入力チェック
    if(!inputAdministratorPassword){
        document.getElementById('edit-is-administrator-password').style.display = "block";
        blankFlag = true;
    }else{
         currentPasswordCheck(inputAdministratorPassword,currentAdministratorPassword).then((result) => {
            blankFlag = result;
         });
    }

    //新しいパスワード未入力チェック
    if(!newAdministratorPassword && !newAdministratorRepassword){
        document.getElementById('edit-is-administrator-newpassword').style.display = "block";
        document.getElementById('edit-is-administrator-repassword').style.display = "block";
        blankFlag = true;
    }else if(!newAdministratorPassword){
        document.getElementById('edit-is-administrator-newpassword').style.display = "block";
        blankFlag = true;
    }else if(!newAdministratorRepassword){
        document.getElementById('edit-is-administrator-repassword').style.display = "block";
        blankFlag = true;

    //新しいパスワードが一致するかチェック
    }else if(newAdministratorPassword != newAdministratorRepassword){
        document.getElementById('not-match-administrator-newpassword').style.display = "block";
        document.getElementById('not-match-administrator-repassword').style.display = "block";
        blankFlag = true;
    }
    return blankFlag;
}


//現在のパスワードチェック
function currentPasswordCheck(inputAdministratorPassword,currentAdministratorPassword){
    var method = "EditVerifyAdministratorUser";
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '../kanrisya_front/ajax/ajaxManager.php',
            type: 'POST',
            dataType: 'json',
            data: {Method: method,
            inputPassword: inputAdministratorPassword,
            currentPassword: currentAdministratorPassword
        }
        })
        .done(function(data) {
            if(!data){
                document.getElementById('not-match-current-password').style.display = "block";
                resolve(true);
            }else{
                resolve(false);
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.log("XMLHttpRequest : " + XMLHttpRequest.status);
            console.log("textStatus     : " + textStatus);
            console.log("errorThrown    : " + errorThrown.message);
            reject("通信エラーがおきました");
        });
    })
}
