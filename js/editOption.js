window.onload = function() {
    var script = $('#script');
    getOptionId = JSON.parse(script.attr('data-option-id'));
    var method = "GetDetailsOption";
    $.ajax({
        url: '../kanrisya_front/ajax/ajaxManager.php',
        type: 'POST',
        dataType: 'json',
        data: {Method: method,
               OptionId: getOptionId
              }
    })
    .done(function(data) {
        var optionData = data;
        if (optionData !== null) {
            document.getElementById("inputOptionName").value = optionData[0]["OptionName"];
            document.getElementById("inputOptionPhonetic").value = optionData[0]["OptionKana"];
        }
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
    var optionName = null;
    var optionKana = null;
    var blankFlag = false;
    $(function(){
    optionName = $('input[name=optionName]').val();
    optionKana = $('input[name=optionKana]').val();
    });
    //オプション情報未入力チェック
    document.getElementById('edit-is-option-name').style.display = "none";
    document.getElementById('edit-is-option-kana').style.display = "none";

    if(!optionName){
        document.getElementById('edit-is-option-name').style.display = "block";
        blankFlag = true;
    }
    if(!optionKana){
        document.getElementById('edit-is-option-kana').style.display = "block";
        blankFlag = true;
    }
    if (blankFlag) {
        return false;
    }else{
        return true;
    }
}
