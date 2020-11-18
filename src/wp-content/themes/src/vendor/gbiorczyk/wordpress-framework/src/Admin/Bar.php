<?php

  namespace Framework\Admin;

  class Bar {

    private $core;

    public function __construct($core) {

      $this->core = $core;

      $this->hideAdminBar();

    }

    /* ---
      Functions
    --- */

      private function hideAdminBar() {

        if (!current_user_can('administrator')) {

          add_filter('show_admin_bar', '__return_false');
          return;

        }

        add_action('get_header', [$this, 'removeDefaultStyles'], 100);
        add_action('init',       [$this, 'loadAssets']);

      }

      public function removeDefaultStyles() {

        remove_action('wp_head', 'wp_admin_bar_header');
        remove_action('wp_head', '_admin_bar_bump_cb');

      }

      public function loadAssets() {

        $this->loadStyles();
        $this->loadScripts();

      }

      private function loadStyles() {

        $this->core->loader->action('css',
          WPF_ASSETS . 'Admin/Bar.css'
        );

      }

      private function loadScripts() {

        $this->core->loader->action('js',
          WPF_ASSETS . 'Admin/Bar.js'
        );

      }

  }