<?php
/**
 * Template for browserconfig.xml
 *
 * @package Mi11er\Utility
 */

namespace Mi11er\Utility;

$manifest = [
	'name' => 'test',
	'icons' => [
		[
			'src' => get_the_site_icon_url( 'android-chrome-36x36.png' ),
			'sizes' => '36x36',
			'type' => 'image/png',
			'density' => 0.75,
		],
		[
			'src' => get_the_site_icon_url( 'android-chrome-48x48.png' ),
			'sizes' => '48x48',
			'type' => 'image/png',
			'density' => 1,
		],
		[
			'src' => get_the_site_icon_url( 'android-chrome-72x72.png' ),
			'sizes' => '72x72',
			'type' => 'image/png',
			'density' => 1.5,
		],
		[
			'src' => get_the_site_icon_url( 'android-chrome-96x96.png' ),
			'sizes' => '96x96',
			'type' => 'image/png',
			'density' => 2,
		],
		[
			'src' => get_the_site_icon_url( 'android-chrome-144x144.png' ),
			'sizes' => '144x144',
			'type' => 'image/png',
			'density' => 3,
		],
		[
			'src' => get_the_site_icon_url( 'android-chrome-192x192.png' ),
			'sizes' => '192x192',
			'type' => 'image/png',
			'density' => 4,
		],
	],
];

wp_send_json( $manifest );
