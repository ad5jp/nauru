<?php
/**
 * よくある質問一覧
 * 
 * @category controller
 * @package Nauru
 */
namespace Nauru\Controller;

class Archive_Faq_Controller extends Common_Controller
{
    public function enqueue()
    {
        wp_enqueue_style( 'faq', get_template_directory_uri() . '/css/faq.css' . NAURU_CSS_PARAM );
    }
}
