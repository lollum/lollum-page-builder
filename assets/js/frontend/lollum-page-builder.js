(function($, sr){
	'use strict';

	// smartresize function from Paul Irish
	// http://www.paulirish.com/2009/throttled-smartresize-jquery-event-handler/
	// debouncing function from John Hann
	// http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
	var debounce = function(func, threshold, execAsap) {
		var timeout;

		return function debounced () {
			var obj = this;
			var args = arguments;

			function delayed () {
				if (!execAsap) {
					func.apply(obj, args);
				}
				timeout = null;
			}

			if (timeout) {
				clearTimeout(timeout);
			} else if (execAsap) {
				func.apply(obj, args);
			}

			timeout = setTimeout(delayed, threshold || 100);
	   };
	};
	// smartresize
	jQuery.fn[sr] = function(fn) { return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };

})(jQuery, 'smartresize');

jQuery(function($) {

	'use strict';

	function full_width_rows() {
		var rows = $('[data-stretch="full"]');

		$.each(rows, function() {
			var _this = $(this);

			// use this element as a reference, because
			// it always has the correct position
			var reference = _this.next('.lpb-clear-section');

			var left_pos = reference.offset().left;
			var offset = 0 - left_pos;
			var width = $(window).width();

			_this.css({
				'position': 'relative',
				'left': offset,
				'width': width,
			});

			if (!_this.hasClass('row-stretch-full')) {
				_this.css({
					'padding-left': left_pos + 'px',
					'padding-right': left_pos + 'px'
				});
			}
		});
	}

	$(window).smartresize(function() {
		full_width_rows();
	});

	full_width_rows();
});
