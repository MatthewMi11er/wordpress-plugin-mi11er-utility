<?php
/**
 * Favicons
 *
 * @package Mi11er\Utility
 */

namespace Mi11er\Utility;

use Mi11er\Utility\Template_Tags as TT;

/**
 * This class provides functions for loading the site favicons
 * The images below must be accessable from the site root:
 *   - favicon.ico
 *   - apple-touch-icon-precomposed.png
 *   - apple-touch-icon-precomposed-57x57.png
 *   - apple-touch-icon-precomposed-72x72.png
 *   - apple-touch-icon-precomposed-76x76.png
 *   - apple-touch-icon-precomposed-114x114.png
 *   - apple-touch-icon-precomposed-120x120.png
 *   - apple-touch-icon-precomposed-144x144.png
 *   - apple-touch-icon-precomposed-152x152.png
 *   - windows-live-tile-144x144.png
 *   - windows-live-tile-128x128.png
 *   - windows-live-tile-270x270.png
 *   - windows-live-tile-558x558.png
 *   - windows-live-tile-558x270.png
 *
 * TODO: Figure out a way to load these dynamically (eg. from a filter).
 */
class Favicons
{
	/**
	 * Print the favicon links
	 */
	public static function the_favicon_links() {
		$msapplication_notification_polling_uris = apply_filters( 'mi11er_utility_favicon_msapplication_notification_urls', array( home_url( '/feed/' ) ) );
		$msapplication_tile_color                = apply_filters( 'mi11er_utility_favicon_msapplication_tile_color', '#005596' );
		$msapplication_name                      = apply_filters( 'mi11er_utility_favicon_msapplication_name', get_bloginfo( 'name' ) );
		$msapplication_tooltip                   = apply_filters( 'mi11er_utility_favicon_msapplication_tooltip', get_bloginfo( 'description' ) );
?>
    <link rel="shortcut icon" type="image/x-icon" href="<?php TT::the_home_url( '/favicon.ico' ); ?>"/>
    <link rel="apple-touch-icon-precomposed" href="<?php TT::the_home_url( '/apple-touch-icon-precomposed.png' ); ?>" />
    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php TT::the_home_url( '/apple-touch-icon-precomposed-57x57.png' ); ?>" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php TT::the_home_url( '/apple-touch-icon-precomposed-72x72.png' ); ?>" />
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="<?php TT::the_home_url( '/apple-touch-icon-precomposed-76x76.png' ); ?>" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php TT::the_home_url( '/apple-touch-icon-precomposed-114x114.png' ); ?>" />
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?php TT::the_home_url( '/apple-touch-icon-precomposed-120x120.png' ); ?>" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php TT::the_home_url( '/apple-touch-icon-precomposed-144x144.png' ); ?>" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php TT::the_home_url( '/apple-touch-icon-precomposed-152x152.png' ); ?>" />
    <!-- ie10 -->
    <meta name="msapplication-TileColor" content="<?php echo esc_attr( $msapplication_tile_color ); ?>"/>
    <meta name="msapplication-TileImage" content="<?php TT::the_home_url( '/windows-live-tile-144x144.png' ); ?>" />
    <!-- /ie10 -->
    <!-- recommended windows 8 pinned site icon sizes http://msdn.microsoft.com/en-us/library/dn455106(v=vs.85).aspx -->
    <meta name="msapplication-square70x70logo" content="<?php TT::the_home_url( '/windows-live-tile-128x128.png' ); ?>" />
    <meta name="msapplication-square150x150logo" content="<?php TT::the_home_url( '/windows-live-tile-270x270.png' ); ?>" />
    <meta name="msapplication-square310x310logo" content="<?php TT::the_home_url( '/windows-live-tile-558x558.png' ); ?>" />
    <meta name="msapplication-wide310x150logo" content="<?php TT::the_home_url( '/windows-live-tile-558x270.png' ); ?>" />
    <meta name="msapplication-tooltip" content="<?php echo esc_attr( $msapplication_tooltip ); ?>"/>
    <meta name="msapplication-notification" content="frequency=180;<?php self::the_msapplication_notification_polling_uris( $msapplication_notification_polling_uris ); ?>">
    <meta name="application-name" content="<?php echo esc_attr( $msapplication_name ); ?>" />
<?php
	}

	/**
	 * Echos concatenated msapplication-notification polling uri string
	 *
	 * @param array $msapplication_notification_polling_uris The list of uris to print.
	 */
	public static function the_msapplication_notification_polling_uris( $msapplication_notification_polling_uris ) {
		foreach ( $msapplication_notification_polling_uris as $key => $value ) {
			$prefix = 0 === $key ? 'polling-uri' : ';polling-uri' . ( $key + 1 );
			echo esc_attr( $prefix . '=' . $value );
		}
	}
}
