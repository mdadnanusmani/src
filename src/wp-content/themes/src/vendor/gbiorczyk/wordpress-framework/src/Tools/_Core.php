<?php

  namespace Framework\Tools;

  class _Core {

    /* ---
      Actions
    --- */

      public function action($action, $args = false) {

        switch ($action) {
          case 'cleaner':

            $cleaner = new Cleaner();
 
          break;
          case 'stats':

            $cleaner = new Stats();
            $cleaner->configStats($args);
 
          break;
          case 'validate-categories':

            $categories = new Categories();
            $categories->addValidation($args);
 
          break;
          default:

            error_log(sprintf(
              'WordPress Framework: undefined action `%s` in Framework\\Tools\\_Core',
              $action
            ));

          break;
        }

      }

  }