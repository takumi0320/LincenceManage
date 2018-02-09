var loadLimit = 20;//表示件数
var tableData;
var licenceListTable;
var dataLength;
var LicenceListNumber;
var restDataLength;//残りデータ数
var loadCount;//読み込みボタン押下回数

var $script = $('#script');
var customerId = JSON.parse($script.attr('data-customer-id'));
// windowが読み込まれた時
window.onload = function() {
    // customerIdが存在するかどうか
    if (customerId) {
        var method = "GetLicence";
        $.ajax({
            url: '../kanrisya_front/ajax/ajaxManager.php',
            type: 'POST',
            dataType: 'json',
            data: {
                Method: method,
                CustomerID: customerId
            }
        })
        .done(function(data) {
            tableData = data;
            if (tableData !== null) {
                console.log(tableData);
                // 返ってきた値の中身があるか
                if (tableData[0].length > 0) {
                    document.getElementById("customer-name").innerHTML='<h2 id="customer-name" class="licence-list-title">'+tableData[0][0]["CustomerName"]+'</h2>';
                    licenceListTable = document.getElementById("licenceListTable");
                    dataLength = tableData[1].length;
                    if(dataLength > loadLimit){
                        MoreloadLimit(loadLimit,tableData,licenceListTable,dataLength);
                        LicenceListNumber = loadLimit;
                        loadCount = 2;
                        document.getElementById("loadLicenceListButton").style.display = "inline-block";
                    }else if(dataLength>=1){
                        LessloadLimit(tableData,licenceListTable,dataLength);
                    } else {
                        document.getElementById("licence-list").style.display = "none";
                        document.getElementById("licence-error").style.display ="block";
                    }
                } else {
                    document.getElementById("customer-name").style.display = "none";
                    document.getElementById("licence-list").style.display = "none";
                    document.getElementById("not-selected").style.display ="block";
                }
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.log("XMLHttpRequest : " + XMLHttpRequest.status);
            console.log("textStatus     : " + textStatus);
            console.log("errorThrown    : " + errorThrown.message);
            alert("通信エラーがおきました");
        });
    } else {
        document.getElementById("customer-name").style.display = "none";
        document.getElementById("licence-list").style.display = "none";
        document.getElementById("not-selected").style.display ="block";
    }
}

//システム情報が20件以上
function MoreloadLimit(loadLimit,tableData,licenceListTable,dataLength){
    for (var i = 0; i < loadLimit; i++) {
        var row = licenceListTable.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);
        var button = '<a href="./licenceDetail.php?CustomerID=' + customerId + '&UserID=' + tableData[1][i]["UserId"] + '" class="btn btn-info" onClick="'+url +'">詳細';
        cell1.textContent = i + 1;
        cell2.textContent = tableData[1][i]["UserId"];
        cell3.textContent = tableData[1][i]["CustomerId"];
        cell4.textContent = tableData[1][i]["BeginDate"] + " ～ " + tableData[1][i]["EndDate"];
        cell5.innerHTML = button;
        console.log("innter");
    }
}

//システム情報が20件未満
function LessloadLimit(tableData,licenceListTable,dataLength){
    for (var i = 0; i < dataLength; i++) {
        var row = licenceListTable.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);
        var button = '<a href="./licenceDetail.php?CustomerID=' + customerId + '&UserID=' + tableData[1][i]["UserId"] + '" class="btn btn-info">詳細';
        cell1.textContent = i + 1;
        cell2.textContent = tableData[1][i]["UserId"];
        cell3.textContent = tableData[1][i]["CustomerId"];
        cell4.textContent = tableData[1][i]["BeginDate"] + " ～ " + tableData[1][i]["EndDate"];
        cell5.innerHTML = button;
        document.getElementById("loadLicenceListButton").style.visibility ="hidden";
        console.log("innter");
    }
}

//読み込みボタン押下
function load_click(){
    restDataLength =  dataLength - loadLimit;
    if(restDataLength >= loadLimit){
        dataLength = restDataLength;
        for (var i = LicenceListNumber; i < loadLimit * loadCount ; i++) {
            var row = licenceListTable.insertRow(-1);
            var row = licenceListTable.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);
            var button = '<a href="./licenceDetail.php?CustomerID=' + customerId + '&UserID=' + tableData[1][i]["UserId"] + '" class="btn btn-info">詳細';
            cell1.textContent = i + 1;
            cell2.textContent = tableData[1][i]["UserId"];
            cell3.textContent = tableData[1][i]["CustomerId"];
            cell4.textContent = tableData[1][i]["BeginDate"] + " ～ " + tableData[1][i]["EndDate"];
            cell5.innerHTML = button;
            console.log("innter");
        }
        loadCount++;
        LicenceListNumber += loadLimit;
    }
    else if(restDataLength <= loadLimit){
        dataLength = LicenceListNumber + restDataLength;
        for (var i = LicenceListNumber; i < dataLength; i++) {
            var row = licenceListTable.insertRow(-1);
            var row = licenceListTable.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);
            var button = '<a href="./licenceDetail.php?CustomerID=' + customerId + '&UserID=' + tableData[1][i]["UserId"] + '" class="btn btn-info">詳細';
            cell1.textContent = i + 1;
            cell2.textContent = tableData[1][i]["UserId"];
            cell3.textContent = tableData[1][i]["CustomerId"];
            cell4.textContent = tableData[1][i]["BeginDate"] + " ～ " + tableData[1][i]["EndDate"];
            cell5.innerHTML = button;
            console.log("innter");
        }
        document.getElementById("loadLicenceListButton").style.visibility ="hidden";
    }
}
