<?php

  namespace Framework\Helpers;

  class _Core {

    public function __construct() {

      new Breadcrumbs();
      new Favicons();
      new Instagram();
      new Langs();
      new Menu();
      new Terms();

    }

    /* ---
      Actions
    --- */

      public function action($action, $args = false) {

        switch ($action) {
          default:

            error_log(sprintf(
              'WordPress Framework: undefined action `%s` in Framework\\Helpers\\_Core',
              $action
            ));

          break;
        }

      }

  }