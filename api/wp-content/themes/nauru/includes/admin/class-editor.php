<?php
/**
 * wysiwyg 関連
 *
 * @category admin
 * @package Nauru
 */
namespace Nauru\Admin;

class Editor
{
    public function __construct()
    {
        //add_filter( 'mce_buttons', array( $this, 'add_style_selector' ) );
        add_filter( 'tiny_mce_before_init', array( $this, 'modify_styles' ) );

        //ブロックエディタ無効化
        add_filter( 'use_block_editor_for_post', '__return_false' );
    }

    /**
     * FILTER HOOK : mce_buttons
     * スタイル選択ボタンを追加
     */
    function add_style_selector( $array ) {
        array_unshift( $array, 'styleselect');
        return $array;
    }
    
    /**
     * FILTER HOOK : tiny_mce_before_init
     * ブロックフォーマット、スタイルセレクトのカスタマイズ
     */
    function modify_styles( $init ) {
        /*
        $style_formats = array(
            array(
                'title' => 'div(段落)',
                'block' => 'div',
                'classes' => 'txt-paragraph',
                'wrapper' => true,
            ),
            array(
                'title' => '見出し2',
                'block' => 'h2',
                'classes' => 'ttl-xl',
            ),
            array(
                'title' => '見出し3',
                'block' => 'h3',
                'classes' => 'ttl-lg',
            ),
            array(
                'title' => '見出し4',
                'block' => 'h4',
                'classes' => 'ttl-md',
            ),
            array(
                'title' => '見出し5',
                'block' => 'h5',
                'classes' => 'ttl-sm',
            ),
            array(
                'title' => '見出し6',
                'block' => 'h6',
                'classes' => 'ttl-xs',
            ),
            array(
                'title' => 'ボックス(赤)',
                'block' => 'div',
                'classes' => 'frame-red',
                'wrapper' => true,
            ),
            array(
                'title' => 'ボックス(白)',
                'block' => 'div',
                'classes' => 'frame',
                'wrapper' => true,
            ),
            array(
                'title' => 'リスト(丸型タイプ)',
                'inline' => 'li',
                'selector' => 'ul',
                'classes' => 'list-ul',
                'wrapper' => true,
            ),
            array(
                'title' => 'リスト(数字タイプ)',
                'inline' => 'li',
                'selector' => 'ol',
                'classes' => 'list-ol',
                'wrapper' => true,
            ),
            array(
                'title' => 'アンダーライン(赤)',
                'inline'=> 'span',
                'styles' => array(
                    'text-decoration' => 'underline',
                    'color' => 'red'
                ),
                'exact' =>    true,
            ),
            array(
                'title' => 'ボタン(googleリンク)',
                'inline' => 'a',
                'classes' => 'button',
                'attributes' => array(
                    'href' => 'https://google.com'
                ),
                'wrapper' => true,
            ),
            array(
                'title' => '書式設定をリセット',
                'selector' => '*',
                'remove' => 'all',
            ),
        );
        $init['style_formats'] = json_encode( $style_formats );
        */
        $init['block_formats'] = '通常=p;大見出し=h2;中見出し=h3;小見出し=h4';
        return $init;
    }
}
