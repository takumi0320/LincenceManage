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
    <title>ライセンス一括登録</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <?php include './header.php' ?>

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="./">ホーム</a></li>
            <li class="active">ライセンス一括登録</li>
        </ol>
        <h2>ライセンス一括登録</h2>
        <form action="./registerCompleteAllLicence.php" name="formAllLicence" method="post" enctype="multipart/form-data">
            <div class="form-group inputFile-group">
                <p>CSV選択</p>
                <input type="file" name="file" id="file" onchange="$('#fileName').val('ファイル名:　' + $(this).prop('files')[0].name)">
                <input type="button" value="ファイル選択" class="btn btn-default" id="inputFile" onClick="$('#file').click();">
                <input id="fileName" readonly type="text">
            </div>
            <a type="button" class="btn btn-primary pull-left" onclick="history.back();">戻る</a>
            <button type="button" class="btn btn-info pull-right" id="checkFileCsv" >登録</button>
        </form>
    </div>
    <!-- ライセンス一括登録中モーダルウィンドウ -->
    <div class="modal fade" id="getRegistrationInAllLicenceModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="RegistrationInAllLicenceModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="RegistrationInAllLicenceModal">ライセンス一括登録中</h4>
                </div>
                <div class="modal-body modal-frame text-center">
                    <p>ライセンス情報を登録しています</p>
                    <p>しばらくお待ち下さい</p>
                </div>
            </div>
        </div>
    </div>
    <!-- CSV非選択時表示モーダルウィンドウ -->
    <div class="modal fade" id="getUnselectionCsvModal" tabindex="-1" role="dialog" aria-labelledby="UnselectionCsvModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="UnselectionCsvModal">ファイルを選択してください</h4>
                </div>
                <div class="modal-body modal-frame text-center">
                    <p>CSVファイルが選択されていません</p>
                </div>
            </div>
        </div>
    </div>
    <script src="./js/jquery-1.12.4.min.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
    <script src="./js/registerAllLicence.js"></script>
</body>
</html>
