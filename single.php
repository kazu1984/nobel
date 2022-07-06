<?php get_header(); ?>

<?php get_template_part('parts/breadcrumb') ?>

<?php $post_id = $post->ID; ?>

<div class="l-sub-page l-inner">
  <h2 class="l-sub-page__title c-page-title"><?php echo get_post_title(get_the_title()); ?></h2>

  <div class="l-sub-page__main">
    <div class="p-item">
      <div class="p-item__images">
        <!-- メイン画像 -->
        <div class="js-item__swiper p-item__swiper swiper">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <img src="<?php echo get_eyecatch_with_default($post_id)[0] ?>" alt="" />
            </div>
            <?php for ($i = 1; $i <= 3; $i++) { ?>
              <div class="swiper-slide">
                <img src="<?php the_field('image' . $i); ?>" alt="" />
              </div>
            <?php } ?>
          </div>
        </div>
        <!-- サムネイル -->
        <div class="swiper js-item__swiper-thumbnail p-item__swiper-thumbnail">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <img src="<?php echo get_eyecatch_with_default($post_id)[0] ?>" alt="" />
            </div>
            <?php for ($i = 1; $i <= 3; $i++) { ?>
              <div class="swiper-slide">
                <?php if (get_field('image' . $i)) { ?>
                  <img src="<?php the_field('image' . $i); ?>" alt="" />
                <?php } ?>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <div class="p-item__detail">
        <p class="p-item__description"><?php the_field('description'); ?></p>
        <div class="p-item__price-list">
          <div class="p-item__sale-info">
            <?php if (is_sale($post_id)) { ?>
              <span class="p-item__sale-tag">値下中</span>
              <p class="p-item__sale-date"><?php echo get_field('sale')['sale-end']; ?>まで</p>
            <?php } ?>
          </div>
          <div class="p-item__price">
            <?php
            if (is_sale($post_id)) {
              $price = get_field('sale')['sale-price'];
            } else {
              $price = get_field('price');
            }
            ?>
            <p class="p-item__price-value"><?php echo number_format($price) ?><span>円</span></p>
            <p class="p-item__price-include">税込み</p>
          </div>
        </div>
        <dl class="p-item__spec">
          <dt class="p-item__spec-title">商品コード</dt>
          <dd class="p-item__spec-text"><?php the_field('code'); ?></dd>
          <dt class="p-item__spec-title">サイズ</dt>
          <?php
          $size = get_field('size');
          $height = $size['height'];
          $width = $size['width'];
          $depth = $size['depth'];
          ?>
          <dd class="p-item__spec-text">高さ <?php echo $height ?>cm ✕ 幅 <?php echo $width ?>cm ✕ 奥行き <?php echo $depth ?>cm</dd>
          <dt class="p-item__spec-title">重量</dt>
          <dd class="p-item__spec-text"><?php the_field('weight'); ?><span>kg</span></dd>
          <dt class="p-item__spec-title">カラー</dt>
          <?php
          $terms = get_the_terms($post->ID, 'color');
          $colors = "";
          $i = 0;
          foreach ($terms as $term) {
            if ($i == 0) {
              $colors = $colors . $term->name;
            } else {
              $colors = $colors . "&nbsp;&nbsp;" . $term->name;
            }
            $i++;
          }
          ?>
          <dd class="p-item__spec-text"><?php echo $colors; ?></dd>
        </dl>
        <div class="p-item__contact">
          <a href="<?php echo home_url() . '/contact/?item_id=' . esc_attr(get_the_ID()); ?>" class="c-button c-button--icon c-button--contact-item">商品についてお問い合わせ</a>
        </div>
      </div>
    </div>
  </div>

  <div class="l-sub-page__aside">
    <div class="p-related-item">
      <h2 class="c-section-title">関連商品</h2>
      <?php
      $categories = get_the_category($post_id);
      $cat_id = $categories[0]->cat_ID;
      $cat_name = $categories[0]->name;
      $args = array(
        'post_type' => 'post',
        'post__not_in' => array($post_id),
        'posts_per_page' => 4,
        'orderby' => 'rand',
        'category__in' => $cat_id,
      );
      $wp_query = new WP_Query($args);
      ?>
      <?php if ($wp_query->have_posts()) : ?>
        <div class="p-related-item__cards p-cards p-cards--large">
          <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
            <?php get_template_part('parts/item-card'); ?>
          <?php endwhile; ?>
        </div>
      <?php else : ?>
        <p class="p-related-item__message">関連商品はありません</p>
      <?php endif; ?>
      <?php wp_reset_postdata(); ?>
      <div class="p-related-item__more">
        <a href="<?php echo get_category_link($cat_id); ?>" class="c-more-text">もっと「<?php echo $cat_name ?>」の商品を見る</a>
      </div>
    </div>
  </div>

  <div class="l-sub-page__aside">
    <div class="p-recommend-item">
      <h2 class="c-section-title">こちらもおすすめ</h2>
      <?php
      $args = array(
        'post_type' => 'post',
        'post__not_in' => array($post_id),
        'posts_per_page' => 4,
        'orderby' => 'rand',
        'meta_key' => 'recommend',
        'meta_value' => true,
        'meta_compare' => '=',
      );
      $the_query = new WP_Query($args);
      ?>
      <?php if ($the_query->have_posts()) : ?>
        <div class="p-recommend-item__cards p-cards p-cards--large">
          <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
            <?php get_template_part('parts/item-card'); ?>
          <?php endwhile; ?>
        </div>
      <?php else : ?>
        <p class="p-recommend-item__message">おすすめ商品はありません</p>
      <?php endif; ?>
      <?php wp_reset_postdata(); ?>
    </div>
  </div>
</div>

<?php get_footer(); ?>