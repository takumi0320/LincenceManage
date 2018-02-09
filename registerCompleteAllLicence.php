<?php
include './include/loginCheck.php';
require_once (dirname(__FILE__) . "/../licence_core/ManagerClass/LicenceManager.php");
require_once (dirname(__FILE__) . "/../licence_core/InformationClass/Licence.php");
// ファイルパスを送る
if(isset($_FILES['file'])){
    $LicenceManager = new LicenceManager();
    $errorFlag = "";
    //ファイルのパスを取得
    $FilePath = $_FILES['file']['tmp_name'];
    //ファイルを読み込む
    if (($FileOpen = fopen($FilePath, "r")) != false){
        //ファイル入力
        $licenceList = array();
        $errorUserId = "";
        while($list = fgetcsv($FileOpen)){
            $list = str_replace("/( |　)/","",$list);
            mb_convert_variables('UTF-8', 'SJIS-win', $list);
            if(!empty($list[0])){
                $Licence = new Licence();
                $Licence->UserId = $list[0];
                $Licence->CustomerId = $list[1];
                $Licence->ProductId = $list[2];
                $Licence->CustomerPassword = $list[3];
                $Licence->ContractCountLicence = $list[4];
                $Licence->BeginDate = $list[5];
                $Licence->EndDate = $list[6];
                array_push($licenceList,$Licence);
            }else{
                $errorUserId++;
            }
        }
        fclose($FileOpen);
    }else{
        $errorFlag = true;
    }
    //ライセンスの顧客IDが存在するか取得
    $notExisitsCustomer = $LicenceManager->GetNotExisitsCustomer($licenceList);
    //ライセンスのシステムIDが存在するか取得
    $notExisitsPuroduct = $LicenceManager->GetNotExisitsProduct($licenceList);
    //ライセンス終了日が開始日より前か比較する
    $mistakeLicenceDate = $LicenceManager->VerifyLicenceDate($licenceList);
    //重複したライセンスを取得
    $overLapLicence = $LicenceManager->GetOverLapLicence($licenceList);
    //ライセンスを登録する
    foreach ($licenceList as $key => $value) {
        $result = array_column($overLapLicence,'userid');
        if(!in_array($value->UserId,$result,true)){
            if($value->BeginDate < $value->EndDate){
                $LicenceManager->RegisterLicence($value);
            }
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
    <title>ライセンス一括登録完了</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <?php include './header.php' ?>

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="./">ホーム</a></li>
            <li class="active">ライセンス一括登録完了</li>
        </ol>
        <h2>ライセンス一括登録完了</h2>
        <div class="completeLicence text-center">
            <p>ライセンスの一括登録が完了しました</p>
            <p><a href="./" class="btn btn-default">ホームへ</a></p>
        </div>
        <?php if(!empty($errorFlag) || !empty($errorUserId) || !empty($notExisitsCustomer) || !empty($notExisitsPuroduct) || !empty($mistakeLicenceDate)){?>
            <div class="alert alert-danger" role="alert">※以下のエラーによってライセンスが登録できませんでした</div>
        <?php }?>
        <?php if($errorFlag){?>
            <div class="alert alert-danger" role="alert">CSVファイルが読み込めませんでした</div>
        <?php }?>
        <?php if(!empty($errorUserId)){?>
            <div class="alert alert-danger" role="alert">
                <?php echo "空白のユーザIDが ".$errorUserId." 件あります";?>
            </div>
        <?php }?>
        <?php if(!empty($notExisitsCustomer)){ ?>
            <div class="alert alert-danger" role="alert">
            <?php
                foreach($notExisitsCustomer as $value){
                    if($value){
                        echo "ユーザID ".$value->UserId." の顧客ID ".$value->CustomerId." はシステムに登録されていません<br/>";
                    }
                }
            ?>
            </div>
        <?php }?>
        <?php if(!empty($notExisitsPuroduct)){ ?>
            <div class="alert alert-danger" role="alert">
            <?php
                foreach($notExisitsPuroduct as $value){
                    if($value){
                        echo "ユーザID ".$value->UserId." のシステムID ".$value->ProductId." はシステムに登録されていません<br/>";
                    }
                }
            ?>
            </div>
        <?php }?>
        <?php if(!empty($mistakeLicenceDate)){?>
            <div class="alert alert-danger" role="alert">
            <?php
                foreach ($mistakeLicenceDate as $key => $value){
                    if($value){
                        echo "ユーザID ".$value->UserId." のライセンス終了日が開始日よりも前の日付になっています<br />";
                    }
                }
            ?>
            </div>
        <?php }?>
        <?php if(!empty($overLapLicence)){ ?>
            <!-- すでに登録されているライセンス情報 -->
            <p class="text-danger">※以下のライセンス情報は既に登録されています</p>
            <table class="table completeLicenceTable">
                <thead>
                    <tr>
                        <th class="col-xs-1">#</th>
                        <th class="col-xs-3">顧客名</th>
                        <th class="col-xs-4">ユーザID</th>
                        <th class="col-xs-4">システム名</th>
                    </tr>
                </thead>
            <?php
            /*重複ライセンス情報を表示*/
                foreach ($overLapLicence as $key => $value) {
            ?>
                    <tbody>
                        <tr>
                            <td><?php echo $key += 1;?></td>
                            <td><?php echo $value['customerName'];?></td>
                            <td><?php echo $value['userId'];?></td>
                            <td><?php echo $value['productName'];?></td>
                        </tr>
                    </tbody>
                <?php
                    }
                ?>
            </table>
        <?php } ?>
    </div>
    <script src="./js/jquery-1.12.4.min.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
