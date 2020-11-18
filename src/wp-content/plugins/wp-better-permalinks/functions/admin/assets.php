<?php

  class Assets_Admin_WPBetterPermalinks {

    private $core;

    function __construct($core) {

      $this->core = $core;

    }

    /* ---
      Actions
    --- */

      public function initActions() {

        add_filter('admin_enqueue_scripts', [$this, 'loadStyles']);
        add_filter('admin_enqueue_scripts', [$this, 'loadScripts']);

      }

    /* ---
      Functions
    --- */

      public function loadStyles() {

        wp_register_style('wp-better-permalinks', WBP_HTTP . 'assets/css/styles.css', '', WBP_VERSION);
        wp_enqueue_style('wp-better-permalinks');

      }

      public function loadScripts() {

        wp_register_script('wp-better-permalinks', WBP_HTTP . 'assets/js/scripts.js', 'jquery', WBP_VERSION, true);
        wp_enqueue_script('wp-better-permalinks');

      }

  }