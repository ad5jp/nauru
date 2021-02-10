<?php
/**
 * 魅力（ギャラリー）
 * 
 * @category controller
 * @package Nauru
 */
namespace Nauru\Controller;

use Nauru\Taxonomies\Gallery_Genre;
use Nauru\Types\Information;

class Archive_Gallery_Controller extends Common_Controller
{
    public $genres;

    public function enqueue()
    {
        wp_enqueue_style( 'gallery', get_template_directory_uri() . '/css/gallery.css' );
    }

    protected function handle()
    {
        //ジャンル一覧取得
        $args = array(
            'taxonomy' => Gallery_Genre::SLUG
        );
        $this->genres = get_terms( $args );
    }

    public function get_source_html()
    {
        $post = get_post();
        $source_name = get_post_meta( $post->ID, 'source_name', true );
        if ( $source_name ) {
            $source_url = get_post_meta( $post->ID, 'source_url', true );
            if ( $source_url ) {
                return sprintf( '(Source: <a href="%s" rel="nofollow">%s</a>)', $source_url, $source_name );
            } else {
                return sprintf( '(Source: <span>%s</span>)', $source_name );
            }
        } else {
            return sprintf( '(Author: <span>%s</span>)', get_the_author() );
        }
    }
}
