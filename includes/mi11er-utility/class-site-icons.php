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
 */
class Site_Icons implements Plugin_Interface
{
	/**
	 * List of files that this plugin will serve.
	 * Image files are assumed to exist at the site root.
	 * Over ride location with the appropriate filter.
	 * Missing images will be served as an empty png.
	 * @todo Set location via site option and media manager.
	 * @todo confirm this list.
	 * @var array
	 */
	protected $_files = [
		'apple-touch-icon-57x57.png',
		'apple-touch-icon-60x60.png',
		'apple-touch-icon-72x72.png',
		'apple-touch-icon-76x76.png',
		'apple-touch-icon-114x114.png',
		'apple-touch-icon-120x120.png',
		'apple-touch-icon-144x144.png',
		'apple-touch-icon-152x152.png',
		'apple-touch-icon-180x180.png',
		'favicon-32x32.png',
		'favicon-194x194.png',
		'favicon-96x96.png',
		'android-chrome-192x192.png',
		'favicon-16x16.png',
		'manifest.json',
		'safari-pinned-tab.svg',
		'mstile-144x144.png',
		'favicon.ico',
	];

	/**
	 * Run whatever is needed for plugin setup
	 */
	public function setup() {
		// Actions.
		add_action( 'customize_register', [ $this, 'customize_register_action' ],     10 );
		add_action( 'wp_head',            [ $this, 'wp_head_action' ],                10 );

		// Filters.
		add_filter( 'do_parse_request',   [ $this, 'do_parse_request_filter' ],       10, 3 );
		add_filter( 'option_site_icon',   [ $this, 'option_site_icon_filter' ],       10 );

		// Tags.
		TT::add_tag( 'the_icon_links', [ $this, 'the_icon_links' ] );
	}

	/**
	 * Hook into the Customizer
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer object.
	 */
	public function customize_register_action( $wp_customize ) {
		/**
		 * Since we're over ridding them...
		 * Remove the default wp-site-icon settings in the Customizer.
		 * @todo print message that this settng is overridden.
		 */
		$wp_customize->remove_control( 'site_icon' );
	}

	/**
	 * Hook into the wp_head function.
	 * @see wp_head()
	 */
	public function wp_head_action() {
		$this->the_icon_links();
	}

	/**
	 * Turns the built in site_icon option setting to prevent it from interfearing with this plugin.
	 * @param mixed $value Value of the option.
	 * @return int 0
	 */
	public static function option_site_icon_filter( $value ) {
		return 0;
	}

	/**
	 * Skip wordpress routing and do our own for certin requests
	 * Eg. @see http://wordpress.stackexchange.com/a/157441
	 * To allow favicon.ico rotuing: @see https://gist.github.com/westonruter/715246
	 * Must run on 'do_parse_request' filter hook.
	 *
	 * @param bool         $continue             Whether or not to parse the request. Default true.
	 * @param WP           $instance             Current WordPress environment instance.
	 * @param array|string $extra_query_vars     Extra passed query variables.
	 *
	 * @return bool
	 */
	public function do_parse_request_filter( $continue, $instance, $extra_query_vars ) {
		/**
		 * Only run inside the do_parse_request_filter.
		 * Only run when it's a url we care about.
		 */
		if ( 'do_parse_request' !== current_filter() || ! in_array( ltrim( $request_path = untrailingslashit( parse_url( add_query_arg( array() ), PHP_URL_PATH ) ), '/'), $this->_files ) ) {
			return $continue;
		}

		switch ( $request_path ) {
			default:
				$file = new Sendfile( apply_filters( 'mu_site_icons_' . $request_path, $request_path ) );
				$file->send();
		}
		// @todo return file;
		exit();
	}

	/**
	 * Print the favicon links
	 * TODO: theme-color
	 * TODO: maskicon color
	 * TODO: File Names
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
