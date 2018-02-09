var loadLimit = 20;//表示件数
var tableData;
var userListTable;
var dataLength;
var userListNumber;
var restDataLength;//残りデータ数
var loadCount;//読み込みボタン押下回数
var userListColumn;
// windowが読み込まれた時
window.onload = function() {
    var method = "GetCustomerUser";
    $.ajax({
        url: '../kanrisya_front/ajax/ajaxManager.php',
        type: 'POST',
        dataType: 'json',
        data: {Method: method}
    })
    .done(function(data) {
            tableData = data;
        if (tableData !== null) {
            console.log(tableData);
            userListTable = document.getElementById("userListTable");
            dataLength = tableData.length;
            if(dataLength > loadLimit){
                MoreloadLimit(loadLimit,tableData,userListTable,dataLength);
                userListNumber = loadLimit;
                loadCount = 2;
            }else{
                LessloadLimit(tableData,userListTable,dataLength);
            }
        }
        document.getElementById("notSearch").style.display ="block";
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
        console.log("XMLHttpRequest : " + XMLHttpRequest.status);
        console.log("textStatus     : " + textStatus);
        console.log("errorThrown    : " + errorThrown.message);
        alert("通信エラーがおきました");
    });
}

//ユーザー情報が20件以上
function MoreloadLimit(loadLimit,tableData,userListTable,dataLength){
    for (var i = 0; i < loadLimit; i++) {
        var row = userListTable.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var userName = '<a href="./licenceList.php?CustomerID='+tableData[i]["CustomerId"]+'">'+tableData[i]["CustomerName"]+'</a>';
        cell1.textContent = i + 1;
        cell2.innerHTML = userName;
        console.log("innter");
    }
    var loadUserList = document.getElementById("loadUserList");
    loadUserList.innerHTML = '<button type="button" class="btn btn-default text-center" id="loadUserListButton" onclick="load_click()">さらに読み込む</button>';
}

//ユーザー情報が20件未満
function LessloadLimit(tableData,userListTable,dataLength){
    for (var i = 0; i < dataLength; i++) {
        var row = userListTable.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var userName = '<a href="./licenceList.php?CustomerID='+tableData[i]["CustomerId"]+'">'+tableData[i]["CustomerName"]+'</a>';
        cell1.textContent = i + 1;
        cell2.innerHTML = userName;
        console.log("innter");
    }
    document.getElementById("loadUserListButton").style.visibility ="hidden";

}

//読み込みボタン押下
function load_click(){
    restDataLength =  dataLength - loadLimit;
    if(restDataLength >= loadLimit){
        dataLength = restDataLength;
        for (var i = userListNumber; i < loadLimit * loadCount ; i++) {
            var row = userListTable.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var userName = '<a href="./licenceList.php?CustomerID='+tableData[i]["CustomerId"]+'">'+tableData[i]["CustomerName"]+'</a>';
            cell1.textContent = i+1;
            cell2.innerHTML = userName;
            console.log("innter");
        }
        loadCount++;
        userListNumber += loadLimit;
        var loadUserList = document.getElementById("loadUserList");
        loadUserList.innerHTML = '<button type="button" class="btn btn-default text-center" id="loadUserListButton" onclick="load_click()">さらに読み込む</button>';

    }
    else if(restDataLength <= loadLimit){
        dataLength = userListNumber + restDataLength;
        for (var i = userListNumber; i < dataLength; i++) {
            var row = userListTable.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var userName = '<a href="./licenceList.php?CustomerID='+tableData[i]["CustomerId"]+'">'+tableData[i]["CustomerName"]+'</a>';
            cell1.textContent = i+1;
            cell2.innerHTML = userName;
            console.log("innter");
        }
        document.getElementById("loadUserListButton").style.visibility ="hidden";

    }
}

//エンターキーで検索
function search_enter(key){
    if(key == 13){
        search_click();
    }
}

//検索ボタン押下
function search_click(){
    var searchCustomerWord = document.getElementById("searchUserName").value;
    var method = 'SearchCustomerUser';
    $.ajax({
        url: '../kanrisya_front/ajax/ajaxManager.php',
        type: 'POST',
        dataType: 'json',
        data: {Method: method,
               CustomerName: searchCustomerWord}
    })
    .done(function(data) {
    document.getElementById("notSearch").style.display ="none";
    tableData = data;
    if (tableData !== null) {
        //検索結果0件
        if(tableData.length == 0){
            $(".product-list-column").empty();
            $(".product-list-value").empty();
            document.getElementById("notSearch").style.display ="block";
            document.getElementById("loadUserListButton").style.visibility ="hidden";

        }else{
            console.log(tableData);
            userListColumn = document.getElementById("userListColumn");
            userListColumn.innerHTML = '<th class="product-list-number col-xs-1">#</th><th class="product-list-titile col-xs-10">顧客名</th>';
            $(".product-list-value").empty();
            userListTable = document.getElementById("userListTable");
            dataLength = tableData.length;
            if(dataLength > loadLimit){
                MoreloadLimit(loadLimit,tableData,userListTable,dataLength);
                userListNumber = loadLimit;
                loadCount = 2;
            }else{
                LessloadLimit(tableData,userListTable,dataLength);
            }
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
