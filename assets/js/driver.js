require('../../templates/formula/path/driver/driver.scss');

var driverModal =  $('.driver-modal');

$(".driver")
    .on('click', function (e) {
        e.preventDefault();
        var url = $(this).data('driver-url');
        $.ajax({
            url: url
        })
            .done(function (html) {
                driverModal.addClass('show');
                driverModal.html(html);
                close();
            })
            .fail(function (xhr) {
                xhr.getError()
            });
    });

function close() {
    $(".close-driver").on('click',function () {
        driverModal.removeClass('show');
    });
}

$(document).keyup(function(e) {
    if (e.keyCode == 27) {
        driverModal.removeClass('show');
    }
});