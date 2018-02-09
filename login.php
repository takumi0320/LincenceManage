<?php
require_once (dirname(__FILE__) . "/../licence_core/ManagerClass/AdministratorUserManager.php");
//ログイン処理
$errorMessage="";
$loginFailureFlag = 0;
if(!empty($_POST['userId']) && !empty($_POST['password'])){
    $AdministratorUserManager = new AdministratorUserManager();
    //エスケープ処理
    $userId = htmlspecialchars($_POST['userId'], ENT_QUOTES, "UTF-8");
    $password = htmlspecialchars($_POST['password'], ENT_QUOTES, "UTF-8");
    $AdministratorList = $AdministratorUserManager->LoginVerifyAdministratorUser($userId,$password);
    //アカウントが正しくない場合
    if($AdministratorList == false){
        $errorMessage = "管理者IDまたは、パスワードが正しくありません";
        $loginFailureFlag++;
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
    <title>ログイン</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body class="login">
    <?php include './header.php' ?>

    <div class="container">
        <h2>ログイン</h2>
        <form name="loginForm" action="./login.php" method="post">
            <div class="form-group col-xs-8 login-group">
                <div class="form-group">
                    <label>管理者ID</label>
                    <input id="administrator-id" type="text" name="userId" class="form-control">
                </div>
                <div class="form-group">
                    <label>パスワード</label>
                    <input id="password" type="password" name="password" class="form-control" onkeydown="onEnterKeyDown();">
                </div>
                <div id="not-match" class="alert alert-danger <?php if(empty($errorMessage)){ echo 'is-blank-error'; } ?>" role="alert"><?php echo $errorMessage; ?></div>
                <div id="all-blank" class="alert alert-danger is-blank-error">管理者IDとパスワードが未入力です。</div>
                <div id="id-is-blank" class="alert alert-danger is-blank-error">管理者IDが未入力です。</div>
                <div id="password-is-blank" class="alert alert-danger is-blank-error">パスワードが未入力です。</div>
                <div id="limit-time-over" class="alert alert-danger is-blank-error">連続してログインに失敗しました。30分後に再度やり直してください。</div>
                <div class="text-center">
                    <button class="btn btn-info login-btn" type="button" onclick="loginCheck();">ログイン</button>
                </div>
            </div>
        </form>
    </div>
    <script src="./js/jquery-1.12.4.min.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
    <script id="script" src="./js/login.js" data-login-flag='<?php echo json_encode($loginFailureFlag); ?>'></script>
</body>
</html>
