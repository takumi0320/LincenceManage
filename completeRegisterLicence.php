<?php
include './include/loginCheck.php';
require_once (dirname(__FILE__) . "/../licence_core/ManagerClass/CustomerUserManager.php");
require_once (dirname(__FILE__) . "/../licence_core/ManagerClass/LicenceManager.php");
require_once (dirname(__FILE__) . "/../licence_core/InformationClass/Licence.php");
require_once (dirname(__FILE__) . "/../licence_core/InformationClass/LicenceOption.php");
require_once (dirname(__FILE__) . "/../licence_core/InformationClass/CustomerUser.php");
$customerUserManager = new CustomerUserManager();
$licenceManager = new LicenceManager();
$licence = new Licence();
$customerUser = new CustomerUser();
// 顧客情報登録
$customerUser->CustomerName = htmlspecialchars($_POST['customerName'], ENT_QUOTES, "UTF-8");
$customerUser->CustomerKana = htmlspecialchars($_POST['customerNameKana'], ENT_QUOTES, "UTF-8");
$customerId = $customerUserManager->RegisterCustomerUser($customerUser);
// ライセンス情報登録
$licence->UserId = htmlspecialchars($_POST['userId'], ENT_QUOTES, "UTF-8");
$licence->CustomerId = $customerId;
$licence->CustomerPassword = htmlspecialchars($_POST['password'], ENT_QUOTES, "UTF-8");
$licence->ProductId = htmlspecialchars($_POST['productId'], ENT_QUOTES, "UTF-8");
$licence->ContractCountLicence = htmlspecialchars($_POST['installCount'], ENT_QUOTES, "UTF-8");
$licence->BeginDate = htmlspecialchars($_POST['licenceBeginDate'], ENT_QUOTES, "UTF-8");
$licence->EndDate = htmlspecialchars($_POST['licenceEndDate'], ENT_QUOTES, "UTF-8");
$licence->LicenceOptionList = array();
if (isset($_POST['option'])) {
    $optionArray = $_POST['option'];
    foreach ($optionArray as $value) {
        $licenceOption = new LicenceOption();
        $licenceOption->OptionId = htmlspecialchars($value['optionId'], ENT_QUOTES, "UTF-8");
        $licenceOption->BeginDate = htmlspecialchars($value['optionBeginDate'], ENT_QUOTES, "UTF-8");
        $licenceOption->EndDate = htmlspecialchars($value['optionEndDate'], ENT_QUOTES, "UTF-8");
        $licence->LicenceOptionList[] = $licenceOption;
    }
}
$licenceManager->RegisterLicence($licence);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="./assets/favicon.ico" type="image/vnd.microsoft.ico">
    <title>ライセンス登録完了</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <?php include './header.php' ?>

    <div class="container">
        <ol class="breadcrumb">
          <li><a href="./">ホーム</a></li>
          <li><a href="./registerLicence.php">ライセンス登録</a></li>
          <li class="active">ライセンス登録完了</li>
        </ol>
        <h2>ライセンス登録完了</h2>
        <p class="complete-text text-center">ライセンスの登録が完了しました</p>
        <div class="go-home-btn text-center">
            <a href="./" class="btn btn-default" >ホームへ</a>
        </div>
    </div>

    <script src="./js/jquery-1.12.4.min.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
