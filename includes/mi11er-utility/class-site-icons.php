<?php
/**
 * Favicons and other icons
 *
 * This assumes that the following files are in the site root:
 *  - android-chrome-36x36.png
 *  - android-chrome-48x48.png
 *  - android-chrome-72x72.png
 *  - android-chrome-96x96.png
 *  - android-chrome-192x192.png
 *  - android-chrome-144x144.png
 *  - apple-touch-icon-57x57.pn'
 *  - apple-touch-icon-60x60.png
 *  - apple-touch-icon-72x72.png
 *  - apple-touch-icon-76x76.png
 *  - apple-touch-icon-114x114.png
 *  - apple-touch-icon-120x120.png
 *  - apple-touch-icon-144x144.png
 *  - apple-touch-icon-152x152.png
 *  - apple-touch-icon-180x180.png
 *  - apple-touch-icon-precomposed.png
 *  - apple-touch-icon.png
 *  - favicon-16x16.png
 *  - favicon-32x32.png
 *  - favicon-96x96.png
 *  - favicon-194x194.png
 *  - favicon.ico
 *  - mstile-70x70.png
 *  - mstile-144x144.png
 *  - mstile-150x150.png
 *  - mstile-310x150.png
 *  - mstile-310x310.png
 *  - safari-pinned-tab.svg
 *
 * Filters (@todo also use site options)
 *  - mu_site_icons_site_name
 *  - mu_site_icons_application_tooltip
 *  - mu_site_icons_tile_color
 *  - mu_site_icons_theme_color
 *
 * @package Mi11er\Utility
 */

namespace Mi11er\Utility;

use Mi11er\Utility\Template_Tags as TT;

/**
 * This class provides functions for loading the site favicons
 *
 * @todo get settings from DB in addtion to using filters.
 */
class Site_Icons implements Plugin_Interface
{
	/**
	 * List of Icons
	 *
	 * @var array
	 */
	protected $_icons = [
		'android-chrome-36x36.png',
		'android-chrome-48x48.png',
		'android-chrome-72x72.png',
		'android-chrome-96x96.png',
		'android-chrome-192x192.png',
		'android-chrome-144x144.png',
		'apple-touch-icon-57x57.png',
		'apple-touch-icon-60x60.png',
		'apple-touch-icon-72x72.png',
		'apple-touch-icon-76x76.png',
		'apple-touch-icon-114x114.png',
		'apple-touch-icon-120x120.png',
		'apple-touch-icon-144x144.png',
		'apple-touch-icon-152x152.png',
		'apple-touch-icon-180x180.png',
		'apple-touch-icon-precomposed.png',
		'apple-touch-icon.png',
		'favicon-16x16.png',
		'favicon-32x32.png',
		'favicon-96x96.png',
		'favicon.ico',
		'mstile-70x70.png',
		'mstile-144x144.png',
		'mstile-150x150.png',
		'mstile-310x150.png',
		'mstile-310x310.png',
		'safari-pinned-tab.svg',
	];

	/**
	 * Run whatever is needed for plugin setup
	 */
	public function setup() {
		// Actions.
		add_action( 'customize_register',        [ $this, 'customize_register_action' ],     20, 1 );
		add_action( 'mu_file_handler',           [ $this, 'mu_file_handler_action' ],               10, 1 );
		add_action( 'wp_head',                   [ $this, 'wp_head_action' ],                10 );

		// Filters.
		add_filter( 'option_site_icon',          [ $this, 'option_site_icon_filter' ],       10, 1 );

		// Tags.
		TT::add_tag( 'get_the_site_icon_url',    [ $this, 'get_the_site_icon_url' ] );
		TT::add_tag( 'get_the_site_name',        [ $this, 'get_the_site_name' ] );
		TT::add_tag( 'the_application_tooltip',  [ $this, 'the_application_tooltip' ] );
		TT::add_tag( 'the_icon_links',           [ $this, 'the_icon_links' ] );
		TT::add_tag( 'the_site_icon_tile_color', [ $this, 'the_site_icon_tile_color' ] );
		TT::add_tag( 'the_site_icon_url',        [ $this, 'the_site_icon_url' ] );
		TT::add_tag( 'the_site_name',            [ $this, 'the_site_name' ] );
		TT::add_tag( 'the_theme_color',          [ $this, 'the_theme_color' ] );
	}

