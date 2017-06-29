/**
 * Created by PhpStorm.
 * User: Haskicbr
 * Date: 14.09.2016
 * Time: 12:38
 */

$(function () {
    $.fn.notify = function (text, timer) {
        
        if (!timer) {
            timer = 1500;
        }

        if ($.fn.notify.timeout) {
            clearTimeout($.fn.notify.timeout);
            $.fn.notify.timeout = false;
        }

        if ($.fn.notify.element) {
            $('#notify').remove();
            $.fn.notify.element = false;
        }
        $.fn.notify.element = this;


        element = document.createElement('div');
        element.setAttribute('id', 'notify');

        $(element).css({
            'color': '#ff7272',
            'text-align': 'center',
            'padding-top': '10px'
        });

        $(element).html(text);

        this.prepend(element);

        $.fn.notify.timeout = setTimeout(function () {
            $('#notify').remove();
        }, timer);
    }
});