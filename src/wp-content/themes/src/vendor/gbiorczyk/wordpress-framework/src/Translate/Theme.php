<?php

  namespace Framework\Translate;

  class Theme {

    public function __construct() {

      $this->setLangDirectory();

    }

    /* ---
      Functions
    --- */

      private function setLangDirectory() {

        $this->createLangDirectory();

        load_theme_textdomain('lang', get_template_directory() . '/langs');
        load_theme_textdomain('wpf',  WPF_PATH . 'langs');

      }

      private function createLangDirectory() {

        $path = get_template_directory() . '/langs';

        if (!file_exists($path))
          mkdir($path, 0777, true);

      }

  }