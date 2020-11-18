<?php

  namespace Framework\Helpers;

  class Langs {

    public function __construct() {

      add_filter('wpf_helper_langs', [$this, 'langs'], 10, 1);

    }

    /* ---
      Actions
    --- */

      public function langs($sortKey) {

        return $this->getLangs($sortKey);

      }

    /* ---
      Functions
    --- */

      public function getLangs($sortKey) {

        $langs = pll_the_languages(['raw' => true]);

        if (!$langs)
          return [];

        $list = [
          'current' => [],
          'others'  => []
        ];

        foreach ($langs as $lang) {

          if ($lang['no_translation'])
            continue;

          if (in_array('current-lang', $lang['classes']))
            $list['current'] = $this->getLang($lang);
          else
            $list['others'][] = $this->getLang($lang);

        }

        if ($list['others']) {

          usort($list['others'], function($a, $b) use ($sortKey) {

            if ($a[$sortKey] == $b[$sortKey])
              return;

            return $a[$sortKey] > $b[$sortKey];

          });

        }

        return $list;

      }

      private function getLang($lang) {

        $data = [
          'url'   => $lang['url'],
          'slug'  => $lang['slug'],
          'title' => $lang['name']
        ];

        $data = apply_filters('wpf_helpers_langs_item', $data, $lang);
        return $data;

      }

  }