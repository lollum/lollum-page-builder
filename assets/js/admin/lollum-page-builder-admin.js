jQuery(function ($) {

	'use strict';
	/* global quicktags, QTags, lpb_admin_vars */

	var _doc = document;
	var _html = _doc.documentElement;
	var block_list = $('#blocks-selection').find('a');
	var default_list_container = $('#default-blocks');
	var grid_container = $('#grid-blocks');
	var empty_message = grid_container.find('.empty');
	var delete_all_blocks = $('#delete-all-blocks');
	var item_header = $('.page-item-header');
	var delete_button = item_header.find('.delete-item');
	var open_box = item_header.find('.edit-item-btn');
	var add_size = item_header.find('.btn-plus');
	var sub_size = item_header.find('.btn-minus');
	var clone_box = item_header.find('.btn-clone');
	var color_inputs = grid_container.find('.input-color');
	var last_icon_input_clicked;
	var content_block_added = false;
	var item_size = [
		['item-1-4','1-4'],
		['item-1-3', '1-3'],
		['item-1-2', '1-2'],
		['item-2-3', '2-3'],
		['item-3-4', '3-4'],
		['item-1-1', '1-1']
	];
	var icons = [
		'fa fa-glass',
		'fa fa-music',
		'fa fa-search',
		'fa fa-envelope-o',
		'fa fa-heart',
		'fa fa-star',
		'fa fa-star-o',
		'fa fa-user',
		'fa fa-film',
		'fa fa-th-large',
		'fa fa-th',
		'fa fa-th-list',
		'fa fa-check',
		'fa fa-remove',
		'fa fa-search-plus',
		'fa fa-search-minus',
		'fa fa-power-off',
		'fa fa-signal',
		'fa fa-gear',
		'fa fa-trash-o',
		'fa fa-home',
		'fa fa-file-o',
		'fa fa-clock-o',
		'fa fa-road',
		'fa fa-download',
		'fa fa-arrow-circle-o-down',
		'fa fa-arrow-circle-o-up',
		'fa fa-inbox',
		'fa fa-play-circle-o',
		'fa fa-repeat',
		'fa fa-refresh',
		'fa fa-list-alt',
		'fa fa-lock',
		'fa fa-flag',
		'fa fa-headphones',
		'fa fa-volume-off',
		'fa fa-volume-down',
		'fa fa-volume-up',
		'fa fa-qrcode',
		'fa fa-barcode',
		'fa fa-tag',
		'fa fa-tags',
		'fa fa-book',
		'fa fa-bookmark',
		'fa fa-print',
		'fa fa-camera',
		'fa fa-font',
		'fa fa-bold',
		'fa fa-italic',
		'fa fa-text-height',
		'fa fa-text-width',
		'fa fa-align-left',
		'fa fa-align-center',
		'fa fa-align-right',
		'fa fa-align-justify',
		'fa fa-list',
		'fa fa-outdent',
		'fa fa-indent',
		'fa fa-video-camera',
		'fa fa-photo',
		'fa fa-pencil',
		'fa fa-map-marker',
		'fa fa-adjust',
		'fa fa-tint',
		'fa fa-edit',
		'fa fa-share-square-o',
		'fa fa-check-square-o',
		'fa fa-arrows',
		'fa fa-step-backward',
		'fa fa-fast-backward',
		'fa fa-backward',
		'fa fa-play',
		'fa fa-pause',
		'fa fa-stop',
		'fa fa-forward',
		'fa fa-fast-forward',
		'fa fa-step-forward',
		'fa fa-eject',
		'fa fa-chevron-left',
		'fa fa-chevron-right',
		'fa fa-plus-circle',
		'fa fa-minus-circle',
		'fa fa-times-circle',
		'fa fa-check-circle',
		'fa fa-question-circle',
		'fa fa-info-circle',
		'fa fa-crosshairs',
		'fa fa-times-circle-o',
		'fa fa-check-circle-o',
		'fa fa-ban',
		'fa fa-arrow-left',
		'fa fa-arrow-right',
		'fa fa-arrow-up',
		'fa fa-arrow-down',
		'fa fa-share',
		'fa fa-expand',
		'fa fa-compress',
		'fa fa-plus',
		'fa fa-minus',
		'fa fa-asterisk',
		'fa fa-exclamation-circle',
		'fa fa-gift',
		'fa fa-leaf',
		'fa fa-fire',
		'fa fa-eye',
		'fa fa-eye-slash',
		'fa fa-warning',
		'fa fa-plane',
		'fa fa-calendar',
		'fa fa-random',
		'fa fa-comment',
		'fa fa-magnet',
		'fa fa-chevron-up',
		'fa fa-chevron-down',
		'fa fa-retweet',
		'fa fa-shopping-cart',
		'fa fa-folder',
		'fa fa-folder-open',
		'fa fa-arrows-v',
		'fa fa-arrows-h',
		'fa fa-bar-chart',
		'fa fa-twitter-square',
		'fa fa-facebook-square',
		'fa fa-camera-retro',
		'fa fa-key',
		'fa fa-gears',
		'fa fa-comments',
		'fa fa-thumbs-o-up',
		'fa fa-thumbs-o-down',
		'fa fa-star-half',
		'fa fa-heart-o',
		'fa fa-sign-out',
		'fa fa-linkedin-square',
		'fa fa-thumb-tack',
		'fa fa-external-link',
		'fa fa-sign-in',
		'fa fa-trophy',
		'fa fa-github-square',
		'fa fa-upload',
		'fa fa-lemon-o',
		'fa fa-phone',
		'fa fa-square-o',
		'fa fa-bookmark-o',
		'fa fa-phone-square',
		'fa fa-twitter',
		'fa fa-facebook',
		'fa fa-github',
		'fa fa-unlock',
		'fa fa-credit-card',
		'fa fa-rss',
		'fa fa-hdd-o',
		'fa fa-bullhorn',
		'fa fa-bell',
		'fa fa-certificate',
		'fa fa-hand-o-right',
		'fa fa-hand-o-left',
		'fa fa-hand-o-up',
		'fa fa-hand-o-down',
		'fa fa-arrow-circle-left',
		'fa fa-arrow-circle-right',
		'fa fa-arrow-circle-up',
		'fa fa-arrow-circle-down',
		'fa fa-globe',
		'fa fa-wrench',
		'fa fa-tasks',
		'fa fa-filter',
		'fa fa-briefcase',
		'fa fa-arrows-alt',
		'fa fa-users',
		'fa fa-link',
		'fa fa-cloud',
		'fa fa-flask',
		'fa fa-cut',
		'fa fa-copy',
		'fa fa-paperclip',
		'fa fa-save',
		'fa fa-square',
		'fa fa-bars',
		'fa fa-list-ul',
		'fa fa-list-ol',
		'fa fa-strikethrough',
		'fa fa-underline',
		'fa fa-table',
		'fa fa-magic',
		'fa fa-truck',
		'fa fa-pinterest',
		'fa fa-pinterest-square',
		'fa fa-google-plus-square',
		'fa fa-google-plus',
		'fa fa-money',
		'fa fa-caret-down',
		'fa fa-caret-up',
		'fa fa-caret-left',
		'fa fa-caret-right',
		'fa fa-columns',
		'fa fa-sort',
		'fa fa-sort-down',
		'fa fa-sort-up',
		'fa fa-envelope',
		'fa fa-linkedin',
		'fa fa-undo',
		'fa fa-legal',
		'fa fa-dashboard',
		'fa fa-comment-o',
		'fa fa-comments-o',
		'fa fa-flash',
		'fa fa-sitemap',
		'fa fa-umbrella',
		'fa fa-paste',
		'fa fa-lightbulb-o',
		'fa fa-exchange',
		'fa fa-cloud-download',
		'fa fa-cloud-upload',
		'fa fa-user-md',
		'fa fa-stethoscope',
		'fa fa-suitcase',
		'fa fa-bell-o',
		'fa fa-coffee',
		'fa fa-cutlery',
		'fa fa-file-text-o',
		'fa fa-building-o',
		'fa fa-hospital-o',
		'fa fa-ambulance',
		'fa fa-medkit',
		'fa fa-fighter-jet',
		'fa fa-beer',
		'fa fa-h-square',
		'fa fa-plus-square',
		'fa fa-angle-double-left',
		'fa fa-angle-double-right',
		'fa fa-angle-double-up',
		'fa fa-angle-double-down',
		'fa fa-angle-left',
		'fa fa-angle-right',
		'fa fa-angle-up',
		'fa fa-angle-down',
		'fa fa-desktop',
		'fa fa-laptop',
		'fa fa-tablet',
		'fa fa-mobile',
		'fa fa-circle-o',
		'fa fa-quote-left',
		'fa fa-quote-right',
		'fa fa-spinner',
		'fa fa-circle',
		'fa fa-reply',
		'fa fa-github-alt',
		'fa fa-folder-o',
		'fa fa-folder-open-o',
		'fa fa-smile-o',
		'fa fa-frown-o',
		'fa fa-meh-o',
		'fa fa-gamepad',
		'fa fa-keyboard-o',
		'fa fa-flag-o',
		'fa fa-flag-checkered',
		'fa fa-terminal',
		'fa fa-code',
		'fa fa-reply-all',
		'fa fa-star-half-empty',
		'fa fa-location-arrow',
		'fa fa-crop',
		'fa fa-code-fork',
		'fa fa-unlink',
		'fa fa-question',
		'fa fa-info',
		'fa fa-exclamation',
		'fa fa-superscript',
		'fa fa-subscript',
		'fa fa-eraser',
		'fa fa-puzzle-piece',
		'fa fa-microphone',
		'fa fa-microphone-slash',
		'fa fa-shield',
		'fa fa-calendar-o',
		'fa fa-fire-extinguisher',
		'fa fa-rocket',
		'fa fa-maxcdn',
		'fa fa-chevron-circle-left',
		'fa fa-chevron-circle-right',
		'fa fa-chevron-circle-up',
		'fa fa-chevron-circle-down',
		'fa fa-html5',
		'fa fa-css3',
		'fa fa-anchor',
		'fa fa-unlock-alt',
		'fa fa-bullseye',
		'fa fa-ellipsis-h',
		'fa fa-ellipsis-v',
		'fa fa-rss-square',
		'fa fa-play-circle',
		'fa fa-ticket',
		'fa fa-minus-square',
		'fa fa-minus-square-o',
		'fa fa-level-up',
		'fa fa-level-down',
		'fa fa-check-square',
		'fa fa-pencil-square',
		'fa fa-external-link-square',
		'fa fa-share-square',
		'fa fa-compass',
		'fa fa-toggle-down',
		'fa fa-toggle-up',
		'fa fa-toggle-right',
		'fa fa-euro',
		'fa fa-gbp',
		'fa fa-dollar',
		'fa fa-rupee',
		'fa fa-yen',
		'fa fa-ruble',
		'fa fa-won',
		'fa fa-bitcoin',
		'fa fa-file',
		'fa fa-file-text',
		'fa fa-sort-alpha-asc',
		'fa fa-sort-alpha-desc',
		'fa fa-sort-amount-asc',
		'fa fa-sort-amount-desc',
		'fa fa-sort-numeric-asc',
		'fa fa-sort-numeric-desc',
		'fa fa-thumbs-up',
		'fa fa-thumbs-down',
		'fa fa-youtube-square',
		'fa fa-youtube',
		'fa fa-xing',
		'fa fa-xing-square',
		'fa fa-youtube-play',
		'fa fa-dropbox',
		'fa fa-stack-overflow',
		'fa fa-instagram',
		'fa fa-flickr',
		'fa fa-adn',
		'fa fa-bitbucket',
		'fa fa-bitbucket-square',
		'fa fa-tumblr',
		'fa fa-tumblr-square',
		'fa fa-long-arrow-down',
		'fa fa-long-arrow-up',
		'fa fa-long-arrow-left',
		'fa fa-long-arrow-right',
		'fa fa-apple',
		'fa fa-windows',
		'fa fa-android',
		'fa fa-linux',
		'fa fa-dribbble',
		'fa fa-skype',
		'fa fa-foursquare',
		'fa fa-trello',
		'fa fa-female',
		'fa fa-male',
		'fa fa-gittip',
		'fa fa-sun-o',
		'fa fa-moon-o',
		'fa fa-archive',
		'fa fa-bug',
		'fa fa-vk',
		'fa fa-weibo',
		'fa fa-renren',
		'fa fa-pagelines',
		'fa fa-stack-exchange',
		'fa fa-arrow-circle-o-right',
		'fa fa-arrow-circle-o-left',
		'fa fa-toggle-left',
		'fa fa-dot-circle-o',
		'fa fa-wheelchair',
		'fa fa-vimeo-square',
		'fa fa-turkish-lira',
		'fa fa-plus-square-o',
		'fa fa-space-shuttle',
		'fa fa-slack',
		'fa fa-envelope-square',
		'fa fa-wordpress',
		'fa fa-openid',
		'fa fa-institution',
		'fa fa-graduation-cap',
		'fa fa-yahoo',
		'fa fa-google',
		'fa fa-reddit',
		'fa fa-reddit-square',
		'fa fa-stumbleupon-circle',
		'fa fa-stumbleupon',
		'fa fa-delicious',
		'fa fa-digg',
		'fa fa-pied-piper',
		'fa fa-pied-piper-alt',
		'fa fa-drupal',
		'fa fa-joomla',
		'fa fa-language',
		'fa fa-fax',
		'fa fa-building',
		'fa fa-child',
		'fa fa-paw',
		'fa fa-spoon',
		'fa fa-cube',
		'fa fa-cubes',
		'fa fa-behance',
		'fa fa-behance-square',
		'fa fa-steam',
		'fa fa-steam-square',
		'fa fa-recycle',
		'fa fa-car',
		'fa fa-taxi',
		'fa fa-tree',
		'fa fa-spotify',
		'fa fa-deviantart',
		'fa fa-soundcloud',
		'fa fa-database',
		'fa fa-file-pdf-o',
		'fa fa-file-word-o',
		'fa fa-file-excel-o',
		'fa fa-file-powerpoint-o',
		'fa fa-file-photo-o',
		'fa fa-file-zip-o',
		'fa fa-file-sound-o',
		'fa fa-file-movie-o',
		'fa fa-file-code-o',
		'fa fa-vine',
		'fa fa-codepen',
		'fa fa-jsfiddle',
		'fa fa-support',
		'fa fa-circle-o-notch',
		'fa fa-rebel',
		'fa fa-empire',
		'fa fa-git-square',
		'fa fa-git',
		'fa fa-y-combinator-square',
		'fa fa-tencent-weibo',
		'fa fa-qq',
		'fa fa-wechat',
		'fa fa-send',
		'fa fa-send-o',
		'fa fa-history',
		'fa fa-circle-thin',
		'fa fa-header',
		'fa fa-paragraph',
		'fa fa-sliders',
		'fa fa-share-alt',
		'fa fa-share-alt-square',
		'fa fa-bomb',
		'fa fa-soccer-ball-o',
		'fa fa-tty',
		'fa fa-binoculars',
		'fa fa-plug',
		'fa fa-slideshare',
		'fa fa-twitch',
		'fa fa-yelp',
		'fa fa-newspaper-o',
		'fa fa-wifi',
		'fa fa-calculator',
		'fa fa-paypal',
		'fa fa-google-wallet',
		'fa fa-cc-visa',
		'fa fa-cc-mastercard',
		'fa fa-cc-discover',
		'fa fa-cc-amex',
		'fa fa-cc-paypal',
		'fa fa-cc-stripe',
		'fa fa-bell-slash',
		'fa fa-bell-slash-o',
		'fa fa-trash',
		'fa fa-copyright',
		'fa fa-at',
		'fa fa-eyedropper',
		'fa fa-paint-brush',
		'fa fa-birthday-cake',
		'fa fa-area-chart',
		'fa fa-pie-chart',
		'fa fa-line-chart',
		'fa fa-lastfm',
		'fa fa-lastfm-square',
		'fa fa-toggle-off',
		'fa fa-toggle-on',
		'fa fa-bicycle',
		'fa fa-bus',
		'fa fa-ioxhost',
		'fa fa-angellist',
		'fa fa-cc',
		'fa fa-shekel',
		'fa fa-meanpath',
		'fa fa-buysellads',
		'fa fa-connectdevelop',
		'fa fa-dashcube',
		'fa fa-forumbee',
		'fa fa-leanpub',
		'fa fa-sellsy',
		'fa fa-shirtsinbulk',
		'fa fa-simplybuilt',
		'fa fa-skyatlas',
		'fa fa-cart-plus',
		'fa fa-cart-arrow-down',
		'fa fa-diamond',
		'fa fa-ship',
		'fa fa-user-secret',
		'fa fa-motorcycle',
		'fa fa-street-view',
		'fa fa-heartbeat',
		'fa fa-venus',
		'fa fa-mars',
		'fa fa-mercury',
		'fa fa-transgender',
		'fa fa-transgender-alt',
		'fa fa-venus-double',
		'fa fa-mars-double',
		'fa fa-venus-mars',
		'fa fa-mars-stroke',
		'fa fa-mars-stroke-v',
		'fa fa-mars-stroke-h',
		'fa fa-neuter',
		'fa fa-genderless',
		'fa fa-facebook-official',
		'fa fa-pinterest-p',
		'fa fa-whatsapp',
		'fa fa-server',
		'fa fa-user-plus',
		'fa fa-user-times',
		'fa fa-hotel',
		'fa fa-viacoin',
		'fa fa-train',
		'fa fa-subway',
		'fa fa-medium',
		'fa fa-y-combinator',
		'fa fa-optin-monster',
		'fa fa-opencart',
		'fa fa-expeditedssl',
		'fa fa-battery-full',
		'fa fa-battery-three-quarters',
		'fa fa-battery-half',
		'fa fa-battery-quarter',
		'fa fa-battery-empty',
		'fa fa-mouse-pointer',
		'fa fa-i-cursor',
		'fa fa-object-group',
		'fa fa-object-ungroup',
		'fa fa-sticky-note',
		'fa fa-sticky-note-o',
		'fa fa-cc-jcb',
		'fa fa-cc-diners-club',
		'fa fa-clone',
		'fa fa-balance-scale',
		'fa fa-hourglass-o',
		'fa fa-hourglass-start',
		'fa fa-hourglass-half',
		'fa fa-hourglass-end',
		'fa fa-hourglass',
		'fa fa-hand-rock-o',
		'fa fa-hand-paper-o',
		'fa fa-hand-scissors-o',
		'fa fa-hand-lizard-o',
		'fa fa-hand-spock-o',
		'fa fa-hand-pointer-o',
		'fa fa-hand-peace-o',
		'fa fa-trademark',
		'fa fa-registered',
		'fa fa-creative-commons',
		'fa fa-gg',
		'fa fa-gg-circle',
		'fa fa-tripadvisor',
		'fa fa-odnoklassniki',
		'fa fa-odnoklassniki-square',
		'fa fa-get-pocket',
		'fa fa-wikipedia-w',
		'fa fa-safari',
		'fa fa-chrome',
		'fa fa-firefox',
		'fa fa-opera',
		'fa fa-internet-explorer',
		'fa fa-television',
		'fa fa-contao',
		'fa fa-500px',
		'fa fa-amazon',
		'fa fa-calendar-plus-o',
		'fa fa-calendar-minus-o',
		'fa fa-calendar-times-o',
		'fa fa-calendar-check-o',
		'fa fa-industry',
		'fa fa-map-pin',
		'fa fa-map-signs',
		'fa fa-map-o',
		'fa fa-map',
		'fa fa-commenting',
		'fa fa-commenting-o',
		'fa fa-houzz',
		'fa fa-vimeo',
		'fa fa-black-tie',
		'fa fa-fonticons',
		'fa fa-reddit-alien',
		'fa fa-edge',
		'fa fa-credit-card-alt',
		'fa fa-codiepie',
		'fa fa-modx',
		'fa fa-fort-awesome',
		'fa fa-usb',
		'fa fa-product-hunt',
		'fa fa-mixcloud',
		'fa fa-scribd',
		'fa fa-pause-circle',
		'fa fa-pause-circle-o',
		'fa fa-stop-circle',
		'fa fa-stop-circle-o',
		'fa fa-shopping-bag',
		'fa fa-shopping-basket',
		'fa fa-hashtag',
		'fa fa-bluetooth',
		'fa fa-bluetooth-b',
		'fa fa-percent',
		'fa fa-gitlab',
		'fa fa-wpbeginner',
		'fa fa-wpforms',
		'fa fa-envira',
		'fa fa-universal-access',
		'fa fa-wheelchair-alt',
		'fa fa-question-circle-o',
		'fa fa-blind',
		'fa fa-audio-description',
		'fa fa-volume-control-phone',
		'fa fa-braille',
		'fa fa-assistive-listening-systems',
		'fa fa-asl-interpreting',
		'fa fa-deaf',
		'fa fa-glide',
		'fa fa-glide-g',
		'fa fa-signing',
		'fa fa-low-vision',
		'fa fa-viadeo',
		'fa fa-viadeo-square',
		'fa fa-snapchat',
		'fa fa-snapchat-ghost',
		'fa fa-snapchat-square',
		'sli-user',
		'sli-people',
		'sli-user-female',
		'sli-user-follow',
		'sli-user-following',
		'sli-user-unfollow',
		'sli-login',
		'sli-logout',
		'sli-emotsmile',
		'sli-phone',
		'sli-call-end',
		'sli-call-in',
		'sli-call-out',
		'sli-map',
		'sli-location-pin',
		'sli-direction',
		'sli-directions',
		'sli-compass',
		'sli-layers',
		'sli-menu',
		'sli-list',
		'sli-options-vertical',
		'sli-options',
		'sli-arrow-down',
		'sli-arrow-left',
		'sli-arrow-right',
		'sli-arrow-up',
		'sli-arrow-up-circle',
		'sli-arrow-left-circle',
		'sli-arrow-right-circle',
		'sli-arrow-down-circle',
		'sli-check',
		'sli-clock',
		'sli-plus',
		'sli-close',
		'sli-trophy',
		'sli-screen-smartphone',
		'sli-screen-desktop',
		'sli-plane',
		'sli-notebook',
		'sli-mustache',
		'sli-mouse',
		'sli-magnet',
		'sli-energy',
		'sli-disc',
		'sli-cursor',
		'sli-cursor-move',
		'sli-crop',
		'sli-chemistry',
		'sli-speedometer',
		'sli-shield',
		'sli-screen-tablet',
		'sli-magic-wand',
		'sli-hourglass',
		'sli-graduation',
		'sli-ghost',
		'sli-game-controller',
		'sli-fire',
		'sli-eyeglass',
		'sli-envelope-open',
		'sli-envelope-letter',
		'sli-bell',
		'sli-badge',
		'sli-anchor',
		'sli-wallet',
		'sli-vector',
		'sli-speech',
		'sli-puzzle',
		'sli-printer',
		'sli-present',
		'sli-playlist',
		'sli-pin',
		'sli-picture',
		'sli-handbag',
		'sli-globe-alt',
		'sli-globe',
		'sli-folder-alt',
		'sli-folder',
		'sli-film',
		'sli-feed',
		'sli-drop',
		'sli-drawer',
		'sli-docs',
		'sli-doc',
		'sli-diamond',
		'sli-cup',
		'sli-calculator',
		'sli-bubbles',
		'sli-briefcase',
		'sli-book-open',
		'sli-basket-loaded',
		'sli-basket',
		'sli-bag',
		'sli-action-undo',
		'sli-action-redo',
		'sli-wrench',
		'sli-umbrella',
		'sli-trash',
		'sli-tag',
		'sli-support',
		'sli-frame',
		'sli-size-fullscreen',
		'sli-size-actual',
		'sli-shuffle',
		'sli-share-alt',
		'sli-share',
		'sli-rocket',
		'sli-question',
		'sli-pie-chart',
		'sli-pencil',
		'sli-note',
		'sli-loop',
		'sli-home',
		'sli-grid',
		'sli-graph',
		'sli-microphone',
		'sli-music-tone-alt',
		'sli-music-tone',
		'sli-earphones-alt',
		'sli-earphones',
		'sli-equalizer',
		'sli-like',
		'sli-dislike',
		'sli-control-start',
		'sli-control-rewind',
		'sli-control-play',
		'sli-control-pause',
		'sli-control-forward',
		'sli-control-end',
		'sli-volume-1',
		'sli-volume-2',
		'sli-volume-off',
		'sli-calendar',
		'sli-bulb',
		'sli-chart',
		'sli-ban',
		'sli-bubble',
		'sli-camrecorder',
		'sli-camera',
		'sli-cloud-download',
		'sli-cloud-upload',
		'sli-envelope',
		'sli-eye',
		'sli-flag',
		'sli-heart',
		'sli-info',
		'sli-key',
		'sli-link',
		'sli-lock',
		'sli-lock-open',
		'sli-magnifier',
		'sli-magnifier-add',
		'sli-magnifier-remove',
		'sli-paper-clip',
		'sli-paper-plane',
		'sli-power',
		'sli-refresh',
		'sli-reload',
		'sli-settings',
		'sli-star',
		'sli-symbol-female',
		'sli-symbol-male',
		'sli-target',
		'sli-credit-card',
		'sli-paypal',
		'sli-social-tumblr',
		'sli-social-twitter',
		'sli-social-facebook',
		'sli-social-instagram',
		'sli-social-linkedin',
		'sli-social-pinterest',
		'sli-social-github',
		'sli-social-gplus',
		'sli-social-reddit',
		'sli-social-skype',
		'sli-social-dribbble',
		'sli-social-behance',
		'sli-social-foursqare',
		'sli-social-soundcloud',
		'sli-social-spotify',
		'sli-social-stumbleupon',
		'sli-social-youtube',
		'sli-social-dropbox'
	];

	// add new block
	block_list.on('click', function(e){
		e.preventDefault();

		var _this = $(this);
		var item_cloned = default_list_container.find('div[data-type="' + _this.data('block') + '"]').clone(true);

		empty_message.hide();
		delete_all_blocks.prop('disabled', false);

		if (item_cloned) {
			// add content block only once
			if (content_block_added && _this.data('block') === 'page-content') {
				return;
			}

			item_cloned.find('.item-xml').attr('name', 'item-xml[]');
			grid_container.append(item_cloned);

			if (_this.data('block') === 'page-content') {
				content_block_added = true;
			}

			var editor = item_cloned.find('textarea.wp-editor-area');

			if (editor.length > 0) {
				clone_editor(item_cloned, editor);
			}

			// minicolors
			item_cloned.find('.input-color').minicolors();

			sortable_block_images();
		}
	});

	// open edit box
	open_box.on('click', function(e){
		e.preventDefault();

		var obfuscator;
		var _this = $(this);
		var item_clicked = _this.parents('.page-item');

		// open the box
		item_clicked.find('.edit-item').show();

		// create overlay
		obfuscator = _doc.createElement('div');
		obfuscator.id = 'page-builder-obfuscator';
		_html.appendChild(obfuscator);
	});

	// close edit box
	$(_doc).on('click', '.edit-item-close-btn', function(e){
		e.preventDefault();

		grid_container.find('.edit-item').hide();
		$('#page-builder-obfuscator').remove();
	});

	// close the edit box when the user clicks on the obfuscator
	// but keep it open if the font-picker modal is open
	$(_doc).on('click', '#page-builder-obfuscator', function(e){
		e.preventDefault();

		if (!$(_html).hasClass('font-picker-modal-open')) {
			grid_container.find('.edit-item').hide();
			$('#page-builder-obfuscator').remove();
		}
	});

	// delete item
	delete_button.on('click', function(){
		var _this = $(this);
		var item_clicked = _this.parents('.page-item');

		if (window.confirm(lpb_admin_vars.delete_block)) {
			var count_blocks = grid_container.find('.page-item').length;

			item_clicked.fadeOut(function(){
				if (item_clicked.data('type') === 'page-content') {
					content_block_added = false;
				}

				item_clicked.remove();

				if (count_blocks < 2) {
					empty_message.show();
					delete_all_blocks.prop('disabled', true);
				}
			});
		}
	});

	// delete all blocks
	delete_all_blocks.on('click', function(e){
		e.preventDefault();

		if (window.confirm('Are you sure you want to remove this block?')) {
			var blocks = grid_container.find('.page-item');

			blocks.fadeOut(function(){
				blocks.remove();
				empty_message.show();
				content_block_added = false;
				delete_all_blocks.prop('disabled', true);
			});
		}
	});

	// add size
	add_size.on('click', function(){
		var _this = $(this);
		var item_clicked = _this.parents('.page-item');
		var scalable = false;
		var current_size;

		for (var i = 0; i < item_size.length - 1; i++) {
			if (item_clicked.hasClass(item_size[i][0])) {
				scalable = true;
				current_size = item_size[i][0];
			}
			if (scalable) {
				if (i < item_size.length - 2) {
					item_clicked.removeClass(current_size).addClass(item_size[i+1][0]);
					item_clicked.find('input.item-size').val(item_size[i+1][1]);
				} else if (i === item_size.length - 2) {
					item_clicked.removeClass(current_size).addClass(item_size[i+1][0]);
					item_clicked.find('input.item-size').val(item_size[i+1][1]);
				}
				break;
			}
		}
	});

	// sub size
	sub_size.on('click', function(){
		var _this = $(this);
		var item_clicked = _this.parents('.page-item');
		var scalable = false;
		var current_size;

		for (var i = item_size.length - 1; i > 0; i--) {
			if (item_clicked.hasClass(item_size[i][0])) {
				scalable = true;
				current_size = item_size[i][0];
			}

			if (scalable) {
				if (i > 1) {
					item_clicked.removeClass(current_size).addClass(item_size[i-1][0]);
					item_clicked.find('input.item-size').val(item_size[i-1][1]);
				} else if (i === 1) {
					item_clicked.removeClass(current_size).addClass(item_size[i-1][0]);
					item_clicked.find('input.item-size').val(item_size[i-1][1]);
				}
				break;
			}
		}
	});

	// clone item
	clone_box.on('click', function(){
		var _this = $(this);
		var item_clicked = _this.parents('.page-item');
		var item_cloned = item_clicked.clone(true);
		var next_item = item_clicked.next();

		clone_textareas(item_clicked, item_cloned);
		clone_selects(item_clicked, item_cloned);

		if (next_item.length) {
			next_item.before(item_cloned);
		} else {
			grid_container.append(item_cloned);
		}

		var editor = item_cloned.find('textarea.wp-editor-area');

		if (editor.length > 0) {
			clone_editor(item_cloned, editor);
		}

		// minicolors
		$('.input-color').minicolors('destroy');
		$('.input-color').minicolors();
	});

	// minicolors
	color_inputs.minicolors();

	// sortable items
	grid_container.sortable({
		handle: '.handle',
		forcePlaceholderSize: true,
		placeholder: 'placeholder-item'
	});

	// generate icons
	build_icon_list();

	// open font picker
	// icon_inputs.on('click', function(e){
	$(_doc).on('click', '.form-field-icon button', function(e){
		e.preventDefault();

		var _this = $(this);
		var icon = '';
		last_icon_input_clicked = _this.prev().find('input');
		icon = last_icon_input_clicked.val();

		set_modal_selected_icon(icon, last_icon_input_clicked);
		$('#font-picker-modal').show();
		$(_html).addClass('font-picker-modal-open');
	});

	$('#font-picker-modal').on('click', 'a.font-picker-item', function(e){
		e.preventDefault();

		var modal = $('#font-picker-modal');
		var icon = $(this).data('picker-icon');

		modal.find('a.font-picker-item').removeClass('active');
		set_modal_selected_icon(icon, last_icon_input_clicked);
	});

	// close font picker
	$('#close-font-picker').on('click', function(e){
		e.preventDefault();

		$('#font-picker-modal').hide();
		$(_html).removeClass('font-picker-modal-open');
	});

	// add images to the block
	$('.block-upload').on('click', function() {
		var _this = $(this);
		var block_upload_frame;
		var multiple = _this.data('multiple');
		var block_images = _this.parent().find('ul.block-images');
		var input = _this.parent().find('input.input-image');

		multiple = (multiple === true) ? true : false;

		// If the media frame already exists, reopen it.
		if (block_upload_frame) {
			block_upload_frame.open();
			return;
		}

		// Create the media frame.
		block_upload_frame = wp.media.frames.block_upload = wp.media({
			states: [
				new wp.media.controller.Library({
					title: _this.data('choose'),
					filterable: 'all',
					multiple: multiple
				})
			]
		});

		// When an image is selected, run a callback.
		block_upload_frame.on('select', function() {
			var selection      = block_upload_frame.state().get('selection');
			var attachment_ids = input.val();

			selection.map(function(attachment) {
				attachment = attachment.toJSON();

				if (attachment.id) {
					attachment_ids   = attachment_ids && multiple ? attachment_ids + ',' + attachment.id : attachment.id;
					var attachment_image = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;

					if (multiple) {
						block_images.append('<li class="image" data-attachment_id="' + attachment.id + '"><img src="' + attachment_image + '" /><a href="#" class="delete-block-image">' + _this.data('text') + '</a></li>');
					} else {
						block_images.empty().append('<li class="image" data-attachment_id="' + attachment.id + '"><img src="' + attachment_image + '" /><a href="#" class="delete-block-image">' + _this.data('text') + '</a></li>');
					}
				}
			});

			input.val(attachment_ids);
		});

		// Finally, open the modal.
		block_upload_frame.open();
	});

	sortable_block_images();

	// add images to the block
	$('.block-images').on('click', 'a.delete-block-image', function(e) {
		e.preventDefault();

		var _this = $(this);
		var attachment_ids = '';
		var container = _this.closest('.form-field');
		var block_images = container.find('ul.block-images');
		var input = container.find('input.input-image');
		var multiple = container.find('button').data('multiple');

		multiple = (multiple === true) ? true : false;
		_this.parent().remove();

		if (multiple) {
			block_images.find('li.image').css('cursor', 'default').each(function() {
				var attachment_id = $(this).attr('data-attachment_id');
				attachment_ids    = attachment_ids + attachment_id + ',';
			});
		}

		input.val(attachment_ids);
	});

	// change image source in select-images inputs
	$('.select-images').on('change', function() {
		var _this = $(this);
		var img_url = _this.find('option:selected').attr('data-url');
		var img = _this.closest('.form-field').find('img');

		img.attr('src', img_url);
	});

	// save xml items
	$('#publish, #save-post').on('click', function(){
		var items_collection = grid_container.find('.page-item');
		var check_js = $('#check-js');

		items_collection.each(function() {
			var _this = $(this);
			var item_type = _this.attr('data-type');
			var type_collection = $('.item-'+item_type);

			populate_xml(type_collection, item_type);
		});

		check_js.val('js');
	});

	// hide/show blog block options on change
	grid_container.on('change', 'select.blog-order', function(){
		var _this = $(this);
		var container = _this.closest('.settings');
		var ids_field = container.find('.blog-order-ids');
		var category_field = container.find('.blog-order-category');

		if (_this.val() === 'ids') {
			ids_field.show();
			category_field.hide();
		} else if (_this.val() === 'category') {
			ids_field.hide();
			category_field.show();
		} else {
			ids_field.hide();
			category_field.hide();
		}
	});

	hide_show_blog_options();

	// build xml
	function populate_xml(items, item){
		var xml_value = '';

		items.each(function(index){
			if (index > 0) {
				var _this = $(this);
				var items_inputs = _this.find('.xml');

				xml_value += '<' + item + '>';

				items_inputs.each(function() {
					var _this = $(this);
					var item_tag = _this.attr('data-type');
					var item_value = _this.val();
					var item_xml = '';

					if (_this.hasClass('esc')) {
						item_xml = tag_xml_esc(item_tag, item_value);
					} else {
						item_xml = tag_xml(item_tag, item_value);
					}

					xml_value += item_xml;
				});

				xml_value += '</' + item + '>';
				_this.find('.item-xml').val(xml_value);
				xml_value = '';
			}
		});
	}

	// build tag xml
	function tag_xml(type, value) {
		return '<'+type+'>'+value+'</'+type+'>';
	}

	// build tag xml escape
	function tag_xml_esc(type, value) {
		return '<'+type+'><![CDATA['+value+']]></'+type+'>';
	}

	// clone wp_editor
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

	// generate icon list
	function build_icon_list() {
		var modal;
		var button;

		// create modal
		modal = _doc.createElement('div');
		modal.id = 'font-picker-modal';
		_html.appendChild(modal);

		// create close button
		button = _doc.createElement('div');
		button.id = 'close-font-picker';
		button.innerHTML = '<i class="fa fa-remove"></i>';
		modal.appendChild(button);

		// append icons
		$(modal).append('<span class="font-picker-zoom"><i class=""></i></span>');

		for (var i in icons) {
			$(modal).append('<a href="#" class="font-picker-item" data-picker-icon="' + icons[i] + '"><i class="' + icons[i] + '"></i></a>');
		}
	}

	// set selected icon
	function set_modal_selected_icon(icon, input) {
		var modal = $('#font-picker-modal');
		var zoom_preview = modal.find('.font-picker-zoom i');

		// set icon in modal
		zoom_preview.attr('class', icon);
		modal.find('a.font-picker-item').removeClass('active');
		modal.find('a[data-picker-icon="' + icon + '"]').addClass('active');

		// set input value
		if (input.length) {
			input.val(icon);
		}
	}

	// sort block images
	function sortable_block_images() {
		grid_container.find('ul.sortable-true').sortable({
			items: 'li.image',
			cursor: 'move',
			forcePlaceholderSize: true,
			forceHelperSize: false,
			helper: 'clone',
			opacity: 0.65,
			placeholder: 'lpb-image-sortable-placeholder',
			start: function(event, ui) {
				var styles = {
					backgroundColor : '#f6f6f6'
				};

				ui.item.css(styles);
			},
			stop: function(event, ui) {
				ui.item.removeAttr('style');
			},
			update: function() {
				var _this = $(this);
				var attachment_ids = '';
				var input = _this.parent().parent().find('input.input-image');


				_this.find('li.image').css('cursor', 'default').each(function() {
					var attachment_id = $(this).attr('data-attachment_id');
					attachment_ids    = attachment_ids + attachment_id + ',';
				});

				input.val(attachment_ids);
			}
		});
	}

	// hide/show blog block options on change
	function hide_show_blog_options() {
		var selects = grid_container.find('select.blog-order');
		$('.blog-order-ids').hide();
		$('.blog-order-category').hide();

		selects.each(function(){
			var _this = $(this);
			var container = _this.closest('.settings');
			var ids_field = container.find('.blog-order-ids');
			var category_field = container.find('.blog-order-category');

			if (_this.val() === 'ids') {
				ids_field.show();
				category_field.hide();
			} else if (_this.val() === 'category') {
				ids_field.hide();
				category_field.show();
			} else {
				ids_field.hide();
				category_field.hide();
			}
		});
	}

	// clone textareas
	function clone_textareas(item, item_cloned) {
		var original_textareas = item.find('textarea');
		var original_textareas_val = [];

		if (original_textareas.length) {
			original_textareas.each(function(index) {
				original_textareas_val.push(original_textareas.eq(index).val());
			});
			var cloned_textareas = item_cloned.find('textarea');

			cloned_textareas.each(function(index) {
				cloned_textareas.eq(index).val(original_textareas_val[index]);
			});
		}
	}

	// clone selects
	function clone_selects(item, item_cloned) {
		var original_selects = item.find('select');
		var original_selects_val = [];

		if (original_selects.length) {
			original_selects.each(function(index) {
				original_selects_val.push(original_selects.eq(index).val());
			});
			var cloned_selects = item_cloned.find('select');

			cloned_selects.each(function(index) {
				cloned_selects.eq(index).val(original_selects_val[index]);
			});
		}
	}
});
