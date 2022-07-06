<?php

// ------------------------------------------------
// グローバル変数
// ------------------------------------------------

// パス
$WP_ROOT_PATH = get_stylesheet_directory_uri();
$WP_IMG_PATH = esc_html($WP_ROOT_PATH . '/assets/images');
$WP_CSS_PATH = esc_html($WP_ROOT_PATH . '/assets/css');
$WP_JS_PATH = esc_html($WP_ROOT_PATH . '/assets/js');

// OGP用
$FACEBOOK_APP_ID = '';
$TWITTER_ACCOUNT_ID = '';


// ------------------------------------------------
// テーマのセットアップ
// ------------------------------------------------
function my_theme_setup()
{
  add_theme_support('post-thumbnails');
  add_theme_support('title-tag');
  add_theme_support('wp-block-styles');
  add_theme_support(
    'html5',
    array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
    )
  );
}
add_action('after_setup_theme', 'my_theme_setup');


// ------------------------------------------------
// css、js、fontの読み込み
// ------------------------------------------------
function my_script_init()
{
  wp_deregister_script('jquery');
  wp_enqueue_script('jquery', '//code.jquery.com/jquery-3.6.0.min.js', "", "1.0.1");

  // google font
  wp_enqueue_style('NotoSans', '//fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap"');

  // fontawsome
  wp_enqueue_style('font-awesome', 'https://use.fontawesome.com/releases/v5.6.1/css/all.css');

  // swiper
  wp_enqueue_script('swiper', '//unpkg.com/swiper@8/swiper-bundle.min.js', "", "1.0.1", false);
  wp_enqueue_style('swiper', '//unpkg.com/swiper@8/swiper-bundle.min.css', "", "1.0.1", false);


  // js
  wp_enqueue_script('main', get_template_directory_uri() . '/assets/js/common.js?v=' . date_i18n('Ymd_His'), array('jquery'), '1.0.1', true);

  // css
  wp_enqueue_style('style-name', get_template_directory_uri() . '/assets/css/styles.css?v=' . date_i18n('Ymd_His'), array(), '1.0.1', false);
}
add_action('wp_enqueue_scripts', 'my_script_init');


// ------------------------------------------------
// wordpressエディタ自動整形の無効化
// ------------------------------------------------
remove_filter('the_content', 'wpautop');
remove_filter('the_excerpt', 'wpautop');
add_filter(
  'tiny_mce_before_init',
  function ($init_array) {
    global $allowedposttags;
    $init_array['valid_elements']          = '*[*]';
    $init_array['extended_valid_elements'] = '*[*]';
    $init_array['valid_children']          = '+a[' . implode('|', array_keys($allowedposttags)) . ']';
    $init_array['indent']                  = true;
    $init_array['wpautop']                 = false;
    $init_array['force_p_newlines']        = false;
    return $init_array;
  }
);

// ------------------------------------------------
// 投稿の自動整形を無効（ダブルクオーテーションなど）
// ------------------------------------------------
add_filter('run_wptexturize', '__return_false');


// ------------------------------------------------
// wordpress更新通知を管理者権限のみに表示
// ------------------------------------------------
function update_nag_admin_only()
{
  if (!current_user_can('administrator')) {
    remove_action('admin_notices', 'update_nag', 3);
  }
}
add_action('admin_init', 'update_nag_admin_only');


// ------------------------------------------------
// 管理メニューの「投稿」に関する表示を「商品」に変更
// ------------------------------------------------
function change_post_menu_label()
{
  global $menu;
  global $submenu;
  $menu[5][0] = '商品';
  $submenu['edit.php'][5][0] = '商品一覧';
  $submenu['edit.php'][10][0] = '商品を追加';
  $submenu['edit.php'][16][0] = 'タグ';
}

