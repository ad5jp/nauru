<?php
/**
 * XMLサイトマップ
 * 
 * @category hooks
 * @package Nauru
 */
namespace Nauru\Hooks;

use Nauru\Taxonomies\Gallery_Genre;
use Nauru\Types\Faq;
use Nauru\Types\Gallery;

class Sitemap
{
    protected $urlset = array();

    public function __construct()
    {
        add_action( 'init', array( $this, 'rewrite' ) );
        add_action( 'do_feed_sitemap', array( $this, 'load_template' ) );
        add_filter( 'wp_sitemaps_enabled', '__return_false' );
        add_filter( 'redirect_canonical', array( $this, 'remove_trailingslash' ), 1, 2 );
    }

    /**
     * ACTION HOOK : rewrite_rules_array
     * サイトマップ用のリライトルール追加
     *
     * @return void
     */
    public function rewrite( $rules ) {
        add_rewrite_rule( '^sitemap\.xml/?$', 'index.php?feed=sitemap', 'top' );
    }

    /**
     * ACTION HOOK : do_feed_{$slug}
     * サイトマップ出力
     */
    function load_template() {
        $this->urlset = array();

        //TOP
        $this->urlset[] = array(
            'loc' => home_url(),
            'lastmod' => date('Y-m-d', strtotime('yesterday')),
            'changefreq' => 'daily',
            'priority' => '1,0',
        );

        //魅力
        $this->urlset[] = array(
            'loc' => get_post_type_archive_link( Gallery::SLUG ),
            'lastmod' => date('Y-m-d', strtotime('yesterday')),
            'changefreq' => 'daily',
            'priority' => '0.8',
        );
        $gallery_genres = get_terms( array( 'taxonomy' => Gallery_Genre::SLUG ) );
        foreach ( $gallery_genres as $genre ) {
            $this->urlset[] = array(
                'loc' => get_term_link( $genre ),
                'lastmod' => date('Y-m-d', strtotime('yesterday')),
                'changefreq' => 'weekly',
                'priority' => '0.5',
            );    
        }

        //FAQ
        $this->urlset[] = array(
            'loc' => get_post_type_archive_link( Faq::SLUG ),
            'lastmod' => date('Y-m-d', strtotime('yesterday')),
            'changefreq' => 'daily',
            'priority' => '0.8',
        );

        //固定ページ
        $pages = get_pages();
        foreach ( $pages as $page ) {
            $this->urlset[] = array(
                'loc' => get_permalink( $page ),
                'lastmod' => date('Y-m-d', strtotime('yesterday')),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            );    
        }

        include( get_template_directory() . '/feed-sitemap.php' );
    }
    
    public function remove_trailingslash( $redirect_url, $requested_url ) {
        if ( 'sitemap' == get_query_var( 'feed' ) ) {
            return $requested_url;
        }
        return $redirect_url;
    }
}
