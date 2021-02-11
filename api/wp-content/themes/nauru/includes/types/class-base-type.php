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
    protected $menu_position = 5;
	protected $supports = array( 'title', 'editor','author', 'thumbnail' );
	
	protected $metaboxes = [];

    public function __construct()
    {
        if ( ! static::SLUG || ! static::LABEL ) {
            throw new \Exception('post type class ' . static::class . ' doesnt have required consts');
        }

		add_action( 'init', array( $this, 'register' ) );

		if ( is_array( $this->metaboxes ) && count( $this->metaboxes ) > 0 ) {
			add_action( 'add_meta_boxes_' . static::SLUG, array( $this, 'add_meta_boxes' ) );
			add_action( 'save_post', array( $this, 'save_meta_boxes' ), 10, 3 );	
		}
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
	
	public function add_meta_boxes()
	{
		foreach ( $this->metaboxes as $key => $label ) {
			$metabox_key = 'theme_metabox_' . static::SLUG . '_' . $key;
			$metabox_view = 'view_metabox_' . $key;
			add_meta_box( $metabox_key, $label, array( $this, $metabox_view ), static::SLUG, 'normal', 'high' );
		}
	}

	public function __call( $function, $args ) {
		if ( strpos( $function, 'view_metabox_' ) === 0 ) {
			$key = str_replace( 'view_metabox_', '', $function );
			if ( array_key_exists( $key, $this->metaboxes ) ) {
				$this->view_metabox( $key, ...$args );
				return;
			}
		}

		throw new \Exception('undefined method ' . static::class . '::' . $function);
	}

	public function view_metabox( $key, $post, $metabox )
	{
		$metabox_key = 'theme_metabox_' . static::SLUG . '_' . $key;
		$nonce_key = 'theme_nonce_' . static::SLUG . '_' . $key;
		$view_file = static::SLUG . '-' . $key . '.php';
		$view_path = TEMPLATEPATH . '/includes/types/metaboxes/' . $view_file;

		wp_nonce_field($metabox_key, $nonce_key);
		echo sprintf('<input type="hidden" name="%s" value="1">', $metabox_key);
		if ( file_exists( $view_path ) ) {
			include( $view_path );
		}
	}

	public function save_meta_boxes( $post_id, $post, $update )
	{
		//対象投稿タイプのみ
		if ( static::SLUG !== get_post_type( $post_id ) ) {
			return;
		}

		//自動保存はスルー
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

		foreach ( $this->metaboxes as $key => $label ) {
			$metabox_key = 'theme_metabox_' . static::SLUG . '_' . $key;
			$nonce_key = 'theme_nonce_' . static::SLUG . '_' . $key;
			
			if ( empty( $_POST[$metabox_key] ) ) {
				continue;
			}

			if ( ! wp_verify_nonce( $_POST[$nonce_key], $metabox_key ) ) {
				wp_die( sprintf( '不正な遷移です (invalid nonce %s)', $nonce_key ) );
			}

			$method = 'save_' . $key;
			if ( method_exists( $this, $method ) ) {
				$this->$method( $post_id, $post, $update );
			}
		}
	}
}
