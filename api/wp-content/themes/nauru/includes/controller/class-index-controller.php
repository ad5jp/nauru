<?php
/**
 * TOPページ
 * 
 * @category controller
 * @package Nauru
 */
namespace Nauru\Controller;

use Nauru\Types\Information;

class Index_Controller extends Common_Controller
{
    public $info_query;

    public function enqueue()
    {
        wp_enqueue_style( 'home', get_template_directory_uri() . '/css/home.css' );
    }
}
