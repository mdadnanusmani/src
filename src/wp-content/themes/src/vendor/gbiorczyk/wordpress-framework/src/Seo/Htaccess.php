<?php

  namespace Framework\Seo;

  class Htaccess {

    public function __construct() {

      add_filter('mod_rewrite_rules', [$this, 'cacheControlHeaders']);

    }

    /* ---
      Functions
    --- */

      public function cacheControlHeaders($rules) {

        if ((substr($_SERVER['REMOTE_ADDR'], 0, 4) == '127.') || ($_SERVER['REMOTE_ADDR'] == '::1'))
          return $rules;

        $this->disableCacheInAdmin();

        $content  = PHP_EOL;
        $content .= '# BEGIN Cache-Control' . PHP_EOL;
        $content .= '  <IfDefine Expires>' . PHP_EOL;
        $content .= '    Expires A25920000' . PHP_EOL;
        $content .= '  </IfDefine>' . PHP_EOL;
        $content .= PHP_EOL;
        $content .= '  <IfModule mod_expires.c>' . PHP_EOL;
        $content .= '    ExpiresActive on' . PHP_EOL;
        $content .= '    ExpiresDefault                                    "access plus 1 month"' . PHP_EOL;
        $content .= PHP_EOL;
        $content .= '    # DATA' . PHP_EOL;
        $content .= '    ExpiresByType text/xml                            "access plus 0 seconds"' . PHP_EOL;
        $content .= '    ExpiresByType text/html                           "access plus 0 seconds"' . PHP_EOL;
        $content .= '    ExpiresByType text/plain                          "access plus 0 seconds"' . PHP_EOL;
        $content .= '    ExpiresByType application/xml                     "access plus 0 seconds"' . PHP_EOL;
        $content .= '    ExpiresByType application/json                    "access plus 0 seconds"' . PHP_EOL;
        $content .= '    ExpiresByType application/rss+xml                 "access plus 1 hour"' . PHP_EOL;
        $content .= '    ExpiresByType application/atom+xml                "access plus 1 hour"' . PHP_EOL;
        $content .= '    ExpiresByType text/x-component                    "access plus 1 hour"' . PHP_EOL;
        $content .= PHP_EOL;
        $content .= '    # MANIFEST' . PHP_EOL;
        $content .= '    ExpiresByType application/x-web-app-manifest+json "access plus 0 seconds"' . PHP_EOL;
        $content .= '    ExpiresByType text/cache-manifest                 "access plus 0 seconds"' . PHP_EOL;
        $content .= PHP_EOL;
        $content .= '    # SCRIPTS' . PHP_EOL;
        $content .= '    ExpiresByType text/css                            "access plus 1 month"' . PHP_EOL; 
        $content .= '    ExpiresByType text/javascript                     "access plus 1 month"' . PHP_EOL; 
        $content .= '    ExpiresByType application/javascript              "access plus 1 month"' . PHP_EOL; 
        $content .= '    ExpiresByType application/x-javascript            "access plus 1 month"' . PHP_EOL;
        $content .= PHP_EOL;
        $content .= '    # IMAGES' . PHP_EOL;
        $content .= '    ExpiresByType image/gif                           "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType image/png                           "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType image/jpe                           "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType image/jpg                           "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType image/jpeg                          "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType image/jp2                           "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType image/pipeg                         "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType image/bmp                           "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType image/tiff                          "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType image/svg+xml                       "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType image/vnd.microsoft.icon            "access plus 1 month"' . PHP_EOL;
        $content .= PHP_EOL;
        $content .= '    # ICONS' . PHP_EOL;
        $content .= '    ExpiresByType image/ico                           "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType image/icon                          "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType text/ico                            "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType image/x-ico                         "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType image/x-icon                        "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType application/ico                     "access plus 1 month"' . PHP_EOL;
        $content .= PHP_EOL;
        $content .= '    # AUDIO' . PHP_EOL;
        $content .= '    ExpiresByType audio/ogg                           "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType audio/basic                         "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType audio/mid                           "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType audio/midi                          "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType audio/mpeg                          "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType audio/x-aiff                        "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType audio/x-mpegurl                     "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType audio/x-pn-realaudio                "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType audio/x-wav                         "access plus 1 month"' . PHP_EOL;
        $content .= PHP_EOL;
        $content .= '    # VIDEO' . PHP_EOL;
        $content .= '    ExpiresByType video/ogg                           "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType video/mp4                           "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType video/webm                          "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType video/x-msvideo                     "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType video/mpeg                          "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType video/quicktime                     "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType video/x-la-asf                      "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType video/x-ms-asf                      "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType x-world/x-vrml                      "access plus 1 month"' . PHP_EOL;
        $content .= PHP_EOL;
        $content .= '    # FONTS' . PHP_EOL;
        $content .= '    ExpiresByType font/truetype                       "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType font/opentype                       "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType application/x-font-ttf              "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType application/x-font-woff             "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType application/font-woff               "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType application/vnd.ms-fontobject       "access plus 1 month"' . PHP_EOL;
        $content .= PHP_EOL;
        $content .= '    # FLASH' . PHP_EOL;
        $content .= '    ExpiresByType application/x-shockwave-flash       "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType video/x-flv                         "access plus 1 month"' . PHP_EOL;
        $content .= PHP_EOL;
        $content .= '    # OTHERS' . PHP_EOL;
        $content .= '    ExpiresByType application/pdf                     "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType image/vnd.wap.wbmp                  "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType application/vnd.wap.wbxml           "access plus 1 month"' . PHP_EOL;
        $content .= '    ExpiresByType application/smil                    "access plus 1 month"' . PHP_EOL;
        $content .= PHP_EOL;
        $content .= '    <IfModule mod_headers.c>' . PHP_EOL;
        $content .= '      Header append Cache-Control "public"' . PHP_EOL;
        $content .= '      <FilesMatch ".(js|css|xml|gz|html)$">' . PHP_EOL;
        $content .= '        Header append Vary: Accept-Encoding' . PHP_EOL;
        $content .= '      </FilesMatch>' . PHP_EOL;
        $content .= '    </IfModule>' . PHP_EOL;
        $content .= '  </IfModule>' . PHP_EOL;
        $content .= PHP_EOL;
        $content .= '  <IfModule mod_deflate.c>' . PHP_EOL;
        $content .= '    AddOutputFilterByType DEFLATE text/plain' . PHP_EOL;
        $content .= '    AddOutputFilterByType DEFLATE text/html' . PHP_EOL;
        $content .= '    AddOutputFilterByType DEFLATE text/css' . PHP_EOL;
        $content .= '    AddOutputFilterByType DEFLATE text/javascript' . PHP_EOL;
        $content .= '    AddOutputFilterByType DEFLATE application/javascript' . PHP_EOL;
        $content .= '    AddOutputFilterByType DEFLATE application/x-javascript' . PHP_EOL;
        $content .= '  </IfModule>' . PHP_EOL;
        $content .= '# END SEO (Cache-Control' . PHP_EOL;
        $content .= PHP_EOL;

        return $content . $rules;

      }

      private function disableCacheInAdmin() {

        $content  = '# BEGIN SEO (Cache-Control)' . PHP_EOL;
        $content .= '  <IfModule mod_expires.c>' . PHP_EOL;
        $content .= '    ExpiresActive off' . PHP_EOL;
        $content .= '  </IfModule>' . PHP_EOL;
        $content .= '# END SEO (Cache-Control)';

        $file = fopen(ABSPATH . '/wp-admin/.htaccess', 'w+');
        fwrite($file, $content);

      } 

  }