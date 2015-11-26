<?php
/**
 * Favicons and other icons
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
class Site_Icons
{
	/**
	 * Print the favicon links
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
		<meta name="msapplication-TileColor" content="#da532c">
		<meta name="msapplication-TileImage" content="<?php TT::the_home_url( '/mstile-144x144.png' ); ?>">
		<meta name="theme-color" content="#ffffff">
		
		
		    <!-- ======================== END SITE ICONS ======================== -->
		

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
		
		return $IND.'<!-- ======================== FAVICONS ======================== -->'.$NL
					.$IND.'<link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">'.$NL
					.$IND.'<link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">'.$NL
					.$IND.'<link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">'.$NL
					.$IND.'<link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png">'.$NL
					.$IND.'<link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">'.$NL
					.$IND.'<link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">'.$NL
					.$IND.'<link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">'.$NL
					.$IND.'<link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png">'.$NL
					.$IND.'<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png">'.$NL
					.$IND.'<link rel="icon" type="image/png" href="/favicon-192x192.png" sizes="192x192">'.$NL
					.$IND.'<link rel="icon" type="image/png" href="/favicon-160x160.png" sizes="160x160">'.$NL
					.$IND.'<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">'.$NL
					.$IND.'<link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">'.$NL
					.$IND.'<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">'.$NL
					.$IND.'<meta name="msapplication-TileColor" content="#da532c">'.$NL
					.$IND.'<meta name="msapplication-TileImage" content="/mstile-144x144.png">'.$NL;
		
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
	
	/**
	 * Overrides the site_icon option setting to prevent built in wp-site-icon from interfearing with this plugin.
	 * TODO: add fliter to allow override.
	 * @param mixed $value Value of the option.
	 * @return int 0
	 */
	public static function option_site_icon_filter( $value ){
		return 0;
	}

	/**
	 * Remove the default wp-site-icon settings in the Customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer object.
	 */
	function customize_the_customizer( $wp_customize ) {
		$wp_customize->remove_control( 'site_icon' );
	}
}
