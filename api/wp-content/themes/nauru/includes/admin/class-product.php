<?php
/**
 * 製品の編集画面
 * 
 * @category admin
 * @package Nauru
 */
namespace Nauru\Admin;

use Nauru\Constant;

class Product
{
    protected $post = null;
    protected $makers = array();

    public function __construct()
    {
        add_filter( 'manage_' . Constant::TYPE_PRODUCT . '_posts_columns', array( $this, 'add_list_columns' ) );
        add_action( 'manage_' . Constant::TYPE_PRODUCT . '_posts_custom_column', array( $this, 'render_list_columns' ), 10, 2 );

        add_action( 'add_meta_boxes_' . Constant::TYPE_PRODUCT, array( $this, 'setup_meta_box' ) );
        add_action( 'save_post', array( $this, 'save_metadata' ) );
    }

    /**
     * FILTER HOOK: manage_{$type}_posts_columns
     * ACTION HOOK: manage_{$type}_posts_custom_column
     * 一覧画面にサブタイトルと製品コード追加
     */
    public function add_list_columns( $original )
    {
        $columns = array();
        foreach ( $original as $key => $value ) {
            $columns[$key] = $value;
            if ($key == 'title') {
                $columns['maker'] = 'メーカー';
            }
        }
        return $columns;
    }
    function render_list_columns( $slug, $post_id ) {
        if ( $slug == 'maker' ) {
            $post = get_post( $post_id );
            if ( ! $post->post_parent ) {
                return;
            }
            if ( ! array_key_exists( $post->post_parent, $this->makers ) ) {
                $maker = get_post( $post->post_parent );
                if ( ! $maker ) {
                    return;
                }
                $this->makers[ $maker->ID ] = $maker->post_title;
            }
            echo $this->makers[ $post->post_parent ];
        }
    }

    /**
     * ACTION HOOK : add_meta_boxes
     * メタボックスを追加
     */
    public function setup_meta_box()
    {
        add_meta_box( 'agx_product_maker', 'メーカー', array( $this, 'view_metabox_maker' ), Constant::TYPE_PRODUCT, 'side', 'high' );

        wp_register_style( 'select2css', '//cdnjs.cloudflare.com/ajax/libs/select2/3.4.8/select2.css', false, '1.0', 'all' );
        wp_enqueue_style( 'select2css' );
        wp_register_script( 'select2', '//cdnjs.cloudflare.com/ajax/libs/select2/3.4.8/select2.js', array( 'jquery' ), '1.0', true );
        wp_enqueue_script( 'select2' );

        $script = 'jQuery(function () {jQuery(".__select2").select2();})';
        wp_add_inline_script( 'select2', $script, 'after' );

        //wp_enqueue_media();
		//wp_enqueue_script( 'jquery-ui-sortable' );
    }

    /**
     * CALLBACK : add_meta_box
     * メタボックスの出力
     */
    public function view_metabox_maker( $post )
    {
        $makers = get_posts( array( 'post_type' => Constant::TYPE_MAKER) );

        $html = '';
        $html = '<input type="hidden" name="edit_product_metadata[]" value="maker">';
        $html .= '<select name="maker" class="__select2" style="width:100%;">';
        $html .= '<option value="0">--メーカーを選択--</option>';
        foreach ( $makers as $maker ) {
            $selected = ( $post && $post->post_parent == $maker->ID ? ' selected' : '' );
            $html .= sprintf('<option value="%s"%s>%s</option>', $maker->ID, $selected, $maker->post_title );
        }
        $html .= '</select>';

        echo $html;
    }

    function save_metadata( $post_id ) {
        if ( empty( $_POST['edit_product_metadata'] ) ) {
            return;
        }
        $edit = $_POST['edit_product_metadata'];

        //自動保存はスルー
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }
    
        //権限チェック
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        //無限ループ回避のためフック解除
        remove_action( 'save_post', array( $this, 'save_metadata' ) );

        //メーカー紐づけ
        if ( in_array( 'maker', $edit ) ) {
            $maker = isset( $_POST['maker'] ) ? intval($_POST['maker']) : 0;
            $update = array(
                'ID' => $post_id,
                'post_parent' => $maker,
            );
            wp_update_post( $update );
        }

        //解除したフックをリストア
        add_action( 'save_post', array( $this, 'save_metadata' ) );
    }
}
