<?php
/**
 * TOPページ
 * 
 * @category controller
 * @package Nauru
 */
namespace Nauru\Controller;

class Page_About_Controller extends Common_Controller
{
    public $info_query;

    public function enqueue()
    {
        wp_enqueue_style( 'page-about', get_template_directory_uri() . '/css/page-about.css' );
    }
}
