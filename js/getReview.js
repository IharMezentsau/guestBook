var dataItems;

function getReviews() {
    $.ajax({
        type:"GET",
        url:"reviewController.php",
        success:
            function(n) {
                dataItems = JSON.parse(n);
                refreshReviews();
            },
    }, "json")};
function refreshReviews() {
    if (window.isAutorise == 1){
        $('#sendReview')[0].reset();
    };
    $('#fileNameLoad').empty();
    $('.ratingReview').raty('cancel');
    $("div#reviewListBag").empty();
    $('#reviewTmpl').tmpl(dataItems).appendTo('#reviewListBag');
    $('div.rating').raty({ starType: 'i', readOnly: true});
};