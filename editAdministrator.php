<?php
include './include/loginCheck.php';
require_once (dirname(__FILE__) . "../../licence_core/ManagerClass/AdministratorUserManager.php");
require_once (dirname(__FILE__) . "../../licence_core/InformationClass/AdministratorUser.php");
$administratorId = "";
if (isset($_GET['AdministratorID'])) {
    $administratorId = htmlspecialchars($_GET['AdministratorID'], ENT_QUOTES, "UTF-8");
}
if(!empty($_POST['administratorPassword']) && !empty($_POST['administratorRepassword'])){
    $AdministratorUserManager = new AdministratorUserManager();
    $AdministratorUser = new AdministratorUser();
    $AdministratorUser->AdministratorId = $_POST['administratorId'];
    $AdministratorUser->AdministratorPassword = password_hash(htmlspecialchars($_POST['administratorPassword']), PASSWORD_DEFAULT);
    $AdministratorUserManager->EditAdministratorUser($AdministratorUser);
    header('Location:../kanrisya_front/administratorList.php');
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
    <title>管理者アカウント編集画面</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <?php include './header.php' ?>

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="./">ホーム</a></li>
            <li><a href="./administratorList.php">管理者アカウント一覧</a></li>
            <li class="active">管理者アカウント編集</li>
        </ol>
        <h2>管理者アカウント編集</h2>
        <form action="editAdministrator.php" method="post" name="editForm">
            <div class="product-form">
                <div class="form-group col-xs-12">
                    <div class="col-xs-5 col-md-offset-1">
                        <label class="productName">現在のパスワード</label></br>
                        <input type="password" class="form-control" name="administratorCurrentPassword" id="currentAdministratorPassword">
                        <div id="edit-is-administrator-password" class="alert alert-danger" style="display:none">パスワードが未入力です</div>
                        <div id="not-match-current-password" class="alert alert-danger" style="display:none">現在のパスワードが間違っています</div>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <div class="col-xs-5 col-md-offset-1">
                        <label class="productPhonetic">新しいパスワード</label></br>
                        <input type="password" class="form-control" name="administratorPassword" id="newAdministratorRepassword">
                        <div id="edit-is-administrator-newpassword" class="alert alert-danger" style="display:none">新しいパスワードが未入力です</div>
                        <div id="not-match-administrator-newpassword" class="alert alert-danger" style="display:none">新しいパスワードが一致しません</div>
                    </div>
                    <div class="col-xs-5">
                        <label class="productPhonetic">新しいパスワード(再入力)</label></br>
                        <input type="password" class="form-control" name="administratorRepassword" id="newAdministratorRepassword">
                        <div id="edit-is-administrator-repassword" class="alert alert-danger" style="display:none">新しいパスワード(再入力)が未入力です</div>
                        <div id="not-match-administrator-repassword" class="alert alert-danger" style="display:none">新しいパスワードが一致しません</div>
                    </div>
                </div>
            </div>
            <div class="btn-block">
                <a type="button" class="btn btn-primary pull-left" onclick="history.back();">戻る</a>
                <button type="button" class="btn btn-info pull-right" id="administrator-eidt-btn" onclick="formCheck();">更新</button>
            </div>
            <input type="hidden" name="administratorId" value='<?php echo $administratorId ; ?>'>
        </form>
    </div>
        <script src="./js/jquery-1.12.4.min.js"></script>
        <script id="script" src="./js/editAdministrator.js" data-administrator-id='<?php echo json_encode($administratorId); ?>'</script>
        <script src="./bootstrap/js/bootstrap.min.js"></script>
    </body>
    </html>
