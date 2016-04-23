<?php
/**
 * The Wordpress system
 *
 * @package Mi11er\Utility
 */

namespace Mi11er\Utility;

/**
 * Wrapper around the Wordpress system
 */
class Wp implements Wp_Interface
{
	/**
	 * Call a function
	 *
	 * @throws \BadFunctionCallException If the function isn't defined.
	 *
	 * @param string $function The name of the function to call.
	 * @param array  $arguments The arguments passed to the function.
	 *
	 * @return mixed
	 */
	public function __call( $function, $arguments ) {
		if ( ! function_exists( $function ) ) {
			throw new \BadFunctionCallException( $function . ' not defined' );
		}

		return call_user_func_array( $function, $arguments );
	}
	/**
	 * Proxy to the wordpress add_filter function.
	 */
	public function add_filter() {
		return $this->__call( __FUNCTION__, func_get_args() );
	}
}
