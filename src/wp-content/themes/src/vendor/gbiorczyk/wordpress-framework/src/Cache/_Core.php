<?php

  namespace Framework\Cache;

  class _Core {

    /* ---
      Actions
    --- */

      public function action($action, $args = false) {

        switch ($action) {
          case 'config':

            $clear = new Clear();
            $clear->configClear($args);

            $config = new Config();
            $config->addConfig($args);

            $generate = new Generate();

            $widget = new Widget();
            $widget->addWidget($args);
 
          break;
          default:

            error_log(sprintf(
              'WordPress Framework: undefined action `%s` in Framework\\Cache\\_Core',
              $action
            ));

          break;
        }

      }

  }