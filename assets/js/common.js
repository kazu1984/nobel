jQuery(function ($) {
  /**
   * トップページ mv
   */
  if ($(".js-mv__swiper").length) {
    const swiper = new Swiper(".js-mv__swiper", {
      loop: true,
      effect: "fade",
      speed: 3000,
      autoplay: {
        delay: 5000,
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
    });
  }

  /**
   * 商品ページ
   */
  if ($(".js-item__swiper").length) {
    const sliderThumbnail = new Swiper(".js-item__swiper-thumbnail", {
      slidesPerView: 4,
    });

    const item_slider = new Swiper(".js-item__swiper", {
      loop: true,
      effect: "fade",
      thumbs: {
        swiper: sliderThumbnail,
      },
    });
  }

  /**
   * シーンのカード
   */
  if ($(".js-scene-swiper").length) {
    const scene_seiper = new Swiper(".js-scene-swiper", {
      loop: true,
      slidesPerView: 1,
      speed: 1000,
      spaceBetween: 16,
      breakpoints: {
        600: {
          slidesPerView: 2,
        },
        768: {
          slidesPerView: 3,
        },
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },

      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
    });
  }

  /**
   * ハンバーガーメニュー クリック時
   */
  $(".js-hamburger").click(function () {
    $("body").toggleClass("fixed");

    if ($(this).attr("aria-expanded") == "false") {
      $(this).attr("aria-expanded", true);
      $(".js-drawer").attr("aria-hidden", false);
      $(".js-drawer").attr("data-click", true);
    } else {
      $(this).attr("aria-expanded", false);
      $(".js-drawer").attr("aria-hidden", true);
      $(".js-drawer").attr("data-click", false);
    }
  });

  /**
   * スムーススクロール
   */
  $(document).on("click", 'a[href*="#"]', function () {
    let time = 400;
    let header = $("header").innerHeight();
    let target = $(this.hash);
    if (!target.length) return;
    let targetY = target.offset().top - header;
    $("html,body").animate({ scrollTop: targetY }, time, "swing");
    return false;
  });

  /**
   * お知らせ一覧のもっと読み込む
   */
  let now_post_num = 5;
  let get_post_num = 2;

  let load = $(".js-load");
  let post_type = load.data("post-type");
  let all_count = load.data("count");
  let term = load.data("term");

  //admin_ajaxにadmin-ajax.phpの絶対パス指定
  let host_url = location.protocol + "//" + location.host;
  let admin_ajax = host_url + "/wp-admin/admin-ajax.php";

  $(document).on("click", ".js-news__more", function () {
    //読み込み中はボタン非表示
    $(".js-news__more").remove();
    var $loading = $(".c-loading");

    //ajax処理
    $.ajax({
      type: "POST",
      url: admin_ajax,
      beforeSend: function () {
        $loading.removeClass("is-hide");
      },
      data: {
        action: "my_ajax_action",
        now_post_num: now_post_num,
        get_post_num: get_post_num,
        post_type: post_type,
        term: term,
      },
    })

      .done(function (data) {
        $loading.addClass("is-hide");
        load.append(data);
        now_post_num = now_post_num + get_post_num;

        if (all_count > now_post_num) {
          load.after(
            '<p class="p-news__more js-news__more">もっと読み込む</p>'
          );
        }
      })
      .fail(function () {
        alert("エラーが発生しました");
      });
  });
});
