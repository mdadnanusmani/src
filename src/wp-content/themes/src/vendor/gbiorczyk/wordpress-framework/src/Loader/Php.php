<?php

  namespace Framework\Loader;

  class Php {

    private $path;

    /* ---
      Actions
    --- */

      public function loadPhp($path) {

        $this->path = $path;

        $this->includeFiles();

      }

    /* ---
      Functions
    --- */

      private function includeFiles() {

        if (!$this->path)
          return;

        $path  = get_template_directory() . '/' . trim($this->path, '/');
        $files = file_exists($path) ? scandir($path) : [];

        if (!$files)
          return;

        foreach ($files as $file) {

          if (pathinfo($file, PATHINFO_EXTENSION) != 'php')
            continue;

          require_once $path . '/' . $file;
        
        }

      }

  }