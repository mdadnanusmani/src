<?php

  namespace Framework\Acf;

  class _Core {

    private $core;

    public function __construct($core) {

      $this->core = $core;

      new Json();
      new Link();
      new Location();

    }

    /* ---
      Actions
    --- */

      public function action($action, $args = false) {

        switch ($action) {
          case 'icons':

            $icons = new Icons();
            $icons->setIconsList($args);
 
          break;
          case 'optionspage':

            $optionspage = new Optionspage($this->core);
            $optionspage->registerOptionsPage($args);
 
          break;
          default:

            error_log(sprintf(
              'WordPress Framework: undefined action `%s` in Framework\\Acf\\_Core',
              $action
            ));

          break;
        }

      }

  }