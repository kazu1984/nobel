<?php get_header(); ?>

<?php get_template_part('parts/breadcrumb') ?>

<div class="l-sub-page l-inner">
  <h2 class="l-sub-page__title c-page-title">お知らせ</h2>
  <div class="l-sub-page__main">
    <div class="p-news">
      <ul class="p-news__categories">
        <li class="p-news__category">
          <a href="<?php echo esc_url(get_post_type_archive_link('news')); ?>" class="c-button c-button--grey is-active">すべて</a>
        </li>

        <?php
        $terms = get_terms('news_tax');
        usort($terms, function ($a, $b) {
          return get_field("order", "news_tax_" . $a->term_id)
            - get_field("order", "news_tax_" . $b->term_id);
        });
        ?>

        <?php $term_arr = ""; ?>
        <?php foreach ($terms as $term) { ?>
          <li class="p-news__category">
            <a href="<?php echo get_term_link($term->slug, 'news_tax') ?>" class="c-button c-button--grey"><?php echo $term->name ?></a>
          </li>
          <?php $term_arr = $term_arr . $term->term_id . ","; ?>
        <?php } ?>
        <?php
        $term_arr = mb_substr($term_arr, 0, -1, "UTF-8");
        ?>
      </ul>

      <?php if (have_posts()) : ?>
        <?php global $wp_query;
        $count = $wp_query->found_posts; ?>
        <ul class="p-news__list js-load" data-count="<?php echo $count; ?>" data-post-type="news" data-term="<?php echo $term_arr ?>">
          <?php while (have_posts()) : the_post(); ?>
            <li class="p-news__item">
              <a href="<?php the_permalink(); ?>" class="p-news__link">
                <time class="p-news__datetime" datetime="<?php the_time('Y.m.d'); ?>"><?php the_time('Y.m.d'); ?></time>
                <?php
                $term = get_the_terms($post->ID, 'news_tax');
                $term_name = $term[0]->name;
                ?>
                <span class="p-news__tag"><?php echo $term_name ?></span>
                <h3 class="p-news__title"><?php the_title(); ?></h3>
              </a>
            </li>
          <?php endwhile; ?>
        </ul>
        <?php if ($count > 5) : ?>
          <p class="p-news__more js-news__more">もっと読み込む</p>
          <div class="c-loading is-hide">
          </div>
        <?php endif; ?>
      <?php else : ?>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php get_footer(); ?>