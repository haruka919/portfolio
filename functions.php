<?php
/* ===============================
カスタムヘッダー
=============================== */
// カスタムヘッダー画像の設置 
$custom_header_defaults = array(
  'default-image' => get_bloginfo('template_url').'/img/headers/logo-bk.png',
  'header-text' => false,
);
// カスタムヘッダー機能を有効にする
add_theme_support('custom-header', $custom_header_defaults);

/* ===============================
カスタムメニュー
=============================== */
function add_custom_menu(){
  register_nav_menu('main-menu','メインメニュー');
}
add_action('after_setup_theme','add_custom_menu');

/* ===============================
ページネーション
=============================== */
// ページネーション
function pagination($pages = '', $range = 2){
  $showitems = ($range * 2) + 1; //表示するページ数（5ページ）
  global $paged; //現在のページ値
  if(empty($paged)) $paged = 1; //デフォルトのページ
  if($pages == ''){
    global $wp_query;
    $pages = $wp_query->max_num_pages;//全ページ数を取得
    if(!$pages){ //全ページ数が空の場合
      $pages = 1;
    }
  }
  if(1 != $pages){ //全ページが１ではない場合はページネーションを表示する
    echo "<div class=\"p-pagenation\">\n";
    echo "<ul class=\"p-pagenation-list\">\n";
    // Prev:現在ページ値が１より大きい場合は表示
    if($paged > 1) echo "<li class=\"p-pagenation-list-item prev\"><a href='".get_pagenum_link($paged - 1)."'><</a></li>\n";
    for($i = 1; $i <= $pages; $i++){
      if(1!= $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1 )|| $pages <= $showitems )){
        echo ($paged == $i)? "<li class=\"p-pagenation-list-item is-active\">".$i."</li>\n":"<li class=\"p-pagenation-list-item\"><a href='".get_pagenum_link($i)."'>".$i."</a></li>\n";
      }
    }
    //Next：総ページ数より現在のページ値が小さい場合は表示
    if($paged < $pages) echo "<li class=\"p-pagenation-list-item  next\"><a href=\"".get_pagenum_link($paged + 1)."\">></a></li>\n";
    echo "</ul>\n";
    echo "</div>\n";
  }
}
/* ===============================
カスタムフィールド
=============================== */
// 投稿ページへ表示するカスタムボックスを定義する
add_action('admin_menu', 'add_custom_inputbox');
// 追加した表示項目のデータ更新：保存の為のアクションフック
add_action('save_post', 'save_custom_postdata');

// 入力項目がどの投稿タイプのページに表示されるのか設定
function add_custom_inputbox(){
  // 第一引数：編集画面のhtmlに挿入されるid属性名
  // 第二引数：管理画面に表示されるカスタムフィールド名
  // 第三引数：メタボックスの中に出力される関数名
  // 第四引数：管理画面に表示するカスタムフィールドの場所（postなら投稿、pageなら固定）
  // 第五引数：配置される順序
  add_meta_box('about_id', 'ABOUT入力', 'custom_area', 'page', 'normal');
}
// 管理画面に表示される内容
function custom_area(){
  global $post;
  echo 'コメント：<textarea cols="80" rows="10" name="about_msg">'.get_post_meta($post->ID, 'about', true).'</textarea><br>';
}
// 投稿ボタンを押した際のデータ更新と保存
function save_custom_postdata($post_id){
  $about_msg = '';
  // カスタムフィールドに入力された情報を取り出す
  if(isset($_POST['about_msg'])){
    $about_msg = $_POST['about_msg'];
  }

  // 内容が変わっていた場合
  if( $about_msg != get_post_meta($post_id, 'about', true)){
    update_post_meta($post_id, 'about', $about_msg);
  }elseif($about_msg == ''){
    delete_post_meta($post_id, 'about', get_post_meta($post_id, 'about', true));
  }
}
/* ===============================
カスタムウィジェット
=============================== */
// ウィジェットエリアを作成する関数がどれなのかを登録する
add_action('widgets_init', 'my_widgets_area');
// ウィジェット自体の作成する関数がどれなのかを登録する
add_action('widgets_init', function(){
register_widget( 'my_widgets_output' );
});

