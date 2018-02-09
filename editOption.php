<?php
include './include/loginCheck.php';
require_once (dirname(__FILE__) . "../../licence_core/ManagerClass/OptionManager.php");
require_once (dirname(__FILE__) . "../../licence_core/InformationClass/Option.php");
$optionId = "";
if (isset($_GET['OptionID'])) {
    $optionId = htmlspecialchars($_GET['OptionID'], ENT_QUOTES, "UTF-8");
}
if(!empty($_POST['optionName']) && !empty($_POST['optionKana'])){
    $OptionManager = new OptionManager();
    $Option = new Option();
    $Option->OptionId = $_POST['optionId'];
    $Option->OptionName = $_POST['optionName'];
    $Option->OptionKana = $_POST['optionKana'];
    $OptionManager->EditOption($Option);
    header('Location:../kanrisya_front/optionList.php');
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
    <title>オプション編集画面</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <?php include './header.php' ?>

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="./">ホーム</a></li>
            <li><a href="./optionList.php">オプション一覧</a></li>
            <li class="active">オプション編集</li>
        </ol>
        <h2>オプション編集</h2>
        <form  class="form-inline" action="editOption.php" method="post" enctype="multipart/form-data">
            <div class="product-form">
                <div class="form-group col-xs-5 col-md-offset-1 product-name">
                    <label class="productName">オプション名</label></br>
                    <input type="text" class="form-control" name="optionName" id="inputOptionName">
                    <div id="edit-is-option-name" class="alert alert-danger" style="display:none">オプション名が未入力です</div>
                </div>
                <div class="form-group col-xs-5 product-phonetic">
                    <label class="productPhonetic">オプション名(ふりがな)</label></br>
                    <input type="text" class="form-control" name="optionKana" id="inputOptionPhonetic">
                    <div id="edit-is-option-kana" class="alert alert-danger" style="display:none">ふりがなが未入力です</div>
                </div>

                <div class="btn-block">
                    <a type="button" class="btn btn-primary pull-left" onclick="history.back();">戻る</a>
                    <button type="submit" class="btn btn-info pull-right" id="option-eidt-btn"  onclick="return formCheck();">更新</button>
                </div>
                <input type="hidden" name="optionId" value='<?php echo $optionId ; ?>'>
        </form>
    </div>
        <script src="./js/jquery-1.12.4.min.js"></script>
        <script id="script" src="./js/editOption.js" data-option-id='<?php echo json_encode($optionId); ?>'></script>
        <script src="./bootstrap/js/bootstrap.min.js"></script>
    </body>
    </html>
