// CSVファイルが選択されているかチェック
$('#checkFileCsv').on('click',function(){
    var selectedfile = document.getElementById("fileName").value;
    if(selectedfile.match(/.csv$/)){
        //CSVファイルが選択されている
        $('#getRegistrationInAllLicenceModal').modal();
        document.formAllLicence.submit();
    }else{
        //CSVファイルが選択されていない
        $('#getUnselectionCsvModal').modal();
    }
});
