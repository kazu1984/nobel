<?php get_header(); ?>

<?php get_template_part('parts/breadcrumb') ?>

<div class="l-sub-page l-inner">

  <?php
  $term = get_queried_object();
  $args = [
    'page_id' => $term->term_id,
    'title_name' => $term->name,
    'img_field_name' => 'scene_image'
  ];
  ?>
  
  <h2 class="l-sub-page__title c-page-title"><?php echo $args['title_name']; ?></h2>

  <div class="l-sub-page__main">
    <?php get_template_part('parts/cat-scene', null, $args); ?>
  </div>

  <div class="l-sub-page__aside">
    <?php get_template_part('parts/scene-loop'); ?>
  </div>
</div>

<?php get_footer(); ?>