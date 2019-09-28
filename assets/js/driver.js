require('../../templates/formula/path/driver/driver.scss');

$(".driver")
    .on('click', function (e) {
        e.preventDefault();
        var url = $(this).data('driver-url');
        var driverModal =  $('.driver-modal');
        $.ajax({
            url: url
        })
            .done(function (html) {
                driverModal.show();
                driverModal.html(html);
            })
            .fail(function (xhr) {
                xhr.getError()
            });
    });