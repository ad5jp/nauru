<?php
/**
 * 営業所紹介の編集画面
 * 
 * @category admin
 * @package Nauru
 */
namespace Nauru\Admin;

use Nauru\Constant;

class Office
{
    protected $post;

    public function __construct()
    {
        add_action( 'add_meta_boxes_' . Constant::TYPE_OFFICE, array( $this, 'setup_meta_box' ) );
        add_action( 'save_post', array( $this, 'save_metadata' ) );
    }

    /**
     * ACTION HOOK : add_meta_boxes
     * メタボックスを追加
     */
    public function setup_meta_box()
    {
        add_meta_box( 'agx_office_info', 'オフィス情報', array( $this, 'view_metabox_info' ), Constant::TYPE_OFFICE, 'normal', 'high' );
		wp_enqueue_media();
    }

    /**
     * CALLBACK : add_meta_box
     * メタボックスの出力
     */
    public function view_metabox_info( $post )
    {
        $this->post = get_post( $post );
        include( TEMPLATEPATH . '/includes/admin/views/metabox-office-info.php' );
    }

    function save_metadata( $post_id ) {
        if ( empty( $_POST['edit_office_metadata'] ) ) {
            return;
        }
        $edit = $_POST['edit_office_metadata'];

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

        //カスタムフィールド保存
        if ( in_array( 'info', $edit ) ) {
            $keys = array( 'address', 'tel', 'fax', 'map', 'photo_appearance', 'photo_staff', 'message_title', 'message_description' );
            foreach ( $keys as $key ) {
                $value = isset( $_POST['meta'][$key] ) ? $_POST['meta'][$key] : "";
                if ( $key == 'photo_appearance' || $key == 'photo_staff' ) {
                    $value = $value ? intval( $value ) : "";
                } elseif ( $key == 'message_description' ) {
                    $value == sanitize_textarea_field( $value );
                } else {
                    $value == sanitize_text_field( $value );
                }

                update_post_meta( $post_id, $key, $value );
            }
        }

        //解除したフックをリストア
        add_action( 'save_post', array( $this, 'save_metadata' ) );
    }
}
