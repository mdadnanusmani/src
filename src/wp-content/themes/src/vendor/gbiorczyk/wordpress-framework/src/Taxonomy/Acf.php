<?php

  namespace Framework\Taxonomy;

  class Acf {

    public function __construct() {

      add_filter('acf/load_field/name=wpf_sitemap_taxonomies', [$this, 'loadValues']);
      add_filter('acf/load_field/name=wpf_seo_share_taxonomy', [$this, 'loadValues']);

    }

    /* ---
      Functions
    --- */

      public function loadValues($field) {

        $field['choices'] = $this->getValues(true);
        return $field;

      }

      public function getValues($labels = false) {

        $list = get_taxonomies([
          'public'   => true,
          '_builtin' => false
        ]);

        $list = $list ? array_values($list) : [];
        $list = array_merge($this->getDefault(), $list);

        if ($labels)
          $list = $this->getLabels($list);

        return $list;

      }

      private function getDefault() {

        $list = get_taxonomies([
          'public'   => true,
          '_builtin' => true
        ]);

        if (!$list)
          return $list;

        foreach ($list as $index => $slug) {

          if (!in_array($slug, ['category']))
            unset($list[$index]);

        }

        return $list;

      }

      private function getLabels($items) {

        $list = [];

        foreach ($items as $slug) {

          $object      = get_taxonomy($slug);
          $list[$slug] = sprintf('%s (%s)', $object->labels->name, $slug);

        }

        return $list;

      }

  }