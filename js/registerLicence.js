var script = $('#script');
var optionList = JSON.parse(script.attr('data-option-list'));
var optionCount = 1;

//＋ボタンを押された時フォームを追加するためのスクリプト
function optionAdd() {
    var optionListToHtml =  makeOptionList();
    var optionAddForm = ''+   //フォームのクローンをoptionAddFormの中に挿入
            '<div class="form-group col-xs-5">'+
                '<label class="control-label">オプション</label>'+
                    '<div class="dropdown">'+
                      '<select class="form-control" name="option[' + optionCount + '][optionId]">'+
                        '<option selected="selected" value="">-- 選択してください --</option>'+
                        optionListToHtml +
                      '</select>'+
                    '</div>'+
            '</div>'+
            '<div class="form-group col-xs-6">'+
                '<label>オプション期間</label>'+
                '<div class="period-group" date-provide="datepicker">'+
                    '<div class="form-period">'+
                        '<input id="option-begin-date-' + optionCount + '" type="text" name="option[' + optionCount + '][optionBeginDate]" class="form-control date">'+
                    '</div>'+
                    '<div class="control-label tilde">〜</div>'+
                    '<div class="form-period">'+
                        '<input id="option-end-date-' + optionCount + '" type="text" name="option[' + optionCount + '][optionEndDate]" class="form-control date">'+
                    '</div>'+
                '</div>'+
                '<div id="option-start-period-is-over-end-' + optionCount + '" class="alert alert-danger is-blank-error">終了日は開始日より後にしてください</div>'+
            '</div>';
    $(function () {
        $('div#form-add-frame').append(optionAddForm);
    });
    optionCount++;

    // カレンダーで日付指定をするためのスクリプト
    $(function () {
        //Default
        $('.date').datepicker({
            format: "yyyy年mm月dd日",
            language: 'ja'
        });
    });
}

// カレンダーで日付指定をするためのスクリプト
$(function () {
    //Default
    $('.date').datepicker({
        format: "yyyy年mm月dd日",
        language: 'ja'
    });
});

function randomPassword(){
    // 生成する文字列の長さ
    var length = 8;
    // 生成する文字列に含める文字セット
    var char = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    var charLength = char.length;
    var ramdom = "";
    for(var count=0; count<length; count++){
        ramdom += char[Math.floor(Math.random() * charLength)];
    }
    $('#text-password').val(ramdom);
    document.getElementById("modal-password").innerHTML = "<p>パスワードは<br>" + ramdom + "<br>です</p>";

}

// オプションリスト生成
function makeOptionList () {
    var optionListToHtml = "";
    for (var subscript in optionList) {
        optionListToHtml = optionListToHtml + '<option value="' + optionList[subscript]["OptionId"] + '">' + optionList[subscript]["OptionName"];
    }
    return optionListToHtml;
}

// フォームをsubmitできるかチェック
function formCheck () {
    var userId = document.getElementById('user-id').value;
    var blankFlag = true;
    blankFlag = isBlank();
    if (blankFlag) {
        return false;
    } else {
        UserIdCheck(userId).then((response) => {
            if (!response) {
                document.registerForm.submit();
            }
        });
    }
}

// 入力項目チェック
function isBlank () {
    var customerName = null;
    var customerNameKana = null;
    var userId = null;
    var password = null;
    var productId = null;
    var installCount = null;
    var licenceBeginDate = null;
    var licenceEndDate = null;
    var blankFlag = false; // trueだったら空値有り
    $(function(){
        customerName = $('input[name=customerName]').val();
        customerNameKana = $('input[name=customerNameKana]').val();
        userId = $('input[name=userId]').val();
        password = $('input[name=password]').val();
        productId = $('[name=productId]').val();
        installCount = $('[name=installCount]').val();
        licenceBeginDate = $('input[name=licenceBeginDate]').val();
        licenceEndDate = $('input[name=licenceEndDate]').val();
    });
    if (!customerName) {
        document.getElementById('customer-name-is-blank').style.display = "block";
        blankFlag = true;
    } else {
        document.getElementById('customer-name-is-blank').style.display = "none";
    }
    if (!customerNameKana) {
        document.getElementById('customer-name-kana-is-blank').style.display = "block";
        blankFlag = true;
    } else {
        document.getElementById('customer-name-kana-is-blank').style.display = "none";
    }
    if (!userId) {
        document.getElementById('user-id-is-blank').style.display = "block";
        document.getElementById('user-id-already').style.display = "none";
        blankFlag = true;
    } else {
        document.getElementById('user-id-is-blank').style.display = "none";
        UserIdCheck(userId).then((result) => {
            blankFlag = result;
        });
    }
    if (!password) {
        document.getElementById('password-is-blank').style.display = "block";
        blankFlag = true;
    } else {
        document.getElementById('password-is-blank').style.display = "none";
    }
    if (!productId) {
        document.getElementById('product-id-is-blank').style.display = "block";
        blankFlag = true;
    } else {
        document.getElementById('product-id-is-blank').style.display = "none";
    }
    if (!installCount) {
        document.getElementById('install-count-is-blank').style.display = "block";
        blankFlag = true;
    } else {
        document.getElementById('install-count-is-blank').style.display = "none";
    }
    if (!licenceBeginDate || !licenceEndDate) {
        document.getElementById('licence-period-is-blank').style.display = "block";
        document.getElementById("licence-start-period-is-over-end").style.display = "none";
        blankFlag = true;
    } else {
        document.getElementById('licence-period-is-blank').style.display = "none";
        if (LicencePeriodCheck()) {
            blankFlag = true;
        }
    }
    if (OptionPeriodCheck()) {
        blankFlag = true;
    }
    return blankFlag;
}

function UserIdCheck (userId) {
    var method = "GetUserFlag";
    return new Promise((resolve, reject) => {
        $.ajax({
            url: './ajax/ajaxManager.php',
            type: 'POST',
            dataType: 'json',
            data: {Method: method,
                    userId: userId}
        })
        .done(function(data) {
            if (data) {
                document.getElementById('user-id-already').style.display = "block";
                resolve(true);
            } else {
                document.getElementById('user-id-already').style.display = "none";
                resolve(false);
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.log("XMLHttpRequest : " + XMLHttpRequest.status);
            console.log("textStatus     : " + textStatus);
            console.log("errorThrown    : " + errorThrown.message);
            reject("error");
        })
    })
}

function LicencePeriodCheck () {
    var result = false;
    var beginDate = document.getElementById("licence-begin-date").value;
    var endDate = document.getElementById("licence-end-date").value;
    if (beginDate >= endDate) {
        document.getElementById("licence-start-period-is-over-end").style.display = "block";
        result = true;
    } else {
        document.getElementById("licence-start-period-is-over-end").style.display = "none";
    }
    return result;
}

function OptionPeriodCheck () {
    var result = false;
    for (var subscript = 0; subscript < optionCount; subscript++) {
        var beginDate = document.getElementById("option-begin-date-" + subscript).value;
        var endDate = document.getElementById("option-end-date-" + subscript).value;
        if (beginDate && endDate) {
            if (beginDate >= endDate) {
                document.getElementById("option-start-period-is-over-end-" + subscript).style.display = "block";
                result = true;
            } else {
                document.getElementById("option-start-period-is-over-end-" + subscript).style.display = "none";
            }
        }
    }
    return result;
}

function StringDateReplace (targetString) {
    var result = targetString.replace(/年|月|日/g, "");
    return result;
}
