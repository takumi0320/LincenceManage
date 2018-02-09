<?php
include './include/loginCheck.php';

require_once (dirname(__FILE__) . "/../licence_core/ManagerClass/ProductManager.php");
require_once (dirname(__FILE__) . "/../licence_core/ManagerClass/OptionManager.php");
require_once (dirname(__FILE__) . "/../licence_core/ManagerClass/EncryptManager.php");
$productManager = new ProductManager();
$optionManager = new OptionManager();
$encryptManager = new EncryptManager();
$productList = $productManager->GetProduct();
$optionList = $optionManager->getOption();
$customerName = htmlspecialchars($_POST['customerName'], ENT_QUOTES, "UTF-8");
$customerNameKana = htmlspecialchars($_POST['customerNameKana'], ENT_QUOTES, "UTF-8");
$userId = htmlspecialchars($_POST['userId'], ENT_QUOTES, "UTF-8");
$password = htmlspecialchars($_POST['password'], ENT_QUOTES, "UTF-8");
$productId = htmlspecialchars($_POST['productId'], ENT_QUOTES, "UTF-8");
$installCount = htmlspecialchars($_POST['installCount'], ENT_QUOTES, "UTF-8");
$licenceBeginDate = htmlspecialchars($_POST['licenceBeginDate'], ENT_QUOTES, "UTF-8");
$licenceEndDate = htmlspecialchars($_POST['licenceEndDate'], ENT_QUOTES, "UTF-8");
$optionArray = $_POST['option'];
$optionData = array();
$optionCount = 0;
foreach ($optionArray as $value) {
    if (!empty($value['optionId']) && !empty($value['optionBeginDate']) && !empty($value['optionEndDate'])) {
        $optionName = "";
        $optionPeriod = htmlspecialchars($value['optionBeginDate'], ENT_QUOTES, "UTF-8") . " ~ " . htmlspecialchars($value['optionEndDate'], ENT_QUOTES, "UTF-8");
        foreach ($optionList as $option) {
            if ($option->OptionId == htmlspecialchars($value['optionId'], ENT_QUOTES, "UTF-8")) $optionName = $option->OptionName;
        }
        $optionData[] = array(
            "optionId" => htmlspecialchars($value['optionId'], ENT_QUOTES, "UTF-8"),
            "optionBeginDate" => htmlspecialchars($value['optionBeginDate'], ENT_QUOTES, "UTF-8"),
            "optionEndDate" => htmlspecialchars($value['optionEndDate'], ENT_QUOTES, "UTF-8"),
            "optionName" => $optionName,
            "optionPeriod" => $optionPeriod
        );
    }
}
$licencePeriod = $licenceBeginDate . "〜" . $licenceEndDate;
$productName = "";
foreach ($productList as $product) {
    if ($product->ProductId == $productId) $productName = $product->ProductName;
}
// パスワードの長さ分●を表示
$fakePassword = "";
for ($i = 0; $i < strlen($password); $i++) {
    $fakePassword = $fakePassword . "●";
}
// パスワードは暗号化
$encryptedPassword = $encryptManager->Encrypt($password);
// 日付フォーマット外し用の定義
$dateFormat = array('年', '月');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="./assets/favicon.ico" type="image/vnd.microsoft.ico">
    <title>ライセンス登録確認</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./bootstrap/css/datepicker.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body class="detail">
    <?php include './header.php' ?>
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="./">ホーム</a></li>
            <li><a href="./registerLicence.php">ライセンス登録</a></li>
            <li class="active">ライセンス登録確認</li>
        </ol>
        <h2>ライセンス登録確認</h2>
        <form action="./completeRegisterLicence.php" method="post">
            <table class="table table-bordered">
                <tr>
                    <td class="col-xs-1"></td>
                    <td class="col-xs-4">顧客名</td>
                    <td class="col-xs-1"></td>
                    <td class="col-xs-4">顧客名(ふりがな)</td>
                    <td class="col-xs-1"></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="detail-content"><?php echo $customerName; ?></td>
                    <input type="hidden" name="customerName" value="<?php echo $customerName; ?>">
                    <td></td>
                    <td class="detail-content"><?php echo $customerNameKana; ?></td>
                    <input type="hidden" name="customerNameKana" value="<?php echo $customerNameKana; ?>">
                    <td></td>
                </tr>
                <tr>
                    <td class="detail-title"></td>
                    <td class="detail-title">ユーザーID</td>
                    <td class="detail-title"></td>
                    <td class="detail-title">パスワード</td>
                    <td class="detail-title"></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="detail-content"><?php echo $userId; ?></td>
                    <input type="hidden" name="userId" value="<?php echo $userId; ?>">
                    <td></td>
                    <td class="detail-content"><?php echo $fakePassword; ?></td>
                    <input type="hidden" name="password" value="<?php echo $encryptedPassword; ?>">
                    <td></td>
                </tr>
                <tr>
                    <td class="detail-title"></td>
                    <td class="detail-title">システム名</td>
                    <td class="detail-title"></td>
                    <td class="detail-title">ライセンス数</td>
                    <td class="detail-title"></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="detail-content"><?php echo $productName; ?></td>
                    <input type="hidden" name="productId" value="<?php echo $productId; ?>">
                    <td></td>
                    <td class="detail-content"><?php echo $installCount; ?></td>
                    <input type="hidden" name="installCount" value="<?php echo $installCount; ?>">
                    <td></td>
                </tr>
                <tr>
                    <td class="detail-title"></td>
                    <td class="detail-title">期間</td>
                    <td class="detail-title"></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="detail-content"><?php echo $licencePeriod; ?></td>
                    <input type="hidden" name="licenceBeginDate" value="<?php echo str_replace('日', '', str_replace($dateFormat, '-', $licenceBeginDate)); ?>">
                    <input type="hidden" name="licenceEndDate" value="<?php echo str_replace('日', '', str_replace($dateFormat, '-', $licenceEndDate)); ?>">
                    <td></td>
                </tr>
                <?php if(!empty($optionData[0]["optionName"])) { ?>
                    <?php foreach($optionData as $value) { ?>
                        <tr>
                            <td class="detail-title"></td>
                            <td class="detail-title">オプション名</td>
                            <td class="detail-title"></td>
                            <td class="detail-title">オプション期間</td>
                            <td class="detail-title"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="detail-content"><?php echo $value['optionName']; ?></td>
                            <td></td>
                            <td class="detail-content"><?php echo $value['optionPeriod']; ?></td>
                            <td></td>
                        </tr>
                        <input type="hidden" name='option[<?php echo $optionCount; ?>][optionId]' value='<?php echo $value['optionId']; ?>'>
                        <input type="hidden" name='option[<?php echo $optionCount; ?>][optionBeginDate]' value='<?php echo str_replace('日', '', str_replace($dateFormat, '-', $value['optionBeginDate'])); ?>'>
                        <input type="hidden" name='option[<?php echo $optionCount; ?>][optionEndDate]' value='<?php echo str_replace('日', '', str_replace($dateFormat, '-', $value['optionEndDate'])); ?>'>
                        <?php $optionCount++; ?>
                    <?php } ?>
                    <input type="hidden" name="optionList" value="">
                <?php } ?>
            </table>
            <div class="row">
                <a type="button" class="btn btn-primary pull-left" onclick="history.back();">戻る</a>
                <button type="submit" class="btn btn-info pull-right" name="check">確認</button>
            </div>
        </form>
    </div>
    <script src="./js/jquery-1.12.4.min.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
