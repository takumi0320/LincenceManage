<?php
//ログアウト処理
session_start();
//管理者IDがある場合
if(!empty($_SESSION["administratorId"])){
    //SESSIONの値を初期化
    $_SESSION = array();
    //SESSIONを破棄する
    session_destroy();
    header("Location: ./login.php");
    exit();
}
?>
