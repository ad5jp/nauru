<?php
/**
 * カテゴリの編集画面
 * 
 * @category admin
 * @package Nauru
 */
namespace Nauru\Admin;

use Nauru\Constant;

class Category
{
    private $term;

    public function __construct()
    {
        add_action( Constant::TAX_CATEGORY . '_add_form_fields', array( $this, 'category_add_field' ) );
        add_action( Constant::TAX_CATEGORY . '_edit_form_fields', array( $this, 'category_edit_field' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
        add_action( 'edited_' . Constant::TAX_CATEGORY, array( $this, 'save_meta_data' ), 10, 2 );
    }

    /**
     * 並び順のフィールド ( term_group を使用 )
     */
    public function category_add_field()
    {
        $this->term = null;
        include( TEMPLATEPATH . '/includes/admin/views/formfield-categories.php' );
    }

    public function category_edit_field( $term )
    {
        $this->term = $term;
        include( TEMPLATEPATH . '/includes/admin/views/formfield-categories.php' );
    }

    function enqueue( $hook_suffix )
    {
        if( 'edit-tags.php' === $hook_suffix || 'term.php' === $hook_suffix ) {
            wp_enqueue_media();
        }
    }

    public function save_meta_data( $term_id, $taxonomy )
    {
        if ( isset( $_POST['meta']['thumbnail'] ) ) {
            $thumbnail = intval( $_POST['meta']['thumbnail'] ) ? intval( $_POST['meta']['thumbnail'] ) : null;
            update_term_meta( $term_id, 'thumbnail', $thumbnail );
        }
        if ( isset( $_POST['meta']['url'] ) ) {
            $url = $_POST['meta']['url'];
            update_term_meta( $term_id, 'url', $url );
        }
        if ( isset( $_POST['meta']['url_blank'] ) ) {
            $url_blank = $_POST['meta']['url_blank'] ? 1 : 0;
            update_term_meta( $term_id, 'url_blank', $url_blank );
        }

    }
}
