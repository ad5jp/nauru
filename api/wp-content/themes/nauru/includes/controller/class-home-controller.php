<?php
/**
 * TOPページ
 * 
 * @category controller
 * @package Nauru
 */
namespace Nauru\Controller;

use Nauru\Types\Information;

class Home_Controller extends Common_Controller
{
    public $info_query;

    public function enqueue()
    {
        wp_enqueue_style( 'home', get_template_directory_uri() . '/css/home.css' . NAURU_CSS_PARAM );
    }

    protected function handle()
    {
        //お知らせの取得
        $args = array(
            'post_type' => Information::SLUG,
            'posts_per_page' => 3,
        );

        $this->info_query = new \WP_Query( $args );
    }
}
