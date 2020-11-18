<?php

  class Generate_Posttypes_WPBetterPermalinks {

    private $core;

    function __construct($core) {

      $this->core = $core;

    }

    /* ---
      Functions
    --- */

      public function generateFriendlyUrl($post, $oldUrl) {

        if (!in_array($post->post_status, ['publish', 'future'])) {

          $this->removeFriendlyUrl($post->ID);
          return;

        }

        $taxonomy  = $this->core->posttypes->options['settings'][$post->post_type];
        $siteUrl   = site_url('/');
        $terms     = $this->getTermsPath($post->ID, $taxonomy);

        $permalink = trim(str_replace($siteUrl, '', $oldUrl), '/');
        $parts     = explode('/', $permalink);
        $oldUrl    = trim(str_replace($siteUrl, '', $oldUrl), '/');
        $newUrl    = array_slice($parts, 0, (count($parts) - 1));
        $newUrl[]  = $terms;
        $newUrl[]  = $post->post_name;
        $newUrl    = array_filter($newUrl);
        $newUrl    = implode('/', $newUrl);

        $rewrites = $this->core->posttypes->options['posts'];

        if (isset($rewrites[$post->ID]) && ($newUrl == $rewrites[$post->ID]['regex']))
          return;

        $rewrite = 'index.php?post_type=' . $post->post_type . '&name=' . $post->post_name;

        $this->core->posttypes->save->saveFriendlyUrl($post->ID, $newUrl, $rewrite);

      }

      public function removeFriendlyUrl($postID) {

        unset($this->core->posttypes->options['posts'][$postID]);
        $this->core->posttypes->save->updateFriendlyUrls();

      }

      private function getTermsPath($postID, $taxonomy) {

        $terms = wp_get_post_terms($postID, $taxonomy, ['orderby' => 'term_id', 'order' => 'asc']);

        if (!$terms)
          return '';

        $yoastCategory = get_post_meta($postID, '_yoast_wpseo_primary_' . $taxonomy, true);

        if ($yoastCategory) {

          $term = get_term_by('id', $yoastCategory, $taxonomy);

        } else {

          $list = [];
          foreach ($terms as $term)
            $list[$term->term_id] = $term->parent;

          foreach ($list as $termID => $parentID) {

            if (isset($list[$parentID]))
              unset($list[$parentID]);

          }

          $list = array_keys($list);
          $term = get_term_by('id', $list[0], $taxonomy);

        }

        $termPath   = [];
        $termPath[] = $term->slug;

        if (!is_object($term))
          return '';

        while ($term->parent) {

          $term = get_term_by('id', $term->parent, $taxonomy);

          if (!is_object($term))
            break;

          $termPath[] = $term->slug;

        }

        $termPath = array_reverse($termPath);
        $path     = implode('/', $termPath);
        $path     = $path ? $path : '';

        return $path;

      }

  }