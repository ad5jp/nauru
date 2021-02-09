<?php
/**
 * 投稿タイプ基底クラス
 * 
 * @category types
 * @package Nauru
 */
namespace Nauru\Types;

class Base_Type
{
    const SLUG = null;
    const LABEL = null;

    protected $public = true;
    protected $has_archive = true;
    protected $menu_position = 10;
    protected $supports = array( 'title', 'editor','author', 'thumbnail', 'page-attributes' );

    public function __construct()
    {
        if ( ! static::SLUG || ! static::LABEL ) {
            throw new \Exception('post type class ' . static::class . ' doesnt have required consts');
        }
        add_action( 'init', array( $this, 'register' ) );
    }

    public function register()
    {
        $labels = array( 
			'name'               => static::LABEL,
			'singular_name'      => static::LABEL,
			'menu_name'          => static::LABEL,
		);
		$args = array( 
			'labels'             => $labels,
			'public'             => $this->public,
			'publicly_queryable' => $this->public,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => $this->public,
			'rewrite'            => array( 'slug' => static::SLUG ),
			'capability_type'    => 'post',
			'has_archive'        => $this->has_archive,
			'hierarchical'       => false,
			'menu_position'      => $this->menu_position,
			'supports'           => $this->supports,
		);
		register_post_type( static::SLUG, $args );
    }
}
