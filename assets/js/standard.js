require('../../templates/formula/path/standard.scss');

$('.s-sideNav__hamburger').click(function () {
   $('.s-sideNav').addClass('open');
});

$('.s-sideNav__close').click(function () {
    $('.s-sideNav').removeClass('open');
});