// ウィジェットエリアを作成する
function my_widgets_area(){
  register_sidebar( array(
    'name' => 'アウトプット作品一覧',
    'id' => 'output',
    'before_widget' => '<div>',
    'after_widget' => '</div>'
  ));
  register_sidebar( array(
    'name' => 'コンテンツウィジェット',
    'id' => 'content-widget',
    'before_widget' => '<aside class="p-widget">',
    'after_widget' => '</aside>',
    'before_title' => '<h2 class="p-widget__heading">',
    'after_title' => '</h2>',
  ));
}
// ウィジェット自体を作成する
class my_widgets_output extends WP_Widget{
  // 初期化（管理画面で表示する名前を設定）
  function __construct(){
    parent::__construct(false, $name = '自己紹介');
  }

  // ウィジェットの入力項目を作成する処理
  function form($instance){
    // 入力された情報をサニタイズして変数に格納
    $title = esc_attr($instance['title']);
    $body = esc_attr($instance['body']);
  ?>
    <p>
      <label for="<?php echo $this->get_field_id('title');?>">
        <?php echo '作品タイトル'; ?>
      </label>
      <input class="widefat" id="<?php echo $this->get_field_id('title');?>" name="<?php echo $this->get_field_name('title');?>" type="text" value="<?php echo $title;?>">
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('body');?>">
        <?php echo '作品の説明';?>
      </label>
      <textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('body');?>" name="<?php echo $this->get_field_name('body');?>"><?php echo $body;?></textarea>
    </p>
  <?php
  }

  // ウィジェットに入力された情報を保存する処理
  function update($new_instance, $old_instance){
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']); //サニタイズ
    $instance['body'] = trim($new_instance['body']); //サニタイズ
    return $instance;
  }

  // 管理画面から入力されたウィジェットを画面に表示する処理
  function widget($args, $instance){
    // 配列を変数に展開
    extract($args);//配列のキー名が変数に使えるようになる

    // ウィジェットから入力された情報を取得
    $title = apply_filters('widget_title', $instance['title']);
    $body = apply_filters('widget_body', $instance['body']);

  // ウィジェットから入力された情報がある場合、htmlを表示する
  if($title){
?>
    <section class="panel">

      <h2><?php echo $title;?></h2>
      <p>
        <?php echo $body;?>
      </p>
    </section>
<?php       
    }
  }
}

/* ===============================
アイキャッチ画像使用
=============================== */
// アイキャッチ画像を有効にする
add_theme_support('post-thumbnails');


/* ===============================
抜粋する文字数を変更
=============================== */
function twpp_change_excerpt_length( $length ) {
  return 80; 
}
add_filter( 'excerpt_length', 'twpp_change_excerpt_length', 999 );


/* ===============================
パンくずリスト
=============================== */
function breadcrumb() {
  $home = '<li class="p-breadcrumb__item"><a href="'.get_bloginfo('url').'" >HOME</a></li>';

  echo '<div class="p-breadcrumb">';
  echo '<div class="p-breadcrumb__inner">';
  echo '<ul class="p-breadcrumb__list">';
  if ( is_front_page() ) {
    // トップページの場合
  }
  else if ( is_category() ) {
    // カテゴリページの場合
    $cat = get_queried_object();
    $cat_id = $cat->parent;
    $cat_list = array();
    while ($cat_id != 0){
      $cat = get_category( $cat_id );
      $cat_link = get_category_link( $cat_id );
      array_unshift( $cat_list, '<li class="p-breadcrumb__item"><a href="'.$cat_link.'">'.$cat->name.'</a></li>' );
      $cat_id = $cat->parent;
    }
    echo $home;
    foreach($cat_list as $value){
      echo $value;
    }
    the_archive_title('<li class="p-breadcrumb__item">', '</li>');
  }
  else if ( is_archive() ) {
  // 月別アーカイブ・タグページの場合
  echo $home;
  the_archive_title('<li class="p-breadcrumb__item">', '</li>');
  }
  else if ( is_single() ) {
  // 投稿ページの場合
  $cat = get_the_category();
    if( isset($cat[0]->cat_ID) ) $cat_id = $cat[0]->cat_ID;
    $cat_list = array();
    while ($cat_id != 0){
        $cat = get_category( $cat_id );
        $cat_link = get_category_link( $cat_id );
        array_unshift( $cat_list, '<li class="p-breadcrumb__item"><a href="'.$cat_link.'">'.$cat->name.'</a></li>' );
        $cat_id = $cat->parent;
    }
    echo $home;
    foreach($cat_list as $value){
        echo $value;
    }
    the_title('<li class="p-breadcrumb__item">', '</li>');
  }
  else if( is_page() ) {
  // 固定ページの場合
  echo $home;
  the_title('<li class="p-breadcrumb__item">', '</li>');
  }
  else if( is_search() ) {
  // 検索ページの場合
  echo $home;
  echo '<li class="p-breadcrumb__item">「'.get_search_query().'」の検索結果</li>';
  }
  else if( is_404() ) {
  // 404ページの場合
  echo $home;
  echo '<li class="p-breadcrumb__item">ページが見つかりません</li>';
  }
  echo "</ul>";
  echo "</div>";
  echo "</div>";
}
 