	/**
	 * Run whatever is needed for plugin activation
	 */
	public function activate() {
		return;
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
		 *
		 * @todo print message that this settng is overridden.
		 */
		$wp_customize->remove_control( 'site_icon' );
	}

	/**
	 * Callback for the `mu_file_handler` action hook
	 *
	 * @param Mi11er\Utility\File_Handler $file_handler The file handler object.
	 */
	public function mu_file_handler_action( $file_handler ) {
		$template_directory = trailingslashit( TT::get_mu_template_directory() );
		$file_handler->add_config( 'browserconfig.xml', '^browserconfig\.xml$', $template_directory . 'browserconfig.php' , true );
		$file_handler->add_config( 'manifest.json',     '^manifest\.json$',     $template_directory . 'manifest.php',       true );
	}

	/**
	 * Callback for the `wp_head` action hook
	 *
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
	 *
	 * @param mixed $value Value of the option.
	 * @return int 0
	 */
	public static function option_site_icon_filter( $value ) {
		return 0;
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
	<link rel="icon" type="image/png" href="<?php TT::the_site_icon_url( 'favicon-96x96.png' ); ?>" sizes="96x96">
	<link rel="icon" type="image/png" href="<?php TT::the_site_icon_url( 'android-chrome-192x192.png' ); ?>" sizes="192x192">
	<link rel="icon" type="image/png" href="<?php TT::the_site_icon_url( 'favicon-16x16.png' ); ?>" sizes="16x16">
	<link rel="manifest" href="<?php TT::the_home_url( '/manifest.json' ); ?>">
	<link rel="mask-icon" href="<?php TT::the_site_icon_url( 'safari-pinned-tab.svg' ); ?>" color="#5bbad5">
	<link rel="shortcut icon" href="<?php TT::the_site_icon_url( 'favicon.ico' ); ?>">
	<meta name="apple-mobile-web-app-title" content="<?php TT::the_site_name(); ?>">
	<meta name="application-name" content="<?php TT::the_site_name(); ?>">
	<meta name="msapplication-TileColor" content="<?php TT::the_site_icon_tile_color(); ?>">
	<meta name="msapplication-TileImage" content="<?php TT::the_site_icon_url( 'mstile-144x144.png' ); ?>">
	<meta name="theme-color" content="<?php TT::the_theme_color(); ?>">
	<meta name="msapplication-tooltip" content="<?php TT::the_application_tooltip(); ?>" />
	<!-- ======================== END SITE ICONS ======================== -->
<?php
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
		if ( ! in_array( $icon_name , $this->_icons, true ) ) {
			throw new \UnexpectedValueException( $icon_name . ' is not a known Icon' );
		}
		$query_string = '';
		$icon_file = TT::get_the_root_directory() . $icon_name;
		if ( is_file( $icon_file ) ) {
			$query_string = '?v=' . date( 'YmdHis', filemtime( $icon_file ) );
		}

		return home_url( '/' . $icon_name . $query_string );
	}

	/**
	 * Return the Application name for the site
	 *
	 * @return string
	 */
	public function get_the_site_name() {
		/**
		 * Filter the site name
		 *
		 * @param string The site name.
		 */
		return apply_filters( 'mu_site_icons_site_name', get_bloginfo( 'name' ) );
	}

	/**
	 * Prints the application tool tip.
	 */
	public function the_application_tooltip() {
		/**
		 * Filters the application tooltip
		 *
		 * @param string The application tooltip.
		 */
		echo esc_attr( apply_filters( 'mu_site_icons_application_tooltip', get_bloginfo( 'description' ) ) );
	}

	/**
	 * Prints the desired Icon tile color.
	 */
	public function the_site_icon_tile_color() {
		/**
		 * Filter the icon tile color
		 *
		 * @param string The icon color.
		 */
		echo esc_attr( apply_filters( 'mu_site_icons_tile_color', '#ffffff' ) );
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
	 * Print the Application name for the site
	 */
	public function the_site_name() {
		echo esc_attr( TT::get_the_site_name() );
	}

	/**
	 * Print the theme color for the site
	 *
	 * @todo Setup an appropriate option.
	 */
	public function the_theme_color() {
		echo esc_attr( apply_filters( 'mu_site_icons_theme_color', '#ffffff' ) );
	}
}
