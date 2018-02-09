<?php
//登録情報のダウンロード処理
$file_path = dirname(__FILE__) . '/tmp/Licence.csv';
header("Content-Type: application/octet-stream");
header('Content-Type: text/csv');
header("Content-Disposition: attachment; filename=Licence.csv");
readfile($file_path);
unlink($file_path);
?>
