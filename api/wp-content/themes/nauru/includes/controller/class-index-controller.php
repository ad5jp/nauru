<?php
/**
 * 汎用テンプレートページ（＝準備中）
 * 
 * @category controller
 * @package Nauru
 */
namespace Nauru\Controller;

class Index_Controller extends Common_Controller
{
    public function enqueue()
    {
        wp_enqueue_style( 'home', get_template_directory_uri() . '/css/home.css' );
    }
}
