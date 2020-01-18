<header class="l-header p-header">
  <h1 class="p-header__title">
    <a href="<?php echo home_url(); ?>">
      <img src="<?php header_image(); ?>" alt="<?php bloginfo('name');?>">
    </a>
  </h1>
  <?php 
    wp_nav_menu( array( 
      'theme_location' => 'main-menu',
      'container' => 'nav',
      'container_class' => 'p-header__nav--pc',
      'items_wrap' => '<ul>%3$s</ul>',
    )); 
  ?>
  
  <div class="p-drawer js-drawer">
    <span></span>
    <span></span>
    <span></span>
  </div>

  <?php   
    wp_nav_menu( array( 
      'theme_location' => 'main-menu',
      'container' => 'nav',
      'container_class' => 'p-header__nav--sp js-spNav',
      'items_wrap' => '<ul>%3$s</ul>',
    ));   
  ?>
</header>

