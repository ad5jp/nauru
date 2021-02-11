<?php
/**
 * 主要設定
 * 
 * @category core
 * @package Nauru
 */
namespace Nauru;

class Core
{
	public function __construct()
	{
		//タイムゾーンセット
		date_default_timezone_set( 'Asia/Tokyo' );

		//セッション
		if ( session_status() !== PHP_SESSION_ACTIVE ) {
			session_start();
		}

		//標準投稿者アーカイブの無効化
		add_filter( 'author_rewrite_rules', '__return_empty_array' );

		//テーマサポート
		add_theme_support( 'post-thumbnails' );	
		add_theme_support( 'title-tag' );
		add_theme_support( 'html5' );
		
		//サムネイル
		set_post_thumbnail_size( 640, 480, true );
		add_image_size( 'square', $width = 480, $height = 480, $crop = true );
	}
}
