<?php
/**
 * 投稿タイプ Gallery (魅力)
 * 
 * @category types
 * @package Nauru
 */
namespace Nauru\Types;

class Gallery extends Base_Type
{
    const SLUG = 'gallery';
    const LABEL = '魅力';

    protected $metaboxes = array(
        'source' => '情報ソース',
    );

    public function __construct()
    {
        parent::__construct();

        add_action( 'pre_get_posts', array( $this, 'modify_query' ) );
    }

    /**
     * ACTION HOOK : pre_get_posts
     * 1ページ30件に
     */
    public function modify_query( $query )
    {
        if ( $query->is_post_type_archive( self::SLUG ) && $query->is_main_query() ) {
            $query->set( 'posts_per_page', 30 );
        }
    }

    protected function save_source( $post_id, $post )
    {
        $meta_source_url = isset( $_POST['meta_source_url'] ) ? sanitize_text_field( $_POST['meta_source_url'] ) : "";
        $meta_source_name = isset( $_POST['meta_source_name'] ) ? sanitize_text_field( $_POST['meta_source_name'] ) : "";

        update_post_meta( $post_id, 'source_url', $meta_source_url );
        update_post_meta( $post_id, 'source_name', $meta_source_name );
    }
}
