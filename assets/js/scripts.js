
jQuery( document ).ready( function() {
  jQuery(document).on( 'click', '.wsaf-wpforms-notice .notice-dismiss', function() {
    jQuery.ajax({
      url: WSALWPFormsData.ajaxURL,
      data: {
        action: 'wsal_wpforms_dismiss_notice'
      }
    })
  });

  // Add on installer
  jQuery(".install-addon:not(.disabled)").click( function(e) {
    jQuery(this).html( WSALWPFormsData.installing );
    var currentButton = jQuery(this);
    var PluginSlug = jQuery(this).attr('data-plugin-slug');
    var nonceValue = jQuery(this).attr('data-nonce');
    var PluginDownloadUrl = jQuery(this).attr('data-plugin-download-url');
    var RedirectToTab = jQuery(this).attr('data-plugin-event-tab-id');
    jQuery(currentButton).next('.spinner').show('200');
    e.preventDefault();
    jQuery.ajax({
      type: 'POST',
      dataType : "json",
      url: WSALWPFormsData.ajaxURL,
      data : {
        action: "run_addon_install",
        plugin_slug: PluginSlug,
        plugin_url: PluginDownloadUrl,
        _wpnonce: nonceValue
      },
      complete: function( data ) {
        if( data.responseText == '"already_installed"' ) {
          jQuery(currentButton).html( WSALWPFormsData.already_installed ).addClass('disabled');
          jQuery(currentButton).next('.spinner').hide('200');
        } else if ( data.responseText == '"activated"' ) {
          jQuery(currentButton).html( WSALWPFormsData.activated ).addClass('disabled');
          jQuery(currentButton).next('.spinner').hide('200');
       } else if ( JSON.stringify(data.responseText).toLowerCase().indexOf('failed') >= 0 ) {
          jQuery(currentButton).html( WSALWPFormsData.failed ).addClass('disabled');
          jQuery(currentButton).next('.spinner').hide('200');
       } else if ( data.responseText == '"success"' || JSON.stringify(data.responseText).toLowerCase().indexOf('success') >= 0 ) {
         jQuery(currentButton).html( WSALWPFormsData.installed ).addClass('disabled');
         jQuery(currentButton).next('.spinner').hide('200');
         // Reload as tabs are not present on page.
         location.reload();
       }
      },
    });
  });
});
