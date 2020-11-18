<?php

  namespace Framework\Loader;

  class Css {

    private $path;

    /* ---
      Actions
    --- */

      public function loadFrontendCss($path) {

        $this->path = $path;

        add_action('wp_enqueue_scripts', [$this, 'registerStyles']);

      }

      public function loadAdminCss($path) {

        $this->path = $path;

        add_action('admin_enqueue_scripts', [$this, 'registerStyles']);

      }

    /* ---
      Functions
    --- */

      public function registerStyles() {

        $handle = md5($this->path);

        if (strpos($this->path, 'http') !== false) {

          $url = $this->path;
          $ver = '';

        } else {

          $url  = get_template_directory_uri() . '/' . trim($this->path, '/');
          $path = get_template_directory() . '/' . trim($this->path, '/');
          $ver  = file_exists($path) ? filemtime($path) : time();

        }

        wp_register_style($handle, $url, '', $ver);
        wp_enqueue_style($handle);

      }

  }