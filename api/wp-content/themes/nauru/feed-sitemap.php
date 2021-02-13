<?php
	header( 'Content-Type: text/xml; charset=' . get_option( 'blog_charset' ), true );
	echo '<?xml version="1.0" encoding="' . get_option( 'blog_charset' ) . '"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php foreach ( $this->urlset as $url ): ?>
	<url>
		<loc><?php echo $url['loc']; ?></loc>
		<lastmod><?php echo $url['lastmod']; ?></lastmod>
		<changefreq><?php echo $url['changefreq']; ?></changefreq>
        <priority><?php echo $url['priority']; ?></priority>
    </url>
    <?php endforeach; ?>
</urlset>
