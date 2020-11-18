<?php

  namespace Framework\Taxonomy;

  class Labels {

    private $core;

    public function __construct($core) {

      $this->core = $core;

    }

    /* ---
      Actions
    --- */

      public function getLabels($settings) {

        return $this->taxonomyLabels($settings);

      }

    /* ---
      Functions
    --- */

      private function taxonomyLabels($settings) {

        $default = $this->loadDefaultLabels();
        $add     = explode(' ', $settings['add']);
        $labels  = [
          'name'          => $settings['name'],
          'singular_name' => $settings['singular'],
          'menu_name'     => isset($settings['menu']) ? $settings['menu'] : $settings['name'],
          'all_items'     => sprintf($default['all_items'], mb_strtolower($settings['name'], 'UTF-8')),
          'add_new_item'  => isset($default['add_new']) ? ($default['add_new'] . ' ' . implode(' ', array_slice($add, 2))) : $settings['add'],
          'menu_name'     => isset($settings['menu']) ? $settings['menu'] : $settings['name']
        ];

        return $labels;

      }

      private function loadDefaultLabels() {

        $lang = $this->core->translate->lang->getCurrentLang();

        if ($lang == 'pl') {

          $labels = [
            'all_items' => 'Wszystkie %s'
          ];

        } else {

          $labels = [
            'add_new'   => 'Add new',
            'all_items' => 'All %s'
          ];

        }

        return $labels;

      }

  }