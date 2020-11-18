<?php

  namespace Framework\Admin;
  use Framework\Posttype as GlobalPosttype;

  class Menu {

    private $config;

    /* ---
      Actions
    --- */

      public function configAdminMenu($config) {

        $this->config = $config;

        if (isset($config['posts']) && !$config['posts'])
          new GlobalPosttype\Post();

        if (isset($config['pages']) && !$config['pages'])
          new GlobalPosttype\Page();

        add_filter('admin_menu', [$this, 'adminMenu']);
        add_filter('admin_init', [$this, 'adminMenuTools']);

      }

    /* ---
      Functions
    --- */

      public function adminMenu() {

        if (!isset($this->config) || !$this->config)
          return;

        $options = $this->config;
        global $menu;
        global $submenu;

        if (isset($options['comments']) && !$options['comments'])
          remove_menu_page('edit-comments.php');

        if (isset($options['customize']) && !$options['customize'])
          unset($submenu['themes.php'][6]);

        if (isset($options['wp_tools']) && !$options['wp_tools']) {

          remove_submenu_page('tools.php', 'tools.php');
          remove_submenu_page('tools.php', 'import.php');
          remove_submenu_page('tools.php', 'export.php');

        }

      }

      public function adminMenuTools() {

        if (!isset($this->config) || !$this->config)
          return;

        $options = $this->config;
        global $menu;
        global $submenu;

        if (isset($options['wp_tools']) && !$options['wp_tools'] && (isset($submenu['tools.php']) && !$submenu['tools.php']))
          unset($menu[75]);

      }

  }