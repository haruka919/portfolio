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

          <?php if(have_posts()):?>
            <?php while(have_posts()):the_post();?>
            <article>
              <figure class="p-singlePost__eyecatch">
                <?php if(has_post_thumbnail()):?>
                  <?php the_post_thumbnail('full');?>
                <?php else: ?>
                  <img src="<?php echo get_template_directory_uri();?>/img/noimage_410x253.jpg">
                <?php endif;?>
              </figure>
              <div class="p-singlePost__titleWrapper">
                <span class="p-singlePost__category"><?php $cat = get_the_category(); $cat = $cat[0]; {echo "$cat->cat_name";} ?></span>
                <h1 class="p-singlePost__title"><?php the_title();?></h1>
                <span class="p-singlePost__date"><?php the_time("Y.m.j");?></span>
              </div>
              <div class="p-singlePost__content">
                <?php the_content(); ?>
              </div>
            </article>

            <?php endwhile;?>

            <div class="pagination">
              <ul>
                <li class="next"><?php next_post_link('%link', 'NEXT');?></li>
                <li class="prev"><?php previous_post_link('%link', 'PREV');?></li>
              </ul>
            </div>

            <!-- Comments -->
            <?php //comments_template();?>

          <?php else: ?>

            <h2 class="title">記事が見つかりませんでした。</h2>
            <p>検索で見つかるかもしれません</p><br>
            <?php get_search_form(); ?>

          <?php endif;?>   
          
        </main>
        <!-- main終わり -->
        
        <!-- sidebar始まり -->
        <?php get_sidebar();?>
        <!-- sidebar終わり -->

      </div>
    </div>

    <div class="l-section p-relatedBlogs__wrapper">
      <div class="p-relatedBlogs__container">
        <h2 class="p-relatedBlogs__title c-heading">カテゴリの関連記事</h2>
        <div class="p-blogs">
          <!-- 記事のループ -->
          <?php
          // 同じカテゴリから記事を6件呼び出す
          $categories = get_the_category($post->ID);
          $category_ID = array();
          foreach($categories as $category):
            array_push( $category_ID, $category -> cat_ID);
          endforeach ;
          $args = array(
            'post__not_in' => array($post -> ID), // 今読んでいる記事を除く
            'posts_per_page'=> 6,
            'category__in' => $category_ID,
            'orderby' => 'rand', // ランダムに記事を選ぶ
          );
          $query = new WP_Query($args);
          if( $query -> have_posts() ): while ($query -> have_posts()) : $query -> the_post();
          ?>

          <div class="p-blog">
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

          <?php endwhile; endif; ?>
          <?php wp_reset_postdata(); ?>
        </div>
      </div>

      </div>
      
    </div>

      <!-- breadcrumb -->
      <?php breadcrumb(); ?>
      <!-- //breadcrumb -->
      <!-- blog終わり -->
   

<!-- footer始まり -->
<?php get_footer();?>
<!-- footer終わり -->


