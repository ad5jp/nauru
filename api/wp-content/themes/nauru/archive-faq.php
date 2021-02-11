<?php get_header(); ?>

<main class="faq">

<hgroup class="page-header">
    <h1 class="page-header-title">よくある質問</h1>
</hgroup>

<section class="faq-content content">
    <div class="inner">
        <dl class="faq-list">
            <?php
                while ( have_posts() ):
                the_post();
            ?>
            <dt class="faq-list-question">
                <i>Q.</i> <?php the_title(); ?>
            </dt>
            <dd class="faq-list-answer">
                <i>A.</i> <?php the_content(); ?>
            </dd>
            <?php
                endwhile;
            ?>
        </dl>
    </div>

    <?php //todo ページネーション ?>
</section>

</main><!--//.faq-->

<?php get_footer(); ?>
