var getUserId;
var getCustomerId;
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
                UserID :getUserId,
                customerId: getCustomerId}
    })
    .done(function(data) {
            licenceData = data;
        if (licenceData !== null) {
            getCustomerName = licenceData.customerName;
            document.getElementById("pushCustomerName").textContent= '株式会社'+licenceData.customerName+'様';
            document.getElementById("detailUserID").textContent= licenceData.productName+'ライセンス詳細';
            document.getElementById("pushUserID").textContent= getUserId;
            document.getElementById("pushProductName").textContent= licenceData.productName;
            document.getElementById("pushNumberContractLicence").textContent= licenceData.licenceInformation.ContractCountLicence;
            document.getElementById("pushLicencePeriod").textContent= licenceData.licenceInformation.BeginDate +'　〜　'+ licenceData.licenceInformation.EndDate;
            if (licenceData.licenceInformation.LicenceOptionList && licenceData.licenceInformation.LicenceOptionList.length > 0) {
                for(var i = 0; i < licenceData.licenceInformation.LicenceOptionList.length; i++){
                    if(i == 0){
                        $('#pushProductOptionName').append(licenceData.licenceInformation.LicenceOptionList[i].OptionName);
                        $('#pushOptionPeriod').append(licenceData.licenceInformation.LicenceOptionList[i].BeginDate +'　〜　'+ licenceData.licenceInformation.LicenceOptionList[i].EndDate);
                    }else{
                        var div = $('<tr class="product-list-column" id="licenceOptionListColumn"><td class="detail-title"></td><td class="detail-title">オプション名</td><td class="detail-title"></td><td class="detail-title">オプション期間</td><td class="detail-title"></td></tr><tr class="product-list-column" id="licenceOptionListValue"><td></td><td class="detail-content" id="pushProductOptionName'+i+'"></td><td></td><td class="detail-content" id="pushOptionPeriod'+i+'"></td><td></td></tr>');
                        $('#detailTable').append(div);
                        $('#pushProductOptionName'+i+'').append(licenceData.licenceInformation.LicenceOptionList[i].OptionName);
                        $('#pushOptionPeriod'+i+'').append(licenceData.licenceInformation.LicenceOptionList[i].BeginDate +'　〜　'+ licenceData.licenceInformation.LicenceOptionList[i].EndDate);
    
                    }
                }
            } else {
                document.getElementById('licenceOptionListColumn').style.display = "none";
                document.getElementById('licenceOptionListValue').style.display = "none";
            }
        }
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
        console.log("XMLHttpRequest : " + XMLHttpRequest.status);
        console.log("textStatus     : " + textStatus);
        console.log("errorThrown    : " + errorThrown.message);
        alert("通信エラーがおきました");
    });
}

//ライセンス編集ボタン押下
function edit_click(){
    location.href ='../kanrisya_front/editLicence.php?CustomerID='+ getCustomerId + '&UserID='+ getUserId;
}
//モーダル内ライセンス削除ボタン押下
 function deleteClick(){
     var method = 'DeleteLicence';
     $.ajax({
         url: '../kanrisya_front/ajax/ajaxManager.php',
         type: 'POST',
         dataType: 'json',
         data: {Method: method,
                UserID: getUserId}
     })
     .done(function(data) {
        $('#LicenceDeleteModal').modal('hide');
        location.href = '../kanrisya_front/licenceList.php?CustomerID=' + getCustomerId;
     })
     .fail(function(jqXHR, textStatus, errorThrown) {
         console.log("XMLHttpRequest : " + XMLHttpRequest.status);
         console.log("textStatus     : " + textStatus);
         console.log("errorThrown    : " + errorThrown.message);
         alert("通信エラーがおきました");
     });

}
