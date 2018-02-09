<?php
include './include/loginCheck.php';
$fileFlag = false;
if(isset($_POST['downloadCsv'])){
    require_once (dirname(__FILE__) . "/../licence_core/ManagerClass/LicenceManager.php");
    $LicenceManager = new LicenceManager();
    $LicenceManager->ExportLicence();
    $fileFlag = true;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="./assets/favicon.ico" type="image/vnd.microsoft.ico">
    <title>ホーム</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body class="main">
    <?php include './header.php' ?>

    <div class="container">
        <h2>管理者ツール</h2>
        <div class="row">
            <div class="col-menu col-xs-4 text-center">
                <a href="./registerLicence.php" class="btn btn-info btn-lg main-btn">ライセンス登録</a>
            </div>
            <div class="col-menu col-xs-4 text-center">
                <a href="./registerAllLicence.php" class="btn btn-info btn-lg main-btn-br">ライセンス<br>一括登録</a>
            </div>
            <div class="col-menu col-xs-4 text-center">
                <a href="./userList.php" class="btn btn-info btn-lg main-btn">ユーザー一覧</a>
            </div>
        </div>
        <div class="row">
            <div class="col-menu col-xs-4 text-center">
                <a href="./productList.php" class="btn btn-success btn-lg main-btn">システム一覧</a>
            </div>
            <div class="col-menu col-xs-4 text-center">
                <a href="./optionList.php" class="btn btn-success btn-lg main-btn">オプション一覧</a>
            </div>
            <div class="col-menu col-xs-4 text-center">
                <a href="./administratorList.php" class="btn btn-success btn-lg main-btn-br">管理者アカウント<br>一覧</a>
            </div>
        </div>
        <div class="row">
            <div class="col-menu col-xs-4 text-center">
                <a href="./accessLogList.php" class="btn btn-success btn-lg main-btn-br">アクセスログ<br>エクスポート</a>
            </div>
            <div class="col-menu col-xs-4 text-center" data-toggle="modal" data-target="#getRegistrationInformationExportModal">
                <a href="#" class="btn btn-success btn-lg main-btn-br">登録情報一括<br>エクスポート</a>
            </div>
        </div>
    </div>
    <!-- 登録情報一括エクスポートモーダルウィンドウ -->
    <div class="modal fade" id="getRegistrationInformationExportModal" tabindex="-1" role="dialog" aria-labelledby="RegistrationInformationExportModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="RegistrationInformationExportModal">登録情報一括エクスポート</h4>
                </div>
                <div class="modal-body modal-frame text-center">
                    <form action="./" method="post">
                        <p>ライセンス登録情報を一括ダウンロードしますか</p>
                        <button class="btn btn-info" type="submit" name="downloadCsv">はい</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">いいえ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="./js/jquery-1.12.4.min.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
    <script src="./js/index.js"></script>
    <script id="script" src="./js/fileDownload.js" data-file-flag='<?php echo json_encode($fileFlag); ?>'></script>
</body>
</html>
