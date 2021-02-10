<?php get_header(); ?>

<main class="information">

<hgroup class="page-header">
    <h1 class="page-header-title">お知らせ</h1>
</hgroup>

<section class="information-content">
    <ul class="information-list">
        <?php
            while ( have_posts() ):
            the_post();
        ?>
        <li class="information-list-item">
            <date class="information-list-item-date"><?php echo get_the_date(); ?></date>
            <a class="information-list-item-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </li>
        <?php
            endwhile;
        ?>
    </ul>

    <?php //todo ページネーション ?>
</section>

</main><!--//.information-->

<?php get_footer(); ?>
