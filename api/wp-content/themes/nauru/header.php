<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head();?>
</head>
<body>

<?php if ( ! is_home() ): ?>
<header class="header">
    <div class="header-branding"><a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/shared/logo.png" alt=""></a></div>
    <nav class="header-nav">
        <a href="#" class="header-nav-toggle">MENU</a>
        <ul class="header-nav-list">
            <li class="header-nav-list-item">
                <a href="<?php echo get_post_type_archive_link( Nauru\Types\Gallery::SLUG ); ?>">
                    <div class="header-nav-list-item-subtitle">GALLERY</div>
                    <div class="header-nav-list-item-title">ナウルの魅力</div>
                </a>
            </li>
            <li class="header-nav-list-item">
                <a href="<?php echo home_url( 'about' ); ?>">
                    <div class="header-nav-list-item-subtitle">ABOUT</div>
                    <div class="header-nav-list-item-title">ナウルについて</div>
                </a>
            </li>
            <li class="header-nav-list-item">
                <a href="<?php echo get_post_type_archive_link( Nauru\Types\Faq::SLUG ); ?>">
                    <div class="header-nav-list-item-subtitle">FAQ</div>
                    <div class="header-nav-list-item-title">よくある質問</div>
                </a>
            </li>
            <li class="header-nav-list-item">
                <a href="<?php echo home_url( 'profile' ); ?>">
                    <div class="header-nav-list-item-subtitle">PROFILE</div>
                    <div class="header-nav-list-item-title">当サイトについて</div>
                </a>
            </li>
        </ul>
    </nav>
</header>
<?php endif; ?>
