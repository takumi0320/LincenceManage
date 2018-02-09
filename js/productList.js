var loadLimit = 20;//表示件数
var tableData;
var productListTable;
var dataLength;
var productListNumber;
var restDataLength;//残りデータ数
var loadCount;//読み込みボタン押下回数
// windowが読み込まれた時
window.onload = function() {
    var method = "GetProduct";
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
                document.getElementById("product-table").style.display ="none";
                document.getElementById("product-error").style.display ="block";
            }
            console.log(tableData);
            productListTable = document.getElementById("productListTable");
            dataLength = tableData.length;
            if(dataLength > loadLimit){
                MoreloadLimit(loadLimit,tableData,productListTable,dataLength);
                productListNumber = loadLimit;
                loadCount = 2;
            }else{
                LessloadLimit(tableData,productListTable,dataLength);
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
function MoreloadLimit(loadLimit,tableData,productListTable,dataLength){
    for (var i = 0; i < loadLimit; i++) {
        var row = productListTable.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var editbutton = '<button type="button" class="btn btn-info " id="editProductID" onclick="edit_click('+ tableData[i]["ProductId"] +')">編集</button>';
        var deletebutton = '<button type="button" class="btn btn-danger " data-toggle="modal" id="deleteProductID'+ i +'"  data-target="#productDeleteModal" data-whatever="'+tableData[i]["ProductId"]+'">削除</button>';
        cell1.textContent = i + 1;
        cell2.textContent = tableData[i]["ProductName"];
        cell3.innerHTML = editbutton;
        cell4.innerHTML = deletebutton;
        document.getElementById("loadProductListButton").style.display ="inline-block";
    }
}

//システム情報が20件未満
function LessloadLimit(tableData,productListTable,dataLength){
    for (var i = 0; i < dataLength; i++) {
        var row = productListTable.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var editbutton = '<button type="button" class="btn btn-info " id="editProductID" onclick="edit_click('+ tableData[i]["ProductId"] +')">編集</button>';
        var deletebutton = '<button type="button" class="btn btn-danger " data-toggle="modal" id="deleteProductID'+i+'"  data-target="#productDeleteModal" data-whatever="'+tableData[i]["ProductId"]+'">削除</button>';
        cell1.textContent = i + 1;
        cell2.textContent = tableData[i]["ProductName"];
        cell3.innerHTML = editbutton;
        cell4.innerHTML = deletebutton;
    }
}

//読み込みボタン押下
function load_click(){
    restDataLength =  dataLength - loadLimit;
    if(restDataLength >= loadLimit){
        dataLength = restDataLength;
        for (var i = productListNumber; i < loadLimit * loadCount ; i++) {
            var row = productListTable.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var editbutton = '<button type="button" class="btn btn-info " id="editProductID" onclick="edit_click('+ tableData[i]["ProductId"] +')">編集</button>';
            var deletebutton = '<button type="button" class="btn btn-danger " data-toggle="modal" id="deleteProductID"  data-target="#productDeleteModal" data-whatever="'+tableData[i]["ProductId"]+'">削除</button>';
            cell1.textContent = i+1;
            cell2.textContent = tableData[i]["ProductName"];
            cell3.innerHTML = editbutton;
            cell4.innerHTML = deletebutton;
            document.getElementById("loadProductListButton").style.display ="inline-block";
        }
        loadCount++;
        productListNumber += loadLimit;
    }
    else if(restDataLength <= loadLimit){
        dataLength = productListNumber + restDataLength;
        for (var i = productListNumber; i < dataLength; i++) {
            var row = productListTable.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var editbutton = '<button type="button" class="btn btn-info " id="editProductID" onclick="edit_click('+tableData[i]["ProductId"]+')">編集</button>';
            var deletebutton = '<button type="button" class="btn btn-danger " data-toggle="modal" id="deleteProductID"  data-target="#productDeleteModal" data-whatever="'+tableData[i]["ProductId"]+'">削除</button>';
            cell1.textContent = i+1;
            cell2.textContent = tableData[i]["ProductName"];
            cell3.innerHTML = editbutton;
            cell4.innerHTML = deletebutton;
            document.getElementById("loadProductListButton").style.display ="none";
        }
    }
}


//リスト内システム削除ボタン押下
$('#productDeleteModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) //モーダルを呼び出すときに使われたボタンを取得
    document.getElementById("deleteProductButton").val = button.data('whatever') //data-whatever の値を取得
    document.getElementById("delete-error").style.display ="none";

})

//モーダル内システム削除ボタン押下
 function delete_click(){
     var deleteProductID = document.getElementById("deleteProductButton").val;
     var method = 'DeleteProduct';
     var deleteFlg;
     $.ajax({
         url: '../kanrisya_front/ajax/ajaxManager.php',
         type: 'POST',
         dataType: 'json',
         data: {Method: method,
                ProductID: deleteProductID}
     })
     .done(function(data) {
        deleteFlg = data;
        //ライセンスに紐づくシステム削除の可否
        if(deleteFlg){
            $('#productDeleteModal').modal('hide');
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

//システム編集ボタン押下
function edit_click(editProductId){
    location.href ='../kanrisya_front/editProduct.php?ProductID='+ editProductId;

}
