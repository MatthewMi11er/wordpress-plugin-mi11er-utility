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

	/**
	 * Proxy to the wordpress apply_filters function.
	 */
	public function apply_filters();

	/**
	 * Proxy to the wordpress current_time function.
	 */
	public function current_time();

	/**
	 * Proxy to the wordpress is_404 function.
	 */
	public function is_404();

	/**
	 * Proxy to the wordpress get_post function.
	 */
	public function get_post();

	/**
	 * Proxy to the wordpress get_post_modified_time function.
	 */
	public function get_post_modified_time();

}
