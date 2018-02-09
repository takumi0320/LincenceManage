<?php
include './include/loginCheck.php';
require_once (dirname(__FILE__) . "../../licence_core/ManagerClass/LicenceManager.php");
require_once (dirname(__FILE__) . "../../licence_core/InformationClass/Licence.php");
require_once (dirname(__FILE__) . "../../licence_core/InformationClass/LicenceOption.php");
$customerId = "";
$userId = "";
// 日付フォーマット外し用の定義
$dateFormat = array('年', '月');
if (isset($_GET['CustomerID'])) {
    $customerId = htmlspecialchars($_GET['CustomerID'], ENT_QUOTES, "UTF-8");
    if (isset($_GET['UserID'])) {
        $userId = htmlspecialchars($_GET['UserID'], ENT_QUOTES, "UTF-8");
    }
}
if(isset($_POST["customerId"]) && isset($_POST["userId"])){
    $customerId = htmlspecialchars($_POST['customerId'], ENT_QUOTES, "UTF-8");
    $LicenceManager = new LicenceManager();
    $Licence = new Licence();
    $Licence->UserId = $_POST["userId"];
    $Licence->ContractCountLicence = $_POST["numberLicence"];
    $Licence->BeginDate = str_replace('日', '', str_replace($dateFormat, '-', $_POST["licenceLower"]));
    $Licence->EndDate = str_replace('日', '', str_replace($dateFormat, '-', $_POST["licenceUpper"]));
    $optionArray = $_POST['option'];
    $optionData = array();
    $Licence->LicenceOptionList = array();
    foreach ($optionArray as $value) {
        if (isset($value['optionId']) && isset($value['beginDate']) && isset($value['endDate'])) {
            $LicenceOption = new LicenceOption();
            $LicenceOption->UserId = $_POST["userId"];
            $LicenceOption->OptionId = $value['optionId'];
            $LicenceOption->BeginDate = str_replace('日', '', str_replace($dateFormat, '-', $value['beginDate']));
            $LicenceOption->EndDate = str_replace('日', '', str_replace($dateFormat, '-', $value['endDate']));
            $Licence->LicenceOptionList[] = $LicenceOption;
        }
    }
    $result = $LicenceManager->EditLicence($Licence);
    $location = 'Location: ./licenceList.php?CustomerID=' . $customerId;
    header($location);
    exit();
}
 ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="shortcut icon" href="./assets/favicon.ico" type="image/vnd.microsoft.ico">
    <titleライセンス編集</title>

    <title>ライセンス編集画面</title>

    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body class="register">
    <?php include './header.php' ?>

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="./">ホーム</a></li>
            <li><a href="./userList.php">ユーザー一覧</a></li>
            <li><a href="./licenceList.php?CustomerID=<?php echo $customerId;?>">ライセンス一覧</a></li>
            <li><a href="./licenceDetail.php?CustomerID=<?php echo $customerId; ?>&amp;UserID=<?php echo $userId; ?>">ライセンス詳細</a></li>
            <li class="active">ライセンス編集</li>
        </ol>
        <h2 class="licence-list-title" id="editCustomerName"></h2>
        <h2 class="licence-list-title" id="editUserId"></h2>
        <form name="updateForm" action="./editLicence.php" method="post">
        <div class="row">
            <div class="form-group col-xs-5">
                <label>ライセンス数</label>
                <div class="dropdown">
                    <select class="form-control" id="numberLicenceChange" name="numberLicence">
                        <option value="" id="licence-count-top">-- 選択してください --</option>
                    </select>
                </div>
                <div id="install-count-is-blank" class="alert alert-danger is-blank-error">ライセンス数を選択してください</div>
            </div>
            <div class="col-xs-6">
                <div class="form-group">
                    <label>期間</label>
                    <div class="period-group" date-provide="datepicker">
                        <div class="form-period">
                            <input id="licence-begin-date" type="text" class="form-control date"  name="licenceLower">
                        </div>
                        <div class="control-label tilde">〜</div>
                        <div class="form-period">
                            <input id="licence-end-date" type="text" class="form-control date" name="licenceUpper">
                        </div>
                    </div>
                    <div id="licence-period-is-blank" class="alert alert-danger is-blank-error">開始日と終了日を選択してください</div>
                    <div id="licence-start-period-is-over-end" class="alert alert-danger is-blank-error">終了日は開始日より後にしてください</div>
                </div>
            </div>
        </div>
        <div id="formAddFrame" class="row">
            <div class="form-group col-xs-5" id="optionGroup">
                <label class="control-label">オプション</label>
                <div class="dropdown">
                    <select class="form-control" id="optionNameSelect" name="option[0][optionId]">
                        <option value="" selected="selected">-- 選択してください --</option>
                    </select>
                </div>
            </div>
            <div class="form-group col-xs-6" id="optionPeriod">
                <label>オプション期間</label>
                <div class="period-group" date-provide="datepicker">
                    <div class="form-period">
                        <input id="option-begin-date-0" type="text" class="form-control date" name="option[0][beginDate]">
                    </div>
                    <div class="control-label tilde">〜</div>
                    <div class="form-period">
                        <input id="option-end-date-0" type="text" class="form-control date" name="option[0][endDate]">
                    </div>
                </div>
                <div id="option-start-period-is-over-end-0" class="alert alert-danger is-blank-error">終了日は開始日より後にしてください</div>
            </div>
            <!--オプション・オプション期間追加ボタン-->
            <div class="col-xs-1" id="optionAdd">
                <a name="addForm" class="option-plus" onclick="optionAdd();">
                    <span class="glyphicon glyphicon-plus-sign add-button pull-right"></span>
                </a>
            </div>
        </div>

        <div class="row">
            <a type="button" class="btn btn-primary pull-left" onclick="history.back();">戻る</a>
            <button type="button" class="btn btn-info pull-right" id="edit-button" onclick="return formCheck();">更新</button>
        </div>
        <input type="hidden" name="customerId" value='<?php echo $customerId; ?>'>
        <input type="hidden" name="userId" value='<?php echo $userId; ?>'>
        </form>

    </div>
    <script src="./js/jquery-1.12.4.min.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
    <script id="script" src="./js/editLicence.js" data-customer-id='<?php echo json_encode($customerId); ?>' data-user-id='<?php echo json_encode($userId); ?>'></script>
    <script src="./bootstrap/js/bootstrap-datepicker.min.js"></script>
    <script src="./bootstrap/locales/bootstrap-datepicker.ja.min.js"></script>
</body>
</html>
