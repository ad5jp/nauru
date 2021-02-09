<?php
/**
 * 投稿タイプ・タクソノミー・リライトルール・クエリ変数の設定
 * 
 * @category hooks
 * @package Nauru
 */
namespace Nauru\Hooks;

use Nauru\Constant;

class Types
{
	public function __construct()
	{
		add_action( 'init', array( $this, 'set_post_types' ) );
		add_action( 'init', array( $this, 'set_taxonomies' ) );
		add_action( 'init', array( $this, 'set_rewrite_rules' ) );
		add_filter( 'query_vars', array( $this, 'add_query_vars' ) );
		add_filter( 'term_link', array( $this, 'term_link' ), 10, 3 );
	}

	/**
	 * ACTION HOOK : init
	 * register_post_type() を実行し、投稿タイプを登録
	 */
	public function set_post_types()
	{
		$labels = array( 
			'name'               => '取扱メーカー',
			'singular_name'      => 'メーカー',
			'menu_name'          => 'メーカー',
		);
		$args = array( 
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => Constant::TYPE_MAKER ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 6,
			'supports'           => array( 'title', 'author', 'thumbnail', 'page-attributes' )
		);
		register_post_type( Constant::TYPE_MAKER, $args );

		$labels = array( 
			'name'               => '製品情報',
			'singular_name'      => '製品',
			'menu_name'          => '製品',
		);
		$args = array( 
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => Constant::TYPE_PRODUCT ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 7,
			'supports'           => array( 'title', 'author', 'thumbnail', 'page-attributes' )
		);
		register_post_type( Constant::TYPE_PRODUCT, $args );

		$labels = array( 
			'name'               => 'キャンペーン・製品情報',
			'singular_name'      => 'キャンペーン・製品情報',
			'menu_name'          => 'キャンペーン',
		);
		$args = array( 
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => Constant::TYPE_CAMPAIGN ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 8,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail' )
		);
		register_post_type( Constant::TYPE_CAMPAIGN, $args );

		$labels = array( 
			'name'               => '営業所紹介',
			'singular_name'      => '営業所',
			'menu_name'          => '営業所',
		);
		$args = array( 
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => Constant::TYPE_OFFICE ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 9,
			'supports'           => array( 'title', 'author', 'page-attributes' )
		);
		register_post_type( Constant::TYPE_OFFICE, $args );

		$labels = array( 
			'name'               => '特注品製作実績',
			'singular_name'      => '製作実績',
			'menu_name'          => '特注品製作実績',
		);
		$args = array( 
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => Constant::TYPE_WORK ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => 9,
			'supports'           => array( 'title', 'author', 'thumbnail', 'page-attributes' )
		);
		register_post_type( Constant::TYPE_WORK, $args );

		$labels = array( 
			'name'               => '問合せデータ',
			'singular_name'      => '問合せデータ',
			'menu_name'          => '問合せデータ',
		);
		$args = array( 
			'labels'             => $labels,
			'public'             => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'capability_type'    => 'post',
			'hierarchical'       => false,
			'menu_position'      => 26,
			'supports'           => array( 'title' )
		);
		register_post_type( Constant::TYPE_FORMDATA, $args );
	}

