<?php
/**
 * クエリの修正関連
 * 
 * @category hooks
 * @package Nauru
 */
namespace Nauru\Hooks;

use Nauru\Constant;

class Query
{
    public function __construct()
    {
        add_action( 'pre_get_posts', array( $this, 'archive_maker_query' ) );
        add_action( 'pre_get_posts', array( $this, 'archive_campaign_query' ) );
        add_action( 'pre_get_posts', array( $this, 'archive_office_query' ) );
        add_action( 'pre_get_posts', array( $this, 'archive_work_query' ) );
        add_action( 'pre_get_terms', array( $this, 'category_query' ) );
    }

    public function archive_maker_query( $query )
    {
        if ( $query->is_post_type_archive( Constant::TYPE_MAKER ) && $query->is_main_query() ) {
            if ( ! is_admin() ) {
                $query->set( 'posts_per_page', 20 );
                $query->set( 'orderby', array(
                    'meta_value' => 'ASC',
                    'menu_order' => 'ASC',
                    'post_date' => 'DESC',
                ) );
                $query->set( 'meta_key', 'post_title_kana' );    
            } else {
                $query->set( 'posts_per_page', 20 );
                $query->set( 'orderby', array(
                    'menu_order' => 'ASC',
                    'post_date' => 'DESC',
                ) );    
            }
        }
    }

    public function archive_campaign_query( $query )
    {
        if ( $query->is_post_type_archive( Constant::TYPE_CAMPAIGN ) && $query->is_main_query() ) {
            $query->set( 'posts_per_page', 30 );
        }
    }

    public function archive_office_query( $query )
    {
        if ( $query->is_post_type_archive( Constant::TYPE_OFFICE ) && $query->is_main_query() ) {
            $query->set( 'posts_per_page', -1 );
            $query->set( 'orderby', array(
                'menu_order' => 'ASC',
                'post_date' => 'DESC',
            ) );
        }
    }

    public function archive_work_query( $query )
    {
        if ( $query->is_post_type_archive( Constant::TYPE_WORK ) ) {
            $query->set( 'posts_per_page', -1 );
            $query->set( 'orderby', array(
                'menu_order' => 'ASC',
                'post_date' => 'DESC',
            ) );
        }
    }

    /**
	 * ACTION HOOK : pre_get_terms
	 * order が未指定なら term_group に
	 */
	public function category_query( $wp_term_query )
	{
		if (
			in_array( Constant::TAX_CATEGORY, $wp_term_query->query_vars['taxonomy'] )
			&& $wp_term_query->query_vars['orderby'] == 'name'
		) {
			$wp_term_query->query_vars['orderby'] = 'term_group';
		}
	}

}