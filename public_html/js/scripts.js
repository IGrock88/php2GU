$(document).ready(function () {

    $showSizeMenu = $('#show-size-menu');
    $sizeMenu =  $('.size-menu');

    $showSizeMenu.click(function () {
        $sizeMenu.show();
    });

    $sizeMenu.mouseenter(function () {
        $sizeMenu.show();
    });

    $sizeMenu.mouseleave(function () {
        $sizeMenu.hide();
    });

    $showSizeMenu.mouseleave(function () {
        $sizeMenu.hide();
    });

    $('.size-menu button').click(function () {
        $showSizeMenu.text($(this).text());
        $sizeMenu.hide();
    });

    $showColorMenu = $('#show-color-menu');
    $colorMenu =  $('.color-menu');

    $showColorMenu.click(function () {
        $colorMenu.show();
    });

    $colorMenu.mouseenter(function () {
        $colorMenu.show();
    });

    $colorMenu.mouseleave(function () {
        $colorMenu.hide();
    });

    $showColorMenu.mouseleave(function () {
        $colorMenu.hide();
    });

    $('.color-menu button').click(function () {
        $($showColorMenu).removeClassWild('*-color');
        $($showColorMenu).addClass($(this).attr("id"));
        $colorMenu.hide();
    });

    (function($) {
        $.fn.removeClassWild = function(mask) {
            return this.removeClass(function(index, cls) {
                var re = mask.replace(/\*/g, '\\S+');
                return (cls.match(new RegExp('\\b' + re + '', 'g')) || []).join(' ');
            });
        };
    })(jQuery);

    // показать меню авторизации
    var $authMenu = $('#auth');
    var flag = 0;
    $('#showAuthMenu').on('click', function () {
        if(flag == 0){
            $authMenu.slideDown();
            flag = 1;
            $(this).addClass('rotate');
        }
        else {
            $authMenu.slideUp();
            flag = 0;
            $(this).removeClass('rotate');
        }

    });


});


