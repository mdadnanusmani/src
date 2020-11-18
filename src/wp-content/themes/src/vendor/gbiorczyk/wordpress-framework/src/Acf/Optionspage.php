<?php

  namespace Framework\Acf;

  class Optionspage {

    private $core, $args, $isDefault, $menu;

    public function __construct($core) {

      $this->core = $core;

    }

    /* ---
      Actions
    --- */

      public function registerOptionsPage($args, $isDefault = false) {

        if (!function_exists('acf_add_options_page') || !function_exists('acf_add_options_sub_page'))
          return;

        $this->menu = new Menu();
        $this->menu->addSeparator();

        $this->args      = $args;
        $this->isDefault = $isDefault;

        add_action('init', [$this, 'addNewOptionsPage'], 0);

      }

      public function addNewOptionsPage() {

        $args = $this->args;

        $this->addOptionsPage($args);
        $this->addOptionSubPages($args['pages'], $args['slug']);

      }

      private function addOptionsPage($args) {

        acf_add_options_page([
          'page_title'  => $args['title'],
          'menu_slug'   => $args['slug'],
          'position'    => $this->isDefault ? 58 : 57,
          'parent_slug' => '',
          'icon_url'    => $args['icon']
        ]);

        if (isset($args['notranslate']) && isset($this->core->translate->optionspages)) {

          foreach ($args['notranslate'] as $slug)
            $this->core->translate->optionspages->notranslate[] = $args['slug'] . '-' . $slug;

        }

      }

      private function addOptionSubPages($pages, $parent) {

        $menuSlug = '';

        foreach ($pages as $slug => $title) {

          $key = $parent . '-' . $slug;

          acf_add_options_sub_page([
            'page_title'  => $title,
            'menu_slug'   => $key,
            'parent_slug' => $parent
          ]);

          if (!$menuSlug)
            $menuSlug = $key;

        }

        if (!$this->isDefault) {

          $this->menu->addHomepageLink($menuSlug);
          $this->menu->addMenuLink($menuSlug);

        }

      } 

  }