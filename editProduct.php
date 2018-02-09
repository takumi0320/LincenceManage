<?php
include './include/loginCheck.php';
require_once (dirname(__FILE__) . "../../licence_core/ManagerClass/ProductManager.php");
require_once (dirname(__FILE__) . "../../licence_core/InformationClass/Product.php");
$productId = "";
if (isset($_GET['ProductID'])) {
    $productId = htmlspecialchars($_GET['ProductID'], ENT_QUOTES, "UTF-8");
}
if(!empty($_POST['productName']) && !empty($_POST['productKana'])){
    $ProductManager = new ProductManager();
    $Product = new Product();
    $Product->ProductId = $_POST['productId'];
    $Product->ProductName = $_POST['productName'];
    $Product->ProductKana = $_POST['productKana'];
    $ProductManager->EditProduct($Product);
    header('Location:../kanrisya_front/productList.php');
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
    <title>システム編集画面</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <?php include './header.php' ?>

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="./">ホーム</a></li>
            <li><a href="./productList.php">システム一覧</a></li>
            <li class="active">システム編集</li>
        </ol>
        <h2>システム編集</h2>
        <form  class="form-inline" action="editProduct.php" method="post" enctype="multipart/form-data">
            <div class="product-form">
                <div class="form-group col-xs-5 col-md-offset-1 product-name">
                    <label class="productName">システム名</label></br>
                    <input type="text" class="form-control" name="productName" id="inputProductName">
                    <div id="edit-is-product-name" class="alert alert-danger" style="display:none">システム名が未入力です</div>
                </div>
                <div class="form-group col-xs-5 product-phonetic">
                    <label class="productPhonetic">システム名(ふりがな)</label></br>
                    <input type="text" class="form-control" name="productKana" id="inputProductPhonetic">
                    <div id="edit-is-product-kana" class="alert alert-danger" style="display:none">ふりがなが未入力です</div>
                </div>

                <div class="btn-block">
                    <a type="button" class="btn btn-primary pull-left" onclick="history.back();">戻る</a>
                    <button type="submit" class="btn btn-info pull-right" id="product-eidt-btn" onclick="return formCheck();">更新</button>
                </div>
                <input type="hidden" name="productId" value='<?php echo $productId ; ?>'>
        </form>
    </div>
        <script src="./js/jquery-1.12.4.min.js"></script>
        <script id="script" src="./js/editProduct.js" data-product-id='<?php echo json_encode($productId); ?>'></script>
        <script src="./bootstrap/js/bootstrap.min.js"></script>
    </body>
    </html>
