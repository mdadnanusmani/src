<?php

  namespace Framework\Integration;

  class GoogleAnalytics {

    public function __construct() {

      add_action('wp_head', [$this, 'installationCode'], 0);

    }

    /* ---
      Functions
    --- */

      public function installationCode() {

        $code = get_field('wpf_integration_google_analytics', 'option');

        if (!$code)
          return;

        ?>      
          <!-- BEGIN Google Analytics -->
            <script async src="https://www.googletagmanager.com/gtag/js?id=<?= $code; ?>"></script>
            <script>
              window.dataLayer = window.dataLayer || [];
              function gtag(){dataLayer.push(arguments);}
              gtag('js', new Date());

              gtag('config', '<?= $code; ?>');
            </script>
          <!-- END Google Analytics -->
        <?php

      }

  }