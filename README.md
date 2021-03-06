# プロジェクト概要

このプロジェクトは、  
ナウル共和国政府観光局日本事務所の[公式サイト](https://nauru.or.jp/)  
をよりモダンでイケてるサイトにすべく、  
有志により勝手に新サイトを作ってしまおうというノリだけで生まれたプロジェクトです。  
  
良いものが出来上がったあかつきには、  
[ナウル共和国政府観光局日本事務所さん](https://twitter.com/nauru_japan)に無償でプレゼントしたいと思います。  

# 開発方針

スピード重視のため、WordPressで構築しています。  
  
第２フェーズの構想として、  
WordPress を API化して (WP REST API のみを用いるヘッドレスCMSとして使用して）、  
フロントを Vue 等で再構築することを検討しています。  
  
# WordPress 開発規約 (仮)

## Controller

テンプレート内にデータ取得等のロジックを書くのは嫌悪感があるので、  
擬似的なコントローラの仕組みを用意しています。  
  
各テンプレートファイルと同名でコントローラを作成すれば、  
コントローラが自動的にインスタンス化されます。  
  
コントローラの作成は必須ではありません。  
対応するコントローラが存在しなければ、  
Common_Controller で代用されます  
  
コントローラに handle() メソッドを定義すれば、  
自動的に実行されます。  
メインループ以外のデータ取得等に使用できます。  
  
ページ固有のCSSやJSの読み込みは enqueue() に定義します。  
  
テンプレートファイルはコントローラのスコープ内となるようにしています。  
つまり、テンプレートファイルで $this->xxx とすれば、  
コントローラのメソッドやプロパティにアクセスできます。  
  
get_header() や get_template_part() で読み込まれるサブテンプレートは、  
コントローラのスコープ外になります。  
これらの場所からコントローラにアクセスしたい場合は、  
Router::load() を使用してください。  

## Migration

管理画面からのサイトに関わる設定を行うと、  
全員の開発環境＋本番環境で同様の操作が必須となり、状態の同期をとるのが困難になります。  
そのため、本テーマには Migration クラスを用意しています。  
  
Migration は、管理画面にアクセスした際に、  
当該環境の Migration バージョンと、  
ソースの Migration::VERSION が相違している場合、  
差分の処理が自動実行されるようになっています。  
  
特に以下の点に注意してください。  
  
- プラグインは原則使用しないでください。  
- 管理画面からの設定変更や、テーマに必須の投稿を作成する必要がある場合は、  
  Migration::VERSION をインクリメントし、  
  その番号に対応するメソッドに内容を定義してください。  
- パーマリンクのリフレッシュが必要な改修を行った場合も、  
  Migration::VERSION をインクリメントしてください。  

## その他

投稿タイプやタクソノミーの定義は、  
Types クラス、 Taxonomy クラスを作成して、  
functions.php でインスタンス化してください。  
当該投稿タイプやタクソノミーに関する固有のフックは、  
極力ここに記述します。  
  
一般的なフック処理は、Hooks 内に任意のクラスファイルを作成し、  
functions.php でインスタンス化してください。  
コンソトラクタにフック処理を記述し、クラスメソッドをバインドします。  
名前空間の汚染を避けるためです。  
