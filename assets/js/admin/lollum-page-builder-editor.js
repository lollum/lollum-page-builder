jQuery(function ($) {

	'use strict';
	/* global quicktags, QTags, YoastSEO, lpb_vars */

	var _doc = document;
	var _html = _doc.documentElement;
	var tinymce_content;
	var content = $('#content');
	var page_builder = $('#lollum-page-builder');
	var grid_container = $('#grid-blocks');
	var column_fields = [];

	/* HTML elements */
	var builder_switcher = '<button type="button" id="lpb-builder-switch" class="switch-builder button">' + lpb_vars.page_builder_button + '</button>';
	var override_dialog_html = '<div id="lpb-content-override-dialog" class="lpb-dialog"><p>' + lpb_vars.override_dialog_description + '</p><p><button type="button" class="button lpb-content-override-action" data-action="stay">' + lpb_vars.override_dialog_stay + '</button> <button type="button" class="button button-primary lpb-content-override-action"  data-action="clear-page-builder">' + lpb_vars.override_dialog_clear + '</button> <button type="button" class="button button-primary lpb-content-override-action" data-action="clear-content">' + lpb_vars.override_dialog_keep + '</button></p></div>';

	// Hide page builder meta boxes
	page_builder.hide();

	// Create switcher button
	$('#wp-content-wrap .wp-editor-tabs').append(builder_switcher);

	// Switch to the page builder editor
	$('#lpb-builder-switch').on('click', function(e) {
		e.preventDefault();

		if (wp_editor_has_content()) {
			if (grid_container.find('.page-item').length) {
				override_dialog();
			} else {
				copy_content();
				show_page_builder();
			}
		} else {
			show_page_builder();
		}
	});

	// Switch back to the WP editor
	page_builder.on('click', '#lpb-back-to-wpeditor', function() {
		show_wp_editor();
	});

	// Get editor content
	$(_doc).on('tinymce-editor-init', function(event, editor) {
		if (editor.id !== 'content') {
			return;
		}

		tinymce_content = editor;
	});

	// Get WP editor content
	function get_wp_editor_content(format) {
		var text;

		if (!tinymce_content || tinymce_content.isHidden()) {
			text = content.val();
		} else {
			text = tinymce_content.getContent({format: format});
			text = text.replace(/(?:<p[^>]*>)?(?:<br[^>]*>)?(?:<\/p>)?/, '');
		}

		return text;
	}

	// Check if the editor has content
	function wp_editor_has_content() {
		if (get_wp_editor_content('raw').length > 0) {
			return true;
		} else {
			return false;
		}
	}

	// Set WP editor content
	function set_wp_editor_content(data) {
		var text;

		if (!tinymce_content || tinymce_content.isHidden()) {
			text = content.val(data);
		} else {
			text = tinymce_content.setContent(data);
		}

		return text;
	}

	// Empty WP editor content
	function empty_wp_editor_content() {
		set_wp_editor_content('');
	}

	// If the default WP editor has some content, what should we do?
	function override_dialog() {
		$('body').append(override_dialog_html);

		// create overlay
		var obfuscator = _doc.createElement('div');
		obfuscator.id = 'lpb-dialog-obfuscator';
		_html.appendChild(obfuscator);

		$('#lpb-content-override-dialog').find('button').on('click', function() {
			var show;
			var action = $(this).data('action');

			show = action === 'stay' ? false : true;

			if (show) {
				if (action === 'clear-page-builder') {
					clear_page_builder();
					copy_content();
				} else if (action === 'clear-content') {
					empty_wp_editor_content();
					copy_builder_to_content();
				}

				show_page_builder();
			}

			$('#lpb-content-override-dialog').remove();
			$('#lpb-dialog-obfuscator').remove();
		});
	}

	// Show page builder
	function show_page_builder() {
		$(_html).addClass('lpb-enabled');

		// Add back to WP editor button
		var back_to_wpeditor = '<button type="button" class="button button-small" id="lpb-back-to-wpeditor">' + lpb_vars.back_to_editor + '</button>';
		page_builder.append(back_to_wpeditor);

		// Hide WP editor
		$('#wp-content-wrap, #post-status-info').hide();

		// Show meta boxes
		page_builder.show();

		// Set editor's type
		set_editor_type('page-builder');

		// Sync content
		sync_page_builder_with_content();
	}

	// Show WP editor
	function show_wp_editor() {
		$(_html).removeClass('lpb-enabled');

		// Hide page builder meta boxes
		page_builder.hide();

		// Set editor's type
		set_editor_type('default-editor');

		// Show default editor
		$('#wp-content-wrap, #post-status-info').show();

		// Remove back button
		$('#lpb-back-to-wpeditor').remove();

		// Resize to trigger reflow of WordPress editor stuff
		$(window).resize();
	}

	// Clear page builder
	function clear_page_builder() {
		var blocks = grid_container.find('.page-item');

		blocks.remove();
	}

	// Copy content to page builder
	function copy_content() {
		var item_cloned = $('#default-blocks').find('div[data-type="column"]').clone(true);

		grid_container.find('.empty').hide();
		$('#delete-all-blocks').prop('disabled', false);
		$('#copy-blocks').prop('disabled', false);

		if (item_cloned) {
			item_cloned.find('.item-xml').attr('name', 'item-xml[]');
			item_cloned.addClass('item-1-1').removeClass('item-1-4');
			item_cloned.find('.item-size').val('1-1');
			grid_container.append(item_cloned);

			var editor = item_cloned.find('textarea.wp-editor-area');

			if (editor.length > 0) {
				clone_editor(item_cloned, editor);
				editor.val(content.val());
			}
		}
	}

	// Clone wp_editor
	function clone_editor(item, input) {
		var id = input.attr('id');
		var new_id = (new Date().getTime()).toString(16);

		// add new ID to the textarea
		input.attr('id', new_id);

		// remove old buttons (dirty workaround)
		item.find('#qt_' + id +  '_toolbar').remove();

		// add new quickbuttons
		var settings = {
			id: new_id,
			buttons: 'em,strong,link'
		};

		quicktags(settings);
		QTags._buttonsInit();
	}

	// Copy page builder to content
	function copy_builder_to_content() {
		copy_page_builder_content();
	}

	// Copy page builder content
	function copy_page_builder_content() {
		set_wp_editor_content(get_columns_content());
	}

	// Returns a string containing the content of each column editor instance
	function get_columns_content() {
		var page_builder_content = '';

		get_column_fields();

		column_fields.map(function(field_id) {
			var column_content = document.getElementById(field_id).value;

			page_builder_content += column_content + '\n\n';
		});

		return page_builder_content;
	}

	// Get an array with the IDs of each column editor instance
	function get_column_fields() {
		column_fields = [];

		grid_container.find('.wp-editor-area').each(function() {
			column_fields.push(this.id);
		});
	}

	// Sync page builder with content
	function sync_page_builder_with_content() {
		var timeout;

		function sync() {
			clearTimeout(timeout);
			timeout = setTimeout(function() {
				copy_builder_to_content();

				// Refresh Yoast analysis
				if (typeof YoastSEO !== 'undefined') {
					YoastSEO.app.refresh();
				}
			}, 250);
		}

		sync();

		get_column_fields();

		column_fields.map(function(field_id) {
			document.getElementById(field_id).addEventListener('keyup', sync);
		});
	}

	// Set editor's type
	function set_editor_type(type) {
		var post_data = {
			action: 'lpb_set_editor_type',
			editor_type: type,
			post_id: lpb_vars.post_id,
			set_editor_type_nonce: lpb_vars.nonce
		};

		$.post(lpb_vars.ajaxurl, post_data);
	}

	// Get editor's type
	function get_editor_type() {
		var post_data = {
			action: 'lpb_get_editor_type',
			post_id: lpb_vars.post_id
		};

		$.post(lpb_vars.ajaxurl, post_data, function(res) {
			if ($.trim(res) === 'page-builder') {
				show_page_builder();
			}
		});
	}

	get_editor_type();
});
