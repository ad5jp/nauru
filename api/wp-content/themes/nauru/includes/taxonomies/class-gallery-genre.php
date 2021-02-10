<?php
/**
 * タクソノミー gallery-genre (ギャラリージャンル)
 * 
 * @category taxonomies
 * @package Nauru
 */
namespace Nauru\Taxonomies;

use Nauru\Types\Gallery;

class Gallery_Genre extends Base_Taxonomy
{
    const SLUG = 'gallery-genre';
    const LABEL = 'ジャンル';
    const POST_TYPE = Gallery::SLUG;

	protected $hierarchical = true;
    protected $rewrite = array( 'slug' => 'gallery/genre' );
    
    public function __construct()
    {
        parent::__construct();

        add_action( 'pre_get_posts', array( $this, 'modify_query' ) );
        add_filter( 'template_include', array( $this, 'modify_template' ) );
    }

    /**
     * ACTION HOOK : pre_get_posts
     * 1ページ30件に
     */
    public function modify_query( $query )
    {
        if ( $query->is_tax( self::SLUG ) && $query->is_main_query() ) {
            $query->set( 'posts_per_page', 30 );
        }
    }

    /**
     * FILTER HOOK : template_include
     * タームアーカイブのテンプレートを archive-gallery.php に変更
     */
    public function modify_template( $template )
    {
        if ( is_tax( self::SLUG ) ) {
            $modified = locate_template( 'archive-gallery.php' );
            if ( $modified !== false ) {
                return $modified;
            }
        }

        return $template;
    }
}
