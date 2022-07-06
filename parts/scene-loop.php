<?php
$args = array(
  'taxonomy' => 'scene'
);
$categories = get_categories($args);
?>

<div class="p-scene-swiper">
  <div class="p-scene-swiper__inner js-scene-swiper swiper">
    <ul class="swiper-wrapper">
      <?php foreach ($categories as $category) { ?>
        <li class="swiper-slide">
          <a href="<?php echo get_category_link($category->term_id) ?>" class="p-scene-card">
            <figure class="p-scene-card__img">
              <?php
              $img = get_field('scene_image', 'category' . '_' . $category->term_id);
              ?>
              <img src="<?php echo $img ?>" alt="">
            </figure>
            <div class="p-scene-card__body">
              <h3 class="p-scene-card__name"><?php echo $category->name; ?></h3>
              <p class="p-scene-card__text"><?php echo $category->description; ?></p>
            </div>
            <div class="p-scene-card__footer">
              <div class="p-scene-card__button">
                <span class="c-right-arrow-button"></span>
              </div>
            </div>
          </a>
        </li>
      <?php } ?>      
    </ul>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
  </div>
</div>