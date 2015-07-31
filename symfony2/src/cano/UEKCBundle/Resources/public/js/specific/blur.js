$(function () {

    var h = 1080;
    var w = 1920;

    var imgRatio = w/h;

    function adjust() {
        var offset = $( "#indexBox" ).offset();
        var ww = window.innerWidth;
        var wh = window.innerHeight;
        var vpRatio = ww/wh;

        if ( imgRatio < vpRatio) {
            $('.blurImage').css({width: ww}).css({height: 'auto'})
        } else {
            $('.blurImage').css({width: 'auto'}).css({height: wh})
        }

        $('.blurImage').css({top: -offset.top-($('.blurImage').height()-wh)/2}).css({left: -offset.left-($('.blurImage').width()-ww)/2});
    }

    adjust();

    $( window ).resize(function() {
        adjust();
    });
});