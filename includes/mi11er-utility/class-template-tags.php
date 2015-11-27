<?php
/**
 * Template Tags
 *
 * @package Mi11er\Utility
 */

namespace Mi11er\Utility;

use Mi11er\Utility\Template_Tags as TT;

/**
 * Various Tags for templating
 */
class Template_Tags
{
	/**
	 * Echos the home url for the current site with optional path appended.
	 *
	 * @param  string $path   Optional. Path relative to the home url. Default empty.
	 * @param  string $scheme Optional. Scheme to give the home url context. Accepts
	 *                        'http', 'https', or 'relative'. Default null.
	 */
	public static function the_home_url( $path = '', $scheme = null ) {
		echo esc_url( home_url( $path, $scheme ) );
	}
	
	/**
	 * Echo The favicon links.
	 */
	public static function the_icon_links() {
		$msapplication_notification_polling_uris = apply_filters( 'mi11er_utility_favicon_msapplication_notification_urls', array( home_url( '/feed/' ) ) );
		$msapplication_tile_color                = apply_filters( 'mi11er_utility_favicon_msapplication_tile_color', '#005596' );
		$msapplication_name                      = apply_filters( 'mi11er_utility_favicon_msapplication_name', get_bloginfo( 'name' ) );
		$msapplication_tooltip                   = apply_filters( 'mi11er_utility_favicon_msapplication_tooltip', get_bloginfo( 'description' ) );
?>
		<!-- ======================== BEGIN SITE ICONS ======================== -->
		<link rel="apple-touch-icon" sizes="57x57" href="<?php TT::the_home_url( '/apple-touch-icon-57x57.png' ); ?>">
		<link rel="apple-touch-icon" sizes="60x60" href="<?php TT::the_home_url( '/apple-touch-icon-60x60.png' ); ?>">
		<link rel="apple-touch-icon" sizes="72x72" href="<?php TT::the_home_url( '/apple-touch-icon-72x72.png' ); ?>">
		<link rel="apple-touch-icon" sizes="76x76" href="<?php TT::the_home_url( '/apple-touch-icon-76x76.png' ); ?>">
		<link rel="apple-touch-icon" sizes="114x114" href="<?php TT::the_home_url( '/apple-touch-icon-114x114.png' ); ?>">
		<link rel="apple-touch-icon" sizes="120x120" href="<?php TT::the_home_url( '/apple-touch-icon-120x120.png' ); ?>">
		<link rel="apple-touch-icon" sizes="144x144" href="<?php TT::the_home_url( '/apple-touch-icon-144x144.png' ); ?>">
		<link rel="apple-touch-icon" sizes="152x152" href="<?php TT::the_home_url( '/apple-touch-icon-152x152.png' ); ?>">
		<link rel="apple-touch-icon" sizes="180x180" href="<?php TT::the_home_url( '/apple-touch-icon-180x180.png' ); ?>">
		<link rel="icon" type="image/png" href="<?php TT::the_home_url( '/favicon-32x32.png' ); ?>" sizes="32x32">
		<link rel="icon" type="image/png" href="<?php TT::the_home_url( '/favicon-194x194.png' ); ?>" sizes="194x194">
		<link rel="icon" type="image/png" href="<?php TT::the_home_url( '/favicon-96x96.png' ); ?>" sizes="96x96">
		<link rel="icon" type="image/png" href="<?php TT::the_home_url( '/android-chrome-192x192.png' ); ?>" sizes="192x192">
		<link rel="icon" type="image/png" href="<?php TT::the_home_url( '/favicon-16x16.png' ); ?>" sizes="16x16">
		<link rel="manifest" href="<?php TT::the_home_url( '/manifest.json' ); ?>">
		<link rel="mask-icon" href="<?php TT::the_home_url( '/safari-pinned-tab.svg' ); ?>" color="#5bbad5">
		<meta name="msapplication-TileColor" content="<?php echo esc_attr( $msapplication_tile_color ); ?>">
		<meta name="msapplication-TileImage" content="<?php TT::the_home_url( '/mstile-144x144.png' ); ?>">
		<meta name="theme-color" content="#ffffff">
		<!-- ======================== END SITE ICONS ======================== -->
<?php
	}
}
