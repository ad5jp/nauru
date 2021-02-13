<?php
require_once( TEMPLATEPATH . '/includes/autoload.php' );

define('NAURU_CSS_UPDATED', '20200214_020000');
define('NAURU_CSS_PARAM', '?updated=' . NAURU_CSS_UPDATED);

new Nauru\Core();
new Nauru\Types\Information();
new Nauru\Types\Gallery();
new Nauru\Types\Faq();
new Nauru\Taxonomies\Gallery_Genre();
new Nauru\Hooks\Sitemap();

if ( is_admin() ) {
    new Nauru\Hooks\Admin();
    new Nauru\Migration();
} else {
    new Nauru\Hooks\Head();
    Nauru\Router::init();
}
