<?php

  namespace Framework\Site;

  class _Core {

    public function __construct() {

      new Ajax();
      new Framework();
      new Login();
      new Title();
      new W3();

    }

    /* ---
      Actions
    --- */

      public function action($action, $args = false) {

        switch ($action) {
          default:

            error_log(sprintf(
              'WordPress Framework: undefined action `%s` in Framework\\Site\\_Core',
              $action
            ));

          break;
        }

      }

  }