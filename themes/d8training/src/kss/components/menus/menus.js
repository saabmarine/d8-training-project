(function (Drupal, $) {
  'use strict';

  Drupal.behaviors.menus = {
    attach: function (context) {

      /* -----------------------------
          MENU IMAGE POPUP
      ----------------------------- */
      $('.menu-popup').magnificPopup({
        type: 'image',
        removalDelay: 500, // delay removal by X to allow out-animation
        callbacks: {
          beforeOpen: function () {
            // just a hack that adds mfp-anim class to markup
            this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
            this.st.mainClass = this.st.el.attr('data-effect');
          }
        },
        closeOnContentClick: true,
        midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
      });

      /* --------------------------
          MENU LIST MIXITUP FILTERING
      -------------------------- */
      $('.food-menu-list').mixItUp();

    }
  };
})(Drupal, jQuery);
