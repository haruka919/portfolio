<?php
/*
Template Name: Home　〜トップページ〜
*/
?>

<!-- head -->
<?php get_header();?>
<!-- //head -->

  <!-- header始まり -->
  <?php get_template_part('content', 'menu');?>
  <!-- header終わり -->

  <main>
    <!-- KV始まり -->
    <section class="l-section p-kv">
      <div class="p-kv__titleWrapper">
        <h2 class="p-kv__title"><img src="<?php echo get_template_directory_uri().'/img/h1_img.png';?>"></h2>
      </div>
    </section>
    <!-- KV終わり -->

    <!-- about始まり -->
    <section id="about" class="p-about__wrapper">
      <div class="p-about__container">
        <div class="p-about__imageWrapper">
          <img src="<?php echo get_template_directory_uri().'/img/kv.jpg';?>" alt="">
        </div>
        <div class="p-about__txtWrapper">
          <h2 class="p-about__title"><img src="<?php echo get_template_directory_uri().'/img/h2_img.png';?>"></h2>
          <p class="p-about__txt">
            <?php echo get_post_meta($post->ID, 'about', true);?>
          </p>
          <!-- <a href="/">私が稼ぎたい理由</a> -->
        </div>
      </div>
    </section> 
     
    <!-- about終わり -->

    <!-- output始まり -->
    <section id="output" class="l-section p-works__wrapper">
      <div class="p-works">
        <h2 class="c-heading p-works__heading">
          アウトプット作品<span class="c-heading-sub p-works__heading-sub">OUTPUT</span>
        </h2>

        <?php 

        global $post;
        $args = array(
          'numberposts' => 4,   //表示（取得）する記事の数
          'post_type' => 'output',  //投稿タイプの指定
          'orderby'  => 'date',
	        'order'    => 'ASC',
         );
        $myposts = get_posts( $args );
        $count=1;
        foreach( $myposts as $post ) {
          setup_postdata($post);
          
        ?>

        <div class="p-work">
          <div class="p-work__imageWrapper">
            <figure class="p-work__pic">
              <?php the_post_thumbnail('full');?>
            </figure>
          </div>
          <div class="p-work__txtWrapper">
            <p class="p-work__num"><?php echo $count; ?><span class="p-work__num-s">&nbsp;|&nbsp;<?php echo wp_count_posts( 'output' )->publish; ?></span></p>
            <h3 class="p-work__ttl"><?php the_title(); ?></h3>
            <p class="p-work__txt"><?php echo get_the_content(); ?></p>
            <!-- <div class="p-work__btnWrapper">
              <a class="p-work__btn" href="<?php the_permalink();?>">詳細を見る</a>
            </div> -->
          </div>
        </div>

        <?php
        $count++;
        }
        wp_reset_postdata();
        ?>

    </section>
    <!-- output終わり -->

    <!-- blog始まり -->
    <section class="l-section p-blogs__wrapper">
      <div class="p-blogs__container">
        <h2 class="c-heading">
          ブログ<span class="c-heading-sub p-blogs__heading-sub">BLOG</span>
        </h2>
        <div class="p-blogs">

        <?php
        global $post;
        $args = array( 'posts_per_page' => 3 );
        $myposts = get_posts( $args );
        foreach( $myposts as $post ) {
          setup_postdata($post);
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

          <?php
          }
          wp_reset_postdata();
          ?>

        </div>
      </div>
    </section>
    <!-- blog終わり -->

    <!-- twitter始まり -->
    <section class="l-section p-twitter__wrapper">
      <div class="p-twitter__inner">
        <h2 class="c-heading--edge p-twitter__heading">
          FOLLOW ME
        </h2>
        <p class="p-twitter__info">Twitterにて毎日の勉強を記録しています。</p>
        <div class="p-twitter__showWrapper">
          <a class="twitter-timeline" data-width="500" data-height="500"
            href="https://twitter.com/h9h1h7?ref_src=twsrc%5Etfw">Tweets by h9h1h7</a>
          <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
        </div>
      </div>
    </section>
    <!-- twitter終わり -->
  </main>

<!-- footer -->
<?php get_footer();?>
<!-- //footer -->

