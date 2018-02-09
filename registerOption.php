<?php
include './include/loginCheck.php';
require_once (dirname(__FILE__) . "../../licence_core/ManagerClass/OptionManager.php");
$errorMessage1="";
$errorMessage2="";
if(isset($_POST["register"])){
    if(!empty($_POST['optionName']) && !empty($_POST['optionKana'])){
        $optionName = $_POST['optionName'];
        $optionKana = $_POST['optionKana'];
        $OptionManager = new OptionManager();
        $OptionManager->RegisterOption($optionName,$optionKana);
        header('Location:../kanrisya_front/completeRegisterOption.php');
        exit();
    }else{
        //項目欄が未入力チェック
        if (empty($_POST['optionName']) && empty($_POST['optionKana'])) {
            $errorMessage1 = 'オプション名が未入力です';
            $errorMessage2 = 'ふりがなが未入力です';
        }else if (empty($_POST["optionName"])) {
            $errorMessage1 = 'オプション名が未入力です';
        }else if(empty($_POST["optionKana"])) {
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
    <title>新規オプション登録</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <?php include './header.php' ?>

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="./">ホーム</a></li>
            <li><a href="./optionList.php">オプション一覧</a></li>
            <li class="active">新規オプション登録</li>
        </ol>
        <h2>新規オプション登録</h2>
        <form  class="form-inline" action="registerOption.php" method="post" enctype="multipart/form-data">
            <div class="product-form">
                <div class="form-group col-xs-5 col-md-offset-1 product-name">
                    <label class="productName">オプション名</label></br>
                    <input type="text" class="form-control" name="optionName" id="inputOptionName">
                    <?php if($errorMessage1){  ?>
                    <div class="alert alert-danger" role="alert"><?php echo $errorMessage1; ?></div>
                    <?php }?>

                </div>

                <div class="form-group col-xs-5 product-phonetic">
                    <label class="productPhonetic">オプション名(ふりがな)</label></br>
                    <input type="text" class="form-control" name="optionKana" id="inputOptionPhonetic">
                    <?php if($errorMessage2){  ?>
                    <div class="alert alert-danger" role="alert"><?php echo $errorMessage2; ?></div>
                    <?php }?>
                </div>

                <div class="btn-block">
                    <a class="btn btn-primary pull-left" onclick="history.back();">戻る</a>
                    <button type="submit" class="btn btn-info pull-right" id="option-register-btn" name="register" >登録</button>
                </div>
            </div>
        </form>
    </div>
    <script src="./js/jquery-1.12.4.min.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