// アーカイブの余計なタイトルを削除
add_filter( 'get_the_archive_title', function ($title) {
  if ( is_category() ) {
    $title = single_cat_title( '', false );
  } elseif ( is_tag() ) {
    $title = single_tag_title( '', false );
  } elseif ( is_month() ) {
    $title = single_month_title( '', false );
  }
  return $title;
});

/* ===============================
新着一覧（ブログ）
=============================== */
function allpost_rel(){
  if(is_page_template('blog') ){
    global $paged;

    $args = array(
      'posts_per_page' => get_option('posts_per_page'), //取得する投稿数の指定
      'paged' => $paged, //現在のページ番号の指定
      'orderby' => 'post_date',
      'order' => 'DESC',
      'post_type' => 'post',
      'post_status' => 'publish'
    );
    $the_query = new WP_Query($args);

    // rel="next"のモジュール
    if($the_query->max_num_pages != $paged){
      if($paged == 0){
        $now_page = 2;
      }else{
        $now_page = $paged + 1;
      }
      echo '<link rel="next" href="'.get_the_permalink().'page/'.$now_page.'"/>'.PHP_EOL;
    }

    // rel="prev"のモジュール
    if( 2 == $paged){
      echo '<link rel="prev" href="'.get_the_permalink().'"/>'.PHP_EOL;
    }elseif( 0 != $paged){
      $now_page = $paged - 1;
      echo '<link rel="prev" href="'.get_the_permalink().'page/'.$now_page.'"/>'.PHP_EOL;
    }

  }
}
add_action( 'wp_head', 'allpost_rel' );

/* ===============================
カスタム投稿タイプ「アウトプット」を追加
=============================== */
function create_post_type_output() {
  $Supports = [
    'title',
    'editor',
    'thumbnail',
  ];
  register_post_type( 'output',
    array(
      'label' => 'アウトプット',
      'labels' => array(
      'all_items' => 'アウトプット一覧'
      ),
      'public' => true,
      'has_archive' => true,
      'menu_position' => 5,
      'supports' => $Supports
    )
  );
}
add_action( 'init', 'create_post_type_output' );

/* ===============================
jsファイル読み込み
=============================== */
function add_my_scripts() {
  wp_enqueue_script( 
    'base-script', 
    get_theme_file_uri( '/js/main.js' ), 
    array( 'jquery' ), 
    '20190123', 
    false
  );
}
add_action('wp_enqueue_scripts', 'add_my_scripts');

/* ===============================
サイドバー（記事数装飾）
=============================== */
// function theme_list_categories( $output, $args ) {
// 	$replaced_text = preg_replace('/<\/a> \(([0-9,]*)\)/', ' <span class="count">${1}</span></a>', $output);
// 	if($replaced_text != NULL) {
// 		return $replaced_text;
// 	} else {
// 		return $output;
// 	}
// }
// add_filter( 'wp_list_categories', 'theme_list_categories', 10, 2 );
// add_filter( 'get_archives_link','theme_list_categories', 10, 2 );

//カテゴリ・アーカイブウィジェットの投稿数のカッコを取り除く
function remove_post_count_parentheses( $output ) {
  $output = preg_replace('/<\/a>.*\((\d+)\)/','<span class="count">$1</span></a>',$output);
  return $output;
}
add_filter( 'wp_list_categories', 'remove_post_count_parentheses' );
add_filter( 'get_archives_link',  'remove_post_count_parentheses' );