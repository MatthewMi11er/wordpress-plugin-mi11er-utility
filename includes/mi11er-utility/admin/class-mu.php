<?php
/**
 * Mi11er\Utility plugin Admin initalization
 *
 * @package Mi11er\Utility
 */

namespace Mi11er\Utility\Admin;

use Mi11er\Utility\Template_Tags as TT;

/**
 * Plugin Admin Intialization
 */
final class Mu
{
	/**
	 * Run whatever is needed for admin setup
	 */
	public function setup() {
		if ( is_admin() ) {
			add_action( 'admin_menu', [ $this, 'admin_menu_action' ], 10, 0 );
		}
	}

	/**
	 * Call Back for the `admin_menu` action hook
	 * Sets up the options page for the main plugin
	 */
	public function admin_menu_action() {
		add_options_page(
			__( 'Mi11er Utility', 'mi11er-utility' ), // Page Title.
			__( 'Mi11er Utility', 'mi11er-utility' ), // Menu Title.
			'manage_options',                         // Capability.
			'mi11er-utility',                         // Menu Slug.
			[ $this, 'add_options_page' ]             // Callback Function.
		);
	}

	/**
	 * Callback for `add_options_page`
	 * displays the options page for the main plugin
	 */
	public function add_options_page() {
		?>
		<div class="wrap">
			<h2><?php esc_html_e( 'Mi11er Utility Settings', 'mi11er-utility' )?></h2>
			<p>Settings comming soon</p>
		</div>
		<?php
	}
}
