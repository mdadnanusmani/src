<?php

  namespace Framework\Sitemap;
  use Framework\Options as GlobalOptions;

  class _Core {

    public function __construct() {

      new GlobalOptions\Sitemap();
      new Init();

    }

    /* ---
      Actions
    --- */

      public function action($action, $args = false) {

        switch ($action) {
          default:

            error_log(sprintf(
              'WordPress Framework: undefined action `%s` in Framework\\Sitemap\\_Core',
              $action
            ));

          break;
        }

      }

  }