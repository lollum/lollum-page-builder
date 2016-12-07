/*
This is a modified version of jQuery Parallax by Ian Lunn
http://www.ianlunn.co.uk/ - @IanLunn
(dual licensed under the MIT and GPL licenses)

This custom version uses smartresize and requestAnimationFrame
to improve scrolling performance
*/
(function( $ ){
	var $window = $(window);
	var windowHeight = $window.height();

	$window.smartresize(function () {
		windowHeight = $window.height();
	});

	$.fn.parallax = function(xpos, speedFactor, outerHeight) {
		var $this = $(this);
		var getHeight;
		var firstTop;

		//get the starting position of each element to have parallax applied to it
		$this.each(function(){
		    firstTop = $this.offset().top;
		});

		if (outerHeight) {
			getHeight = function(jqo) {
				return jqo.outerHeight(true);
			};
		} else {
			getHeight = function(jqo) {
				return jqo.height();
			};
		}

		// setup defaults if arguments aren't specified
		if (arguments.length < 1 || xpos === null) {
			xpos = '50%';
		}
		if (arguments.length < 2 || speedFactor === null) {
			speedFactor = 0.1;
		}
		if (arguments.length < 3 || outerHeight === null) {
			outerHeight = true;
		}

		// function to be called whenever the window is scrolled or resized
		function update(){
			var pos = $window.scrollTop();

			$this.each(function(){
				var $element = $(this);
				var top = $element.offset().top;
				var height = getHeight($element);

				// Check if totally above or totally below viewport
				if (top + height < pos || top > pos + windowHeight) {
					return;
				}

				$this.css('backgroundPosition', xpos + ' ' + Math.round((firstTop - pos) * speedFactor) + 'px');
			});
		}

		$window.bind('scroll', function() {
 			window.requestAnimationFrame(update);
 		}).smartresize(function() { window.requestAnimationFrame(update); });
		update();
	};
})(jQuery);

jQuery(function($) {

	'use strict';
	/* global DocumentTouch, lpb_frontend_vars */

	// Check if the browser support the Touch Events API
	// This *does not* necessarily reflect a touchscreen device!!!
	function maybe_touch() {
		if (('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch) {
			return true;
		} else {
			return false;
		}
	}

	// Full-width rows
	function full_width_rows() {
		var rows = $('[data-stretch="full"]');

		// use this element as a reference, because
		// it always has the correct position
		var reference = $('.lpb-clear-section');

		// the default page container is the body element
		// but developers can pass a custom container
		var page_container = (lpb_frontend_vars.page_container === 'body') ? false : $(lpb_frontend_vars.page_container);
		var page_container_left_offset = 0;
		var page_container_right_offset = 0;

		// calculate page container offset only when
		// the element exists and if it's not the body
		if (page_container && page_container.length > 0) {
			page_container_left_offset = page_container.offset().left;
			page_container_right_offset = $(window).width() - (page_container_left_offset + page_container.outerWidth());
		}

		var left_pos = reference.offset().left;
		var offset = 0 - left_pos + page_container_left_offset;
		var width = $(window).width() - page_container_left_offset - page_container_right_offset;

		$.each(rows, function() {
			var _this = $(this);

			_this.addClass('hidden-row');
			_this.css({
				'position': 'relative',
				'left': offset,
				'width': width,
			});

			if (!_this.hasClass('row-stretch-full')) {
				_this.css({
					'padding-left': left_pos - page_container_left_offset + 'px',
					'padding-right': left_pos - page_container_right_offset + 'px'
				});
			}

			_this.removeClass('hidden-row');
		});
	}

	// Rows with the parallax effect
	function parallax_sections() {
		// Parallax is disabled in touch devices
		if ( maybe_touch() ) {
			return;
		}

		var blocks = $('.parallax-yes');

		blocks.each(function() {
			var _this = $(this);
			var xpos = _this.data('x');

			_this.parallax(xpos, 0.3);
		});
	}

	// Init functions

	full_width_rows();

	if ( maybe_touch() ) {
		document.documentElement.className += ' lpb-maybe-touch';
	}

	$(window).on('load', function() {
		parallax_sections();
	});

	$(window).smartresize(function() {
		full_width_rows();
		parallax_sections();
	});
});
