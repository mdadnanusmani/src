<?php

  namespace Framework\Integration;

  class FacebookPixel {

    public function __construct() {

      add_action('wp_head',   [$this, 'installationCode']);
      add_action('wp_footer', [$this, 'noscriptCode']);

    }

    /* ---
      Functions
    --- */

      public function installationCode() {

        $code = get_field('wpf_integration_pixel', 'option');

        if (!$code)
          return;

        ?>      
          <!-- BEGIN Facebook Pixel -->
            <script>
              !function(f,b,e,v,n,t,s)
              {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
              n.callMethod.apply(n,arguments):n.queue.push(arguments)};
              if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
              n.queue=[];t=b.createElement(e);t.async=!0;
              t.src=v;s=b.getElementsByTagName(e)[0];
              s.parentNode.insertBefore(t,s)}(window, document,'script',
              'https://connect.facebook.net/en_US/fbevents.js');
              fbq('init', '<?= $code; ?>');
              fbq('track', 'PageView');
            </script>
          <!-- END Facebook Pixel -->
        <?php

      }

      public function noscriptCode() {

        $code = get_field('wpf_integration_pixel', 'option');

        if (!$code)
          return;

        ?>      
          <!-- BEGIN Facebook Pixel -->
            <noscript>
              <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=<?= $code; ?>&ev=PageView&noscript=1"/>
            </noscript>
          <!-- END Facebook Pixel -->
        <?php

      }

  }