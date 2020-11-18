<?php

  namespace Framework\Options;

  class _Core {

    private $core;

    public function __construct($core) {

      $this->core = $core;

      new Page($core);

    }

    /* ---
      Actions
    --- */

      public function action($action, $args = false) {

        switch ($action) {
          default:

            error_log(sprintf(
              'WordPress Framework: undefined action `%s` in Framework\\Options\\_Core',
              $action
            ));

          break;
        }

      }

  }