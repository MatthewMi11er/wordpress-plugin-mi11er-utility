<?php

namespace spec\Mi11er\Utility;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Mi11er\Utility\Wp_Interface;

class FiltersSpec extends ObjectBehavior
{
	function let( Wp_Interface $wp ) {
		$wp_mock = \spec\Mi11er\Utility\Wp_Mock_Registry::instance( $wp );
		$wp_mock->define( 'Mi11er\Utility','add_action' );
		$wp_mock->define( 'Mi11er\Utility','add_filter' );
		$wp_mock->define( 'Mi11er\Utility','apply_filters' );
		$wp_mock->define( 'Mi11er\Utility','is_404' );
		$wp_mock->define( 'Mi11er\Utility','get_post_modified_time' );
		$wp_mock->define( 'Mi11er\Utility','current_time' );
		$wp_mock->define( 'Mi11er\Utility','get_post' );
		$wp->add_action( Argument::cetera() )->willReturn( 'test' );
		$wp->add_filter( Argument::cetera() )->willReturn( 'test' );
	}

	function it_is_initializable() {
		$this->shouldHaveType( 'Mi11er\Utility\Filters' );
	}

	function it_registers_filters() {
		$this->setup();
		$this->setup();
		$this->get_registered_filters()->shouldHaveCount( 7 );
	}

	function it_gets_activiated() {
		$this->activate()->shouldReturn( true );
	}

	function it_filters_https_local_ssl_verify( Wp_Interface $wp ) {
		$wp->WP_ENV = 'production';
		$this->https_local_ssl_verify_filter( true )->shouldReturn( true );
		$wp->WP_ENV = 'development';
		$this->https_local_ssl_verify_filter( true )->shouldReturn( false );
	}

	function it_filters_is_email() {
		$this->is_email_filter( true,'someone@example.com' )->shouldReturn( 'someone@example.com' );
		$this->is_email_filter( true,'someone' )->shouldReturn( false );
	}
	/*
	function it_filters_redirect_canonical( Wp_Interface $wp ) {
		$wp->is_404()->willReturn( true );
		$wp->apply_filters( 'mu_prevent_wordpress_url_guess_redirect', true )->willReturn( true );
		$this->redirect_canonical_filter( 'test' )->shouldReturn( false );

		$wp->is_404()->willReturn( true );
		$wp->apply_filters( 'mu_prevent_wordpress_url_guess_redirect', true )->willReturn( false );
		$this->redirect_canonical_filter( 'test' )->shouldReturn( 'test' );

		$wp->is_404()->willReturn( false );
		$wp->apply_filters( 'mu_prevent_wordpress_url_guess_redirect', true )->willReturn( true );
		$this->redirect_canonical_filter( 'test' )->shouldReturn( 'test' );
	}

	function it_filters_get_the_date( Wp_Interface $wp ) {
		$wp->current_time( 'timestamp' )->willReturn( '@' . time() );

		$this->get_the_date_filter( 'fake_date' )->shouldReturn( 'fake_date' );

		$post = new \stdClass();
		$post->post_date = date_format( new \DateTime() , 'Y-m-d H:i:s' );
		$wp->get_post( null )->willReturn( $post );
		$this->get_the_date_filter( 'fake_date', 1 )->shouldReturn( 'today' );

		$wp->get_post( null )->willReturn( false );
		$this->get_the_date_filter( 'fake_date', 1 )->shouldReturn( 'fake_date' );
	}

	function it_filters_get_the_time( Wp_Interface $wp ) {
		$wp->current_time( 'timestamp' )->willReturn( '@' . time() );

		$this->get_the_time_filter( 'fake_time' )->shouldReturn( 'fake_time' );

		$post = new \stdClass();
		$post->post_date = date_format( new \DateTime( '00:00:00' ) , 'Y-m-d H:i:s' );
		$wp->get_post( null )->willReturn( $post );
		$this->get_the_time_filter( 'fake_time', 2 )->shouldReturn( 'midnight' );

		$wp->get_post( null )->willReturn( false );
		$this->get_the_time_filter( 'fake_time', 2 )->shouldReturn( 'fake_time' );
	}

	function it_filters_get_the_modified_date( Wp_Interface $wp ) {
		$wp->current_time( 'timestamp' )->willReturn( '@' . time() );

		$this->get_the_modified_date_filter( 'fake_date' )->shouldReturn( 'fake_date' );

		$wp->get_post_modified_time( 'Y-m-d\TH:i:sP', null, null, true )->willReturn( date_format( new \DateTime() , 'Y-m-d\TH:i:sP' ) );
		$this->get_the_modified_date_filter( 'fake_date', 1 )->shouldReturn( 'today' );
	}

	function it_filters_get_the_modified_time( Wp_Interface $wp ) {
		$wp->current_time( 'timestamp' )->willReturn( '@' . time() );

		$this->get_the_modified_time_filter( 'fake_time' )->shouldReturn( 'fake_time' );

		$wp->get_post_modified_time( 'Y-m-d\TH:i:sP', null, null, true )->willReturn( date_format( new \DateTime( '00:00:00' ) , 'Y-m-d\TH:i:sP' ) );
		$this->get_the_modified_time_filter( 'fake_time', 2 )->shouldReturn( 'midnight' );
	}*/
}
