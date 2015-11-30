<?php
use Mi11er\Utility as MU;

class UnitTest extends PHPUnit_Framework_TestCase
{
	public function testThatItsTestingTime() {

		$this->assertTrue( true );
	}
	public function testPluingIsActive() {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		$plugin = 'mi11er-utility';
		$this->assertFalse( is_plugin_active( $plugin ) );

		$this->assertInstanceOf('Mi11er\Utility\Mu', Mu\mu() );
		$current = get_option( 'active_plugins' );
		$current[] = $plugin;

		do_action( 'activate_plugin', $plugin );
		update_option( 'active_plugins', $current );
		do_action( 'activate_' . $plugin );
		do_action( 'activated_plugin',  $plugin );

		$this->assertTrue( is_plugin_active( $plugin ) );
	}
	
	public function test_mu_function_returns_plugin_option(){
		$this->assertInstanceOf('Mi11er\Utility\Mu', Mu\mu() );
	}
}
