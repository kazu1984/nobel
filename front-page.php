<?php get_header(); ?>

<div class="l-mv p-mv">
  <div class="js-mv__swiper p-mv__swiper swiper">
    <ul class="swiper-wrapper">
      <li class="swiper-slide">
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/top/mv1.jpg" alt="">
      </li>
      <li class="swiper-slide">
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/top/mv2.jpg" alt="">
      </li>
      <li class="swiper-slide">
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/top/mv3.jpg" alt="">
      </li>
    </ul>
    <div class="swiper-pagination"></div>
  </div>
  <div class="p-mv__copy">
    <p class="p-mv__copy-main">テキストテキスト</p>
    <p class="p-mv__copy-sub">テキストが入ります。テキストが入ります。<br>テキストが入ります。テキストが入ります。</p>
  </div>
</div>

<div class="l-inner">

  <section class="l-top-new p-top-new">
    <h2 class="c-section-title">新着商品</h2>
    <?php if (have_posts()) : ?>
      <div class="p-top-new__cards p-cards">
        <?php while (have_posts()) : the_post(); ?>
          <?php get_template_part('parts/item-card'); ?>
        <?php endwhile; ?>
      <?php endif; ?>
      </div>
  </section>

  <section class="l-top-scene p-top-scene">
    <h2 class="c-section-title">シーンで探す</h2>
    <div class="p-top-scene__cards">
      <?php get_template_part('parts/scene-loop'); ?>
    </div>
  </section>

  <section class="l-top-category p-top-category">
    <h2 class="c-section-title">カテゴリーから探す</h2>
    <div class="p-top-category__cards">
      <?php get_template_part('parts/category-loop'); ?>
    </div>
  </section>

  <section class="l-top-sale p-top-sale">
    <h2 class="c-section-title">お買い得商品</h2>
    <?php
    $args = array(
      'post_type' => 'post',
      'orderby' => 'rand',
      'posts_per_page' => 4,
      'meta_query' => array(
        'relation' => 'AND',
        array(
          'key' => 'sale-flag',
          'value' => true,
          'compare' => '=',
        ),
        array(
          'key' => 'sale_sale-start',
          'value' => date('Y-m-d', time()),
          'compare' => '<=',
          'type' => 'DATE',
        ),
        array(
          'key' => 'sale_sale-end',
          'value' => date('Y-m-d', time()),
          'compare' => '>=',
          'type' => 'DATE',
        ),
      ),
    );

    $the_query = new WP_Query($args);
    ?>
    <?php if ($the_query->have_posts()) : ?>
      <div class="p-top-sale__cards p-cards p-cards--large">
        <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
          <?php get_template_part('parts/item-card'); ?>
        <?php endwhile; ?>
      </div>
    <?php else : ?>
      <p class="p-top-sale__message">現在セール中の商品はありません</p>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
  </section>
</div>

<?php get_footer(); ?>