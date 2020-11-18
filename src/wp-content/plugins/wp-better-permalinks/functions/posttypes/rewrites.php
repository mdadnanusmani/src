<?php

  class Rewrites_Posttypes_WPBetterPermalinks {

    private $core;

    function __construct($core) {

      $this->core = $core;

    }

    /* ---
      Actions
    --- */

      public function initActions() {

        add_action('generate_rewrite_rules', [$this, 'generateRewriteRules']);
        add_filter('mod_rewrite_rules',      [$this, 'generate301Redirects'], 100);

      }

    /* ---
      Functions
    --- */

      public function generateRewriteRules($wp_rewrite) {

        if (!$this->core->posttypes->options['posts'])
          return;

        $list = [];

        foreach ($this->core->posttypes->options['posts'] as $rewrite)
          $list[$rewrite['regex'] . '/?$'] = $rewrite['path'];

        $wp_rewrite->rules = $list + $wp_rewrite->rules;
        return $wp_rewrite->rules;

      }

      public function generate301Redirects($rules) {

        if (!$this->core->posttypes->options['posts_redirects'])
          return $rules;

        $list = [];

        $content  = PHP_EOL;
        $content .= '# BEGIN WP Better Permalinks (Post Types)' . PHP_EOL;
        $content .= '  <IfModule mod_rewrite.c>' . PHP_EOL;
        $content .= '    RewriteEngine on' . PHP_EOL;

        foreach ($this->core->posttypes->options['posts_redirects'] as $postID => $post) {

          if (!isset($this->core->posttypes->options['posts'][$postID]))
            continue;

          foreach ($post['redirects'] as $redirect) {

            if ($redirect == $post['current'])
              continue;

            $content .= '    RewriteRule ^' . $redirect . '/$ /' . $post['current'] . '/ [R=301,L]' . PHP_EOL;

          }

        }

        $content .= '  </IfModule>' . PHP_EOL;
        $content .= '# END WP Better Permalinks (Post Types)' . PHP_EOL;
        $content .= PHP_EOL;

        return $content . $rules;

      }

  }