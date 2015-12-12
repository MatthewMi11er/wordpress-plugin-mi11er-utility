<?php
/**
 * Interface for Mi11er\Utility plugins
 *
 * @package Mi11er\Utility
 */

namespace Mi11er\Utility;

interface Plugin_Interface
{
	/**
	 * Run whatever is needed for plugin setup
	 */
	public function setup();
}
