<?php get_header(); ?>

<?php get_template_part('parts/breadcrumb') ?>

<div class="l-sub-page l-inner">
  <h2 class="l-sub-page__title c-page-title">商品検索</h2>
  <div class="l-sub-page__main">
    <div class="p-item-search">
      <div class="p-item-search__form">
        <?php echo get_search_form(); ?>
      </div>
      <div class="p-item-search__item-list p-item-list">
        <?php if (have_posts()) : ?>
          <div class="p-item-list__count">
            <?php my_result_count(); ?>
          </div>
          <div class="p-item-list__cards p-cards p-cards--large">
            <?php while (have_posts()) : the_post(); ?>
              <?php get_template_part('parts/item-card'); ?>
            <?php endwhile; ?>
          </div>
        <?php else : ?>
          <p class="p-item-list__message">該当する商品がありませんでした。</p>
        <?php endif; ?>
      </div>
    </div>
    <div class="l-pagination">
      <?php the_posts_pagination(
        array(
          'mid_size'      => 1,
          'prev_next'     => true,
          'prev_text'     => __('前へ'),
          'next_text'     => __('次へ'),
          'type'          => 'list',
        )
      ); ?>
    </div>
  </div>
</div>

<?php get_footer(); ?>
