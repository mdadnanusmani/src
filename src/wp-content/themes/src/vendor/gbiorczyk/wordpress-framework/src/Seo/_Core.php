<?php

  namespace Framework\Seo;
  use Framework\Options as GlobalOptions;

  class _Core {

    private $core;

    public function __construct($core) {

      $this->core = $core;

      new Attachment();
      new Host();
      new Htaccess();
      new Jquery();
      new Redirects();
      new Search();
      new GlobalOptions\Share($core);
      new Share();
      new Wpcf7();

    }

    /* ---
      Actions
    --- */

      public function action($action, $args = false) {

        switch ($action) {
          default:

            error_log(sprintf(
              'WordPress Framework: undefined action `%s` in Framework\\Seo\\_Core',
              $action
            ));

          break;
        }

      }

  }