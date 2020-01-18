<?php
/*
Template Name: BLOGBLOG　〜最新ブログ一覧〜
*/
?>
<!-- head -->
<?php get_header();?>
<!-- //head -->

  <!-- header始まり -->
  <?php get_template_part('content', 'menu');?>
  <!-- header終わり -->

    <!-- blog終わり -->
    <div class="p-pageTitle__wrapper">
      <div class="p-pageTitle__container">
        <h1 class="p-pageTitle c-heading--edge">BLOG<span class="p-pageTitle-sub">ぱるこのブログ</span></h1>
      </div>
    </div>

    <div class="l-section">
      <div class="l-wrapper">
        
        <!-- main始まり -->
        <main class="l-main">
          <div class="p-blogs">

        <?php

        // ページネーションに現在のページ位置を知らせるのに必要
        $paged = (int) get_query_var('paged');

        $args = array(
          // get_option('posts_per_page') ← で管理画面で設定した、記事一覧で表示するページ数を取得
          'posts_per_page' => get_option('posts_per_page'),
          // (int) get_query_var('paged') ← で取得した、$pagedを挿入
          'paged' => $paged,
          'orderby' => 'post_date',
          'order' => 'DESC',
          'post_type' => 'post',
          'post_status' => 'publish'
        );

        // 記事一覧のMaxページ数を取得するのに必要
        $the_query = new WP_Query($args);

        // 記事一覧のループスタート
        if ( $the_query->have_posts() ) :
          while ( $the_query->have_posts() ) : $the_query->the_post();
        ?>
      
        <div class="p-blog p-blog-s">
          <a href="<?php the_permalink(); ?>">
            <figure class="p-blog__pic">
              <?php if(has_post_thumbnail()):?>
                <?php the_post_thumbnail('full');?>
              <?php else: ?>
                <img src="<?php echo get_template_directory_uri();?>/img/noimage_410x253.jpg">
              <?php endif;?>
            </figure>
            <h3 class="p-blog__ttl"><?php the_title(); ?></h3>
            <ul class="p-blog__typeList">
              <li class="p-blog__category"><?php $cat = get_the_category(); $cat = $cat[0]; {echo "$cat->cat_name";} ?></li>
              <li class="p-blog__date"><?php the_time('Y.m.d') ?></li>
            </ul>
            <p class="p-blog__txt"><?php echo get_the_excerpt(); ?></p>
            <div class="p-blog__btnlineWrapper">
              <span class="p-blog__btnline">read more→</span>
            </div>
          </a>
        </div>

        <?php

          endwhile;
        endif;

        // 記事一覧のループ終わり
        wp_reset_postdata();

        pagination($the_query->max_num_pages);
        ?>


          </div>
        </main>
        <!-- main終わり -->
        
        <!-- sidebar始まり -->
        <?php get_sidebar();?>
        <!-- sidebar終わり -->
        
      </div>
    </div>

    <!-- blog終わり -->
   
    <!-- breadcrumb -->
    <?php breadcrumb(); ?>
    <!-- //breadcrumb -->
    
<!-- footer始まり -->
<?php get_footer();?>
<!-- footer終わり -->

