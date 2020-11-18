<?php

  class Generate_Terms_WPBetterPermalinks {

    private $core;

    function __construct($core) {

      $this->core = $core;

    }

    /* ---
      Functions
    --- */

      public function generateFriendlyUrl($termID, $taxonomy, $oldUrl) {

        $term = get_term_by('id', $termID, $taxonomy);

        if (!$term)
          return;

        $settings       = array_flip($this->core->terms->options['settings']);
        $postTypeObject = get_post_type_object($settings[$taxonomy]);
        $postTypeSlug   = $postTypeObject->rewrite['slug'];
        $taxonomyObject = get_taxonomy($taxonomy);
        $taxonomySlug   = $taxonomyObject->rewrite['slug'];

        $siteUrl       = site_url('/');
        $terms         = $this->getTermsPath($term, $taxonomy);
        $permalink     = trim(str_replace($siteUrl, '', $oldUrl), '/');
        $parts         = explode('/', $permalink);
        $parts         = array_slice($parts, 0, (count($parts) - 1));
        $index         = (count($parts) - 1);
        $parts[$index] = str_replace($taxonomySlug, $postTypeSlug, $parts[$index]);

        $oldUrl   = trim(str_replace($siteUrl, '', $oldUrl), '/');
        $newUrl   = $parts;
        $newUrl[] = $terms;
        $newUrl[] = $term->slug;
        $newUrl   = array_filter($newUrl);
        $newUrl   = implode('/', $newUrl);

        $rewrites = $this->core->terms->options['terms'];

        if (isset($rewrites[$term->term_id]) && ($newUrl == $rewrites[$term->term_id]['regex']))
          return;

        $rewrite = 'index.php?' . $taxonomy . '=' . $term->slug;

        $this->core->terms->save->saveFriendlyUrl($termID, $newUrl, $rewrite);

      }

      public function removeFriendlyUrl($termID) {

        unset($this->core->terms->options['terms'][$termID]);
        $this->core->terms->save->updateFriendlyUrls();

      }

      private function getTermsPath($term, $taxonomy) {

        $termPath = [];

        while ($term->parent) {

          $term       = get_term_by('id', $term->parent, $taxonomy);
          $termPath[] = $term->slug;

        }

        $termPath = array_reverse($termPath);
        $path     = implode('/', $termPath);
        $path     = $path ? $path : '';

        return $path;

      }

  }