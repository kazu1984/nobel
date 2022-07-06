<div class="p-category">
  <div class="p-category__description">
    <div class="p-category__text">
      <?php echo category_description(); ?>
    </div>
    <figure class="p-category__img">
      <?php
      $img = get_field($args['img_field_name'], 'scene' . '_' . $args['page_id']);
      ?>
      <img src="<?php echo $img; ?>" alt="">
    </figure>
  </div>
  <div class="p-category__item-list p-item-list">
    <?php if (have_posts()) : ?>
      <div class="p-item-list__count">
        <?php my_result_count(); ?>
      </div>
      <div class="p-item-list__cards p-cards p-cards--large">
        <?php while (have_posts()) : the_post(); ?>
          <?php get_template_part('parts/item-card'); ?>
        <?php endwhile; ?>
      </div>
    <?php endif; ?>
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