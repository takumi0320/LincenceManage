<?php
include './include/loginCheck.php';
$customerId = "";
if (isset($_GET['CustomerID'])) {
    $customerId = htmlspecialchars($_GET['CustomerID'], ENT_QUOTES, "UTF-8");
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="./assets/favicon.ico" type="image/vnd.microsoft.ico">
    <title>ライセンス一覧</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body class="list">
    <?php include './header.php' ?>

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="./">ホーム</a></li>
            <li><a href="./userList.php">ユーザー一覧</a></li>
            <li class="active">ライセンス一覧</li>
        </ol>
        <h2 id="customer-name" class="licence-list-title">　</h2>
        <h2 id="licence-list-title" class="licence-list-title">ライセンス一覧</h2>
        <div id="licence-list">
            <table class="table">
                <thead>
                    <tr class="licence-list-column">
                        <th class="col-xs-1">#</th>
                        <th class="licence-table-title col-xs-3">ユーザーID<a><span id="table-head1" class="glyphicon" aria-hidden="true"></a></span></th>
                        <th class="licence-table-title col-xs-4">システム名<a><span id="table-head2" class="glyphicon" aria-hidden="true"></a></span></th>
                        <th class="licence-table-title col-xs-3">期間<a><span id="table-head3" class="glyphicon" aria-hidden="true"></a></span></th>
                        <th class="col-xs-1"></th>
                    </tr>
                </thead>
                <tbody id="licenceListTable">
                </tbody>
            </table>
            <div class="read-btn text-center">
                <button type="button" class="btn btn-default text-center" id="loadLicenceListButton" onclick="load_click()" style="display: none;">さらに読み込む</button>
            </div>
        </div>
        <div id="not-selected" class="alert alert-danger" role="alert" style="display: none;">ライセンス情報の存在するユーザーを選択してください</div>
        <div id="licence-error" class="alert alert-danger" role="alert" style="display: none;">ライセンス情報はありません</div>
    </div>
    <script src="./js/jquery-1.12.4.min.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
    <script src="./js/licenceList.js" id="script" data-customer-id='<?php echo json_encode($customerId); ?>'></script>
</body>
</html>
