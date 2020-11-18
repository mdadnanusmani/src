<?php

  namespace Framework\Settings;
  use Framework\Options as GlobalOptions;

  class _Core {

    public function __construct() {

      new Browsersync();
      new Cron();
      new Error404();
      new GlobalOptions\Phpmailer();
      new Phpmailer();
      new Polylang();

    }

    /* ---
      Actions
    --- */

      public function action($action, $args = false) {

        switch ($action) {
          case 'images':

            $images = new Images();
            $images->addImageSizes($args);
 
          break;
          case 'nav':

            $nav = new Nav();
            $nav->addnavMenus($args);
 
          break;
          case 'plugins-update':

            $plugins = new Plugins();
            $plugins->lockUpdatePlugins($args);
 
          break;
          case 'security':

            $security = new Security();
            $security->configSecurity($args);
 
          break;
          case 'upload':

            $upload = new Upload();
            $upload->addTypesForUpload($args);
 
          break;
          default:

            error_log(sprintf(
              'WordPress Framework: undefined action `%s` in Framework\\Settings\\_Core',
              $action
            ));

          break;
        }

      }

  }