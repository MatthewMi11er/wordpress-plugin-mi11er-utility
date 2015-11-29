<?php

class UnitTest extends PHPUnit_Framework_TestCase
{
	public function testThatItsTestingTime() {

		$this->assertTrue( true );
	}
	public function testPluingIsActive() {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		$plugin = 'mi11er-utility';
		$this->assertFalse( is_plugin_active( $plugin ) );

		$current = get_option( 'active_plugins' );
		$current[] = $plugin;

		do_action( 'activate_plugin', $plugin );
		update_option( 'active_plugins', $current );
		do_action( 'activate_' . $plugin );
		do_action( 'activated_plugin',  $plugin );

		$this->assertTrue( is_plugin_active( $plugin ) );
	}
}
