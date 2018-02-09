<?php
include './include/loginCheck.php';
require_once (dirname(__FILE__) . '/../licence_core/ManagerClass/ProductManager.php');
require_once (dirname(__FILE__) . '/../licence_core/ManagerClass/OptionManager.php');
$productManager = new ProductManager();
$optionManager = new OptionManager();
$productList = $productManager->GetProduct();
$optionList = $optionManager->getOption();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="./assets/favicon.ico" type="image/vnd.microsoft.ico">
    <title>ライセンス登録</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body class="register">
    <?php include './header.php' ?>
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="./">ホーム</a></li>
            <li class="active">ライセンス登録</li>
        </ol>
        <h2>ライセンス登録</h2>
        <form name="registerForm" action="./checkRegisterLicence.php" method="post">
            <div class="form-center col-xs-12">
                <div class="row">
                    <div class="form-group col-xs-5">
                        <label>顧客名</label>
                        <input type="text" name="customerName" class="form-control" maxlength="20">
                        <div id="customer-name-is-blank" class="alert alert-danger is-blank-error">顧客名を入力してください</div>
                    </div>
                    <div class="form-group col-xs-5">
                        <label>顧客名(ふりがな)</label>
                        <input type="text" name="customerNameKana" class="form-control" maxlength="30">
                        <div id="customer-name-kana-is-blank" class="alert alert-danger is-blank-error">顧客名(ふりがな)を入力してください</div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-5">
                        <label>ユーザーID</label>
                        <input id="user-id" type="text" name="userId" class="form-control" maxlength="15">
                        <div id="user-id-is-blank" class="alert alert-danger is-blank-error">ユーザーIDを入力してください</div>
                        <div id="user-id-already" class="alert alert-danger is-blank-error">このユーザーIDは別のユーザーが利用しています</div>
                    </div>
                </div>
                <div class="row row-eq-height">
                    <div class="form-group col-xs-5">
                        <label>パスワード</label>
                        <input type="password" name="password" id="text-password" class="form-control" readonly>
                        <div id="password-is-blank" class="alert alert-danger is-blank-error">パスワードを自動生成してください</div>
                    </div>
                    <div class="form-group col-xs-4">
                        <!-- パスワード自動生成ボタン -->
                        <label　class="sr-only"><font size="4" color="white">パスワード自動生成</font></label>
                        <button type="button" class="form-control btn btn-default passwordbtn" data-toggle="modal" data-target="#PasswordAutoForm" onclick="randomPassword();">パスワード自動生成</button>
                    </div>
                </div>
                <!--システム選択セレクトボタン-->
                <div class="row">
                    <div class="form-group col-xs-5">
                        <label class="control-label">システム名</label>
                        <div>
                            <select class="form-control" name="productId">
                                <option selected="selected" value="">-- 選択してください --</option>
                                <?php foreach ($productList as $value) { ?>
                                <option value='<?php echo $value->ProductId; ?>'><?php echo $value->ProductName; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div id="product-id-is-blank" class="alert alert-danger is-blank-error">システム名を選択してください</div>
                    </div>
                    <!--ライセンス数選択セレクトボタン-->
                    <div class="form-group col-xs-5">
                        <label>ライセンス数</label>
                        <div class="dropdown">
                            <select class="form-control" name="installCount">
                                <option selected="selected" value="">-- 選択してください --</option>
                                <?php for($installCount = 1; $installCount<=30; $installCount++){ ?>
                                <option value='<?php echo $installCount;?>'><?php echo $installCount; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div id="install-count-is-blank" class="alert alert-danger is-blank-error">ライセンス数を選択してください</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label>期間</label>
                            <div class="period-group" date-provide="datepicker">
                                <div class="form-period">
                                    <input id="licence-begin-date" type="text" name="licenceBeginDate" class="form-control date">
                                </div>
                                <div class="control-label tilde">〜</div>
                                <div class="form-period">
                                    <input id="licence-end-date" type="text" name="licenceEndDate" class="form-control date">
                                </div>
                            </div>
                            <div id="licence-period-is-blank" class="alert alert-danger is-blank-error">開始日と終了日を選択してください</div>
                            <div id="licence-start-period-is-over-end" class="alert alert-danger is-blank-error">終了日は開始日より後にしてください</div>
                        </div>
                    </div>
                </div>
                <div id="form-add-frame" class="row">
                    <div class="form-group col-xs-5">
                        <label class="control-label">オプション</label>
                        <div class="dropdown">
                            <select class="form-control" name="option[0][optionId]">
                                <option selected="selected" value="">-- 選択してください --</option>
                                <?php foreach ($optionList as $value) { ?>
                                <option value='<?php echo $value->OptionId; ?>'><?php echo $value->OptionName; ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-xs-6">
                        <label>オプション期間</label>
                        <div class="period-group" date-provide="datepicker">
                            <div class="form-period">
                                <input id="option-begin-date-0" type="text" name="option[0][optionBeginDate]" id="optionDateLowerLimit" class="form-control date">
                            </div>
                            <div class="control-label tilde">〜</div>
                            <div class="form-period">
                                <input id="option-end-date-0" type="text" name="option[0][optionEndDate]" id="optionDateUpperLimit" class="form-control date">
                            </div>
                        </div>
                        <div id="option-start-period-is-over-end-0" class="alert alert-danger is-blank-error">終了日は開始日より後にしてください</div>
                    </div>
                    <!--オプション・オプション期間追加ボタン-->
                    <div class="col-xs-1">
                        <a class="option-plus" href="#" onclick="optionAdd();">
                            <span class="glyphicon glyphicon-plus-sign add-button pull-right"></span>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <a class="btn btn-primary pull-left" onclick="history.back();">戻る</a>
                    <button type="button" class="btn btn-info pull-right" name="register" onclick="formCheck();">確認</button>
                </div>
            </div>
        </form>
        <!-- パスワード自動生成モーダルウィンドウ -->
        <div class="modal fade" id="PasswordAutoForm">
            <div class="modal-dialog modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">パスワード自動生成</h4>
                </div>
                <div class="modal-body modal-frame text-center">
                    <p id="modal-password" class="modal-password">
                </div>
            </div>
        </div>
        <!-- パスワード自動生成モーダルウィンドウ -->
        <script src="./js/jquery-1.12.4.min.js"></script>
        <script src="./bootstrap/js/bootstrap.min.js"></script>
        <script src="./bootstrap/js/bootstrap-datepicker.min.js"></script>
        <script src="./bootstrap/locales/bootstrap-datepicker.ja.min.js"></script>
        <script id="script" src="./js/registerLicence.js" data-option-list='<?php echo json_encode($optionList); ?>'></script>
</body>
</html>
