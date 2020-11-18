<?php

  namespace Framework\Loader;

  class _Core {

    private $isLocal;
    private $isValidator;

    public function __construct() {

      $this->isLocal     = (substr($_SERVER['REMOTE_ADDR'], 0, 4) == '127.') || ($_SERVER['REMOTE_ADDR'] == '::1');
      $this->isValidator = (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'validator.w3.org') !== false));

    }

    /* ---
      Actions
    --- */

      public function action($action, $args = false) {

        switch ($action) {
          case 'css':

            foreach ((array)$args as $arg) {

              $css = new Css();
              $css->loadFrontendCss($arg);

            }
 
          break;
          case 'inline-css':

            if (!$this->isLocal && !$this->isValidator) {

              foreach ((array)$args as $arg) {

                $css = new Cssinline();
                $css->printCss($arg);

              }

            } else {

              $this->action('css', $args);

            }
 
          break;
          case 'admin-css':

            foreach ((array)$args as $arg) {

              $css = new Css();
              $css->loadAdminCss($arg);

            }
 
          break;
          case 'js':

            foreach ((array)$args as $arg) {

              $js = new Js();
              $js->loadFrontendJs($arg);

            }
 
          break;
          case 'admin-js':

            foreach ((array)$args as $arg) {

              $js = new Js();
              $js->loadAdminJs($arg);

            }
 
          break;
          case 'php':

            foreach ((array)$args as $arg) {

              $php = new Php();
              $php->loadPhp($arg);

            }
 
          break;
          default:

            error_log(sprintf(
              'WordPress Framework: undefined action `%s` in Framework\\Loader\\_Core',
              $action
            ));

          break;
        }

      }

  }