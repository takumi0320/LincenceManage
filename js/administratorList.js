var loadLimit = 20;//表示件数
var tableData;
var administratorListTable;
var dataLength;
var administratorListNumber;
var restDataLength;//残りデータ数
var loadCount;//読み込みボタン押下回数
// windowが読み込まれた時
window.onload = function() {
    var method = "GetAdministratorUser";
    $.ajax({
        url: '../kanrisya_front/ajax/ajaxManager.php',
        type: 'POST',
        dataType: 'json',
        data: {Method: method}
    })
    .done(function(data) {
            tableData = data;
        if (tableData !== null) {
            if(tableData.length == 0){
                document.getElementById("administrator-table").style.display ="none";
                document.getElementById("administrator-error").style.display ="block";
            }
            console.log(tableData);
            administratorListTable = document.getElementById("administratorListTable");
            dataLength = tableData.length;
            if(dataLength > loadLimit){
                MoreloadLimit(loadLimit,tableData,administratorListTable,dataLength);
                administratorListNumber = loadLimit;
                loadCount = 2;
            }else{
                LessloadLimit(tableData,administratorListTable,dataLength);
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

//管理者アカウント情報が20件以上
function MoreloadLimit(loadLimit,tableData,administratorListTable,dataLength){
    for (var i = 0; i < loadLimit; i++) {
        var row = administratorListTable.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var editbutton = '<button type="button" class="btn btn-info " id="editAdministratorId' + i + '" value="'+ tableData[i]["AdministratorId"] +'" onclick="edit_click(value)">パスワード編集</button>';
        var deletebutton = '<button type="button" class="btn btn-danger" data-toggle="modal" id="deleteAdministratorId' + i + '" data-target="#administratorDeleteModal" data-whatever="'+tableData[i]["AdministratorId"]+'">削除</button>';
        cell1.textContent = i + 1;
        cell2.textContent = tableData[i]["AdministratorId"];
        cell3.innerHTML = editbutton;
        cell4.innerHTML = deletebutton;
        document.getElementById("loadAdministratorListButton").style.display ="inline-block";
    }
}

//管理者アカウント情報が20件未満
function LessloadLimit(tableData,administratorListTable,dataLength){
    for (var i = 0; i < dataLength; i++) {
        var row = administratorListTable.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var editbutton = '<button type="button" class="btn btn-info " id="editAdministratorId'+ i +'" value="'+ tableData[i]["AdministratorId"] +'" onclick="edit_click(value)">パスワード編集</button>';
        var deletebutton = '<button type="button" class="btn btn-danger" data-toggle="modal" id="deleteAdministratorId' + i + '" data-target="#administratorDeleteModal" data-whatever="'+tableData[i]["AdministratorId"]+'">削除</button>';
        cell1.textContent = i + 1;
        cell2.textContent = tableData[i]["AdministratorId"];
        cell3.innerHTML = editbutton;
        cell4.innerHTML = deletebutton;
        document.getElementById("loadAdministratorListButton").style.visibility ="hidden";
    }
}

//読み込みボタン押下
function load_click(){
    restDataLength =  dataLength - loadLimit;
    if(restDataLength >= loadLimit){
        dataLength = restDataLength;
        for (var i = administratorListNumber; i < loadLimit * loadCount ; i++) {
            var row = administratorListTable.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var editbutton = '<button type="button" class="btn btn-info " id="editAdministratorId' + i + '" value="'+ tableData[i]["AdministratorId"] +'" onclick="edit_click(value)">パスワード編集</button>';
            var deletebutton = '<button type="button" class="btn btn-danger" data-toggle="modal" id="deleteAdministratorId' + i + '" data-target="#administratorDeleteModal" data-whatever="'+tableData[i]["AdministratorId"]+'">削除</button>';
            cell1.textContent = i+1;
            cell2.textContent = tableData[i]["AdministratorId"];
            cell3.innerHTML = editbutton;
            cell4.innerHTML = deletebutton;
            document.getElementById("loadAdministratorListButton").style.display ="inline-block";
        }
        loadCount++;
        administratorListNumber += loadLimit;
    }
    else if(restDataLength <= loadLimit){
        dataLength = administratorListNumber + restDataLength;
        for (var i = administratorListNumber; i < dataLength; i++) {
            var row = administratorListTable.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var editbutton = '<button type="button" class="btn btn-info " id="editAdministratorId' + i + '" value="'+ tableData[i]["AdministratorId"] +'" onclick="edit_click(value)">パスワード編集</button>';
            var deletebutton = '<button type="button" class="btn btn-danger" data-toggle="modal" id="deleteAdministratorId' + i + '" data-target="#administratorDeleteModal" data-whatever="'+ tableData[i]["AdministratorId"] +'">削除</button>';
            cell1.textContent = i+1;
            cell2.textContent = tableData[i]["AdministratorId"];
            cell3.innerHTML = editbutton;
            cell4.innerHTML = deletebutton;
            document.getElementById("loadAdministratorListButton").style.display ="none";
        }
    }
}

//リスト内システム削除ボタン押下
$('#administratorDeleteModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) //モーダルを呼び出すときに使われたボタンを取得
    document.getElementById("deleteAdministratorButton").val = button.data('whatever') //data-whatever の値を取得
})

//モーダル内システム削除ボタン押下
 function delete_click(){
     var deleteAdministratorID = document.getElementById("deleteAdministratorButton").val;
     var method = 'DeleteAdministratorUser';
     $.ajax({
         url: '../kanrisya_front/ajax/ajaxManager.php',
         type: 'POST',
         dataType: 'json',
         data: {Method: method,
                AdministratorID: deleteAdministratorID}
     })
     .done(function(data) {
     $('#administratorDeleteModal').modal('hide');
     location.reload();
     })
     .fail(function(jqXHR, textStatus, errorThrown) {
         console.log("XMLHttpRequest : " + XMLHttpRequest.status);
         console.log("textStatus     : " + textStatus);
         console.log("errorThrown    : " + errorThrown.message);
         alert("通信エラーがおきました");
     });

}

//管理者アカウント編集ボタン押下
function edit_click(editAdministratorId){
    location.href ='../kanrisya_front/editAdministrator.php?AdministratorID='+ editAdministratorId;

}
