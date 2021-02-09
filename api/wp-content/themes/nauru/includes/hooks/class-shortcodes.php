<?php
/**
 * ショートコードの登録
 * 
 * @category hooks
 * @package Nauru
 */
namespace Nauru\Hooks;

class Shortcodes
{
	public function __construct()
	{
		//add_shortcode( 'box', array( $this, 'box' ) );

		//ショートコードのPタグ除去
		remove_filter( 'the_content', 'wpautop' );
		add_filter( 'the_content', 'wpautop', 99 );
		add_filter( 'the_content', 'shortcode_unautop', 100 );		
	}

	public function box( $atts, $content )
	{
		/*
		$atts = shortcode_atts( array(
			'type' => 'default',
		), $atts, 'agi_box' );

		$output = '';
		$output .= '<div class="editor-box-' . $atts['type'] . '">';
		$output .= do_shortcode( shortcode_unautop( $content ) );
		$output .= '</div>';

		return $output;
		*/
	}
}
