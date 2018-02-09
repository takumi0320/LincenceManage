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
    <title>オプション一覧</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <?php include './header.php' ?>

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="./">ホーム</a></li>
            <li class="active">オプション一覧</li>
        </ol>
        <h2>オプション一覧</h2>
        <div class="product-register-btn">
            <a href="./registerOption.php" class="btn btn-info pull-right">新規登録</a>
        </div>
        <div>
        <table class="table" id="option-table">
            <thead>
                <tr class="product-list-column">
                    <th class="product-list-number col-xs-1">#</th>
                    <th class="product-list-titile col-xs-10">オプション名</th>
                    <th class="col-xs-1"></th>
                </tr>
            </thead>
            <tbody class="product-list-value" id="optionListTable">
            </tbody>
        </table>
        <div id="edit-is-blank" class="alert alert-danger"style="display:none">このオプションはライセンスに含まれています</div>

        <div class="read-btn text-center">
            <button type="button" class="btn btn-default text-center" id="loadOptionListButton" onclick="load_click()" style="display: none;">さらに読み込む</button>
        </div>
        <div id="option-error" class="alert alert-danger" role="alert" style="display: none">オプション情報はありません</div>
    </div>
        <!-- オプション削除モーダルウィンドウ -->
        <div class="modal fade" id="optionDeleteModal" tabindex="-1" role="dialog" aria-labelledby="DeleteOptionModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="DeleteOptionModal">オプション削除</h4>
                    </div>
                    <div class="modal-body modal-frame text-center">
                        <p>オプションを削除してもよろしいですか</p>
                        <button type="button" class="btn btn-danger" id="deleteOptionButton" onclick="delete_click()">削除</button>
                        <button type="button" class="btn btn-success" data-dismiss="modal">キャンセル</button>
                        <div id="delete-error" class="alert alert-danger" role="alert" style="display: none">ライセンスに登録されているオプションのため削除できません</div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="./js/jquery-1.12.4.min.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
    <script src="./js/optionList.js"></script>
</body>
</html>
