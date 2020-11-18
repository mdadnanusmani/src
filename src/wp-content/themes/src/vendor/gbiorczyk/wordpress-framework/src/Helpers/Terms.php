<?php

  namespace Framework\Helpers;

  class Terms {

    public function __construct() {

      add_filter('wpf_helper_terms', [$this, 'terms'], 10, 2);

    }

    /* ---
      Actions
    --- */

      public function terms($slug, $sortField = false) {

        return $this->getTerms($slug, $sortField);

      }

    /* ---
      Functions
    --- */

      public function getTerms($slug, $sortField) {

        global $wp;

        $current = is_tax() ? get_queried_object()->term_id : 0;
        $terms   = get_terms([
          'taxonomy' => $slug
        ]);

        if (!$terms)
          return [];

        $terms = $this->termsTree($terms, $sortField);
        $terms = $this->termsActive($terms, $current)['items'];

        return $terms;

      }

    /* ---
      Parse items
    --- */

      private function termsActive($terms, $currentTerm) {

        $isActive = false;

        foreach ($terms as $index => $term) {

          if ($term['id'] == $currentTerm) {

            $terms[$index]['active'] = true;
            $isActive = true;

            continue;

          }

          if (!$term['children'])
            continue;

          $children = $this->termsActive($term['children'], $currentTerm);

          if (!$children['active'])
            continue;

          $terms[$index]['active']   = true;
          $terms[$index]['children'] = $children['items'];
          $isActive = false;

        }

        return [
          'active' => $isActive,
          'items'  => $terms
        ];

      }

      private function termsTree($terms, $sortField, $parentID = 0) {

        $list = [];

        foreach ($terms as $index => $term) {

          if ($term->parent != $parentID)
            continue;

          $list[] = $this->parseTerm($term, $terms, $sortField);

        }

        if (!$sortField)
          return $list;

        usort($list, function($a, $b) use ($sortField) {

          if ($a[$sortField] == $b[$sortField]) {

            if ($a['title'] == $b['title'])
              return;

            return $a['title'] > $b['title'];

          }

          return $a[$sortField] < $b[$sortField];

        });

        return $list;

      }

      private function parseTerm($term, $terms, $sortField) {

        $children = $this->termsTree($terms, $sortField, $term->term_id);
        $url      = get_term_link($term);
        $object   = (object)[
          'term_id'  => $term->term_id,
          'taxonomy' => $term->taxonomy
        ];

        $data = [
          'id'       => $term->term_id,
          'url'      => $url,
          'title'    => $term->name,
          'active'   => false,
          'children' => $children ? $children : []
        ];

        if ($sortField)
          $data[$sortField] = get_field($sortField, $object);

        $data = apply_filters('wpf_helpers_terms_item', $data);
        return $data;

      }

  }