// ------------------------------------------------
// 管理画面上の「投稿」に関する表示を「商品」に変更
// ------------------------------------------------
function change_post_object_label()
{
  global $wp_post_types;
  $labels = &$wp_post_types['post']->labels;
  $labels->name = '商品';
  $labels->singular_name = '商品';
  $labels->add_new = _x('追加', '商品');
  $labels->add_new_item = '商品の新規追加';
  $labels->edit_item = '商品の編集';
  $labels->new_item = '新規商品';
  $labels->view_item = '商品を表示';
  $labels->search_items = '商品を検索';
  $labels->not_found = '記事が見つかりませんでした';
  $labels->not_found_in_trash = 'ゴミ箱に記事は見つかりませんでした';
}
add_action('init', 'change_post_object_label');
add_action('admin_menu', 'change_post_menu_label');

/**
 * 不要なメニューを非表示
 * （コメントアウトした行のメニューは表示される）
 */
add_action('admin_menu', 'my_add_remove_admin_menus');
function my_add_remove_admin_menus()
{
  global $menu;
  unset($menu[2]);  // ダッシュボード
  unset($menu[4]);  // メニューの線1
  // unset($menu[5]);  // 投稿
  // unset($menu[10]); // メディア
  // unset($menu[15]); // リンク
  // unset($menu[20]); // ページ
  unset($menu[25]); // コメント
  unset($menu[59]); // メニューの線2
  // unset($menu[60]); // テーマ
  // unset($menu[65]); // プラグイン
  // unset($menu[70]); // プロフィール
  // unset($menu[75]); // ツール
  // unset($menu[80]); // 設定
  unset($menu[90]); // メニューの線3
}

/**
 *  投稿一覧ページのカスタム
 */
function add_posts_columns($columns)
{
  $columns['sale-flag'] = 'セール';
  $columns['thumbnail'] = 'アイキャッチ';
  return $columns;
}
add_filter('manage_posts_columns', 'add_posts_columns');

function add_posts_custom_column($column_name, $post_id)
{
  if ($column_name === 'sale-flag') {
    $column_count = get_post_meta($post_id, 'sale-flag', true);
    if (!empty($column_count)) {
      echo esc_html($column_count);
    } else {
      echo __('None');
    }
  }
  if ('thumbnail' == $column_name) {
    $thumb = get_the_post_thumbnail($post_id, array(100, 100), 'thumbnail');
    echo ($thumb) ? $thumb : '－';
  }
}
add_action('manage_posts_custom_column', 'add_posts_custom_column', 10, 2);



// ------------------------------------------------
// デフォルトアイキャッチの設定
// ------------------------------------------------
function get_eyecatch_with_default($post_id)
{
  if (has_post_thumbnail($post_id)) {
    $id = get_post_thumbnail_id($post_id);
    $img = wp_get_attachment_image_src($id, 'full');
  } else {
    $img = array(get_template_directory_uri() . '/assets/images/common/no_image.png');
  }

  return $img;
}

// ------------------------------------------------
// アイキャッチのaltを取得
// ------------------------------------------------
function get_eyecatch_alt()
{
  if (has_post_thumbnail()) {
    $thumbnail_alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
  } else {
    $thumbnail_alt = "";
  }
  return $thumbnail_alt;
}


// ------------------------------------------------
// OGP設定
// ------------------------------------------------
add_action('wp_head', 'my_add_meta_ogp');
function my_add_meta_ogp()
{
  if (is_front_page() || is_singular()) {
    global $WP_IMG_PATH;
    global $FACEBOOK_APP_ID;
    global $TWITTER_ACCOUNT_ID;
    global $post;
    $ogp_title = '';
    $ogp_descr = '';
    $ogp_url = '';
    $ogp_img = '';
    $insert = '';

    if (is_singular() && !is_page()) {
      setup_postdata($post);
      $ogp_title = $post->post_title;
      $ogp_descr = mb_substr(get_the_excerpt(), 0, 100);
      $ogp_url = get_permalink();
      wp_reset_postdata();
    } else {
      $ogp_title = get_bloginfo('name');
      $ogp_descr = get_bloginfo('description');
      $ogp_url = home_url();
    }

    // og:type
    $ogp_type = (is_front_page() || is_home()) ? 'website' : 'article';

    // og:image
    if (is_singular() && has_post_thumbnail()) {
      $ps_thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
      $ogp_img = $ps_thumb[0];
    } else {
      $ogp_img = $WP_IMG_PATH . '/common/ogp.jpg';
    }

    // タグ出力
    $insert .= '<meta property="og:title" content="' . esc_attr($ogp_title) . '">' . "\n";
    $insert .= '<meta property="og:description" content="' . esc_attr($ogp_descr) . '">' . "\n";
    $insert .= '<meta property="og:type" content="' . $ogp_type . '">' . "\n";
    $insert .= '<meta property="og:url" content="' . esc_url($ogp_url) . '">' . "\n";
    $insert .= '<meta property="og:image" content="' . esc_url($ogp_img) . '">' . "\n";
    $insert .= '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '">' . "\n";
    $insert .= '<meta name="twitter:card" content="summary_large_image">' . "\n";
    $insert .= '<meta name="twitter:site" content="' . $TWITTER_ACCOUNT_ID . '">' . "\n";
    $insert .= '<meta property="og:locale" content="ja_JP">' . "\n";
    $insert .= '<meta property="fb:app_id" content="' . $FACEBOOK_APP_ID . '">' . "\n";
    echo $insert;
  }
}


