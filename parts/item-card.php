<?php
if (!empty($args)) {
  $post_id = $args['post_id'];
} else {
  $post_id = $post->ID;
}
?>
<a href="<?php the_permalink($post_id); ?>" class="p-card">
  <div class="p-card__head">
    <figure class="p-card__img">
      <img src="<?php echo get_eyecatch_with_default($post_id)[0] ?>" alt="">
    </figure>
    <?php if (is_sale($post_id)) { ?>
      <span class="p-card__sale-label"></span>
    <?php } ?>
  </div>
  <div class="p-card__body">
    <h3 class="p-card__title"><?php echo get_post_title(get_the_title($post_id)); ?></h3>
  </div>
  <div class="p-card__footer">
    <?php if (is_sale($post_id)) { ?>
      <p class="p-card__price p-card__price--sale">
        <span>値下中&nbsp;</span>
      <?php } else { ?>
      <p class="p-card__price">
      <?php } ?>
      <span class="p-card__num">
        <?php
        if (is_sale($post_id)) {
          echo number_format(get_field('sale', $post_id)['sale-price']);
        } else {
          echo number_format(get_field('price', $post_id));
        }
        ?></span>円<span class="u-text-inline-block">（税込）</span>
      </p>
  </div>
</a>