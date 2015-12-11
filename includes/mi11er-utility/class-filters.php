<?php
/**
 * Mi11er\Utility Manage Filters
 *
 * @package Mi11er\Utility
 */

namespace Mi11er\Utility;

/**
 * It's Filter Time.
 */
final class Filters
{
	/**
	 * Register All the primary Filter hooks for the puglin
	 */
	public function register_hooks() {

		add_filter( 'option_site_icon', __NAMESPACE__ . '\Site_Icons::option_site_icon_filter' );
		add_filter( 'do_parse_request', __NAMESPACE__ . '\Site_Icons::do_parse_request_filter', 10, 3 );
	}
}
