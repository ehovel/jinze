;(function ($){
	$.fn.equalHeight = function (options) {
		var tallest = 0;
        $(this).each(function() {
            $(this).css({height: '', 'min-height': ''});
            var thisHeight = $(this).height();
            if(thisHeight > tallest) {
                tallest = thisHeight;
            }
        });

        return $(this).css( 'min-height', tallest);
	}
})(window.$ja || window.jQuery);