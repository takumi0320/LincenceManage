<?php
include './include/loginCheck.php';
$customerId = "";
$userId = "";
if (isset($_GET['CustomerID'])) {
    $customerId = htmlspecialchars($_GET['CustomerID'], ENT_QUOTES, "UTF-8");
    if (isset($_GET['UserID'])) {
        $userId = htmlspecialchars($_GET['UserID'], ENT_QUOTES, "UTF-8");
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="shortcut icon" href="./assets/favicon.ico" type="image/vnd.microsoft.ico">
    <titleライセンス詳細</title>
    <title>ライセンス詳細画面</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body class="detail">
    <?php include './header.php' ?>

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="./">ホーム</a></li>
            <li><a href="./userList.php">ユーザー一覧</a></li>
            <li><a href="./licenceList.php?CustomerID=<?php echo $customerId; ?>">ライセンス一覧</a></li>
            <li class="active">ライセンス詳細</li>
        </ol>
        <h2 class="licence-list-title" id="pushCustomerName"></h2>
        <h2 class="licence-list-title" id="detailUserID">ライセンス詳細</h2>
        <div>
            <table class="table table-bordered" id ="detailTableList">
                <tbody id ="detailTable">
                <tr class="product-list-column">
                    <td class="col-xs-1"></td>
                    <td class="col-xs-4">ユーザーID</td>
                    <td class="col-xs-1"></td>
                    <td class="col-xs-4">システム名</td>
                    <td class="col-xs-1"></td>
                </tr>
                <tr class="product-list-column">
                    <td></td>
                    <td class="detail-content" id="pushUserID"></td>
                    <td></td>
                    <td class="detail-content" id="pushProductName"></td>
                    <td></td>
                </tr>
                <tr class="product-list-column">
                    <td class="detail-title"></td>
                    <td class="detail-title">ライセンス数</td>
                    <td class="detail-title"></td>
                    <td class="detail-title">期間</td>
                    <td class="detail-title"></td>
                </tr>
                <tr class="product-list-column">
                    <td></td>
                    <td class="detail-content" id="pushNumberContractLicence"></td>
                    <td></td>
                    <td class="detail-content" id="pushLicencePeriod"></td>
                    <td></td>
                </tr>
                <tr class="product-list-column" id="licenceOptionListColumn">
                    <td class="detail-title"></td>
                    <td class="detail-title">オプション名</td>
                    <td class="detail-title"></td>
                    <td class="detail-title">オプション期間</td>
                    <td class="detail-title"></td>
                </tr>
                <tr class="product-list-column" id="licenceOptionListValue">
                    <td></td>
                    <td class="detail-content" id="pushProductOptionName"></td>
                    <td></td>
                    <td class="detail-content" id="pushOptionPeriod"></td>
                    <td></td>
                </tr>
                </tbody>
            </table>
            <div class="foot-buttons area">
                <button class="btn btn-primary pull-left" onclick="history.back();">戻る</button>
                <div class="pull-right">
                    <button class="btn btn-info licence-edit-button" type="button" onclick="edit_click()">ライセンス編集</button>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#LicenceDeleteModal">削除</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ライセンス削除モーダルウィンドウ -->
    <div class="modal fade" id="LicenceDeleteModal" tabindex="-1" role="dialog" aria-labelledby="LicenceDelete">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="LicenceDelete">ライセンス削除</h4>
                </div>
                <div class="modal-body modal-frame text-center">
                    <p>ライセンスを削除してもよろしいですか</p>
                    <div class="alert alert-danger" id="notDeleteLicence" role="alert" style="display:none">ライセンスを削除できません</div>
                    <button type="button" class="btn btn-danger" id="deleteLicenceButton" onclick="deleteClick()">削除</button>
                    <button type="button" class="btn btn-success" data-dismiss="modal">キャンセル</button>
                </div>
            </div>
        </div>
    </div>
    <script src="./js/jquery-1.12.4.min.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
    <script id="script" src="./js/licenceDetail.js" data-customer-id='<?php echo json_encode($customerId); ?>' data-user-id='<?php echo json_encode($userId); ?>'></script>
</body>
</html>
