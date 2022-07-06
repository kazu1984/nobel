<form class="p-search-form" method="get" action="<?php echo esc_url(home_url()); ?>">
  <input type="hidden" name="s">
  <input type="hidden" name="post_type" value="post">

  <div class="p-search-form__item">
    <p class="p-search-form__label">商品名</p>
    <?php
    if (!empty($_GET['s'])) {
      $s_word = htmlspecialchars($_GET['s'], ENT_QUOTES, 'UTF-8');
    } else {
      $s_word = "";
    }
    ?>
    <input type="text" name="s" class="c-form__text c-form__text--search" value="<?php echo $s_word ?>" placeholder="商品名を入力してください">
  </div>
  <div class="p-search-form__item">
    <p class="p-search-form__label">カテゴリー</p>
    <div class="c-form__select">
      <select class="c-form__select-body" name="cat">
        <optgroup label="カテゴリー">
          <?php
          $categories = get_categories();
          ?>
          <option value="" <?= get_query_var('cat') === '' ? ' selected' : '' ?>>すべて</option>
          <?php foreach ($categories as $category) { ?>
            <option value="<?php echo esc_attr($category->slug) ?>" <?= get_query_var('cat') === $category->term_id ? ' selected' : '' ?>><?php echo $category->name ?></option>
          <?php } ?>
        </optgroup>
      </select>
    </div>
  </div>
  <div class="p-search-form__item">
    <p class="p-search-form__label">シーン</p>
    <div class="c-form__select">
      <select class="c-form__select-body" name="scene">
        <optgroup label="シーン">
          <?php
          $args1 = array(
            'taxonomy' => 'scene'
          );
          $scenes = get_categories($args1);
          ?>
          <option value="" <?= get_query_var('scene') === '' ? ' selected' : '' ?>>すべて</option>;
          <?php foreach ($scenes as $scene) { ?>
            <option value="<?php echo esc_attr($scene->slug) ?>" <?= get_query_var('scene') === $scene->slug ? ' selected' : '' ?>><?php echo $scene->name ?></option>
          <?php } ?>
        </optgroup>
      </select>
    </div>
  </div>
  <div class="p-search-form__item">
    <p class="p-search-form__label">カラー</p>
    <ul class="p-search-form__colors">
      <?php
      $args2 = array(
        'hide_empty' => false,
      );
      $terms = get_terms('color', $args);
      if (!empty($_GET['colors'])) {
        foreach ($_GET['colors'] as $value) {
          $selected_color[] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
      }
      ?>
      <?php foreach ($terms as $term) { ?>
        <?php
        $checked = '';
        if (!empty($selected_color)) {
          if (in_array($term->slug, $selected_color, true)) {
            $checked = ' checked';
          };
        }
        ?>
        <li class="p-search-form__color">
          <label>
            <input class="c-form__checkbox" type="checkbox" name="colors[]" value="<?php echo esc_attr($term->slug) ?>" <?php echo esc_attr($checked); ?>><span>&nbsp;</span>
          </label>
          <span class="c-box c-box--<?php echo $term->slug ?>"></span>
        </li>
      <?php } ?>
    </ul>
  </div>
  <div class="p-search-form__button">
    <input type="submit" value="検索する" class="c-button"></input>
  </div>
</form>