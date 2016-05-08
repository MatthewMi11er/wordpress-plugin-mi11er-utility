<?php
namespace spec\Mi11er\Utility;
require dirname( dirname( __DIR__ ) ).'/includes/mi11er-utility/class-autoloader.php';
use Mi11er\Utility\Wp_Interface;

class Wp_Mock_Registry{
	private static $me=null;
	private $wp=null;
	private function __construct(){
	}
	public static function instance($wp = null){
		if(self::$me === null){
			self::$me = new self();
		}
		if($wp !== null){
			self::$me->setWp($wp);
		}
		return self::$me;
	}
	public function setWp($wp){
		$this->wp = $wp;
	}
	public function getWp(){
		return $this->wp->getWrappedObject();
	}
	public function define($namespace, $function_name ){
		if (! function_exists($namespace. '\\'. $function_name)){
		$d = 'namespace '.$namespace.'; function '.$function_name.'(){
					$args = func_get_args();
					$wp = \spec\Mi11er\Utility\Wp_Mock_Registry::instance()->getWp();
				call_user_func_array([$wp,\''.$function_name.'\'],$args);}';
		eval( $d );
	}
	}
}
