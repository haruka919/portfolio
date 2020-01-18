jQuery(function () {
  jQuery('.js-drawer').on('click', function () {
    jQuery(this).toggleClass('active');
    // return false;
    jQuery('body').toggleClass('open');
  });
});