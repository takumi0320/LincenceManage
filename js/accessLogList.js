var loadLimit = 20;//表示件数
var tableData;
var accessLogListTable;
var dataLength;
var AccessLogListNumber;
var restDataLength;//残りデータ数
var loadCount;//読み込みボタン押下回数


// windowが読み込まれた時
window.onload = function() {
    var logscript = $('#logscript');
    var logFileFlag = JSON.parse(logscript.attr('data-file-flag'));
    if(logFileFlag){
        window.location.href = "./logCsvDownload.php";
        logFileFlag = false;
    }
    var method = "GetAccessLog";
    $.ajax({
        url: '../kanrisya_front/ajax/ajaxManager.php',
        type: 'POST',
        dataType: 'json',
        data: {
            Method: method
        }
    })
    .done(function(data) {
        tableData = data;
        console.log(tableData);
        if (tableData !== null) {
            // 返ってきた値の中身があるか
            if (tableData.length > 0) {
                accessLogListTable = document.getElementById("accessLogListTable");
                dataLength = tableData.length;
                if(dataLength > loadLimit){
                    MoreloadLimit(loadLimit,tableData,accessLogListTable,dataLength);
                    AccessLogListNumber = loadLimit;
                    loadCount = 2;
                    document.getElementById("loadLicenceListButton").style.display = "inline-block";
                }else if(dataLength>=1){
                    LessloadLimit(tableData,accessLogListTable,dataLength);
                    document.getElementById("loadLicenceListButton").style.display = "none";
                }
            } else {
                document.getElementById("accessLoglist-table").style.display = "none";
                document.getElementById("loadLicenceListButton").style.display = "none";
                document.getElementById("accessLogExport").style.display = "none";
                document.getElementById("licence-error").style.display ="block";
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

//システム情報が20件以上
function MoreloadLimit(loadLimit,tableData,accessLogListTable,dataLength){
    for (var i = 0; i < loadLimit; i++) {
        var row = accessLogListTable.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        cell1.textContent = i + 1;
        cell2.textContent = tableData[i]["SecurityId"];
        cell3.textContent = tableData[i]["IpAddress"];
        cell4.textContent = tableData[i]["BrowserName"];
        console.log("innter");
    }
}

//システム情報が20件未満
function LessloadLimit(tableData,accessLogListTable,dataLength){
    for (var i = 0; i < dataLength; i++) {
        var row = accessLogListTable.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        cell1.textContent = i + 1;
        cell2.textContent = tableData[i]["SecurityId"];
        cell3.textContent = tableData[i]["IpAddress"];
        cell4.textContent = tableData[i]["BrowserName"];
        console.log("innter");
    }
}

//読み込みボタン押下
function load_click(){
    restDataLength =  dataLength - loadLimit;
    if(restDataLength >= loadLimit){
        dataLength = restDataLength;
        for (var i = AccessLogListNumber; i < loadLimit * loadCount ; i++) {
            var row = accessLogListTable.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            cell1.textContent = i + 1;
            cell2.textContent = tableData[i]["SecurityId"];
            cell3.textContent = tableData[i]["IpAddress"];
            cell4.textContent = tableData[i]["BrowserName"];
            console.log("innter");
        }
        loadCount++;
        AccessLogListNumber += loadLimit;
    }
    else if(restDataLength <= loadLimit){
        dataLength = AccessLogListNumber + restDataLength;
        for (var i = AccessLogListNumber; i < dataLength; i++) {
            var row = accessLogListTable.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            cell1.textContent = i + 1;
            cell2.textContent = tableData[i]["SecurityId"];
            cell3.textContent = tableData[i]["IpAddress"];
            cell4.textContent = tableData[i]["BrowserName"];
            console.log("innter");
        }
        document.getElementById("loadLicenceListButton").style.visibility ="hidden";
    }
}
