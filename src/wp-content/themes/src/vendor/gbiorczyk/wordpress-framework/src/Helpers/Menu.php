<?php

  namespace Framework\Helpers;

  class Menu {

    public function __construct() {

      add_filter('wpf_helper_menu', [$this, 'menu'], 10, 1);

    }

    /* ---
      Actions
    --- */

      public function menu($location) {

        return $this->getMenu($location);

      }

    /* ---
      Functions
    --- */

      public function getMenu($location) {

        $locations = get_nav_menu_locations();

        if (!isset($locations[$location]))
          return [];

        $items = wp_get_nav_menu_items($locations[$location]);

        if (!$items)
          return [];

        _wp_menu_item_classes_by_context($items);

        $items = $this->navTree($items);

        $items = apply_filters('wpf_helpers_menu', $items);
        return $items;

      }

    /* ---
      Parse items
    --- */

      private function navTree($items, $parentID = 0) {

        $list = [];

        foreach ($items as $index => $item) {

          if ($item->menu_item_parent != $parentID)
            continue;

          $list[] = $this->parseItem($item, $items);

        }

        return $list;

      }

      private function parseItem($item, $items) {

        $object = (object)[
          'ID'        => $item->ID,
          'post_type' => $item->post_type
        ];
        $children = $this->navTree($items, $item->ID);
        $active   = (in_array('current-menu-parent', $item->classes) || in_array('current-menu-item', $item->classes));

        if (!$active && ($item->type == 'post_type_archive')) {

          global $post;

          if (is_object($post) && ($post->post_type == $item->object))
            $active = true;

        }

        $data = [
          'object'   => $object,
          'url'      => $item->url,
          'title'    => $item->title,
          'target'   => $item->target ? $item->target : '_self',
          'active'   => $active,
          'children' => $children ? $children : []
        ];

        $data = apply_filters('wpf_helpers_menu_item', $data, $item);
        return $data;

      }

  }