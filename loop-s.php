<?php if(have_posts()):?>
<?php while(have_posts()):the_post();?>
    <div class="p-blog p-blog-s">
    <a href="<?php the_permalink();?>">
        <figure class="p-blog__pic">
          <?php if(has_post_thumbnail()):?>
            <?php the_post_thumbnail('full');?>
          <?php else: ?>
            <img src="<?php echo get_template_directory_uri();?>/img/noimage_410x253.jpg">
          <?php endif;?>
        </figure>
        <h3 class="p-blog__ttl"><?php the_title();?></h3>
        <ul class="p-blog__typeList">
        <li class="p-blog__category"><?php $cat = get_the_category(); $cat = $cat[0]; {echo "$cat->cat_name";} ?></li>
        <li class="p-blog__date"><?php the_time("Y.m.j");?></li>
        </ul>
        <p class="p-blog__txt"><?php echo get_the_excerpt(); ?></p>
        <div class="p-blog__btnlineWrapper">
        <span class="p-blog__btnline">read more→</span>
        </div>
    </a>
    </div>
<?php endwhile;?>
<?php endif;?>