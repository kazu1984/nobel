<?php get_header(); ?>

<?php get_template_part('parts/breadcrumb') ?>

<?php $post_id = $post->ID; ?>

<div class="l-sub-page l-inner">
  <h2 class="l-sub-page__title c-page-title"><?php echo get_post_title(get_the_title()); ?></h2>

  <div class="l-sub-page__main">
    <div class="p-news-post">
      <div class="p-news-post__text c-post"><?php the_content(); ?></div>
      <a href="<?php echo esc_url(home_url('news')) ?>" class="p-news-post__back">お知らせ一覧へ戻る</a>
    </div>
  </div>

</div>

<?php get_footer(); ?>