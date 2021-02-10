<?php
/**
 * お知らせ一覧
 * 
 * @category controller
 * @package Nauru
 */
namespace Nauru\Controller;

class Archive_Information_Controller extends Common_Controller
{
    public function enqueue()
    {
        wp_enqueue_style( 'information', get_template_directory_uri() . '/css/information.css' );
    }
}
