<?php

  namespace Framework\Translate;

  class _Core {

    private $core;

    public function __construct($core) {

      $this->core = $core;

      new Acf();
      $this->js   = new Js();
      $this->lang = new Lang();
      new Theme();

      if (function_exists('pll_current_language')) {

        new Admin();
        $this->optionspages = new Optionspages($core);
        $this->posttypes    = new Posttypes();
        $this->taxonomies   = new Taxonomies();

      }

    }

    /* ---
      Actions
    --- */

      public function action($action, $args) {

        switch ($action) {
          case 'js':

            $this->js->translateJs($args);
 
          break;
          default:

            error_log(sprintf(
              'WordPress Framework: undefined action `%s` in Framework\\Translate\\_Core',
              $action
            ));

          break;
        }

      }

  }