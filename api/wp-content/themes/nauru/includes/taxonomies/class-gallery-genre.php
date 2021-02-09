<?php
/**
 * タクソノミー gallery-genre (ギャラリージャンル)
 * 
 * @category taxonomies
 * @package Nauru
 */
namespace Nauru\Taxonomies;

use Nauru\Types\Gallery;

class Gallery_genre extends Base_Taxonomy
{
    const SLUG = 'gallery-genre';
    const LABEL = 'ジャンル';
    const POST_TYPE = Gallery::SLUG;
	
	protected $hierarchical = true;
	protected $rewrite = array( 'slug' => 'gallery/genre' );
}
