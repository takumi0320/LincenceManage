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
    <title>管理者アカウント一覧</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <?php include './header.php' ?>

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="./">ホーム</a></li>
            <li class="active">管理者アカウント一覧</li>
        </ol>
        <h2>管理者アカウント一覧</h2>
        <div class="product-register-btn">
            <a href="./registerAdministrator.php" class="btn btn-info pull-right">新規登録</a>
        </div>
        <div>
            <table class="table" id="administrator-table">
                <thead>
                    <tr class="product-list-column">
                        <th class="product-list-number col-xs-1">#</th>
                        <th class="product-list-titile col-xs-10">アカウント名</th>
                        <th class="col-xs-1"></th>
                    </tr>
                </thead>
                <tbody class="product-list-value" id="administratorListTable">
                </tbody>
            </table>
            <div class="read-btn text-center">
                <button type="button" class="btn btn-default text-center" id="loadAdministratorListButton" onclick="load_click()" style="display: none;">さらに読み込む</button>
            </div>
        </div>

        <!-- 管理者アカウント削除モーダルウィンドウ -->
        <div class="modal fade" id="administratorDeleteModal" tabindex="-1" role="dialog" aria-labelledby="DeleteAdministratorModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">管理者アカウント削除</h4>
                    </div>
                    <div class="modal-body modal-frame text-center">
                        <p>管理者アカウントを削除してもよろしいですか</p>
                        <button type="button" class="btn btn-danger" id="deleteAdministratorButton" onclick="delete_click()">削除</button>
                        <button type="button" class="btn btn-success" data-dismiss="modal">キャンセル</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="./js/jquery-1.12.4.min.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
    <script src="./js/administratorList.js"></script>
</body>
</html>
