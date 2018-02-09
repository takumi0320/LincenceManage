<?php
//アクセスログのダウンロード処理
$file_path = dirname(__FILE__) . '/tmp/AccessLog.csv';
header("Content-Type: application/octet-stream");
header('Content-Type: text/csv');
header("Content-Disposition: attachment; filename=AccessLog.csv");
readfile($file_path);
unlink($file_path);
 ?>
