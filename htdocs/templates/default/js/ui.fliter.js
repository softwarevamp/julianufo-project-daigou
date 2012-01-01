/// <reference path="App_Script/jquery-1.2.6-vsdoc.js" />
$.fn.fliter = function(options) {
    $.fn.fliter.Default = { type: "num", length: 2 };
    options = $.extend($.fn.fliter.Default, options);
    if (options.type == "num") {
        $(this).bind('keyup', function(event) {
            this.value = this.value.replace(/[^\d\.]/g, '');
            if (this.value.match(/\d*\.\d{2,}/)) {
                this.value = this.value.match(/\d*\.\d{2}/);
            }
            
        })
    }
    else if (options.type == "onlynum") {
        $(this).bind('keyup', function(event) {
            this.value = this.value.replace(/[^\d]/g, '');
        })
    }
    return $(this);
}

