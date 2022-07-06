<?php
$args = array(
  'parent' => 0,
  'orderby' => 'term_order',
  'order' => 'ASC'
);
$categories = get_categories($args);
?>
<div class="p-category-cards p-cards p-cards--category">
  <?php foreach ($categories as $category) : ?>
    <a href="<?php echo get_category_link($category->term_id); ?>" class="p-category-card">
      <figure class="p-category-card__img">
        <?php
        $img = get_field('image', 'category' . '_' . $category->term_id);
        ?>
        <img src="<?php echo $img ?>" alt="">
      </figure>
      <div class="p-category-card__body">
        <h3 class="p-category-card__name"><?php echo $category->name; ?></h3>
      </div>
    </a>
  <?php endforeach; ?>
</div>