// ------------------------------------------------
// titleにセパレータを出力
// ------------------------------------------------
add_filter('document_title_separator', 'my_document_title_separator');
function my_document_title_separator($separator)
{
  $separator = '|';
  return $separator;
}


// ------------------------------------------------
// 記事タイトルが未入力の場合のテキスト
// ------------------------------------------------
function get_post_title($title)
{
  if ($title != "") {
    return $title;
  }
  return "(non title)";
}

// ------------------------------------------------
// メインループの制御
// ------------------------------------------------
function my_query($query)
{
  if (is_admin() || !$query->is_main_query()) {
    return;
  }

  $post_per_page = 8;
  $query->set('posts_per_page', $post_per_page);
  $query->set('ignore_sticky_posts', 1);

  if ($query->is_front_page()) {
    $query->set('posts_per_page', 6);
  }

  if ($query->is_post_type_archive('news')) {
    $query->set('posts_per_page', 5);
  }

  if ($query->is_tax()) {
    $query->set('posts_per_page', 5);
  }
}
add_filter('pre_get_posts', 'my_query');


//-----------------------------------------------------------
// ページネーション関連
//-----------------------------------------------------------
/**
 * ページネーションのHTMLカスタマイズ
 */
function custom_pagination_html($template)
{
  $template = '
  <nav class="c-pagination" role="navigation">
      <h2 class="screen-reader-text">%2$s</h2>
      %3$s
  </nav>';
  return $template;
}
add_filter('navigation_markup_template', 'custom_pagination_html');


/**
 * ○件中○○件目を表示
 */
function my_result_count()
{
  global $wp_query;
  $paged = get_query_var('paged') - 1;
  $ppp   = get_query_var('posts_per_page');
  $count = $total = $wp_query->post_count;
  $from  = 0;
  if (0 < $ppp) {
    $total = $wp_query->found_posts;
    if (0 < $paged)
      $from  = $paged * $ppp;
  }
  printf(
    '%2$s%3$s件目を表示（全%1$s件）',
    $total,
    (1 < $count ? ($from + 1 . '〜') : ''),
    ($from + $count)
  );
}


//-----------------------------------------------------------
// Contact Form 7
//-----------------------------------------------------------
/**
 * メール確認用が一致してない場合
 */
add_filter('wpcf7_validate_email', 'wpcf7_validate_email_filter_confrim', 11, 2);
add_filter('wpcf7_validate_email*', 'wpcf7_validate_email_filter_confrim', 11, 2);
function wpcf7_validate_email_filter_confrim($result, $tag)
{
  $type = $tag['type'];
  $name = $tag['name'];
  if ('email' == $type || 'email*' == $type) {
    if (preg_match('/(.*)-confirm$/', $name, $matches)) {
      $target_name = $matches[1];
      $posted_value = trim((string) $_POST[$name]);
      $posted_target_value = trim((string) $_POST[$target_name]);
      if ($posted_value != $posted_target_value) {
        $result->invalidate($tag, "確認用のメールアドレスが一致していません");
      }
    }
  }
  return $result;
}

/** 
 * ContactForm7で自動挿入されるPタグ、brタグを削除
 */
