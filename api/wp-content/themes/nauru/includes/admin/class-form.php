<?php
/**
 * フォームの設定
 * 
 * @category hooks
 * @package Nauru
 */
namespace Nauru\Admin;

use Nauru\Constant;

class Form
{
	public function __construct()
	{
        add_action( 'add_meta_boxes_page', array( $this, 'setup_meta_box_page' ) );
        add_action( 'add_meta_boxes_' . Constant::TYPE_FORMDATA, array( $this, 'setup_meta_box_formdata' ) );
        add_action( 'save_post', array( $this, 'save_form_setting' ) );
		add_filter( 'display_post_states', array( $this, 'post_states' ) );
		add_action( 'restrict_manage_posts', array( $this, 'add_formtype_filter' ) );

		add_action( 'admin_menu', array( $this, 'add_formdata_submenu' ) );
		add_action( 'admin_init', array( $this, 'exec_download' ) );
	}

	/**
     * ACTION HOOK : add_meta_boxes
     * メタボックスを追加
     */
    public function setup_meta_box_page( $post )
    {
		if ( ! $post || ! array_key_exists( $post->post_name, Constant::FORMS ) ) {
            return;
        }
        add_meta_box( 'agi_inqiuery_setting', 'メール設定', array( $this, 'view_metabox_form_setting' ), 'page', 'normal', 'high' );
    }

    public function setup_meta_box_formdata(  )
    {
        add_meta_box( 'agi_formdata', '送信内容', array( $this, 'view_metabox_formdata' ), Constant::TYPE_FORMDATA, 'normal', 'high' );
    }

    /**
     * CALLBACK : add_meta_box
     * メタボックスの出力
     */
    public function view_metabox_formdata( $post )
    {
        echo nl2br( esc_html( $post->post_content ) );
    }

    public function view_metabox_form_setting( $post )
    {
        if ( ! array_key_exists( $post->post_name, Constant::FORMS ) ) {
            return;
        }
        $this->post = $post;
        include( TEMPLATEPATH . '/includes/admin/views/metabox-form-setting.php' );
    }

    function save_form_setting( $post_id ) {
        $post = get_post( $post_id );

        if ( ! $post || $post->post_type != 'page' || ! array_key_exists( $post->post_name, Constant::FORMS ) ) {
            return;
        }

        //自動保存はスルー
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        //権限チェック
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        //カスタムフィールド更新
        foreach ( array( 'notification_to', 'notification_subject', 'thanks_from', 'thanks_fromname', 'thanks_subject', 'thanks_body' ) as $key ) {
            $meta[$key] = isset( $_POST['meta'][$key] ) ? $_POST['meta'][$key] : "";

            if ( $key == 'notification_to' || $key == 'thanks_body' ) {
                $meta[$key] = sanitize_textarea_field( $meta[$key] );
            } else {
                $meta[$key] = sanitize_text_field( $meta[$key] );
            }

            update_post_meta( $post_id, $key, $meta[$key] );
        }
    }

	/**
	 * FILTER HOOK : display_post_states
	 * 固定ページ一覧にフォームである旨を表記
	 */
	public function post_states($state)
	{
		global $post;
		if ( array_key_exists( $post->post_name, Constant::FORMS ) ) {
			$state[] = 'フォーム';
			return $state;
		}
		return $state;
	}

	/**
	 * ACTION HOOK : restrict_manage_posts
	 * 問合せデータ一覧ページをフォーム種別で絞る
	 */
	public function add_formtype_filter()
	{
		global $post_type;
		if ( $post_type == Constant::TYPE_FORMDATA ) {
			wp_dropdown_categories( array(
				'show_option_all' => 'すべてのフォーム',
				'orderby' => 'name',
				'selected' => get_query_var( Constant::TAX_FORMTYPE ),
				'hide_empty' => 0,
				'name' => Constant::TAX_FORMTYPE,
				'taxonomy' => Constant::TAX_FORMTYPE,
				'value_field' => 'slug',
			) );
		}
	}

	/**
	 * フォームデータのダウンロードメニューを追加
	 */
	public function add_formdata_submenu()
	{
		$slug = 'edit.php?post_type=' . Constant::TYPE_FORMDATA;
		add_submenu_page( $slug, 'ダウンロード', 'ダウンロード', 'manage_options', 'download', array( $this, 'view_download' ) );
	}

	/**
	 * 一括操作メニューにエクスポートを追加
	 */
	public function view_download()
	{
		include( TEMPLATEPATH . '/includes/admin/view/formdata-download.php' );
	}

	public function exec_download()
	{
		if ( empty( $_POST['download_formdata_type'] ) || empty( $_POST['download_formdata_nonce'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( $_POST['download_formdata_nonce'], 'download' ) ) {
			wp_die( 'トークンが一致しません' );
		}

		$arg = array();
		$arg['post_type'] = Constant::TYPE_FORMDATA;
		$arg['posts_per_page'] = -1;
		$arg['post_status'] = 'any';
		$arg['tax_query'] = array(
			array(
				'taxonomy' => Constant::TAX_FORMTYPE,
				'field'    => 'term_id',
				'terms'    => intval( $_POST['download_formdata_type'] ),
			),
		);		
		$formdata = get_posts( $arg );

		$filename = 'formdata_' . date('Ymd') . '.csv';
		header( "Content-Type: application/octet-stream" );
		header( "Content-Disposition: attachment; filename={$filename}" );

		$fp = fopen( "php://output", "w" );
		$header_printed = false;
		foreach( $formdata as $post ) {
			$rawdata = get_post_meta( $post->ID, 'rawdata', true );
			$rawdata = mb_convert_encoding( $rawdata, 'SJIS' );
			if ( ! $rawdata ) {
				continue;
			}
			if ( ! $header_printed ) {
				$header = array_keys( $rawdata );
				array_unshift( $header, mb_convert_encoding( '送信日時', 'SJIS' ) );
				fputcsv( $fp, $header, ",", '"' );
				$header_printed = true;
			}
			$row = array_values( $rawdata );
			array_unshift( $row, $post->post_date );
			fputcsv( $fp, $row, ",", '"' );
		}
		fclose( $fp );
		die;
	}
}
