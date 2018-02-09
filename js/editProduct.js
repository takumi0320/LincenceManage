window.onload = function() {
    var script = $('#script');
    getProductId = JSON.parse(script.attr('data-product-id'));
    var method = "GetDetailsProduct";
    $.ajax({
        url: '../kanrisya_front/ajax/ajaxManager.php',
        type: 'POST',
        dataType: 'json',
        data: {Method: method,
               ProductId: getProductId
              }
    })
    .done(function(data) {
        var productData = data;
        if (productData !== null) {
            document.getElementById("inputProductName").value = productData[0]["ProductName"];
            document.getElementById("inputProductPhonetic").value = productData[0]["ProductKana"];
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
    var productName = null;
    var productKana = null;
    var blankFlag = false;
    $(function(){
    productName = $('input[name=productName]').val();
    productKana = $('input[name=productKana]').val();
    });
    //システム情報未入力チェック
    document.getElementById('edit-is-product-name').style.display = "none";
    document.getElementById('edit-is-product-kana').style.display = "none";

    if(!productName){
        document.getElementById('edit-is-product-name').style.display = "block";
        blankFlag = true;
    }
    if(!productKana){
        document.getElementById('edit-is-product-kana').style.display = "block";
        blankFlag = true;
    }
    if (blankFlag) {
        return false;
    }else{
        return true;
    }
}
