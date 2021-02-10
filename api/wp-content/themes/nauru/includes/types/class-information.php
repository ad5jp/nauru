<?php
/**
 * 投稿タイプ Information (お知らせ)
 * 
 * @category types
 * @package Nauru
 */
namespace Nauru\Types;

class Information extends Base_Type
{
    const SLUG = 'information';
    const LABEL = 'お知らせ';

    protected $supports = array( 'title', 'editor','author', 'page-attributes' );
}
