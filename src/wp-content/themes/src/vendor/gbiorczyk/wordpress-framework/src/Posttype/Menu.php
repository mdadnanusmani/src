<?php

  namespace Framework\Posttype;

  class Menu {

    /* ---
      Actions
    --- */

      public function addSeparator() {

        add_filter('admin_menu', [$this, 'newSeparator']);

      }

    /* ---
      Functions
    --- */

      public function newSeparator() {

        global $menu;
        $menu[29] = $menu[59];

      }

  }