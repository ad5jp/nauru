<?php get_header(); ?>
<?php the_post(); ?>

<main class="page">

<hgroup class="page-header">
    <h1 class="page-header-title"><?php the_title(); ?></h1>
</hgroup>

<section class="page-content">
    <div class="inner">
        <div class="page-content-inner block-editor-content">
            <?php the_content(); ?>
        </div>
    </div>
</section>

</main><!--//.page-->

<?php get_footer(); ?>
