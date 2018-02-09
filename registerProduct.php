<?php
include './include/loginCheck.php';
require_once (dirname(__FILE__) . "../../licence_core/ManagerClass/ProductManager.php");
$errorMessage1="";
$errorMessage2="";
if(isset($_POST["register"])){
    if(!empty($_POST['productName']) && !empty($_POST['productKana'])){
        $productName = $_POST['productName'];
        $productKana = $_POST['productKana'];
        $ProductManager = new ProductManager();
        $ProductManager->RegisterProduct($productName,$productKana);
        header('Location:../kanrisya_front/completeRegisterProduct.php');
        exit();
    }else{
        //項目欄が未入力チェック
        if (empty($_POST['productName']) && empty($_POST['productKana'])) {
            $errorMessage1 = 'システム名が未入力です';
            $errorMessage2 = 'ふりがなが未入力です';
        }else if (empty($_POST["productName"])) {
            $errorMessage1 = 'システム名が未入力です';
        }else if(empty($_POST["productKana"])) {
            $errorMessage2 = 'ふりがなが未入力です';
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
    <title>システム登録画面</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <?php include './header.php' ?>

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="./">ホーム</a></li>
            <li><a href="./productList.php">システム一覧</a></li>
            <li class="active">新規システム登録</li>
        </ol>
        <h2>新規システム登録</h2>
        <form  class="form-inline" action="registerProduct.php" method="post" enctype="multipart/form-data">
            <div class="product-form">
                <div class="form-group col-xs-5 col-md-offset-1 product-name">
                    <label class="productName">システム名</label></br>
                    <input type="text" class="form-control" name="productName" id="inputProductName">
                    <?php if($errorMessage1){  ?>
                    <div class="alert alert-danger" role="alert"><?php echo $errorMessage1; ?></div>
                    <?php }?>
                </div>
                <div class="form-group col-xs-5 product-phonetic">
                    <label class="productPhonetic">システム名(ふりがな)</label></br>
                    <input type="text" class="form-control" name="productKana" id="inputProductPhonetic">
                    <?php if($errorMessage2){  ?>
                    <div class="alert alert-danger" role="alert"><?php echo $errorMessage2; ?></div>
                    <?php }?>
                </div>


                <div class="btn-block">
                    <a type="button" class="btn btn-primary pull-left" onclick="history.back();">戻る</a>
                    <button type="submit" class="btn btn-info pull-right" id="product-register-btn" name="register">登録</button>
                </div>
        </form>
    </div>
        <script src="./js/jquery-1.12.4.min.js"></script>
        <script src="./bootstrap/js/bootstrap.min.js"></script>
    </body>
    </html>
