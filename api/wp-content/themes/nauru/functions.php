<?php
require_once( TEMPLATEPATH . '/includes/autoload.php' );

new Nauru\Core();
new Nauru\Types\Information();
new Nauru\Types\Gallery();
new Nauru\Types\Faq();
new Nauru\Taxonomies\Gallery_Genre();

if ( is_admin() ) {
    new Nauru\Hooks\Admin();
    new Nauru\Migration();
} else {
    new Nauru\Hooks\Head();
    Nauru\Router::init();
}
