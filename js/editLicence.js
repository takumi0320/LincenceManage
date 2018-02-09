var getUserId;
var getCustomerId;
var licenceData;
var optionData;
var optionCount = 1;
var formBottom = 0;
// windowが読み込まれた時
window.onload = function() {
    //GETの受信
    var script = $('#script');
    getCustomerId = JSON.parse(script.attr('data-customer-id'));
    getUserId = JSON.parse(script.attr('data-user-id'));
    var method = "GetDetailsLicence";
    $.ajax({
        url: '../kanrisya_front/ajax/ajaxManager.php',
        type: 'POST',
        dataType: 'json',
        data: {Method: method,
               UserID: getUserId,
               customerId: getCustomerId}

    })
    .done(function(data) {
        licenceData = data;
        var licenceDetail = licenceData.licenceInformation;
        var licenceOption = licenceData.licenceInformation.LicenceOptionList;
        console.log(licenceDetail);
        console.log(licenceOption);
        var method = "GetOption";
        $.ajax({
            url: '../kanrisya_front/ajax/ajaxManager.php',
            type: 'POST',
            dataType: 'json',
            data: {Method: method,
                   UserID: getUserId}
        })
        .done(function(data) {
            optionData = data;
            console.log(optionData);
            if (licenceData !== null && optionData  !== null) {
                document.getElementById("editCustomerName").textContent= '株式会社'+licenceData.customerName+'様';
                document.getElementById("editUserId").textContent= licenceData.productName+'ライセンス編集';
                // ライセンス数表示
                if (licenceDetail.ContractCountLicence) {
                    for(var i = 1;  i <= 30; i++){
                        if(i == licenceDetail.ContractCountLicence){
                            $('#numberLicenceChange').append('<option selected="selected" >' + i + '</option>');
                        }else{
                            $('#numberLicenceChange').append('<option>' + i + '</option>');
                        }
                    }
                } else {
                    document.getElementById('licence-count-top').selected = "selected"
                    for(var i = 1;  i <= 30; i++){
                        $('#numberLicenceChange').append('<option>' + i + '</option>');
                    }
                }
                
                //ライセンス期間表示
                document.getElementById("licence-begin-date").value = licenceDetail.BeginDate;
                document.getElementById("licence-end-date").value = licenceDetail.EndDate;

                //オプション名・期間表示
                for(var i = 0; i <  licenceOption.length; i++){
                    if(i  == 0 ){
                        for(var c = 0;  c < optionData.length; c++){
                            if(licenceOption[i].OptionId == optionData[c].OptionId){
                                $('#optionNameSelect').append('<option selected="selected" value="'+ licenceOption[i].OptionId +'">' + licenceOption[i].OptionName + '</option>');
                            }else{
                                $('#optionNameSelect').append('<option value="'+ optionData[c].OptionId +'">' + optionData[c].OptionName + '</option>');
                            }
                        }
                        document.getElementById("option-begin-date-0").value = licenceOption[i].BeginDate;
                        document.getElementById("option-end-date-0").value = licenceOption[i].EndDate;
                    }else{
                        optionCount++;
                        var formAdd = $('<div class="form-group col-xs-5" id="optionGroup"><label class="control-label">オプション</label><div class="dropdown"><select class="form-control" id="optionNameSelect' + i + '" name="option[' + optionCount + '][optionId]"><option selected="selected" value="'+licenceOption[i].OptionId+'">'+ licenceOption[i].OptionName +'</option></select></div></div><div class="form-group col-xs-6" id="optionPeriod"><label>オプション期間</label><div class="period-group" date-provide="datepicker"><div class="form-period"><input id="option-begin-date-' + i + '" type="text" class="form-control date" name="option[' + optionCount + '][beginDate]"></div><div class="control-label tilde">〜</div><div class="form-period"><input id="option-end-date-' + i + '" type="text" class="form-control date" name="option[' + optionCount + '][endDate]"></div></div><div id="option-start-period-is-over-end-' + i + '" class="alert alert-danger is-blank-error">終了日は開始日より後にしてください</div>');
                        if( i == 1){
                            $('#formAddFrame').append(formAdd);
                        }else{
                            $('#formAddFrame').append(formAdd);
                        }
                        document.getElementById("option-begin-date-"+i).value = licenceOption[i].BeginDate;
                        document.getElementById("option-end-date-"+i).value = licenceOption[i].EndDate;

                        for(var c = 0;  c < optionData.length; c++){
                            if(licenceOption[i].OptionId != optionData[c].OptionId){
                                $('#optionNameSelect'+ i).append('<option value="'+ optionData[c].OptionId +'">' + optionData[c].OptionName + '</option>');

                            }
                        }
                        $('#optionNameSelect'+ i).append('<option value=""></option>');
                        formBottom++;
                    }
                    // カレンダーで日付指定をするためのスクリプト
                    $(function () {
                        //Default
                        $('.date').datepicker({
                            format: "yyyy年mm月dd日",
                            language: 'ja'
                        });
                    });
                }
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.log("XMLHttpRequest : " + XMLHttpRequest.status);
            console.log("textStatus     : " + textStatus);
            console.log("errorThrown    : " + errorThrown.message);
            alert("通信エラーがおきました");
        });

    })
    .fail(function(jqXHR, textStatus, errorThrown) {
        console.log("XMLHttpRequest : " + XMLHttpRequest.status);
        console.log("textStatus     : " + textStatus);
        console.log("errorThrown    : " + errorThrown.message);
        alert("通信エラーがおきました");
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

//追加ボタン押下したときの処理
function optionAdd() {
    var formAdd = $('<div class="form-group col-xs-5" id="optionGroup"><label class="control-label">オプション</label><div class="dropdown"><select class="form-control" id="optionNameSelect'+ optionCount +'" name="option[' + optionCount + '][optionId]"><option value="" id="licence-count-top">-- 選択してください --</option></select></div></div><div class="form-group col-xs-6" id="optionPeriod"><label>オプション期間</label><div class="period-group" date-provide="datepicker"><div class="form-period"><input id="option-begin-date-'+ optionCount +'" type="text" class="form-control date" name="option[' + optionCount + '][beginDate]"></div><div class="control-label tilde">〜</div><div class="form-period"><input id="option-end-date-'+ optionCount +'" type="text" class="form-control date" name="option[' + optionCount +'][endDate]"></div></div><div id="option-start-period-is-over-end-' + optionCount + '" class="alert alert-danger is-blank-error">終了日は開始日より後にしてください</div></div>');
    $("#formAddFrame").append(formAdd);
    for(var i = 0;  i < optionData.length; ++i){
            $('#optionNameSelect'+ optionCount).append('<option value="'+ optionData[i].OptionId +'">' + optionData[i].OptionName + '</option>');
    }
    optionCount++;
    console.log('optionAdd');

    // カレンダーで日付指定をするためのスクリプト
    $(function () {
        //Default
        $('.date').datepicker({
            format: "yyyy年mm月dd日",
            language: 'ja'
        });
    });
}

// フォームをsubmitできるかチェック
function formCheck() {
    var numberLicence = null;
    var licenceBeginDate = null;
    var licenceEndDate = null;
    var optionId =  [];
    var optionBeginDate =  [];
    var optionEndDate =  [];
    var blankFlag = false; // trueだったら空値有り
    $(function(){
    numberLicence = $('select[name=numberLicence]').val();
    licenceBeginDate = $('input[name=licenceLower]').val();
    licenceEndDate = $('input[name=licenceUpper]').val();
    });
    //ライセンス情報未入力チェック
    if(!numberLicence){
        blankFlag = true;
        document.getElementById("install-count-is-blank").style.display = "block";
    } else {
        document.getElementById("install-count-is-blank").style.display = "none";
    }
    if (!licenceBeginDate || !licenceEndDate) {
        blankFlag = true;
        document.getElementById("licence-period-is-blank").style.display = "block";
        document.getElementById("licence-start-period-is-over-end").style.display = "none"; 
    } else {
        document.getElementById("licence-period-is-blank").style.display = "none";
        //ライセンス期間チェック
        if (LicencePeriodCheck()) {
            blankFlag = true;
        }
    }
    //オプション期間チェック
    if (OptionPeriodCheck()) {
        blankFlag = true;
    }
    // 最終判定
    if (blankFlag) {
        return false;
    }else{
        // submitさせる
        document.updateForm.submit();
    }
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