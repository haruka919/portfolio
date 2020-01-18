  <!-- footer始まり -->
  <footer class="l-footer p-footer__wrapper">
    <div class="p-footer">
      <div class="p-footer__snsWrapper">
        <h2 class="p-footer__logo"><img src="img/logo.png" alt=""></h2>
        <ul class="p-footer__sns">
          <li class="p-footer__sns-ico"><a href="/"><i class="fab fa-twitter"></i></a></li>
          <li class="p-footer__sns-ico"><a href="/"><i class="fab fa-instagram"></i></a></li>
        </ul>
      </div>
      <div class="p-footer__navWrapper">
        <?php   
          wp_nav_menu( array( 
            'theme_location' => 'main-menu',
            'container' => 'nav',
            'container_class' => 'p-footer__nav',
            'items_wrap' => '<ul>%3$s</ul>',
          ));   
        ?>      
      </div>
    </div>
    <p class="p-footer__copyright"><small>©paruko 2019</small></p>
  </footer>
  <!-- footer終わり -->
</body>
</html>