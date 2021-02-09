<?php
require_once( TEMPLATEPATH . '/includes/autoload.php' );

//new Nauru\Constant();
new Nauru\Core();
new Nauru\Types\Information();
new Nauru\Types\Gallery();
new Nauru\Types\Faq();
new Nauru\Taxonomies\Gallery_genre();
//new Nauru\Hooks\Shortcodes();

if ( is_admin() ) {
    //new Nauru\Admin\Product();
    //new Nauru\Admin\Category();
    //new Nauru\Admin\Office();
    //new Nauru\Admin\Maker();
    //new Nauru\Admin\Form();
    new Nauru\Migration();
} else {
    //new Nauru\Hooks\Templates();
    new Nauru\Hooks\Head();
    Nauru\Router::init();
}