	/**
	 * ACTION HOOK : init
	 * register_taxonomy(), register_taxonomy_for_object_type() を実行し、タクソノミーを追加
	 */
	public function set_taxonomies()
	{
		register_taxonomy( 
			Constant::TAX_CATEGORY,
			array( Constant::TYPE_MAKER, Constant::TYPE_PRODUCT ),
			array( 
				'label' => 'カテゴリー',
				'show_in_quick_edit' => true,
				//'rewrite' => array( 'slug' => Constant::TYPE_MAKER . '/' . Constant::TAX_CATEGORY ),
				'show_admin_column' => true,
				'hierarchical' => true
			)
		);
		register_taxonomy_for_object_type( Constant::TAX_CATEGORY, Constant::TYPE_MAKER );
		register_taxonomy_for_object_type( Constant::TAX_CATEGORY, Constant::TYPE_PRODUCT );

		register_taxonomy( 
			Constant::TAX_WORKTYPE,
			Constant::TYPE_WORK,
			array( 
				'label' => '特注品カテゴリ',
				'show_in_quick_edit' => true,
				'show_admin_column' => true,
				'hierarchical' => true
			)
		);
		register_taxonomy_for_object_type( Constant::TAX_WORKTYPE, Constant::TYPE_WORK );

		register_taxonomy( 
			Constant::TAX_CAMPAIGN_CAT,
			Constant::TYPE_CAMPAIGN,
			array( 
				'label' => '情報カテゴリ',
				'show_in_quick_edit' => true,
				'rewrite' => array( 'slug' => str_replace( '-', '/', Constant::TAX_CAMPAIGN_CAT ) ),
				'show_admin_column' => true,
				'hierarchical' => true
			)
		);
		register_taxonomy_for_object_type( Constant::TAX_CAMPAIGN_CAT, Constant::TYPE_CAMPAIGN );

		register_taxonomy( 
			Constant::TAX_CAMPAIGN_TAR,
			Constant::TYPE_CAMPAIGN,
			array( 
				'label' => 'キャンペーン対象',
				'show_in_quick_edit' => true,
				'rewrite' => array( 'slug' => str_replace( '-', '/', Constant::TAX_CAMPAIGN_TAR ) ),
				'show_admin_column' => true,
				'hierarchical' => true
			)
		);
		register_taxonomy_for_object_type( Constant::TAX_CAMPAIGN_TAR, Constant::TYPE_CAMPAIGN );

		register_taxonomy( 
			Constant::TAX_FORMTYPE,
			Constant::TYPE_FORMDATA,
			array( 
				'label' => 'フォーム種別',
				'show_admin_column' => true,
			)
		);
		register_taxonomy_for_object_type( Constant::TAX_FORMTYPE, Constant::TYPE_FORMDATA );
	}
	
	/**
	 * ACTION HOOK : init
	 * add_rewrite_rule() を実行し、リライトルールを追加
	 */
	public function set_rewrite_rules()
	{
		//カテゴリ別メーカー一覧
		$pattern = Constant::TYPE_MAKER . '/' . Constant::TAX_CATEGORY . '/([^/]+)/?$';
		$rewrite = 'index.php?post_type=' . Constant::TYPE_MAKER . '&' . Constant::TAX_CATEGORY . '=$matches[1]';
		add_rewrite_rule( $pattern, $rewrite, 'top');

		//カテゴリ別CMPAINGNー一覧
		$pattern = str_replace( '-', '/', Constant::TAX_CAMPAIGN_CAT ) . '/([^/]+)/?$';
		$rewrite = 'index.php?post_type=' . Constant::TYPE_CAMPAIGN . '&' . Constant::TAX_CAMPAIGN_CAT . '=$matches[1]';
		add_rewrite_rule( $pattern, $rewrite, 'top');

		//フォーム用
		$pattern = '([^/]+)/(input|confirm|send|thanks)/?$';
		$rewrite = 'index.php?pagename=$matches[1]&mode=$matches[2]';
		add_rewrite_rule( $pattern, $rewrite, 'top');
	}

	public function term_link( $termlink, $term, $taxonomy )
	{
		if ( $taxonomy == Constant::TAX_CATEGORY ) {
			$search = "/" . Constant::TAX_CATEGORY . "/";
			$replace = "/" . Constant::TYPE_MAKER . "/" . Constant::TAX_CATEGORY . "/";
			$termlink = str_replace( $search, $replace, $termlink );
		}
		return $termlink;
	}

	public function add_query_vars( $query_vars )
    {
        $query_vars[] = 'mode';
        return $query_vars;
    }
}
