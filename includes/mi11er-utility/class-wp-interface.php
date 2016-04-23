<?php
/**
 * Interface for the Wordpress system
 *
 * @package Mi11er\Utility
 */

namespace Mi11er\Utility;

interface Wp_Interface
{
	/**
	 * Proxy to the wordpress add_filter function.
	 */
	public function add_filter();
}
