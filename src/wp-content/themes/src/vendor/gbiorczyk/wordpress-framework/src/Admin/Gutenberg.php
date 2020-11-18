<?php

  namespace Framework\Admin;

  class Gutenberg {

    public $isActive = false;

    public function __construct() {

      add_filter('use_block_editor_for_post_type', [$this, 'disableGutenberg'], 10, 2);
      add_filter('gutenberg_can_edit_post_type',   [$this, 'disableGutenberg'], 10, 2);

    }

    /* ---
      Functions
    --- */

      public function disableGutenberg($isEnabled, $postType) {
          
          return $this->isActive;

      }

  }