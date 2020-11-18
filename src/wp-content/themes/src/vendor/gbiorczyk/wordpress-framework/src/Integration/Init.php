<?php

  namespace Framework\Integration;

  class Init {

    public function __construct() {

      $this->initIntegartions();

    }

    /* ---
      Functions
    --- */

      private function initIntegartions() {

        $enable = (function_exists('get_field') && get_field('wpf_integration_active', 'option'));

        if (!$enable)
          return;

        new GoogleAnalytics();
        new TagManager();
        new FacebookPixel();
        new Hotjar();
        new LiveChat();
        new MessengerCustomerchat();

      }

  }