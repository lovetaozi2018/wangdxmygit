var paths = window.location.pathname.split('/');
var controller = '';
if (window.location.href.indexOf('public') > -1) {
    controller = paths[3];
} else {
    controller = paths[1];
}
$('li .active').removeClass();
$('#' + controller).addClass('active');