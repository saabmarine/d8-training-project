(function (Drupal, $) {
  'use strict';

  Drupal.behaviors.searchForm = {
    attach: function (context) {

      /* -------------------------
          SCROLLSPY ACTIVE
      -------------------------- */
      $('body').scrollspy({
        target: '.bs-example-js-navbar-scrollspy',
        offset: 50
      });

      /* ---------------------------
          OPEN SEARCH FORM
      --------------------------- */
      var $searchForm = $('.search-form');
      var $searchFormTrigger = $('.search-form-trigger');
      var $formOverlay = $('.search-form-overlay');
      $searchFormTrigger.on('click', function (e) {
        e.preventDefault();
        toggleSearch();
      });

      function toggleSearch(type) {
        if (type === 'close') {
          // close serach
          $searchForm.removeClass('is-visible');
          $searchFormTrigger.removeClass('search-is-visible');
        }
        else {
          // toggle search visibility
          $searchForm.toggleClass('is-visible');
          $searchFormTrigger.toggleClass('search-is-visible');

          if ($searchForm.hasClass('is-visible')) {
            $searchForm.find('input[type="search"]').focus();
          }

          if ($searchForm.hasClass('is-visible')) {
            $formOverlay.addClass('is-visible');
          }
          else {
            $formOverlay.removeClass('is-visible');
          }
        }
      }

    }
  };
})(Drupal, jQuery);
