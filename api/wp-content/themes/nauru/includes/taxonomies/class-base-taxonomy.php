<?php
/**
 * タクソノミー基底クラス
 * 
 * @category taxonomies
 * @package Nauru
 */
namespace Nauru\Taxonomies;

class Base_Taxonomy
{
    const SLUG = null;
    const LABEL = null;
    const POST_TYPE = null;
	
	protected $hierarchical = true;
	protected $rewrite = true;

    public function __construct()
    {
        if ( ! static::SLUG || ! static::LABEL || ! static::POST_TYPE ) {
            throw new \Exception('taxonomy class ' . static::class . ' doesnt have required consts');
        }

		add_action( 'init', array( $this, 'register' ) );

		if ( isset( $this->rewrite['slug'] ) ) {
			add_action( 'init', array( $this, 'rewrite' ) );
		}
    }

    public function register()
    {
		$args = array( 
			'label' => static::LABEL,
			'show_in_quick_edit' => true,
			'show_admin_column' => true,
			'rewrite' => $this->rewrite,
			'hierarchical' => $this->hierarchical
		);

		register_taxonomy( 
			static::SLUG,
			static::POST_TYPE,
			$args
		);

		register_taxonomy_for_object_type( static::SLUG, static::POST_TYPE );

	}
	
	public function rewrite()
	{
		$pattern = $this->rewrite['slug'] . '/([^/]+)/?$';
		$rewrite = 'index.php?' . self::SLUG . '=$matches[1]';
		add_rewrite_rule( $pattern, $rewrite, 'top');	
	}
}
