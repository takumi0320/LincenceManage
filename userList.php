<?php
include './include/loginCheck.php';
 ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="./assets/favicon.ico" type="image/vnd.microsoft.ico">
    <title>ユーザー一覧</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <?php include './header.php' ?>

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="./">ホーム</a></li>
            <li class="active">ユーザー一覧</li>
        </ol>
        <h2>ユーザー一覧</h2>
        <div class="input-group customerSearch col-xs-3 pull-right">
            <input type="text" class="form-control" name="searchWord" id="searchUserName" onkeydown="search_enter(window.event.keyCode)" >
            <span class="input-group-btn">
                <button class="btn btn-success" type="button" onclick="search_click()">
                    <i class='glyphicon glyphicon-search'></i>
                </button>
            </span>
        </div>
        <table class="table table-hover customerTable" >
            <thead>
                <tr class="product-list-column" id="userListColumn">
                    <th class="product-list-number col-xs-1">#</th>
                    <th class="product-list-titile col-xs-10">顧客名</th>
                </tr>
            </thead>
            <tbody class="product-list-value" id="userListTable">
            </tbody>
        </table>
        <div class="read-btn text-center" id="loadUserList">
        </div>
        <div id="notSearch" class="not-search alert alert-danger" role="alert" style="display: none;">検索結果がありませんでした</div>

    </div>
    <script src="./js/jquery-1.12.4.min.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
    <script src="./js/userList.js"></script>

</body>
</html>
