<?php

  namespace Framework\Integration;
  use Framework\Options as GlobalOptions;

  class _Core {

    public function __construct() {

      new GlobalOptions\Integration();
      new Init();

    }

    /* ---
      Actions
    --- */

      public function action($action, $args = false) {

        switch ($action) {
          default:

            error_log(sprintf(
              'WordPress Framework: undefined action `%s` in Framework\\Integration\\_Core',
              $action
            ));

          break;
        }

      }

  }