(function (Drupal, $) {
  'use strict';

  Drupal.behaviors.mainMenu = {
    attach: function (context) {

      /* -------------------------
          STICKY MAINMENU
      ------------------------- */
      $('#mainmenu-area').sticky({
        topSpacing: 0
      });

      /* -------------------------------
          DROPDOWN MOBILE MENU
      ------------------------------- */
      var id;

      function doneResizing() {
        if (Modernizr.mq('screen and (max-width:991px)')) {
          $('.at-drop-down').on('click', function (e) {
            e.preventDefault();
            $(this).next($('.sub-menu')).slideToggle();
          });
        }
      }

      $(window).on('load resize', function () {
        if (typeof id !== 'undefined') {
          clearTimeout(id);
        }
        id = setTimeout(doneResizing, 0);
      });

    }
  };
})(Drupal, jQuery);