add_filter('wpcf7_autop_or_not', 'wpcf7_autop_return_false');
function wpcf7_autop_return_false()
{
  return false;
}

/**
 * 送信ボタンをクリックした後の遷移先設定 
 */
add_action('wp_footer', 'add_origin_thanks_page');
function add_origin_thanks_page()
{
  $thanks = home_url('/thanks/');
  echo <<< EOC
     <script>
       var thanksPage = {
         144: '{$thanks}',
         147: '{$thanks}',
       };
     document.addEventListener( 'wpcf7mailsent', function( event ) {
       location = thanksPage[event.detail.contactFormId];
     }, false );
     </script>
   EOC;
}

/**
 * フォームにGETパラメータを初期設定 
 */
function my_form_tag_filter($tag)
{
  if (!is_array($tag)) {
    return $tag;
  }

  if (isset($_GET['item_id'])) {
    $name = $tag['name'];
    $item_id = $_GET['item_id'];
    $item_name = get_the_title($item_id);
    $item_code = get_field('code', $item_id);
    if ($name == 'item-name') {
      $tag['values'] = (array) $item_name;
    }
    if ($name == 'item-code') {
      $tag['values'] = (array) $item_code;
    }
  }

  return $tag;
}
add_filter('wpcf7_form_tag', 'my_form_tag_filter', 11);


/** 
 * GETパラメータ取得設定
 */
function set_org_query_vars($query_vars)
{
  $query_vars[] = 'item_id';
  return $query_vars;
}
add_filter('query_vars', 'set_org_query_vars');



//------------------------------------------------
// 商品検索
//------------------------------------------------
function my_refine_search($query)
{
  if (is_admin() || !$query->is_main_query()) {
    return;
  }

  if ($query->is_search()) {

    $s = $_GET['s'];
    $post_type = $_GET['post_type'];

    if (isset($_GET['cat'])) {
      $category = $_GET['cat'];
    }
    if (isset($_GET['scene'])) {
      $scene = $_GET['scene'];
    }
    if (isset($_GET['colors'])) {
      $colors = $_GET['colors'];
    }

    $tax_query = array(
      'relation' => 'AND'
    );

    // カテゴリー
    if (!empty($category)) {
      array_push($tax_query, array(
        'taxonomy'  => 'category',
        'terms'     => $category,
        'field'     => 'slug',
      ));
    }

    // シーン
    if (!empty($scene)) {
      array_push($tax_query, array(
        'taxonomy'  => 'scene',
        'terms'     => $scene,
        'field'     => 'slug',
      ));
    }

    // カラー
    if (!empty($colors)) {
      array_push($tax_query, array(
        'taxonomy'  => 'color',
        'terms'     => $colors,
        'field'     => 'slug',
      ));
    }

    if (!empty($post_type)) {
      $query->set('post_type', $post_type);
    }
    $query->set('post_status', 'publish');
    $query->set('posts_per_page', 8);

    $query->set('s', $s);
    if (!empty($tax_query)) {
      $query->set('tax_query', $tax_query);
    }
  }
}
add_action('pre_get_posts', 'my_refine_search');


/**
 * AND 検索から OR に変更
 */
function custom_or_search($search)
{
  return str_replace(')) AND ((', ')) OR ((', $search);
}
add_filter('posts_search', 'custom_or_search');


// ------------------------------------------------
// セール中の判定
// ------------------------------------------------
function is_sale($post_id)
{
  if (get_field("sale-flag", $post_id)) {
    $today = date('Y-m-d');
    $sale_start_date = date('Y-m-d', strtotime(get_field("sale", $post_id)['sale-start']));
    $sale_end_date = date('Y-m-d', strtotime(get_field("sale", $post_id)['sale-end']));

    $aaa = array(
      'today' => $today,
      'start' => $sale_start_date,
      'end' => $sale_end_date,
    );

    if ($today >= $sale_start_date) {
      if ($today <= $sale_end_date) {
        return true;
      }
    }
  }
  return false;
}


