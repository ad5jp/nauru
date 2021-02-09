<?php
/**
 * HEAD内の出力関連
 * 
 * @category hooks
 * @package Nauru
 */
namespace Nauru\Hooks;

class Head
{
    public function __construct()
    {
        add_action( 'init', array( $this, 'remove_default' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
        add_action( 'wp_head', array( $this, 'meta' ) );
        add_action( 'wp_head', array( $this, 'tracking' ) );

        add_filter( 'document_title_separator', array( $this, 'title_separator' ) );
    }

    /**
     * ACTION HOOK : init
     * head内のゴミ削除
     */
    public function remove_default()
    {
        remove_action( 'wp_head', 'wp_generator' );
        remove_action( 'wp_head', 'rsd_link' );
        remove_action( 'wp_head', 'wlwmanifest_link' );
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
        remove_action( 'admin_print_styles', 'print_emoji_styles' );    
        remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
        remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );    
        remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    }

    /**
     * ACTION HOOK : wp_enqueue_scripts
     * CSS・JSの読み込み
     */
    public function enqueue()
    {
        wp_enqueue_style( 'style', get_stylesheet_uri() );
        wp_enqueue_style( 'font-noto-sans', '//fonts.googleapis.com/css?family=Noto+Sans+JP%3A100%2C300%2C400%2C500%2C700%2C900&#038;display=swap&#038;subset=japanese&#038;' );
        wp_enqueue_style( 'font-awesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' );
        wp_enqueue_style( 'destyle', get_template_directory_uri() . '/css/destyle.css' );
        wp_enqueue_style( 'shared', get_template_directory_uri() . '/css/shared.css' );
    }

    /**
     * ACTION HOOK : wp_head
     * Metaタグ類の出力
     */
    public function meta()
    {
        //todo メタタグ出力
        ?>
            <meta name="keywords" content="">
            <meta name="description" content="">
            <meta property="og:title" content="">
            <meta property="og:type" content="">
            <meta property="og:url" content="">
            <meta property="og:image" content="">
            <meta property="og:site_name"  content="">
            <meta property="og:description" content="">
            <meta property="fb:app_id" content="">
            <meta name="twitter:card" content="">
            <link rel="icon" href="">
            <link rel="apple-touch-icon" sizes="120x120" href="">
        <?php
    }

    /**
     * ACTION HOOK : wp_head
     * トラッキングコードの出力
     */
    public function tracking()
    {
        if ( is_user_logged_in() || $_SERVER['SERVER_NAME'] == 'localhost' || strpos($_SERVER['SERVER_NAME'], 'ad5.dev') !== false ) {
            return;
        }
        ?>
            <!-- todo トラッキングコード -->
        <?php
    }

    /**
     * FILTER HOOK : document_title_separator
     * HTMLタイトルの区切り文字変更
     */
    public function title_separator( $sep )
    {
        return ' | ';
    }
}