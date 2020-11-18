<?php

  class Notice_Admin_WPBetterPermalinks {

    private $core;

    function __construct($core) {

      $this->core = $core;

    }

    /* ---
      Actions
    --- */

      public function initActions() {

        add_action('admin_notices', [$this, 'showAdminNotice']);

        add_action('admin_init',                          [$this, 'hideNoticeByDefault']);
        add_action('wp_ajax_wp_better_permalinks_notice', [$this, 'hideNotice']);

      }

    /* ---
      Notice content
    --- */

      public function showAdminNotice() {

        if ((get_option(WBP_NOTICE, 0) >= time()) || (get_current_screen()->id != 'dashboard'))
          return;

        ?>
          <div class="notice notice-success is-dismissible" data-notice="wp-better-permalinks">
            <h2>
              <?= __('Thank you for using our plugin WP Better Permalinks!', 'wp-better-permalinks'); ?>
            </h2>
            <p>
              <?php echo sprintf(__('Please let us know what you think about our plugin. It is important that we can develop this tool. Thank you for all the ratings, reviews and donates. %sIf you have a technical problem, please contact us first before adding the rating. We will try to help you!', 'wp-better-permalinks'), '<br>'); ?>
            </p>
            <p>
              <a href="https://wordpress.org/support/plugin/wp-better-permalinks/" target="_blank" class="button button-primary">
                <?= __('Add technical topic', 'wp-better-permalinks'); ?>
              </a>
              <a href="https://wordpress.org/support/plugin/wp-better-permalinks/reviews/#new-post" target="_blank" class="button button-primary">
                <?= __('Add review', 'wp-better-permalinks'); ?>
              </a>
              <a href="https://www.paypal.me/mateuszgbiorczyk/" target="_blank" class="button button-primary">
                <?= __('Donate us', 'wp-better-permalinks'); ?>
              </a>
              <a href="#" target="_blank" class="button" data-permanently>
                <?= __('I added review, do not show again', 'wp-better-permalinks'); ?>
              </a>
            </p>
          </div>
        <?php

      }

    /* ---
      Turn off notice
    --- */

      public function hideNoticeByDefault() {

        if (get_option(WBP_NOTICE, false) !== false)
          return;

        $expires = strtotime('+1 week');
        $this->saveNoticeExpires($expires);

      }

      public function hideNotice() {

        $isPermanent = isset($_POST['permanently']) && $_POST['permanently'];
        $expires     = strtotime($isPermanent ? '+10 years' : '+1 month');

        $this->saveNoticeExpires($expires);

      }

      public function saveNoticeExpires($expires) {

        if (get_option(WBP_NOTICE, false) !== false)
          update_option(WBP_NOTICE, $expires);
        else
          add_option(WBP_NOTICE, $expires);

      }

  }