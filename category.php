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
          <h2 class="p-blogs__title"><span class="p-blogs__title-category"><?php $cat = get_the_category(); $cat = $cat[0]; {echo "$cat->cat_name";} ?></span>のカテゴリーの記事</h2>
          <div class="p-blogs">

            <!-- 記事のループ -->
            <?php get_template_part('loop-s'); ?>

            <?php if(function_exists("pagination")) pagination($wp_query->max_num_pages); ?>

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