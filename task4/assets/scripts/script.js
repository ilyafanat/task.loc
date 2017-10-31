$( document ).ready(function() {
    $('.add-submit').on('click', function() {
        var addData = $('.form-add-user-info').serialize();
        console.log(showData);return false;
        $.ajax({
            url: '/task4/index.php',
            data: addData,
            method: post,
            success: function( result ) {
                console.log(showData);return false;
            }
        });
    });

    $('.show-submit').on('click', function() {
        var showData = $('.form-show-user-phone').serialize();
        $.ajax({
            url: '/task4/index.php',
            method: post,
            data: showData,
            success: function( result ) {
                console.log(showData);return false;
            }
        });
    });
});