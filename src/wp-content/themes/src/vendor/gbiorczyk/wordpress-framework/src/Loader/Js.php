<?php

  namespace Framework\Loader;

  class Js {

    private $path;

    /* ---
      Actions
    --- */

      public function loadFrontendJs($path) {

        $this->path = $path;

        add_action('wp_enqueue_scripts', [$this, 'registerScripts']);

      }

      public function loadAdminJs($path) {

        $this->path = $path;

        add_action('admin_enqueue_scripts', [$this, 'registerScripts']);

      }

    /* ---
      Functions
    --- */

      public function registerScripts() {

        $handle = md5($this->path);

        if (strpos($this->path, 'http') !== false) {

          $url = $this->path;
          $ver = '';

        } else {

          $url  = get_template_directory_uri() . '/' . trim($this->path, '/');
          $path = get_template_directory() . '/' . trim($this->path, '/');
          $ver  = file_exists($path) ? filemtime($path) : time();

        }

        wp_register_script($handle, $url, [], $ver, true);
        wp_enqueue_script($handle);

      }

  }