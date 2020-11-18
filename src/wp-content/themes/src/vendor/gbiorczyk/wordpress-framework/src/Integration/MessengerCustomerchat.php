<?php

  namespace Framework\Integration;

  class MessengerCustomerchat {

    public function __construct() {

      add_action('wp_footer', [$this, 'installationCode'], 1000);

    }

    /* ---
      Functions
    --- */

      public function installationCode() {

        $code = get_field('facebook_customerchat', 'option');

        if (!$code || !$code['page_id'])
          return;

        $locale = function_exists('pll_current_language') ? pll_current_language('locale') : get_locale();

        ?>      
          <!-- BEGIN Messenger Customer Chat -->
            <script>
              (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = 'https://connect.facebook.net/<?= $locale; ?>/sdk/xfbml.customerchat.js#xfbml=1&version=v2.12&autoLogAppEvents=1';
                fjs.parentNode.insertBefore(js, fjs);
              }(document, 'script', 'facebook-jssdk'));
            </script>
            <div
              class="fb-customerchat"
              page_id="<?= $code['page_id']; ?>"
              theme_color="<?= $code['theme_color']; ?>"
              logged_in_greeting="<?= $code['greeting']['logged_in_users']; ?>"
              logged_out_greeting="<?= $code['greeting']['logged_out_users']; ?>"
              greeting_dialog_display="<?= $code['hide_default'] ? 'hide' : 'show'; ?>"
            ></div>
          <!-- END Messenger Customer Chat -->
        <?php

      }

  }