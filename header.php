<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name=“robots” content=“noindex”>
  <meta name="format-detection" content="telephone=no">

  <title><?php bloginfo('name'); ?></title>
  <meta name="description" content="<?php bloginfo('description') ?>">
  <link rel="shortcut icon" href="<?php echo esc_url(get_template_directory_uri()) . '/assets/images/common/icon.png' ?>">
</head>


<?php wp_head(); ?>
</head>


<body <?php body_class(); ?>>
  <div class="l-container">
    <header class="l-header p-header">
      <div class="p-header__inner">
        <h1 class="p-header__logo">
          <a href="<?php echo esc_url(home_url('')) ?>">NOBEL.</a>
        </h1>
        <div class="p-header__menu">

          <form role="search" method="get" class="p-header__search c-search-box" action="<?php echo esc_url(home_url('/')); ?>">
            <div class="c-search-box__inner">
              <input type="hidden" name="post_type" value="post">
              <label class="screen-reader-text" for="s"><?php _x('Search for:', 'label'); ?></label>
              <input type="text" class="c-search-box__text c-form__text c-form__text--search-box" value="<?php echo get_search_query(); ?>" placeholder="商品名で検索" name="s"/>
              <i class="c-search-box__icon fas fa-search"></i>
            </div>
          </form>

          <nav class="p-header__nav">
            <ul class="p-header__items">
              <li class="p-header__item">
                <a href="<?php echo esc_url(home_url('item-search')) ?>" class="c-menu-link">商品検索</a>
              </li>
              <li class="p-header__item">
                <a href="<?php echo esc_url(home_url('history')) ?>" class="c-menu-link">閲覧履歴</a>
              </li>
              <li class="p-header__item">
                <a href="<?php echo esc_url(home_url('news')) ?>" class="c-menu-link">お知らせ</a>
              </li>
            </ul>
          </nav>
          <div class="p-header__button">
            <a href="<?php echo esc_url(home_url('contact')) ?>" class="c-button c-button--icon c-button--contact">お問い合わせ</a>
          </div>
        </div>
        <button type="button" class="p-header__hamburger c-hamburger js-hamburger" aria-controls="p-drawer" aria-expanded="false">
          <span class="c-hamburger__line">
            <span class="u-visually-hidden">
              メニューを開閉する
            </span>
          </span>
        </button>
      </div>
      <div class="p-header__drawer p-drawer js-drawer" aria-hidden="true" data-click="false">
        <ul class="p-drawer__items">
          <li class="p-drawer__item">
            <a href="<?php echo esc_url(home_url('item-search')) ?>" class="p-drawer__link">商品検索</a>
          </li>
          <li class="p-drawer__item">
            <a href="<?php echo esc_url(home_url('history')) ?>" class="p-drawer__link">閲覧履歴</a>
          </li>
          <li class="p-drawer__item">
            <a href="<?php echo esc_url(home_url('news')) ?>" class="p-drawer__link">お知らせ</a>
          </li>
          <li class="p-drawer__item">
            <a href="<?php echo esc_url(home_url('contact')) ?>" class="c-button c-button--icon c-button--contact">お問い合わせ</a>
          </li>
        </ul>
      </div>
    </header>
    <main>