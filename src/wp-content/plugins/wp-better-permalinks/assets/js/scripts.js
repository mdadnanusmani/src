(function($) {

  /* ---
    Closing admin notice
  --- */

    var isHidden = false;

    $(document).on('click', '.notice[data-notice=wp-better-permalinks] .notice-dismiss', function() {

      if (isHidden)
        return;

      $.ajax(ajaxurl, {
        type: 'POST',
        data: {
          action : 'wp_better_permalinks_notice'
        }
      });

    });

    $(document).on('click', '.notice[data-notice=wp-better-permalinks] .button[data-permanently]', function(e) {

      e.preventDefault();

      isHidden = true;
      $('.notice[data-notice=wp-better-permalinks] .notice-dismiss').click();

      $.ajax(ajaxurl, {
        type: 'POST',
        data: {
          action      : 'wp_better_permalinks_notice',
          permanently : 1
        }
      });

    });

  /* ---
    Lock taxonomy double selection
  --- */

    $('.wbsOptionPage__column table select').change(function() {

      var current = $(this);
      var value   = current.val();

      $(this).closest('tr').siblings().find('select').each(function() {

        if ($(this).val() == value)
          $(this).find('option').first().prop('selected', true);

      })

    });

})(jQuery);