$('#selectedFile').on('change', function (e) {
    console.log(e.target.files[0].name);
    $('#fileNameLoad').text(e.target.files[0].name);
});
$('#selectedFileUpdate').on('change', function (e) {
    console.log(e.target.files[0].name);
    $('#fileNameLoadUpdate').text(e.target.files[0].name);
});