var loadLimit = 20;//表示件数
var tableData;
var optionListTable;
var dataLength;
var optionListNumber;
var restDataLength;//残りデータ数
var loadCount;//読み込みボタン押下回数
// windowが読み込まれた時
window.onload = function() {
    var method = "GetOption";
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
                document.getElementById("option-table").style.display ="none";
                document.getElementById("option-error").style.display ="block";
            }
            console.log(tableData);
            optionListTable = document.getElementById("optionListTable");
            dataLength = tableData.length;
            if(dataLength > loadLimit){
                MoreloadLimit(loadLimit,tableData,optionListTable,dataLength);
                optionListNumber = loadLimit;
                loadCount = 2;
            }else{
                LessloadLimit(tableData,optionListTable,dataLength);
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
function MoreloadLimit(loadLimit,tableData,optionListTable,dataLength){
    for (var i = 0; i < loadLimit; i++) {
        var row = optionListTable.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var editbutton = '<button type="button" class="btn btn-info " id="editOptionID" onclick="edit_click('+tableData[i]["OptionId"]+')">編集</button>';
        var deletebutton = '<button type="button" class="btn btn-danger" data-toggle="modal" id="deleteOptionID' + i + '" data-target="#optionDeleteModal" data-whatever="'+tableData[i]["OptionId"]+'">削除</button>';
        cell1.textContent = i + 1;
        cell2.textContent = tableData[i]["OptionName"];
        cell3.innerHTML = editbutton;
        cell4.innerHTML = deletebutton;
        document.getElementById("loadOptionListButton").style.display ="inline-block";
    }
}

//システム情報が20件未満
function LessloadLimit(tableData,optionListTable,dataLength){
    for (var i = 0; i < dataLength; i++) {
        var row = optionListTable.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var editbutton = '<button type="button" class="btn btn-info " id="editOptionID" onclick="edit_click('+tableData[i]["OptionId"]+')">編集</button>';
        var deletebutton = '<button type="button" class="btn btn-danger " data-toggle="modal" id="deleteOptionID' + i + '"  data-target="#optionDeleteModal" data-whatever="'+tableData[i]["OptionId"]+'">削除</button>';
        cell1.textContent = i + 1;
        cell2.textContent = tableData[i]["OptionName"];
        cell3.innerHTML = editbutton;
        cell4.innerHTML = deletebutton;
    }
}

//読み込みボタン押下
function load_click(){
    restDataLength =  dataLength - loadLimit;
    if(restDataLength >= loadLimit){
        dataLength = restDataLength;
        for (var i = optionListNumber; i < loadLimit * loadCount ; i++) {
            var row = optionListTable.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var editbutton = '<button type="button" class="btn btn-info " id="editOptionID" onclick="edit_click('+ tableData[i]["OptionId"] +')">編集</button>';
            var deletebutton = '<button type="button" class="btn btn-danger " data-toggle="modal" id="deleteOptionID' + i + '"  data-target="#optionDeleteModal" data-whatever="'+tableData[i]["OptionId"]+'">削除</button>';
            cell1.textContent = i+1;
            cell2.textContent = tableData[i]["OptionName"];
            cell3.innerHTML = editbutton;
            cell4.innerHTML = deletebutton;
            document.getElementById("loadOptionListButton").style.display ="inline-block";
        }
        loadCount++;
        optionListNumber += loadLimit;
    }
    else if(restDataLength <= loadLimit){
        dataLength = optionListNumber + restDataLength;
        for (var i = optionListNumber; i < dataLength; i++) {
            var row = optionListTable.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var editbutton = '<button type="button" class="btn btn-info " id="editOptionID" onclick="edit_click('+tableData[i]["OptionId"]+')">編集</button>';
            var deletebutton = '<button type="button" class="btn btn-danger " data-toggle="modal" id="deleteOptionID' + i + '"  data-target="#optionDeleteModal" data-whatever="'+tableData[i]["OptionId"]+'">削除</button>';
            cell1.textContent = i+1;
            cell2.textContent = tableData[i]["OptionName"];
            cell3.innerHTML = editbutton;
            cell4.innerHTML = deletebutton;
            document.getElementById("loadOptionListButton").style.display ="none";
        }
    }
}


//リスト内システム削除ボタン押下
$('#optionDeleteModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) //モーダルを呼び出すときに使われたボタンを取得
    document.getElementById("deleteOptionButton").val = button.data('whatever') //data-whatever の値を取得
    document.getElementById("delete-error").style.display ="none";

})

//モーダル内システム削除ボタン押下
 function delete_click(){
     var deleteOptionID = document.getElementById("deleteOptionButton").val;
     var method = 'DeleteOption';
     var deleteFlg;
     $.ajax({
         url: '../kanrisya_front/ajax/ajaxManager.php',
         type: 'POST',
         dataType: 'json',
         data: {Method: method,
                OptionID: deleteOptionID}
     })
     .done(function(data) {
     deleteFlg = data;
     //ライセンスに紐づくシステム削除の可否
     if(deleteFlg){
         $('#optionDeleteModal').modal('hide');
         location.reload();
     }else{
         document.getElementById("delete-error").style.display ="block";
     }
     })
     .fail(function(jqXHR, textStatus, errorThrown) {
         console.log("XMLHttpRequest : " + XMLHttpRequest.status);
         console.log("textStatus     : " + textStatus);
         console.log("errorThrown    : " + errorThrown.message);
         alert("通信エラーがおきました");
     });
}

//オプション編集ボタン押下
function edit_click(editOptionId){
    location.href ='../kanrisya_front/editOption.php?OptionID='+ editOptionId;

}
