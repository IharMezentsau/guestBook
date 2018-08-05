function modalWindow(id) {

    $.ajax({
        type: "GET",
        url: "getUpdate.php?id=" + id,
        success:
            function (n) {
                $('#updateImg').empty();
                $("#btnDelImg").empty();
                $('#fileNameLoadUpdate').empty();
                dataUpdate = JSON.parse(n);
                $('#modal-update').modal("show");
                $('div.updateRating').raty({starType: 'i', score: dataUpdate.rating});
                $('#textReviewUpdate').text(dataUpdate.message);
                $('.submitUpdate').attr("data-update", id);
                if (dataUpdate.image != null) {
                    $('#updateImg').append("<img alt='image' class='img-responsive' src='" + dataUpdate.image + "'>");
                    $('#btnDelImg').append("<button id='deleteImage' class='btn btn-danger btn-block btn-group'></button>");
                    $('#deleteImage').append("<i class='far fa-trash-alt'></i>");
                }
            }
    }, "json");

};
