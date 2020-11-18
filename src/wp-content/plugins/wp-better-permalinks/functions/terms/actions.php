<?php

  class Actions_Terms_WPBetterPermalinks {

    private $core;

    function __construct($core) {

      $this->core = $core;

    }

    /* ---
      Actions
    --- */

      public function initActions() {

        add_action('pre_delete_term', [$this, 'getTermRelations'], 10, 2);

        foreach ($this->core->terms->options['settings'] as $postType => $taxonomy) {

          add_action('created_' . $taxonomy, function($termID) {

            $taxonomy = str_replace('created_', '', current_filter());
            $this->addRewriteRule($termID, $taxonomy, true);

          }, 10, 1);

          add_action('edited_' . $taxonomy, function($termID) {

            $taxonomy = str_replace('edited_', '', current_filter());
            $this->addRewriteRule($termID, $taxonomy);

          }, 10, 1);

          add_action('delete_' . $taxonomy, function($termID) {

            $taxonomy = str_replace('delete_', '', current_filter());
            $this->removeRewriteRule($termID, $taxonomy);

          }, 10, 1);

        }

      }

    /* ---
      Rewrite rule
    --- */

      public function addRewriteRule($termID, $taxonomy, $onlyTerms = false) {

        remove_filter('term_link', [$this->core->terms->links, 'replaceLinks'], 100, 3);

        $old = get_term_link($termID, $taxonomy);

        $this->core->terms->generate->generateFriendlyUrl($termID, $taxonomy, $old);

        add_filter('term_link', [$this->core->terms->links, 'replaceLinks'], 100, 3);

        $new = get_term_link($termID, $taxonomy);
        $this->core->terms->redirects->addRedirect($termID, $old, $new);

        if (!$onlyTerms && ($new != $old)) {

          $this->refreshTermChildren($taxonomy, $termID);
          $this->refreshTermPosts($taxonomy, $termID);

        }

      }

      private function removeRewriteRule($termID, $taxonomy) {

        if (!in_array($taxonomy, $this->core->terms->options['settings']))
          return;

        $this->core->terms->generate->removeFriendlyUrl($termID);
        $this->core->terms->redirects->removeRedirect($termID);

        $this->refreshTermChildren($taxonomy);
        $this->refreshTermPosts($taxonomy);

      }

    /* ---
      Term relations
    --- */

      public function getTermRelations($termID, $taxonomy, $currentExists = false) {

        if (!in_array($taxonomy, $this->core->terms->options['settings']))
          return;

        $termIDs = [$termID];
        $terms   = get_term_children($termID, $taxonomy);

        if ($terms)
          $termIDs = array_merge($termIDs, $terms);

        $posts = get_posts([
          'posts_per_page' => -1,
          'post_type'      => array_flip($this->core->terms->options['settings'])[$taxonomy],
          'tax_query'      => [
              [
                'taxonomy'         => $taxonomy,
                'field'            => 'term_id',
                'terms'            => $termIDs,
                'include_children' => false,
                'operator'         => 'IN'
              ]
          ]
        ]);

        if (!$currentExists)
          $termIDs = array_slice($termIDs, 1);

        $this->relations[$taxonomy] = [
          'terms' => $termIDs,
          'posts' => $posts
        ];

      }

      private function refreshTermChildren($taxonomy, $termID = false) {

        if (!in_array($taxonomy, $this->core->terms->options['settings']))
          return;

        if ($termID)
          $this->getTermRelations($termID, $taxonomy, true);

        $termIDs = $this->relations[$taxonomy]['terms'];

        if (!$termIDs)
          return;

        foreach ($termIDs as $termID)
          $this->addRewriteRule($termID, $taxonomy, true);

      }

      private function refreshTermPosts($taxonomy, $termID = false) {

        if (!in_array($taxonomy, $this->core->terms->options['settings']))
          return;

        if ($termID)
          $this->getTermRelations($termID, $taxonomy, true);

        $posts = $this->relations[$taxonomy]['posts'];

        if (!$posts)
          return;

        foreach ($posts as $post)
          $this->core->posttypes->actions->addRewriteRule($post);

      }

  }