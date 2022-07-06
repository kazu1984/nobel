<?php get_header(); ?>

<?php get_template_part('parts/breadcrumb') ?>

<div class="l-sub-page l-inner">
  <h2 class="l-sub-page__title c-page-title">商品検索</h2>
  <div class="l-sub-page__main">
    <div class="p-item-search">
      <div class="p-item-search__form">
        <?php echo get_search_form(); ?>
      </div>
    </div>
  </div>
</div>


<?php get_footer(); ?>