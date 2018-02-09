<?php
include './include/loginCheck.php';
require_once (dirname(__FILE__) . "../../licence_core/ManagerClass/AdministratorUserManager.php");
$errorMessage1="";
$errorMessage2="";
$errorMessage3="";
if(isset($_POST["register"])){
    if(!empty($_POST['administratorID']) && !empty($_POST['password']) && !empty($_POST['rePassword'])){
        if($_POST['password'] == $_POST['rePassword'] ){
            $AdministratorUserManager = new AdministratorUserManager();
            $administratorId = htmlspecialchars($_POST['administratorID'], ENT_QUOTES, "UTF-8");
            $result = $AdministratorUserManager->DuplicationAdministratorUser($administratorId);
            if($result){
                $errorMessage1 = '管理者IDが重複しています';
            }else{
                $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);
                $AdministratorUserManager->RegisterAdministratorUser($administratorId,$password);
                header('Location:../kanrisya_front/completeRegisterAdministrator.php');
                exit();
            }
        }else{
            $errorMessage3 = "パスワードが間違っています";
        }

    }else{
        //項目欄が未入力チェック
        if(empty($_POST['administratorID']) && empty($_POST['password']) && empty($_POST['rePassword'])){
            $errorMessage1 = '管理者IDが未入力です';
            $errorMessage2= 'パスワードが未入力です';
            $errorMessage3 = 'パスワード(再入力)が未入力です';
        } else if (empty($_POST["administratorID"])) {
            $errorMessage1 = '管理者IDが未入力です';
        } else if (empty($_POST["password"])) {
            $errorMessage2= 'パスワードが未入力です';
        } else if (empty($_POST["rePassword"])) {
            $errorMessage3 = 'パスワード(再入力)が未入力です';
        }
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
    <title>管理者アカウント登録</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <?php include './header.php' ?>

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="./">ホーム</a></li>
            <li><a href="./administratorList.php">管理者アカウント一覧</a></li>
            <li class="active">管理者アカウント登録</li>
        </ol>
        <h2>管理者アカウント登録</h2>
        <form action="registerAdministrator.php" method="post">
            <div class="product-form">
                <div class="form-group col-xs-12">
                    <div class="col-xs-5 col-md-offset-1">
                        <label class="productName">管理者ID</label>
                        <input type="text" class="form-control" name="administratorID" >
                        <?php if($errorMessage1){  ?>
                        <div class="alert alert-danger" role="alert"><?php echo $errorMessage1; ?></div>
                        <?php }?>
                    </div>

                </div>
                <div class="form-group col-xs-12">
                    <div class="col-xs-5 col-md-offset-1">
                        <label class="productName">パスワード</label>
                        <input type="password" class="form-control" name="password">
                        <?php if($errorMessage2){  ?>
                        <div class="alert alert-danger" role="alert"><?php echo $errorMessage2; ?></div>
                        <?php }?>
                    </div>
                    <div class="col-xs-5">
                        <label class="productName">パスワード(再入力)</label>
                        <input type="password" class="form-control" name="rePassword">
                        <?php if($errorMessage3){  ?>
                        <div class="alert alert-danger" role="alert"><?php echo $errorMessage3; ?></div>
                        <?php }?>

                    </div>

                </div>

            </div>

            <div class="btn-block">
                <a type="button" class="btn btn-primary pull-left" onclick="history.back();">戻る</a>
                <button type="sumbit" class="btn btn-info pull-right" name="register">登録</button>
            </div>
        </form>
        <script src="./js/jquery-1.12.4.min.js"></script>
        <script src="./bootstrap/js/bootstrap.min.js"></script>
    </body>
    </html>
