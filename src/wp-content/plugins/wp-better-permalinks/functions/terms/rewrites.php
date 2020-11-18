<?php

  class Rewrites_Terms_WPBetterPermalinks {

    private $core;

    function __construct($core) {

      $this->core = $core;

    }

    /* ---
      Actions
    --- */

      public function initActions() {

        add_action('generate_rewrite_rules', [$this, 'generateRewriteRules']);
        add_filter('mod_rewrite_rules',      [$this, 'generate301Redirects'], 99);

      }

    /* ---
      Functions
    --- */

      public function generateRewriteRules($wp_rewrite) {

        if (!$this->core->terms->options['terms'])
          return;

        $list = [];

        foreach ($this->core->terms->options['terms'] as $rewrite) {

          $list[$rewrite['regex'] . '/page/([0-9]+)/?$'] = $rewrite['path'] . '&paged=$matches[1]';
          $list[$rewrite['regex'] . '/?$']               = $rewrite['path'];

        }

        $wp_rewrite->rules = $list + $wp_rewrite->rules;
        return $wp_rewrite->rules;

      }

      public function generate301Redirects($rules) {

        if (!$this->core->terms->options['terms_redirects'])
          return $rules;

        $list = [];

        $content  = PHP_EOL;
        $content .= '# BEGIN WP Better Permalinks (Terms)' . PHP_EOL;
        $content .= '  <IfModule mod_rewrite.c>' . PHP_EOL;
        $content .= '    RewriteEngine on' . PHP_EOL;

        foreach ($this->core->terms->options['terms_redirects'] as $termID => $term) {

          if (!isset($this->core->terms->options['terms'][$termID]))
            continue;

          foreach ($term['redirects'] as $redirect) {

            if ($redirect == $term['current'])
              continue;

            $content .= '    RewriteRule ^' . $redirect . '/$ /' . $term['current'] . '/ [R=301,L]' . PHP_EOL;

          }

        }

        $content .= '  </IfModule>' . PHP_EOL;
        $content .= '# END WP Better Permalinks (Terms)' . PHP_EOL;
        $content .= PHP_EOL;

        return $content . $rules;

      }

  }