<?php
/**
 * 汎用コントローラ
 * 
 * @category controller
 * @package Nauru
 */
namespace Nauru\Controller;

class Common_Controller
{
    public $template;
    protected $post = null;
    protected $term = null;
    protected $post_type = null;
    protected $breadcramb = array();

    public function __construct($template)
    {
        $this->template = $template;

        //投稿オブジェクト・投稿タイプオブジェクトをロード
        $this->load_property();

        //メイン処理
        $this->handle();

        //CSS/JSのキューイング
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );

        //タイトルタグ
        add_filter( 'document_title_parts', array( $this, 'modify_document_title' ) );

        $this->template_include();
    }

    public function breadcramb()
    {
        if ( ! $this->breadcramb ) {
            //末端から順に入れていく
            $breadcramb = array();
            $breadcramb = array_merge( $breadcramb, $this->get_breadcramb_post() );
            $breadcramb = array_merge( $breadcramb, $this->get_breadcramb_term() );
            $breadcramb = array_merge( $breadcramb, $this->get_breadcramb_type() );
            $breadcramb[] = array(
                'label' => 'HOME',
                'link' => home_url(),
            );
    
            //末端のリンクを削除
            $breadcramb[0]['link'] = null;
            //反転させる
            $this->breadcramb = array_reverse( $breadcramb );    
        }

        $this->print_breadcramb( $this->breadcramb );
    }

    /**
     * 投稿オブジェクト・投稿タイプオブジェクトをロード
     */
    private function load_property()
    {
        if ( is_singular() ) {
            global $post;
            $this->post = $post;    
            if ( $this->post->post_type != 'post' && $this->post->post_type != 'page' ) {
				$this->post_type = get_post_type_object( $this->post->post_type );
			}
		} elseif ( is_tax() || is_category() ) {
            $this->term = get_queried_object();
            if ( $this->term ) {
                $tax = get_taxonomy( $this->term->taxonomy );
                $post_type = get_post_type_object( $tax->object_type[0] );
                if ( $post_type->name != 'post' && $post_type->name != 'page' ) {
                    $this->post_type = $post_type;
                }    
            }
		} elseif ( is_post_type_archive() ) {
			$this->post_type = get_queried_object();
        }
    }

    /**
     * メイン処理（各コントローラでオーバーライド）
     */
    protected function handle()
    {

    }

    /**
     * CSS/JSのキューイング（各コントローラでオーバーライド）
     */
    public function enqueue()
    {

    }

    /**
     * テンプレートの読み込み
     * 
     * テンプレートをコントローラのスコープにするために（つまり $this が使えるように）、
     * Router の template_include で強制的に false を返し、
     * 代わりにここで include する。
     */
    protected function template_include()
    {
        include( $this->template );
    }

    protected function get_breadcramb_post()
    {
        $paths = array();
        //個別投稿ページのみ処理
        if ( $this->post ) {
            $cursor = $this->post;
            while ( $cursor ) {
                $paths[] = array(
                    'label' => $cursor->post_title,
                    'link' => get_permalink( $cursor )
                );
                $cursor = $cursor->post_parent ? get_post( $cursor->post_parent ) : null;
            }
        }
        return $paths;
    }

    protected function get_breadcramb_term()
    {
        $paths = array();
        //タクソノミーアーカイブのみ処理。それ以外のページは個別にオーバーライドする
        if ( is_tax() || is_category() ) {
            //親タームも遡っていく
			$cursor = get_queried_object();
			while ( $cursor ) {
				$paths[] = array(
					'label' => $cursor->name,
					'link' => get_term_link( $cursor )
				);
				$cursor = $cursor->parent ? get_term( $cursor->parent, $cursor->taxonomy ) : null;
			}
		}
        return $paths;
    }

    protected function get_breadcramb_type()
    {
        $paths = array();
        if ( $this->post_type ) {
			$paths[] = array(
				'label' => $this->post_type->labels->name,
				'link' => get_post_type_archive_link( $this->post_type->name )
			);
		}
        return $paths;
    }

    protected function print_breadcramb( $breadcramb )
    {
        if ( $breadcramb && count( $breadcramb ) > 1 ) {
			$output = '<ul itemscope itemtype="http://schema.org/BreadcrumbList">';
			foreach ( $breadcramb as $index => $cramb ) {
				$output .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
				if ( $cramb['link'] ) {
					$output .= '<a itemprop="item" href="' . $cramb['link'] . '">';
				}
				$output .= '<span itemprop="name">' . $cramb['label'] . '</span>';
				if ( $cramb['link'] ) {
					$output .= '</a>';
				}
				$output .= '<meta itemprop="position" content="' . ($index + 1) . '" />';
				$output .= '</li>';
			}
			$output .= '</ul>';
			echo $output;
		}
    }

    /**
     * FILTER HOOK : pre_get_document_title
     * タイトルタグの設定
     */
    public function modify_document_title( $title )
    {
        if ( $get_document_title_page = $this->get_document_title_page() ) {
            $title['title'] = $get_document_title_page;
        }
        $title['site'] = 'ナウル共和国非公式サイト';
        return $title;
    }

    protected function get_document_title_page()
    {
        //必要に応じて個別コントローラで上書き
        return null;
    }

    /**
     * メタタグ用値取得　各コントローラでオーバーライドする
     */
    public function page_title()
    {
        if ( $this->post ) {
            return $this->post->post_title;
        } elseif ( $this->term ) {
            return $this->term->term_name;
        } elseif ( $this->post_type ) {
            return $this->post_type->label;
        } else {
            return get_bloginfo( 'name' );
        }
    }

    public function keywords()
    {
        return array( 'ナウル', 'ナウル共和国' );
    }

    public function description()
    {
        if ( $this->post ) {
            return mb_strimwidth( str_replace( array("\r", "\n", "\r\n"), "", strip_tags( $this->post->post_content ) ), 0, 280, '...' );
        } else {
            return "ナウル共和国を応援するために、有志により制作された非公式WEBサイトです。";
        }
    }

    public function canonical()
    {
        if ( $this->post ) {
            return get_permalink( $this->post->ID );
        } elseif ( $this->term ) {
            return get_term_link( $this->term );
        } elseif ( $this->post_type ) {
            return get_post_type_archive_link( $this->post_type->name );
        } else {
            return home_url();
        }
    }
}
