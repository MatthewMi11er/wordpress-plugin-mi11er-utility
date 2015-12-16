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
 *
 * If not running Nginx or to disable serving the icons through this plugin's php,
 * place icon image files at site root and/or set MU_SITE_ICONS_NO_NGINX = true.
 * @todo get settings from DB in addtion to using filters.
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
		'android-chrome-36x36.png'         => '^android-chrome-36x36\.png$',
		'android-chrome-48x48.png'         => '^android-chrome-48x48\.png$',
		'android-chrome-72x72.png'         => '^android-chrome-72x72\.png$',
		'android-chrome-96x96.png'         => '^android-chrome-96x96\.png$',
		'android-chrome-192x192.png'       => '^android-chrome-192x192\.png$',
		'android-chrome-144x144.png'       => '^android-chrome-144x144\.png$',
		'apple-touch-icon-57x57.png'       => '^apple-touch-icon-57x57\.png$',
		'apple-touch-icon-60x60.png'       => '^apple-touch-icon-60x60\.png$',
		'apple-touch-icon-72x72.png'       => '^apple-touch-icon-72x72\.png$',
		'apple-touch-icon-76x76.png'       => '^apple-touch-icon-76x76\.png$',
		'apple-touch-icon-114x114.png'     => '^apple-touch-icon-114x114\.png$',
		'apple-touch-icon-120x120.png'     => '^apple-touch-icon-120x120\.png$',
		'apple-touch-icon-144x144.png'     => '^apple-touch-icon-144x144\.png$',
		'apple-touch-icon-152x152.png'     => '^apple-touch-icon-152x152\.png$',
		'apple-touch-icon-180x180.png'     => '^apple-touch-icon-180x180\.png$',
		'apple-touch-icon-precomposed.png' => '^apple-touch-icon-precomposed\.png$',
		'apple-touch-icon.png'             => '^apple-touch-icon\.png$',
		'browserconfig.xml'                => '^browserconfig\.xml$',
		'favicon-16x16.png'                => '^favicon-16x16\.png$',
		'favicon-32x32.png'                => '^favicon-32x32\.png$',
		'favicon-96x96.png'                => '^favicon-96x96\.png$',
		'favicon-194x194.png'              => '^favicon-194x194\.png$',
		'favicon.ico'                      => '^favicon\.ico$',
		'manifest.json'                    => '^manifest\.json$',
		'mstile-70x70.png'                 => '^mstile-70x70\.png$',
		'mstile-144x144.png'               => '^mstile-144x144\.png$',
		'mstile-150x150.png'               => '^mstile-150x150\.png$',
		'mstile-310x150.png'               => '^mstile-310x150\.png$',
		'mstile-310x310.png'               => '^mstile-310x310\.png$',
		'safari-pinned-tab.svg'            => '^safari-pinned-tab\.svg$',
	];

	/**
	 * The Request File Handler
	 * Set when the request is for an icon image file.
	 * @var Mi11er\Utity\Sendfile
	 */
	protected $_request_file = null;

	/**
	 * Run whatever is needed for plugin setup
	 */
	public function setup() {
		// Actions.
		add_action( 'customize_register',                [ $this, 'customize_register_action' ],     10 );
		add_action( 'init',                              [ $this, 'init_action' ],                   10 );
		add_action( 'wp_head',                           [ $this, 'wp_head_action' ],                10 );

		// Filters.
		add_filter( 'option_site_icon',                  [ $this, 'option_site_icon_filter' ],       10, 1 );
		add_filter( 'redirect_canonical',                [ $this, 'redirect_canonical' ],            10, 2 );
		add_filter( 'template_include',                  [ $this, 'template_include_filter' ],       10, 1 );


		// Tags.
		TT::add_tag( 'get_the_site_icon_url',            [ $this, 'get_the_site_icon_url' ] );
		TT::add_tag( 'the_icon_links',                   [ $this, 'the_icon_links' ] );
		TT::add_tag( 'the_site_icon_tile_color',         [ $this, 'the_site_icon_tile_color' ] );
		TT::add_tag( 'the_site_icon_url',                [ $this, 'the_site_icon_url' ] );
	}

	/**
	 * ================Actions
	 */

	/**
	 * Callback for the `customize_register` action
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
	 * Callback for the `init` action hook
	 * Fires after WordPress has finished loading but before any headers are sent.
	 *
	 * Most of WP is loaded at this stage, and the user is authenticated. WP continues
	 * to load on the init hook that follows (e.g. widgets), and many plugins instantiate
	 * themselves on it for all sorts of reasons (e.g. they need a user, a taxonomy, etc.).
	 *
	 * If you wish to plug an action once WP is loaded, use the wp_loaded hook below.
	 */
	public function init_action() {
		/**
		 * Add custom rewrite rules so we can handle
		 * the icon files.
		 */
		foreach ( $this->_files as $file => $rewrite ) {
			add_rewrite_rule( $rewrite, 'index.php?mu_site_icons_file=' . $file , 'top' );
		}
		add_rewrite_tag( '%mu_site_icons_file%', '([^&]+)' );
	}

	/**
	 * Callback for the `wp_head` action hook
	 * @see wp_head()
	 */
	public function wp_head_action() {
		// Display our icons in the header.
		$this->the_icon_links();
	}

	/**
	 * ================Filters
	 */

	/**
	 * Callback for the `option_site_icon` filer hook
	 * Turns the built in site_icon option setting to prevent it from interfearing with this plugin.
	 * @param mixed $value Value of the option.
	 * @return int 0
	 */
	public static function option_site_icon_filter( $value ) {
		return 0;
	}

	/**
	 * Callback for the `redirect_canonical` filter hook
	 * Filter the canonical redirect URL.
	 *
	 * Returning false to this filter will cancel the redirect.
	 *
	 * @param string $redirect_url  The redirect URL.
	 * @param string $requested_url The requested URL.
	 *
	 * @return bool|string
	 */
	public function redirect_canonical( $redirect_url, $requested_url ) {
		// Check if we're dealing stuff we care about.
		if ( ! array_key_exists( $mu_site_icons_file = get_query_var( 'mu_site_icons_file' ), $this->_files ) ) {
			return $redirect_url;
		}
		
		// None of our files should have a tralining slash.
		return false;
	}

	/**
	 * Callback for the template_include filter hook
	 * Filter the path of the current template before including it.
	 *
	 * @param string $template The path of the template to include.
	 */
	public function template_include_filter( $template ) {
		// Check if we're dealing stuff we care about.
		if ( ! array_key_exists( $mu_site_icons_file = get_query_var( 'mu_site_icons_file' ), $this->_files ) ) {
			return $template;
		}

		$template_directory = trailingslashit( TT::get_mu_template_directory() );

		// Determine the correct template to load.
		if ( 'browserconfig.xml' === $mu_site_icons_file ) {
			return $template_directory . 'browserconfig.php';
		} elseif ( 'manifest.json' === $mu_site_icons_file ) {
			return $template_directory . 'manifest.php';
		} elseif ( ! defined( 'MU_SITE_ICONS_NO_NGINX' ) || false === MU_SITE_ICONS_NO_NGINX ) {
			/**
			 * Use the filter to override this.
			 * If you really place your icon files at the root it should never get to this point anyway.
			 */
			$icon_location = '/';

			/**
			 * Filter where the icons are stored.
			 * Using this requires nginx.
			 * The location must be understood by nginx but can be internal or external.
			 *
			 * @todo make this work with other servers.
			 * @todo allow setting of file names in addtion to location.
			 *
			 * @param string $icon_location The location of the icons.
			 */
			$icon_location = trailingslashit( applay_filters( 'mu_site_icons_location', $icon_location ) );
			$this->_request_file = new Sendfile( $icon_location . $mu_site_icons_file );
			return $template_directory . 'icons.php';
		}

		// If it gets to here it's not something we deal with.
		return $template;
	}

	/**
	 * ================Tags
	 */

	/**
	 * Print the favicon links
	 * TODO: theme-color
	 * TODO: maskicon color
	 * TODO: File Names
	 */
	public function the_icon_links() {
		$msapplication_notification_polling_uris = apply_filters( 'mi11er_utility_favicon_msapplication_notification_urls', array( home_url( '/feed/' ) ) );
		$msapplication_tile_color                = apply_filters( 'mi11er_utility_favicon_msapplication_tile_color', '#005596' );
		$msapplication_name                      = apply_filters( 'mi11er_utility_favicon_msapplication_name', get_bloginfo( 'name' ) );
		$msapplication_tooltip                   = apply_filters( 'mi11er_utility_favicon_msapplication_tooltip', get_bloginfo( 'description' ) );
?>
		<!-- ======================== BEGIN SITE ICONS ======================== -->
		<link rel="apple-touch-icon" sizes="57x57" href="<?php TT::the_site_icon_url( 'apple-touch-icon-57x57.png' ); ?>">
		<link rel="apple-touch-icon" sizes="60x60" href="<?php TT::the_site_icon_url( 'apple-touch-icon-60x60.png' ); ?>">
		<link rel="apple-touch-icon" sizes="72x72" href="<?php TT::the_site_icon_url( 'apple-touch-icon-72x72.png' ); ?>">
		<link rel="apple-touch-icon" sizes="76x76" href="<?php TT::the_site_icon_url( 'apple-touch-icon-76x76.png' ); ?>">
		<link rel="apple-touch-icon" sizes="114x114" href="<?php TT::the_site_icon_url( 'apple-touch-icon-114x114.png' ); ?>">
		<link rel="apple-touch-icon" sizes="120x120" href="<?php TT::the_site_icon_url( 'apple-touch-icon-120x120.png' ); ?>">
		<link rel="apple-touch-icon" sizes="144x144" href="<?php TT::the_site_icon_url( 'apple-touch-icon-144x144.png' ); ?>">
		<link rel="apple-touch-icon" sizes="152x152" href="<?php TT::the_site_icon_url( 'apple-touch-icon-152x152.png' ); ?>">
		<link rel="apple-touch-icon" sizes="180x180" href="<?php TT::the_site_icon_url( 'apple-touch-icon-180x180.png' ); ?>">
		<link rel="icon" type="image/png" href="<?php TT::the_site_icon_url( 'favicon-32x32.png' ); ?>" sizes="32x32">
		<link rel="icon" type="image/png" href="<?php TT::the_site_icon_url( 'favicon-194x194.png' ); ?>" sizes="194x194">
		<link rel="icon" type="image/png" href="<?php TT::the_site_icon_url( 'favicon-96x96.png' ); ?>" sizes="96x96">
		<link rel="icon" type="image/png" href="<?php TT::the_site_icon_url( 'android-chrome-192x192.png' ); ?>" sizes="192x192">
		<link rel="icon" type="image/png" href="<?php TT::the_site_icon_url( 'favicon-16x16.png' ); ?>" sizes="16x16">
		<link rel="manifest" href="<?php TT::the_site_icon_url( 'manifest.json' ); ?>">
		<link rel="mask-icon" href="<?php TT::the_site_icon_url( 'safari-pinned-tab.svg' ); ?>" color="#5bbad5">
		<link rel="shortcut icon" href="<?php TT::the_site_icon_url( 'favicon.ico?' ); ?>">
		<meta name="apple-mobile-web-app-title" content="test">
		<meta name="application-name" content="test">
		<meta name="msapplication-TileColor" content="<?php echo esc_attr( $msapplication_tile_color ); ?>">
		<meta name="msapplication-TileImage" content="<?php TT::the_site_icon_url( 'mstile-144x144.png' ); ?>">
		<meta name="theme-color" content="#ffffff">
		<!-- ======================== END SITE ICONS ======================== -->
<?php
	}

	/**
	 * Prints the desired Icon tile color.
	 */
	public function the_site_icon_tile_color() {
		/**
		 * Filter the icon tile color
		 * @param string The icon color.
		 */
		echo esc_attr( apply_filters( 'mu_site_icons_tile_color', '#ffffff' ) );
	}

	/**
	 * Return the url for the specificed site icon.
	 *
	 * @throws \UnexpectedValueException If the icon is not on THE LIST.
	 *
	 * @param string $icon_name The name of the icon to get.
	 *
	 * @return string
	 */
	public function get_the_site_icon_url( $icon_name ) {
		if ( ! array_key_exists( $icon_name , $this->_files ) ) {
			throw new \UnexpectedValueException( $icon_name . ' is not a known Icon' );
		}

		return home_url( '/' . $icon_name );
	}

	/**
	 * Print the url for the specificed site icon.
	 *
	 * @param string $icon_name The name of the icon to get.
	 */
	public function the_site_icon_url( $icon_name ) {
		echo esc_url( TT::get_the_site_icon_url( $icon_name ) );
	}

	/**
	 * ================Misc
	 */

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
