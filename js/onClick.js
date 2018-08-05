$("#newReview").click(function(event) {
    event.preventDefault();
    var message = $("#textReview").val();
    var rating = $('.ratingReview').raty('score');
    var image = $("#selectedFile").prop('files')[0];
    var formImage = new FormData();
    formImage.append('file', image);
    formImage.append('message', message);
    formImage.append('rating', rating);
    formImage.append('_method', 'POST');
    $.ajax({
        type:"POST",
        url:"reviewController.php",
        data:formImage,
        cache: false,
        processData: false,
        contentType: false,
        success:
            function() {
                answer();
            },
    }, "json");
    function answer() {
        getReviews();
    };
});

$("body").on('click', ".updateMessage", function (event) {
    var idUpdate = $(this).attr("data-update");
    modalWindow(idUpdate);
});

$("body").on('click', "#deleteImage", function () {
    var idImage = $(".submitUpdate").attr("data-Update");
    $.ajax({
        type: "GET",
        url: "deleteImage.php?id=" + idImage,
        success:
            function () {
                getReviews();
                modalWindow(idImage);
            }
    }, "json");
});

$("body").on('click', ".submitUpdate", function(event) {
    event.preventDefault();
    var idMessage = $(".submitUpdate").attr("data-Update");
    var message = $("#textReviewUpdate").val();
    var rating = $('.updateRating').raty('score');
    var image = $("#selectedFileUpdate").prop('files')[0];
    var formUpdate = new FormData();
    formUpdate.append('id', idMessage);
    formUpdate.append('file', image);
    formUpdate.append('message', message);
    formUpdate.append('rating', rating);
    formUpdate.append('_method', 'PUT');
    $.ajax({
        type:"POST",
        url:"reviewController.php",
        data: formUpdate,
        cache: false,
        processData: false,
        contentType: false,
        success:
            function() {
                getReviews();
            },
    }, "json");
});

$("body").on('click', ".deleteMessage", function(event) {
    var idMessage = $(this).attr("data-delete");
    $.ajax({
        type: "DELETE",
        url: "reviewController.php?id=" + idMessage,
        success:
            function () {
                getReviews();
            },
    }, "json");
});
