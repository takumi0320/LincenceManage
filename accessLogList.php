<?php
    include './include/loginCheck.php';
    $logFileFlg = false;
    if(isset($_POST['downloadAccessLog'])){
        require_once (dirname(__FILE__) . "/../licence_core/ManagerClass/CustomerAccessLogManager.php");
        $CustomerAccessLogManager = new CustomerAccessLogManager();
        $CustomerAccessLogManager->ExportAccessLog();
        $logFileFlg = true;
    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="./assets/favicon.ico" type="image/vnd.microsoft.ico">
    <title>アクセスログ一覧</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <?php include './header.php' ?>

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="./">ホーム</a></li>
            <li class="active">アクセスログ一覧</li>
        </ol>
        <h2>アクセスログ一覧</h2>
        <div class="accessLog-btn pull-right">
            <button type="button" id="accessLogExport" class="btn btn-success" data-toggle="modal" data-target="#getAccessLogExportModal">アクセスログエクスポート</button>
        </div>
        <table id="accessLoglist-table" class="table">
            <thead>
                <tr>
                    <th class="col-xs-1">#</th>
                    <th class="col-xs-3">顧客名</th>
                    <th class="col-xs-4">操作</th>
                    <th class="col-xs-4">アクセス日時</th>
                </tr>
            </thead>
            <tbody id="accessLogListTable">
            </tbody>
        </table>
        <div class="read-btn text-center">
            <button type="button" class="btn btn-default text-center" id="loadLicenceListButton" onclick="load_click()" style="display: none;">さらに読み込む</button>
        </div>
        <div id="licence-error" class="alert alert-danger" role="alert" style="display: none;">アクセスログはありません</div>
    </div>
    <!-- アクセスログエクスポートモーダルウィンドウ -->
    <div class="modal fade" id="getAccessLogExportModal" tabindex="-1" role="dialog" aria-labelledby="AccessLogExportModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="AccessLogExportModal">アクセスログエクスポート</h4>
                </div>
                <div class="modal-body modal-frame text-center">
                    <form action="./accessLogList.php" method="post">
                        <p>アクセスログをダウンロードしますか</p>
                        <button type="submit" class="btn btn-info" name="downloadAccessLog">はい</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">いいえ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="./js/jquery-1.12.4.min.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
    <script id="logscript" src="./js/accessLogList.js" data-file-flag='<?php echo json_encode($logFileFlg); ?>'></script>
</body>
</html>
