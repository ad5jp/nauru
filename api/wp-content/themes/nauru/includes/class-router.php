<?php
/**
 * コントローラのルーティング
 * 
 * @category core
 * @package Nauru
 */
namespace Nauru;

class Router
{
	private static $router;
	private static $controller;

	private function __construct()
	{
		add_filter( 'template_include', array( $this, 'route_controller' ), 9999 );
	}

	public function route_controller( $template )
	{
		$template_name = basename( $template );
		$template_basename = substr( $template_name, 0, strpos( $template_name, '.' ) );
		$controller_name = "Nauru\\Controller\\" . join( '_', array_map( 'ucfirst', explode( '-', $template_basename ) ) ) . '_Controller';
		if ( class_exists( $controller_name ) ) {
			self::$controller = new $controller_name($template);
		} else {
			self::$controller = new Controller\Common_Controller($template);
		}

		//テンプレートの読み込み
		self::$controller->template_include();

		//コントローラ内から読み込むため、殺す
		//@see Common_Controller::template_include
		return false;
	}

	public static function init()
	{
        if ( ! isset( self::$router ) ) {
            self::$router = new Router();    
        }
	}

	public static function load()
	{
        if ( ! isset( self::$controller ) ) {
            throw new \RuntimeException("controller not initialted.");
        }
        return self::$controller;
	}

	private function __clone()
    {
        throw new \RuntimeException("cannot clone this instance.");
    }
}
