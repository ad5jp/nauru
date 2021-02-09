<?php
/**
 * WordPress の基本設定
 *
 * このファイルは、インストール時に wp-config.php 作成ウィザードが利用します。
 * ウィザードを介さずにこのファイルを "wp-config.php" という名前でコピーして
 * 直接編集して値を入力してもかまいません。
 *
 * このファイルは、以下の設定を含みます。
 *
 * * MySQL 設定
 * * 秘密鍵
 * * データベーステーブル接頭辞
 * * ABSPATH
 *
 * @link https://ja.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// 注意:
// Windows の "メモ帳" でこのファイルを編集しないでください !
// 問題なく使えるテキストエディタ
// (http://wpdocs.osdn.jp/%E7%94%A8%E8%AA%9E%E9%9B%86#.E3.83.86.E3.82.AD.E3.82.B9.E3.83.88.E3.82.A8.E3.83.87.E3.82.A3.E3.82.BF 参照)
// を使用し、必ず UTF-8 の BOM なし (UTF-8N) で保存してください。

// ** MySQL 設定 - この情報はホスティング先から入手してください。 ** //
/** WordPress のためのデータベース名 */
define( 'DB_NAME', 'database_name_here' );

/** MySQL データベースのユーザー名 */
define( 'DB_USER', 'username_here' );

/** MySQL データベースのパスワード */
define( 'DB_PASSWORD', 'password_here' );

/** MySQL のホスト名 */
define( 'DB_HOST', 'localhost' );

/** データベースのテーブルを作成する際のデータベースの文字セット */
define( 'DB_CHARSET', 'utf8' );

/** データベースの照合順序 (ほとんどの場合変更する必要はありません) */
define( 'DB_COLLATE', '' );

/**#@+
 * 認証用ユニークキー
 *
 * それぞれを異なるユニーク (一意) な文字列に変更してください。
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org の秘密鍵サービス} で自動生成することもできます。
 * 後でいつでも変更して、既存のすべての cookie を無効にできます。これにより、すべてのユーザーを強制的に再ログインさせることになります。
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'IwN7W.+K1iMws6!0GDsr2C&/|`DzU}u;~yGv+G~N*G^~!DlC*Z4<HWj@+M-cvbX!');
define('SECURE_AUTH_KEY',  'AAk]I-9]jQOP.~aDXruP|${Qb;!+@q>HrdKVaq<]3Ml+8jHhVZJkoKjWJ|:_,-N.');
define('LOGGED_IN_KEY',    'l;)2Rb6Z&Ct/I[n69Y~4.JdaqZkStN)V]nFOa1H<-$Kb>:j4{TOt=PkbUU5)C{Dx');
define('NONCE_KEY',        '!rO)YAT-}VbViM()D8`!f.=-_F2|U}{*G&bkq=)Pj.@y%YRz|9m[@PItU8)#HKyt');
define('AUTH_SALT',        '5Qi=%RO0EC/vM!,o8t]%:B5W3/Z}iT H$V(%@{Pj*N0(p`NWDjp#m3|cD{ke`y;{');
define('SECURE_AUTH_SALT', '0q3Qkn:NoG*brnd+ZgU0b~Dl]zXJ-@g3(GPTigiqx2Xg;c/XKt2pN0v6 pp<+`ZC');
define('LOGGED_IN_SALT',   '<@HlE! q1XMuBB,,%`R`UYr:815:2<+|0-Rf,-WZfFr(j-6MFm[_{:?XTnwQgXS6');
define('NONCE_SALT',       'h))#l`{!o;7vP>LBp8yfyT:CG^EN(`IOZr53?Mn|/ZzxHKix=?+$VN)x]MY9WDqD');

/**#@-*/

/**
 * WordPress データベーステーブルの接頭辞
 *
 * それぞれにユニーク (一意) な接頭辞を与えることで一つのデータベースに複数の WordPress を
 * インストールすることができます。半角英数字と下線のみを使用してください。
 */
$table_prefix = 'wp_';

/**
 * 開発者へ: WordPress デバッグモード
 *
 * この値を true にすると、開発中に注意 (notice) を表示します。
 * テーマおよびプラグインの開発者には、その開発環境においてこの WP_DEBUG を使用することを強く推奨します。
 *
 * その他のデバッグに利用できる定数についてはドキュメンテーションをご覧ください。
 *
 * @link https://ja.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );

/* 編集が必要なのはここまでです ! WordPress でのパブリッシングをお楽しみください。 */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
