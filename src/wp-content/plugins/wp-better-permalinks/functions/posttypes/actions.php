<?php

  class Actions_Posttypes_WPBetterPermalinks {

    private $core;

    function __construct($core) {

      $this->core = $core;

    }

    /* ---
      Actions
    --- */

      public function initActions() {

        add_action('save_post',      [$this, 'initAddRewriteRule'], 10, 3);
        add_action('delete_post',    [$this, 'removeRewriteRule'],  10);

      }

    /* ---
      Functions
    --- */

      public function initAddRewriteRule($postID, $post, $update) {

        if (!array_key_exists($post->post_type, $this->core->posttypes->options['settings']) || !in_array($post->post_status, ['publish', 'future']))
          return;

        $this->addRewriteRule($post);

      }

      public function addRewriteRule($post) {

        global $wp_rewrite;

        remove_filter('post_type_link', [$this->core->posttypes->links, 'replaceLinks'], 100, 3);
        $old = get_permalink($post->ID);
        add_filter('post_type_link', [$this->core->posttypes->links, 'replaceLinks'], 100, 3);

        $post = get_post($post->ID);
        $this->core->posttypes->generate->generateFriendlyUrl($post, $old);

        $new = get_permalink($post->ID);
        $this->core->posttypes->redirects->addRedirect($post->ID, $old, $new);

      }

      public function removeRewriteRule($postID) {

        if (!isset($this->core->posttypes->options['posts'][$postID]))
          return;

        $this->core->posttypes->generate->removeFriendlyUrl($postID);
        $this->core->posttypes->redirects->removeRedirect($postID);

      }

  }