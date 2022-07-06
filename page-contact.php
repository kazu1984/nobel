<?php get_header(); ?>

<?php get_template_part('parts/breadcrumb') ?>

<?php
if (get_query_var('item_id')) {
  $item_id = get_query_var('item_id');
  $img_url = get_the_post_thumbnail_url($item_id);
}
?>

<div class="l-sub-page l-inner">
  
  <h2 class="l-sub-page__title c-page-title">お問い合わせ入力</h2>

  <div class="l-sub-page__main">
    <div class="p-contact">
      <p class="p-contact__text">下記フォームに必要事項をご記入の上、お問い合わせをお願いいたします。</p>

      <div class="p-contact__form p-form">
        <?php if (get_query_var('item_id')) {
          echo do_shortcode('[contact-form-7 id="147" title="お問い合わせ（商品）"]');
        } else {
          echo do_shortcode('[contact-form-7 id="144" title="お問い合わせ"]');
        }
        ?>
      </div>
    </div>
  </div>
</div>

<?php if (get_query_var('item_id')) { ?>
  <script type="text/javascript">
    var url = '<?php echo $img_url; ?>';
    const item_img = document.querySelector('.js-form__item-img');
    item_img.style.backgroundImage = 'url(' + url + ')';
  </script>
<?php } ?>

<?php get_footer(); ?>