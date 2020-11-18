<?php

  namespace Framework\Posttype;

  class Labels {

    private $core;

    public function __construct($core) {

      $this->core = $core;

    }

    /* ---
      Actions
    --- */

      public function getLabels($settings) {

        return $this->postTypeLabels($settings);

      }

    /* ---
      Functions
    --- */

      public function postTypeLabels($settings) {

        $default  = $this->loadDefaultLabels();
        $add      = explode(' ', $settings['add']);
        $labels   = [
          'name'               => $settings['name'],
          'singular_name'      => $settings['singular'],
          'add_new'            => isset($default['add_new']) ? $default['add_new'] : implode(' ', array_slice($add, 0, 2)),
          'add_new_item'       => isset($default['add_new']) ? ($default['add_new'] . ' ' . implode(' ', array_slice($add, 2))) : $settings['add'],
          'new_item'           => ucfirst(str_replace('ą', 'a', $add[1])) . ' ' . mb_strtolower($settings['singular'], 'UTF-8'),
          'edit_item'          => sprintf($default['edit_item'], implode(' ', array_slice($add, 2))),
          'view_item'          => sprintf($default['view_item'], implode(' ', array_slice($add, 2))),
          'all_items'          => sprintf($default['all_items'], mb_strtolower($settings['name'], 'UTF-8')),
          'search_items'       => $default['search_items'],
          'not_found'          => $default['not_found'],
          'not_found_in_trash' => $default['not_found_in_trash'],
          'menu_name'          => isset($settings['menu']) ? $settings['menu'] : $settings['name']
        ];

        return $labels;

      }

      private function loadDefaultLabels() {

        $lang = $this->core->translate->lang->getCurrentLang();

        if ($lang == 'pl') {

          $labels = [
            'edit_item'          => 'Edytuj %s',
            'view_item'          => 'Zobacz %s',
            'all_items'          => 'Wszystkie %s',
            'search_items'       => 'Szukaj',
            'not_found'          => 'Nie znaleziono żadnych elementów.',
            'not_found_in_trash' => 'Nie znaleziono żadnych elementów w koszu.'
          ];

        } else {

          $labels = [
            'add_new'            => 'Add new',
            'edit_item'          => 'Edit %s',
            'view_item'          => 'View %s',
            'all_items'          => 'All %s',
            'search_items'       => 'Search',
            'not_found'          => 'No items found.',
            'not_found_in_trash' => 'No items found in Trash.'
          ];

        }

        return $labels;

      } 

  }