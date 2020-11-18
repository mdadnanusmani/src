<?php

  class Admin_WPBetterPermalinks {

    private $core;

    function __construct($core) {

      $this->core = $core;

    }

    /* ---
      Actions
    --- */

      public function initCore() {

        $this->loadSettings();

        return true;

      }

      private function loadSettings() {

        $this->options = [
          'settings' => array_filter(get_option('wbp_settings', []))
        ];

      }

  }