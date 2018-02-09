//登録情報の一括エクスポート
window.onload = function () {
    var script = $('#script');
    var fileFlag = JSON.parse(script.attr('data-file-flag'));
    if (fileFlag){
        window.location.href = "./csvDownload.php";
        fileFlag = false;
    }
}
