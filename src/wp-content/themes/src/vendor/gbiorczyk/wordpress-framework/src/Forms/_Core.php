<?php

  namespace Framework\Forms;
  use Framework\Options as GlobalOptions;

  class _Core {

    private $core;

    public function __construct($core) {

      $this->core = $core;

    }

    /* ---
      Actions
    --- */

      public function action($action, $args = false) {

        switch ($action) {
          case 'load':

            new GlobalOptions\Forms();
            new Ajax($this->core);
            new Form($this->core, $args);
            new Posttype($this->core);
            new Scripts($this->core, $args);
 
          break;
          default:

            error_log(sprintf(
              'WordPress Framework: undefined action `%s` in Framework\\Forms\\_Core',
              $action
            ));

          break;
        }

      }

  }