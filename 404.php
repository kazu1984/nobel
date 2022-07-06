<?php get_header(); ?>

<div class="l-sub-page l-sub-page--404 l-inner">
  <h2 class="l-sub-page__title c-page-title">指定したURLのページは存在しません。</h2>

  <div class="l-sub-page__main">
    <a href="<?php echo esc_url(home_url('')) ?>">TOPへ戻る</a>
  </div>

</div>

<?php get_footer(); ?>