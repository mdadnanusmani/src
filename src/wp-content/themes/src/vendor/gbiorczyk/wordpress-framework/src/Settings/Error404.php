<?php

  namespace Framework\Settings;

  class Error404 {

    public function __construct() {

      add_filter('mod_rewrite_rules', [$this, 'notExistsFileRedirect']);

    }

    /* ---
      Functions
    --- */

      public function notExistsFileRedirect($rules) {

        $content  = PHP_EOL;
        $content .= '# BEGIN 404' . PHP_EOL;
        $content .= '  <IfModule mod_rewrite.c>' . PHP_EOL;
        $content .= '    RewriteEngine on' . PHP_EOL;
        $content .= '    RewriteCond %{REQUEST_FILENAME} !-f' . PHP_EOL;
        $content .= '    RewriteCond %{REQUEST_URI} ^/.*\.(gif|jpeg|jpg|png|svg|css|js|eot|woff|woff2|ttf)$ [NC]' . PHP_EOL;
        $content .= '    RewriteRule ^ - [L,R=404]' . PHP_EOL;
        $content .= '  </IfModule>' . PHP_EOL;
        $content .= '# END 404' . PHP_EOL;
        $content .= PHP_EOL;

        return $content . $rules;

      }

  }