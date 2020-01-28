
jQuery( document ).ready( function() {
  jQuery(document).on( 'click', '.wsaf-wpforms-notice .notice-dismiss', function() {

      jQuery.ajax({
          url: ajaxurl,
          data: {
              action: 'wsal_wpforms_dismiss_notice'
          }
      })

  });
});
