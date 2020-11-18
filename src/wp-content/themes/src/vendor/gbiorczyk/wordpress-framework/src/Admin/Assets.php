<?php

  namespace Framework\Admin;

  class Assets {

    private $core, $path;

    public function __construct($core) {

      $this->core = $core;

      add_action('admin_init', [$this, 'loadAssets']);

    }

    /* ---
      Functions
    --- */

      public function loadAssets() {

        $this->loadStyles();
        $this->loadScripts();

      }

      private function loadStyles() {

        $this->core->loader->action('admin-css',
          WPF_ASSETS. 'Admin/Assets.css'
        );

      }

      private function loadScripts() {

        $this->core->loader->action('admin-js',
          WPF_ASSETS . 'Admin/Assets.js'
        );

      }

  }