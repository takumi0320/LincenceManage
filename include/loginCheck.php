<?php
// SESSIONがあるかどうかチェックする
session_start();
if(empty($_SESSION['administratorId'])){
    // SESSIONに値がない
    header("Location: ./login.php");
    exit();
}
?>
