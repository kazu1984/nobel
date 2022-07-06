<?php get_header(); ?>

<?php get_template_part('parts/breadcrumb') ?>

<div class="l-sub-page l-inner">

  <h2 class="l-sub-page__title c-page-title">最近チェックした商品</h2>

  <div class="l-sub-page__main">
    <div class="p-history">
      <div class="p-history__cards p-cards p-cards--large">
        <?php readpost_typecheack(4); ?>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>