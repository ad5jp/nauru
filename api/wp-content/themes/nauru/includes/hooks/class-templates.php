<?php
/**
 * テンプレートの変更関連
 * 
 * @category hooks
 * @package Nauru
 */
namespace Nauru\Hooks;

use Nauru\Constant;

class Templates
{
    public function __construct()
    {
        add_filter( 'template_include', array( $this, 'form_template' ), 1 );
    }

    /**
     * FILTER HOOK : template_include
     * フォームの専用テンプレート
     */
    public function form_template( $template )
    {
		global $post;
        if ( ! empty( $post->post_name ) && array_key_exists( $post->post_name, Constant::FORMS ) ) {
            $new_template = locate_template( array(
                'form-' . $post->post_name . '.php',
            ) );
            if ( ! $new_template ) {
                wp_die( 'フォームテンプレートが見つかりません' );
			}
			return $new_template;
        }

        return $template;
    }
}