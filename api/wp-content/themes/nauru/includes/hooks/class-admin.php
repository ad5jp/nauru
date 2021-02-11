<?php
/**
 * 管理画面関連
 * 
 * @category hooks
 * @package Nauru
 */
namespace Nauru\Hooks;

class Admin
{
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'remove_menus' ) );
    }

    /**
     * ACTION HOOK : admin_menu
     * 不要なメニューの削除
     *
     * @return void
     */
    function remove_menus() {
        remove_menu_page( 'index.php' ); // ダッシュボード
        remove_menu_page( 'edit.php' ); // 投稿
        remove_menu_page( 'edit-comments.php' ); // コメント
        remove_menu_page( 'themes.php' ); // 外観
        remove_menu_page( 'plugins.php' ); // プラグイン
    }
}
