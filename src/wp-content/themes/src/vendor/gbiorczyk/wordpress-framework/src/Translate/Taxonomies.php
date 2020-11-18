<?php

  namespace Framework\Translate;

  class Taxonomies {

    public $list;

    public function __construct() {

      add_action('init',      [$this, 'initGenerateRewriteRules']);
      add_filter('term_link', [$this, 'termLinkFilter'], 10, 3);

    }

    /* ---
      Actions
    --- */

      public function translateTaxonomy($slug, $list) {

        $this->list[$slug] = $list;

      }

    /* ---
      Rewrite rules
    --- */

      public function initGenerateRewriteRules() {

        if (!$this->list)
          return;

        foreach ($this->list as $taxonomy => $translations) {

          add_filter($taxonomy . '_rewrite_rules', function() {

            $taxonomy = str_replace('_rewrite_rules', '', current_filter());
            return $this->getTaxonomyRewriteRules($taxonomy);

          });

        }

      }

      public function getTaxonomyRewriteRules($taxonomy) {

        $rewrites    = [];
        $defaultLang = pll_default_language();

        foreach ($this->list[$taxonomy] as $lang => $translation) {

          if ($lang == $defaultLang) {

            $rewrites[$translation . '/([^/]+)/page/?([0-9]{1,})/?$']  = 'index.php?' . $taxonomy . '=$matches[1]&paged=$matches[2]';
            $rewrites[$translation . '/([^/]+)/?$']                    = 'index.php?' . $taxonomy . '=$matches[1]';

          } else {

            $rewrites['(' . $lang . ')/' . $translation . '/([^/]+)/page/?([0-9]{1,})/?$']  = 'index.php?' . $taxonomy . '=$matches[2]&paged=$matches[3]';
            $rewrites['(' . $lang . ')/' . $translation . '/([^/]+)/?$']                    = 'index.php?' . $taxonomy . '=$matches[2]';

          }

        }

        return $rewrites;

      }

    /* ---
      Links
    --- */

      public function termLinkFilter($link, $term, $taxonomy) {

        if (!$this->list || !isset($this->list[$taxonomy]))
          return $link;

        $lang        = pll_get_term_language($term->term_id);
        $defaultLang = pll_default_language();

        if (!$lang)
          return $link;

        if ($lang != $defaultLang)
          $link = site_url('/') . $lang . '/' . $this->list[$taxonomy][$lang] . '/' . $term->slug . '/';
        else
          $link = site_url('/') . $this->list[$taxonomy][$defaultLang] . '/' . $term->slug . '/';

        return $link;

      }

  }