<?php get_header(); ?>

<main class="home">

<div class="home-background"></div>

<section class="home-main">
    <h1 class="home-main-branding"><a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/shared/logo-blue.png" alt="<?php echo get_bloginfo( 'name' ); ?>"></a></h1>
    <div class="home-main-tagline">
        <div class="home-main-tagline-baloon">コロナが収束したら</div>
        <p>ナウルへ行こう!!</p>
    </div>
</section>

<section class="home-nav">
    <div class="inner">
        <nav class="home-nav-list">
            <a href="<?php echo get_post_type_archive_link( Nauru\Types\Gallery::SLUG ); ?>" class="home-nav-list-item">
                <div class="home-nav-list-item-subtitle">GALLERY</div>
                <div class="home-nav-list-item-title">ナウルの魅力</div>
                <div class="home-nav-list-item-icon"><i class="fa fa-pagelines"></i></div>
            </a>
            <a href="<?php echo home_url( 'about' ); ?>" class="home-nav-list-item">
                <div class="home-nav-list-item-subtitle">ABOUT</div>
                <div class="home-nav-list-item-title">ナウルについて</div>
                <div class="home-nav-list-item-icon"><i class="fa fa-plane"></i></div>
            </a>
            <a href="<?php echo get_post_type_archive_link( Nauru\Types\Faq::SLUG ); ?>" class="home-nav-list-item">
                <div class="home-nav-list-item-subtitle">FAQ</div>
                <div class="home-nav-list-item-title">よくある質問</div>
                <div class="home-nav-list-item-icon"><i class="fa fa-question-circle-o"></i></div>
            </a>
            <a href="<?php echo home_url( 'profile' ); ?>" class="home-nav-list-item">
                <div class="home-nav-list-item-subtitle">PROFILE</div>
                <div class="home-nav-list-item-title">当サイトについて</div>
                <div class="home-nav-list-item-icon"><i class="fa fa-rss"></i></div>
            </a>
        </nav>
    </div>
</section>

<section class="home-information">
    <h2 class="home-information-title">お知らせ</h2>
    <ul class="home-information-list">
        <?php
            while ( $this->info_query->have_posts() ):
            $this->info_query->the_post();
        ?>
        <li class="home-information-list-item">
            <date class="home-information-list-item-date"><?php echo get_the_date(); ?></date>
            <a class="home-information-list-item-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </li>
        <?php
            endwhile;
            wp_reset_postdata();
        ?>
        </li>
    </ul>
    <a href="<?php echo get_post_type_archive_link( Nauru\Types\Information::SLUG ); ?>" class="home-information-more">もっと読む</a>
</section>

</main><!--//.home-->

<?php get_footer(); ?>
