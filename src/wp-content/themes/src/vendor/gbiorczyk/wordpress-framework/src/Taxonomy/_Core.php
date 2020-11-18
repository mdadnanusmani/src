<?php

  namespace Framework\Taxonomy;

  class _Core {

    private $core;

    public function __construct($core) {

      $this->core = $core;

      $this->acf    = new Acf();
      $this->labels = new Labels($core);

    }

    /* ---
      Actions
    --- */

      public function action($action, $args = false) {

        switch ($action) {
          case 'register':

            $register = new Register($this->core);
            $register->registerNewsTaxonomy($args);
 
          break;
          default:

            error_log(sprintf(
              'WordPress Framework: undefined action `%s` in Framework\\Taxonomy\\_Core',
              $action
            ));

          break;
        }

      }

  }