//------------------------------------------------
// お知らせ一覧のもっと読み込む
//------------------------------------------------
function my_ajax()
{
  global $post;

  $args = array(
    'posts_per_page' => $_POST["get_post_num"],
    'offset' => $_POST["now_post_num"],
    'post_type' => $_POST["post_type"],
    'orderby' => 'date',
    'order' => 'DESC',
    'tax_query' => array(
      array(
        'taxonomy' => 'news_tax',
        'field'    => 'term_id',
        'terms'    => explode(',', $_POST["term"]),
      ),
    ),
  );

  $my_posts = get_posts($args);
  foreach ($my_posts as $post) : setup_postdata($post);
    $term = get_the_terms($post->ID, 'news_tax');
    $term_name = "その他";
    if ($term) {
      $term_name = $term[0]->name;
    }
    echo '<li class="p-news__item">';
    echo '<a href="' . get_the_permalink() . '" class="p-news__link">';
    echo '<time class="p-news__datetime" datetime="' . get_the_time('Y.m.d') . '">' . get_the_time('Y.m.d') . '</time>';
    echo '<span class="p-news__tag">' . $term_name . '</span>';
    echo '<h3 class="p-news__title">' . get_the_title() . '</h3>';
    echo '</a>';
    echo '</li>';
  endforeach;
  wp_reset_postdata();
  wp_die();
}
add_action('wp_ajax_my_ajax_action', 'my_ajax');
add_action('wp_ajax_nopriv_my_ajax_action', 'my_ajax');


//------------------------------------------------
// タクソノミー未選択時に特定のタームを選択させる
//------------------------------------------------
function add_defaultcategory_automatically($post_ID)
{
  global $wpdb;
  $curTerm = wp_get_object_terms($post_ID, 'news_tax');
  if (0 == count($curTerm)) {
    // 未選択時は「その他」に設定
    $defaultTerm = array(22);
    wp_set_object_terms($post_ID, $defaultTerm, 'news_tax');
  }
}
add_action('publish_news', 'add_defaultcategory_automatically');


//------------------------------------------------
// 「閲覧履歴」ページの設定
//------------------------------------------------

/**
 * 閲覧履歴用のキャッシュ設定
 */
add_action('get_header', 'readpost');

function readpost()
{
  global $browsing_histories;
  $browsing_histories = null;
  $postread = null;
  $set_this_ID = null;

  if (is_single()) {
    if (isset($_COOKIE['postid_history'])) {
      //cookieの値を呼び出し
      $browsing_histories = explode(",", $_COOKIE['postid_history']);
      if ($browsing_histories[0] != get_the_ID()) {
        if (count($browsing_histories) >= 50) {
          $set_browsing_histories = array_slice($browsing_histories, 0, 49);
        } else {
          $set_browsing_histories = $browsing_histories;
        }
        //値の先頭が現在の記事IDでなければ文字列の一番最初に追加
        $set_this_ID = get_the_ID() . ',' . implode(",", $set_browsing_histories);
        setcookie('postid_history', $set_this_ID, time() + 60 * 60 * 24 * 365 * 1, '/');
      }
    } else {
      //cookieがなければ、現在の記事IDを保存
      $set_this_ID = get_the_ID();
      setcookie('postid_history', $set_this_ID, time() + 60 * 60 * 24 * 365 * 1, '/');
    }
    //詳細ページ以外なら呼び出しのみ
  } else {
    if (isset($_COOKIE['postid_history'])) {
      $browsing_histories = explode(",", $_COOKIE['postid_history']);
    }
  }
  if (isset($_COOKIE['postid_history'])) {
    $postread = explode(",", $_COOKIE['postid_history']);
    $postread = array_unique($postread);
    $postread = array_values($postread);
  }


  return $postread;
}

/**
 * 閲覧履歴の呼び出し
 */
function readpost_typecheack($postnum)
{
  $postdate = readpost();
  $numlist = 0;

  if (!empty($postdate)) {
    foreach ($postdate as $key => $val) {
      $posttype = get_post_type($val);
      if ($posttype === "post") {
        if ($postnum == $numlist) {
          break;
        }
        $args = [
          'post_id' => $val
        ];

        get_template_part('parts/item-card', null, $args);

        $numlist++;
      }
    }
  }
}
