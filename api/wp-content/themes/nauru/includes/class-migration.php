<?php
/**
 * マイグレーション
 * 
 * @category core
 * @package Nauru
 */
namespace Nauru;

class Migration
{
	const VERSION = 2;

	public function __construct()
	{
		$current = intval( get_option( 'nauru-migration-version', 0 ) );

		if ( $current < self::VERSION ) {
			for ( $version = $current + 1; $version <= self::VERSION; $version++ ) {
				$method = "migrate_" . $version;
				if ( method_exists( $this, $method ) ) {
					$this->$method();
				}
			}

			flush_rewrite_rules();
			
			update_option( 'nauru-migration-version', self::VERSION );
		}
	}

	private function migrate_1()
	{
		update_option('permalink_structure', '/%postname%/', true);

		update_option('date_format', 'Y.m.d', true);
		update_option('time_format', 'H:i', true);
		update_option('links_updated_date_format', 'Y.m.d H:i', true);

		update_option('default_pingback_flag', 0);
		update_option('default_ping_status', 0);
		update_option('default_comment_status', 0);

		update_option('thumbnail_size_w', '640', true);
		update_option('thumbnail_size_h', '480', true);
		update_option('thumbnail_crop', '1', true);
		update_option('medium_size_w', '800', true);
		update_option('medium_size_h', '800', true);
		update_option('large_size_w', '1920', true);
		update_option('large_size_h', '1020', true);
	}

	private function migrate_2()
	{
		$page = array(
			'post_type' => 'page',
			'post_title' => 'ナウル共和国について',
			'post_name' => 'about',
			'post_status' => 'publish',
		);
		wp_insert_post( $page );

		$page = array(
			'post_type' => 'page',
			'post_title' => '当観光局について',
			'post_name' => 'profile',
			'post_status' => 'publish',
		);
		wp_insert_post( $page );
	}
}
