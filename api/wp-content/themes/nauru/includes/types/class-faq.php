<?php
/**
 * 投稿タイプ Faq (よくある質問)
 * 
 * @category types
 * @package Nauru
 */
namespace Nauru\Types;

class Faq extends Base_Type
{
    const SLUG = 'faq';
    const LABEL = 'よくある質問';

    protected $supports = array( 'title', 'editor','author', 'page-attributes' );

}
