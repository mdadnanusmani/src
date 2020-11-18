<?php

  namespace Framework\Admin;

  class _Core {

    private $core;

    public function __construct($core) {

      $this->core = $core;

      new Assets($core);
      new Bar($core);
      new Categories();
      new Comments();
      $this->gutenberg = new Gutenberg();
      new Yoast();

    }

    /* ---
      Actions
    --- */

      public function action($action, $args = false) {

        switch ($action) {
          case 'gutenberg':

            $this->gutenberg->isActive = is_bool($args) ? $args : false;
 
          break;
          case 'menu':

            $menu = new Menu();
            $menu->configAdminMenu($args);
 
          break;
          case 'tinymce':

            $tinymce = new Tinymce();
            $tinymce->configTinymce($args);
 
          break;
          default:

            error_log(sprintf(
              'WordPress Framework: undefined action `%s` in Framework\\Admin\\_Core',
              $action
            ));

          break;
        }

      }

  }