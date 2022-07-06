<?php get_header(); ?>

<?php get_template_part('parts/breadcrumb') ?>

<div class="l-sub-page l-inner">

  <?php
  $page_id = get_query_var('cat');
  $name = get_category($page_id)->name;
  $args = [
    'page_id' => $page_id,
    'title_name' => $name,
    'img_field_name' => 'image'
  ];
  ?>

  <h2 class="l-sub-page__title c-page-title"><?php echo $args['title_name']; ?></h2>

  <div class="l-sub-page__main">
    <?php get_template_part('parts/cat-scene', null, $args); ?>
  </div>

  <div class="l-sub-page__aside">
    <?php get_template_part('parts/category-loop'); ?>
  </div>
</div>

<?php get_footer(); ?>