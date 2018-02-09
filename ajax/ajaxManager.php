<?php
require_once (dirname(__FILE__) . "/../../licence_core/ManagerClass/CustomerUserManager.php");
require_once (dirname(__FILE__) . "/../../licence_core/ManagerClass/AdministratorUserManager.php");
require_once (dirname(__FILE__) . "/../../licence_core/ManagerClass/LicenceManager.php");
require_once (dirname(__FILE__) . "/../../licence_core/ManagerClass/ProductManager.php");
require_once (dirname(__FILE__) . "/../../licence_core/ManagerClass/OptionManager.php");
require_once (dirname(__FILE__) . "/../../licence_core/ManagerClass/LicenceManager.php");
require_once (dirname(__FILE__) . "/../../licence_core/ManagerClass/CustomerAccessLogManager.php");
header('Content-type: application/json');
$methodName = $_POST['Method'];
$result;
switch ($methodName){
    //顧客情報取得
    case'GetCustomerUser':
    $CustomerUserManager = new CustomerUserManager();
    $result = $CustomerUserManager->GetCustomerUser();
    break;
    //顧客情報検索
    case'SearchCustomerUser';
    $customerName = $_POST['CustomerName'];
    $CustomerUserManager = new CustomerUserManager();
    $result = $CustomerUserManager->SearchCustomerUser($customerName);
    break;
    //管理者アカウント情報取得
    case'GetAdministratorUser':
    $AdministratorUserManager = new AdministratorUserManager();
    $result = $AdministratorUserManager->GetAdministratorUser();
    break;
    //管理者アカウントパスワード取得
    case'GetAdministratorUserPassword':
    $administratorId = $_POST['AdministratorId'];
    $AdministratorUserManager = new AdministratorUserManager();
    $result = $AdministratorUserManager->GetAdministratorUserPassword($administratorId);
    break;
    //管理者アカウント情報削除
    case'DeleteAdministratorUser':
    $administratorId = $_POST['AdministratorID'];
    $AdministratorUserManager = new AdministratorUserManager();
    $result = $AdministratorUserManager->DeleteAdministratorUser($administratorId);
    break;
    //現在のパスワード確認
    case'EditVerifyAdministratorUser':
    $AdministratorUserManager = new AdministratorUserManager();
    $inputCurrentPassword = $_POST['inputPassword'];
    $currentPassword = $_POST['currentPassword'];
    $result = $AdministratorUserManager->EditVerifyAdministratorUser($inputCurrentPassword, $currentPassword);
    break;
    //システム情報取得
    case'GetProduct':
    $ProductManager = new ProductManager();
    $result = $ProductManager->GetProduct();
    break;
    //システム詳細情報取得
    case'GetDetailsProduct':
    $productId = $_POST['ProductId'];
    $ProductManager = new ProductManager();
    $result = $ProductManager->GetDetailsProduct($productId);
    break;
    //システム情報削除
    case'DeleteProduct':
    $productId = $_POST['ProductID'];
    $ProductManager = new ProductManager();
    $result = $ProductManager->DeleteProduct($productId);
    break;
    //オプション情報取得
    case'GetOption':
    $OptionManager = new OptionManager();
    $result = $OptionManager->GetOption();
    break;
    //オプション詳細情報取得
    case'GetDetailsOption':
    $optionId = $_POST['OptionId'];
    $OptionManager = new OptionManager();
    $result = $OptionManager->GetDetailsOption($optionId);
    break;
    //オプション情報削除
    case'DeleteOption':
    $optionId = $_POST['OptionID'];
    $OptionManager = new OptionManager();
    $result = $OptionManager->DeleteOption($optionId);
    break;
    //ライセンス情報取得
    case'GetLicence':
    $custormerUserId = $_POST['CustomerID'];
    $LicenceManager = new LicenceManager();
    $result = $LicenceManager->GetLicence($custormerUserId);
    break;
    //アクセスログ取得
    case'GetAccessLog':
    $CustomerAccessLogManager = new CustomerAccessLogManager();
    $result = $CustomerAccessLogManager->GetAccessLog();
    break;
    //ライセンス情報確認
    case 'GetUserFlag':
    $userId = $_POST['userId'];
    $LicenceManager = new LicenceManager();
    $result = $LicenceManager->GetUserIdFlag($userId);
    break;
    //ライセンス詳細情報取得
    case'GetDetailsLicence':
    $userId = $_POST['UserID'];
    $customerId = $_POST['customerId'];
    $LicenceManager = new LicenceManager();
    $result = $LicenceManager->GetDetailsLicence($userId, $customerId);
    break;
    //ライセンス情報削除
    case'DeleteLicence':
    $userId = $_POST['UserID'];
    $LicenceManager = new LicenceManager();
    $result = $LicenceManager->DeleteLicence($userId);
    break;
}
echo json_encode($result);
?>
