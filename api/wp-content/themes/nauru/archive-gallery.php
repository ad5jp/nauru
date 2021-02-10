<?php get_header(); ?>

<main class="gallery">

<hgroup class="page-header">
    <h1 class="page-header-title">ナウルの魅力</h1>
</hgroup>

<section class="gallery-genres">
    <nav class="gallery-genres-nav">
    <?php foreach ( $this->genres as $genre ): ?>
    <a class="gallery-genres-nav-item" href="<?php echo get_term_link( $genre ); ?>"><?php echo $genre->name; ?></a>
    <?php endforeach; ?>
    </nav>
</section>

<section class="gallery-content">
    <ul class="gallery-list">
        <?php
            while ( have_posts() ):
            the_post();
        ?>
        <li class="gallery-list-item">
            <a href="javascript:void()" class="gallery-list-item-image">
            <?php the_post_thumbnail(); ?>
            </a>
            <div class="gallery-list-item-meta">
                <h3 class="gallery-list-item-title"><?php the_title(); ?></h3>
                <div class="gallery-list-item-source"><?php echo $this->get_source_html(); ?></div>
            </div>
        </li>
        <?php
            endwhile;
        ?>
    </ul>

    <?php //todo ページネーション ?>
</section>

</main><!--//.gallery-->

<?php get_footer(); ?>
