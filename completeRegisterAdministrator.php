<?php
include './include/loginCheck.php';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="./assets/favicon.ico" type="image/vnd.microsoft.ico">
    <title>管理者アカウント登録完了</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <?php include './header.php' ?>

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="./">ホーム</a></li>
            <li class="active">管理者アカウント登録</li>
        </ol>
        <h2>管理者アカウント登録</h2>
        <p class="complete-text text-center">新たな管理者アカウントを登録しました</p>
        <div class="go-home-btn text-center">
            <a href="./" class="btn btn-default" >ホームへ</a>
        </div>
    </div>

    <script src="./js/jquery-1.12.4.min.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
