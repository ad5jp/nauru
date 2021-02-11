<?php get_header(); ?>
<?php the_post(); ?>

<main class="information">

<hgroup class="page-header">
    <h2 class="page-header-title">お知らせ</h2>
</hgroup>


<section class="information-content">
    <div class="information-header">
        <h1 class="information-title"><?php the_title(); ?></h1>
        <div class="information-date"><date><?php echo get_the_date(); ?></date></div>
    </div>
    <div class="information-body classic-editor-content">
        <?php the_content(); ?>
    </div>
</section>

</main><!--//.information-->

<?php get_footer(); ?>
