<?php

  namespace Framework\Acf;

  class Menu {

    private $slug;

    /* ---
      Actions
    --- */

      public function addSeparator() {

        add_filter('admin_menu', [$this, 'newSeparator']);

      }

      public function addHomepageLink($slug) {

        $this->slug = $slug;
        add_action('admin_menu', [$this, 'homepageLink']);

      }

      public function addMenuLink($slug) {

        $this->slug = $slug;
        add_action('admin_menu', [$this, 'menuLink']);

      }

    /* ---
      Functions
    --- */

      public function newSeparator() {

        global $menu;
        $menu[51] = $menu[59];

      }

      public function homepageLink() {

        $home = get_option('page_on_front');

        if (function_exists('pll_get_post'))
          $home = pll_get_post($home);

        if (!$home)
          return;

        add_submenu_page(
          $this->slug,
          '',
          get_the_title($home),
          'manage_options',
          'post.php?post=' . $home . '&action=edit',
          ''
        );

      }

      public function menuLink() {

        if (!get_nav_menu_locations())
          return;

        add_submenu_page(
          $this->slug,
          '',
          'Menu',
          'manage_options',
          'nav-menus.php',
          ''
        );

      }

  }