<?php

  namespace Framework\Settings;

  class Security {

    private $config;

    /* ---
      Actions
    --- */

      public function configSecurity($config) {

        $this->config = $config;

        $this->htaccessRules();
        $this->secureWordPress();
        $this->accessLog();

      }

    /* ---
      .htaccess
    --- */

      private function htaccessRules() {

        add_filter('mod_rewrite_rules', [$this, 'disablePHPErrors']);
        add_filter('mod_rewrite_rules', [$this, 'protectWpConfigFile']);
        add_filter('mod_rewrite_rules', [$this, 'disableIndexes']);
        add_filter('mod_rewrite_rules', [$this, 'directoryAccess']);
        add_filter('mod_rewrite_rules', [$this, 'lockAccessToFiles']);
        add_filter('mod_rewrite_rules', [$this, 'repairDatabase']);
        add_filter('mod_rewrite_rules', [$this, 'urlHacking']);
        add_filter('mod_rewrite_rules', [$this, 'HTTPHeaders']);
        add_filter('mod_rewrite_rules', [$this, 'disableXmlRpc']);
        add_filter('mod_rewrite_rules', [$this, 'userEnumeration']);

      }

      /* ---
        PHP errors
      --- */

        public function disablePHPErrors($rules) {

          $content  = PHP_EOL;
          $content .= '# BEGIN Security (PHP errors)' . PHP_EOL;
          $content .= '  <IfModule mod_php5.c>' . PHP_EOL;
          $content .= '    php_value display_startup_errors off' . PHP_EOL;
          $content .= '    php_value display_errors off' . PHP_EOL;
          $content .= '  </IfModule>' . PHP_EOL;
          $content .= '  <IfModule mod_php7.c>' . PHP_EOL;
          $content .= '    php_value display_startup_errors off' . PHP_EOL;
          $content .= '    php_value display_errors off' . PHP_EOL;
          $content .= '  </IfModule>' . PHP_EOL;
          $content .= '# END Security (PHP errors)' . PHP_EOL;
          $content .= PHP_EOL;

          return $content . $rules;

        }

      /* ---
        wp-config.php
      --- */

        public function protectWpConfigFile($rules) {

          $content  = PHP_EOL;
          $content .= '# BEGIN Security (wp-config.php)' . PHP_EOL;
          $content .= '  <Files wp-config.php>' . PHP_EOL;
          $content .= '    Order Allow,Deny' . PHP_EOL;
          $content .= '    Deny from all' . PHP_EOL;
          $content .= '  </Files>' . PHP_EOL;
          $content .= '# END Security (wp-config.php)' . PHP_EOL;
          $content .= PHP_EOL;

          return $content . $rules;

        }

      /* ---
        Directory listing
      --- */

        public function disableIndexes($rules) {

          $content  = PHP_EOL;
          $content .= '# BEGIN Security (Indexes)' . PHP_EOL;
          $content .= '  Options All -Indexes' . PHP_EOL;
          $content .= '# END Security (Indexes)' . PHP_EOL;
          $content .= PHP_EOL;

          return $content . $rules;

        }

      /* ---
        WordPress directories
      --- */

        public function directoryAccess($rules) {

          $this->robotsDirectories();

          $content  = PHP_EOL;
          $content .= '# BEGIN Security (Directory access)' . PHP_EOL;
          $content .= '  <IfModule mod_rewrite.c>' . PHP_EOL;
          $content .= '    RewriteEngine On' . PHP_EOL;
          $content .= '    RewriteBase /' . PHP_EOL;
          $content .= '    RewriteRule ^wp-admin/includes/ - [L,R=404]' . PHP_EOL;
          $content .= '    RewriteRule !^wp-includes/ - [S=3]' . PHP_EOL;
          $content .= '    RewriteRule ^wp-includes/[^/]+\.php$ - [L,R=404]' . PHP_EOL;
          $content .= '    RewriteRule ^wp-includes/js/tinymce/langs/.+\.php - [L,R=404]' . PHP_EOL;
          $content .= '    RewriteRule ^wp-includes/theme-compat/ - [L,R=404]' . PHP_EOL;

          if ($this->config['wpc_path_allow']) {

            foreach ($this->config['wpc_path_allow'] as $path) {

              $path     = trim($path, '/');
              $content .= '    RewriteCond %{REQUEST_URI} !^/' . $path . '?$' . PHP_EOL;

            }

          }

          $content .= '    RewriteRule ^wp-content/([^.]+).php?$ - [L,R=404]' . PHP_EOL;
          $content .= '  </IfModule>' . PHP_EOL;
          $content .= '# END Security (Directory access)' . PHP_EOL;
          $content .= PHP_EOL;

          return $content . $rules;

        }

        private function robotsDirectories() {

          $content  = 'User-agent: *' . PHP_EOL;
          $content .= 'Disallow: /wp-admin/' . PHP_EOL;
          $content .= 'Allow: /wp-includes/*/*.css' . PHP_EOL;
          $content .= 'Allow: /wp-includes/*/*.js' . PHP_EOL;
          $content .= 'Disallow: /wp-includes/' . PHP_EOL;
          $content .= 'Disallow: /wp-content/languages/' . PHP_EOL;
          $content .= 'Allow: /wp-content/plugins/*/*.css' . PHP_EOL;
          $content .= 'Allow: /wp-content/plugins/*/*.js' . PHP_EOL;
          $content .= 'Disallow: /wp-content/plugins/' . PHP_EOL;
          $content .= 'Allow: /wp-content/themes/*/*.css' . PHP_EOL;
          $content .= 'Allow: /wp-content/themes/*/*.js' . PHP_EOL;
          $content .= 'Allow: /wp-content/themes/*/*.eot' . PHP_EOL;
          $content .= 'Allow: /wp-content/themes/*/*.svg' . PHP_EOL;
          $content .= 'Allow: /wp-content/themes/*/*.ttf' . PHP_EOL;
          $content .= 'Allow: /wp-content/themes/*/*.woff' . PHP_EOL;
          $content .= 'Allow: /wp-content/themes/*/*.woff2' . PHP_EOL;
          $content .= 'Allow: /wp-content/themes/*/*.gif' . PHP_EOL;
          $content .= 'Allow: /wp-content/themes/*/*.jpg' . PHP_EOL;
          $content .= 'Allow: /wp-content/themes/*/*.jpeg' . PHP_EOL;
          $content .= 'Allow: /wp-content/themes/*/*.png' . PHP_EOL;
          $content .= 'Disallow: /wp-content/themes/' . PHP_EOL;
          $content .= 'Disallow: /wp-content/upgrade/' . PHP_EOL;
          $content .= 'Disallow: /*?*' . PHP_EOL;
          $content .= 'Disallow: *?replytocom' . PHP_EOL;
          $content .= 'Disallow: /archives/' . PHP_EOL;
          $content .= 'Disallow: /comments/feed/' . PHP_EOL;

          $file = fopen(ABSPATH . '/robots.txt', 'w+');
          fwrite($file, $content);

        }

      /* ---
        Safe files
      --- */

        public function lockAccessToFiles($rules) {

          $files = [
            '*.htaccess',
            '*.htpasswd',
            '*.ini',
            '*.phps',
            '*.fla',
            '*.log',
            'error_log',
            '*.sh',
            'changelog.txt',
            'license.html',
            'license.txt',
            'license.commercial.txt',
            'readme.html',
            'readme.md',
            'readme.txt',
            'install.php',
            '*.bak',
            '*.git',
            '*.svn',
            '*.sql',
            '*.tar',
            '*.tar.gz'
          ];

          $content  = PHP_EOL;
          $content .= '# BEGIN Security (Files)' . PHP_EOL;

            foreach ($files as $index => $file) {

              $regex = str_replace(['.', '*'], ['\.', '.*'], mb_strtolower($file));

              $content .= '  <files ~ "^(?i)(' . $regex . ')$">' . PHP_EOL;
              $content .= '    order allow,deny' . PHP_EOL;
              $content .= '    deny from all' . PHP_EOL;
              $content .= '  </files>' . PHP_EOL;

            }

          $content .= '# END Security (Files)' . PHP_EOL;
          $content .= PHP_EOL;

          return $content . $rules;

        }

      /* ---
        Repair database 
      --- */

        public function repairDatabase($rules) {

          $content  = PHP_EOL;
          $content .= '# BEGIN Security (Repair database)' . PHP_EOL;
          $content .= '  <IfModule mod_rewrite.c>' . PHP_EOL;
          $content .= '    RewriteEngine On' . PHP_EOL;
          $content .= '    RewriteBase /' . PHP_EOL;
          $content .= '    RewriteRule ^wp-admin/maint/repair.php?$ - [L,R=404]' . PHP_EOL;
          $content .= '  </IfModule>' . PHP_EOL;
          $content .= '# END Security (Repair database)' . PHP_EOL;
          $content .= PHP_EOL;

          return $content . $rules;

        }

      /* ---
        URL Hacking
      --- */

        public function urlHacking($rules) {

          $content  = PHP_EOL;
          $content .= '# BEGIN Security (URL Hacking)' . PHP_EOL;
          $content .= '  <IfModule mod_rewrite.c>' . PHP_EOL;
          $content .= '    RewriteEngine On' . PHP_EOL;
          $content .= '    RewriteCond %{REQUEST_METHOD} ^(HEAD|TRACE|DELETE|TRACK) [NC]' . PHP_EOL;
          $content .= '    RewriteRule ^(.*)$ - [F,L]' . PHP_EOL;
          $content .= '  </IfModule>' . PHP_EOL;
          $content .= '# END Security (URL Hacking)' . PHP_EOL;
          $content .= PHP_EOL;

          return $content . $rules;

        }

      /* ---
        Clickjacking, XSS, MIME types
      --- */

        public function HTTPHeaders($rules) {

          $content  = PHP_EOL;
          $content .= '# BEGIN Security (HTTP headers)' . PHP_EOL;
          $content .= '  <ifModule mod_headers.c>' . PHP_EOL;
          $content .= '    Header set X-XSS-Protection "1; mode=block"' . PHP_EOL;
          $content .= '    Header set X-Frame-Options "sameorigin"' . PHP_EOL;
          $content .= '    Header set X-Content-Type-Options "nosniff"' . PHP_EOL;
          $content .= '  </IfModule>' . PHP_EOL;
          $content .= '# END Security (HTTP headers)' . PHP_EOL;
          $content .= PHP_EOL;

          return $content . $rules;

        }

      /* ---
        XML-RPC
      --- */

        public function disableXmlRpc($rules) {

          $content  = PHP_EOL;
          $content .= '# BEGIN Security (XML-RPC)' . PHP_EOL;
          $content .= '  <files xmlrpc.php>' . PHP_EOL;
          $content .= '    order allow,deny' . PHP_EOL;
          $content .= '    deny from all' . PHP_EOL;
          $content .= '  </files>' . PHP_EOL;
          $content .= '# END Security (XML-RPC)' . PHP_EOL;
          $content .= PHP_EOL;

          return $content . $rules;

        }

      /* ---
        User enumeration
      --- */

        public function userEnumeration($rules) {

          $content  = PHP_EOL;
          $content .= '# BEGIN Security (User enumeration)' . PHP_EOL;
          $content .= '  <IfModule mod_rewrite.c>' . PHP_EOL;
          $content .= '    RewriteEngine On' . PHP_EOL;
          $content .= '    RewriteCond %{REQUEST_URI} ^/$' . PHP_EOL;
          $content .= '    RewriteCond %{QUERY_STRING} ^/?author=\d' . PHP_EOL;
          $content .= '    RewriteRule ^ - [L,R=404]' . PHP_EOL;
          $content .= '  </IfModule>' . PHP_EOL;
          $content .= '# END Security (User enumeration)' . PHP_EOL;
          $content .= PHP_EOL;

          return $content . $rules;

        }

    /* ---
      Secure WordPress
    --- */

      private function secureWordPress() {

        $this->PHPErrors();
        $this->autoUpdateWordpress();
        $this->WPVersion();
        $this->WPHeaders();
        $this->hideLoginPage();
        $this->loginErrors();
        $this->limitLoginAttempts();
        $this->xmlRpc();
        $this->fileEdit();
        $this->loadScriptsAndStyles();
        $this->hideUserLogins();
        $this->searchReferer();
        $this->searchString();
        $this->commentReferer();
        $this->trackback();
        $this->yoastVersion();

      }

      /* ---
        PHP errors
      --- */

        private function PHPErrors() {

          if (defined('WP_DEBUG') && (WP_DEBUG === true))
            return;

          error_reporting(0);
          @ini_set('display_errors', 0);

        }

      /* ---
        Auto-update core
      --- */

        private function autoUpdateWordpress() {

          add_filter('auto_update_core', '__return_true');

        }

      /* ---
        WP version
      --- */

        private function WPVersion() {

          add_filter('script_loader_src', [$this, 'removeWPVersion']);
          add_filter('style_loader_src',  [$this, 'removeWPVersion']);
          add_filter('the_generator',     '__return_empty_string');

        }

        public function removeWPVersion($src) {

          global $wp_version;

          parse_str(parse_url($src, PHP_URL_QUERY), $query);

          if (!empty($query['ver']) && $query['ver'] === $wp_version)
            $src = remove_query_arg('ver', $src);

          return $src;

        }

      /* ---
        Headers
      --- */

        private function WPHeaders() {

          /* REST API */
          remove_action('wp_head', 'rest_output_link_wp_head', 10);
          remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);

          /* XML-RPC */
          remove_action('wp_head', 'rsd_link');

          /* RSS feed */
          remove_action('wp_head', 'feed_links', 2);
          remove_action('wp_head', 'feed_links_extra', 3);

          /* Windows Live Writer */
          remove_action('wp_head', 'wlwmanifest_link');

          /* Link do index page */
          remove_action('wp_head', 'index_rel_link');

          /* Post Relational Links */
          remove_action('wp_head', 'start_post_rel_link', 10, 0);
          remove_action('wp_head', 'index_rel_link', 10, 0);
          remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
          remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

          /* Shortlink */
          remove_action('wp_head', 'wp_shortlink_wp_head');
          
          /* Emojicons */
          remove_action('wp_head',         'print_emoji_detection_script', 7);
          remove_action('wp_print_styles', 'print_emoji_styles');

        }

      /* ---
        Hide login page
      --- */

        private function hideLoginPage() {

          add_action('init', [$this, 'newLoginUrlRewrite']);

          if (!$this->checkNewLoginUrlRewriteExists())
            return;

          add_action('init',             [$this, 'disableDefaultPages']);
          add_action('init',             [$this, 'redirectToAdminPanel']);
          add_action('site_url',         [$this, 'redirectNewLoginUrl'], 10, 1);
          add_action('network_site_url', [$this, 'redirectNewLoginUrl'], 10, 1);
          add_action('wp_redirect',      [$this, 'redirectNewLoginUrl'], 10, 1);

        }

        public function newLoginUrlRewrite() {

          add_rewrite_rule(trim($this->config['login_url'], '/'), 'wp-login.php', 'top');

        }

        public function checkNewLoginUrlRewriteExists() {

          $path    = ABSPATH . '/.htaccess';
          $content = file_exists($path) ? file_get_contents($path) : '';

          if (strpos($content, 'RewriteRule ^' . trim($this->config['login_url'], '/')) !== false)
            return true;

          return;

        }

        public function disableDefaultPages() {

          $isAdmin = (is_admin() && !is_user_logged_in() && !defined('DOING_AJAX'));
          $isLogin = ((strpos($_SERVER['REQUEST_URI'], '/login') === 0) || (strpos($_SERVER['REQUEST_URI'], '/wp-login.php') === 0));

          if ($isAdmin || $isLogin)
            wp_die(__('This page is locked.', 'lang'), 404);

        }

        public function redirectToAdminPanel() {

          if (!is_user_logged_in() || !isset($_SERVER['SCRIPT_FILENAME']) || (strpos($_SERVER['SCRIPT_FILENAME'], 'wp-login.php') === false))
            return;

          wp_redirect(admin_url());

        }

        public function redirectNewLoginUrl($url) {

          if (!is_user_logged_in() && isset($_SERVER['SCRIPT_FILENAME']) && (strpos($_SERVER['SCRIPT_FILENAME'], 'wp-login.php') === false))
            return $url;

          $url = str_replace('wp-login.php', trim($this->config['login_url'], '/'), $url);
          return $url;

        }

      /* ---
        Limit login attempts
      --- */

        private function limitLoginAttempts() {

          add_action('wp_login_failed', [$this, 'detectFailedLogin']);
          add_action('init',            [$this, 'protectBruteForce']);

        }

        public function detectFailedLogin() {

          $key   = 'failed_login_' . base64_encode($_SERVER['REMOTE_ADDR']);
          $value = get_transient($key);
          $value = ($value && is_numeric($value)) ? ($value + 1) : 1;

          delete_transient($key);
          set_transient($key, $value, (15 * MINUTE_IN_SECONDS));

        }

        public function protectBruteForce() {

          if (!isset($_SERVER['SCRIPT_FILENAME']) || (strpos($_SERVER['SCRIPT_FILENAME'], 'wp-login.php') === false))
            return;

          $key   = 'failed_login_' . base64_encode($_SERVER['REMOTE_ADDR']);
          $value = get_transient($key);

          if (!$value || ($value < 5))
            return;

          wp_die(__('This page is locked.', 'lang'), 404);

        }

      /* ---
        Login errors
      --- */

        private function loginErrors() {

          add_filter('login_errors', function() {

            return sprintf(
              __('%sERROR%s: An error occured. Try again.', 'lang'),
              '<strong>',
              '</strong>'
            );

          });

        }

      /* ---
        XML-RPC
      --- */

        private function xmlRpc() {

          add_filter('xmlrpc_enabled',                  '__return_false');
          add_filter('pre_update_option_enable_xmlrpc', '__return_false');
          add_filter('pre_option_enable_xmlrpc',        '__return_zero');
          add_filter('xmlrpc_methods',                  '__return_empty_array', PHP_INT_MAX);

        }

      /* ---
        File edit
      --- */

        private function fileEdit() {

          if (defined('DISALLOW_FILE_EDIT'))
            return;

          define('DISALLOW_FILE_EDIT', true);

        }

      /* ---
        Load concatenate JS & CSS files
      --- */

        private function loadScriptsAndStyles() {

          add_filter('mod_rewrite_rules', [$this, 'lockLoadScriptsAndStylesFiles']);

          if (!is_user_logged_in())
            define('CONCATENATE_SCRIPTS', false);

        }

        public function lockLoadScriptsAndStylesFiles($rules) {

          $content  = PHP_EOL;
          $content .= '# BEGIN Security (load JS & CSS)' . PHP_EOL;
          $content .= '  <IfModule mod_rewrite.c>' . PHP_EOL;
          $content .= '    RewriteEngine on' . PHP_EOL;
          $content .= '    RewriteCond %{REQUEST_FILENAME} ^.*wp-admin/load-scripts.php$ [OR]' . PHP_EOL;
          $content .= '    RewriteCond %{REQUEST_FILENAME} ^.*wp-admin/load-styles.php$' . PHP_EOL;
          $content .= '    RewriteCond %{HTTP_COOKIE} !^.*wordpress_logged_in.*$ [NC]' . PHP_EOL;
          $content .= '    RewriteRule ^ - [L,R=404]' . PHP_EOL;
          $content .= '  </IfModule>' . PHP_EOL;
          $content .= '# END Security (load JS & CSS)' . PHP_EOL;
          $content .= PHP_EOL;

          return $content . $rules;

        }

      /* ---
        Hide user logins
      --- */

        private function hideUserLogins() {

          add_action('rest_prepare_user', [$this, 'replaceUserLogins'], 10, 3);

        }

        public function replaceUserLogins($user, $request, $creating) {

          $login    = $request->data->user_login;
          $sanitize = sanitize_title($login);

          if ((strpos($user->data['name'], $login) !== false) || (strpos($user->data['name'], $sanitize) !== false))
            $user->data['name'] = '*******';

          if ((strpos($user->data['slug'], $login) !== false) || (strpos($user->data['slug'], $sanitize) !== false))
            $user->data['slug'] = '*******';

          if ((strpos($user->data['link'], $login) !== false) || (strpos($user->data['link'], $sanitize) !== false))
            $user->data['link'] = '*******';

          return $user;

        }

      /* ---
        Search verify
      --- */

        private function searchReferer() {

          add_action('parse_query', [$this, 'verifySearchReferer']);

        }

        public function verifySearchReferer() {

          if (!is_search() || !isset($_SERVER['HTTP_REFERER']) || !$_SERVER['HTTP_REFERER'])
            return;

          if (parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) != parse_url(home_url('/'), PHP_URL_HOST))
            die();

        }

      /* ---
        Search string
      --- */

        private function searchString() {

          if (!isset($_GET['s']) || !$_GET['s'])
            return;

          $_GET['s'] = htmlspecialchars($_GET['s'], ENT_NOQUOTES);

        }

      /* ---
        Comment verify
      --- */

        private function commentReferer() {

          add_filter('comment_form',        [$this, 'commentTemplate']);
          add_filter('pre_comment_on_post', [$this, 'checkCommentReferer']);

        }

        public function commentTemplate() {

          ?>
            <input type="hidden" name="comment_referer" value="1">
          <?php

        }

        public function checkCommentReferer() {

          if (!isset($_POST['comment_referer']))
            die();

        }

      /* ---
        Disable trackbacks
      --- */

        private function trackback() {

          add_action('wp', function() {

            if (is_trackback())
              die();

          });

        }

      /* ---
        Yoast SEO version
      --- */

        private function yoastVersion() {

          add_action('get_header', [$this, 'yoastHeaderStart']);
          add_action('wp_head',    [$this, 'yoastHeaderEnd'], 999);

        }

        public function yoastHeaderStart() {

          ob_start(function($output) {
            return preg_replace('/\n?<.*?yoast.*?>/mi','', $output);
          });

        }

        public function yoastHeaderEnd() {

          ob_end_flush();

        }

    /* ---
      Access log
    --- */

      private function accessLog() {

        $this->removeOlderLogs();

        add_action('template_redirect', [$this, 'addAccessLog']);
        add_action('shutdown',          [$this, 'addAccessLog']);

      }

      private function removeOlderLogs() {

        if (get_transient('wpf_remove_logs') !== false)
          return;

        set_transient('wpf_remove_logs', true, DAY_IN_SECONDS);
        $path = ABSPATH . 'wp-content/logs/';

        if (!file_exists($path))
          return;

        $expires  = time() - (3 * MONTH_IN_SECONDS);
        $path    .= '*-{users,visitors}.log';
        $files    = glob($path, GLOB_BRACE);

        if (!$files)
          return;

        foreach ($files as $file) {

          if (filemtime($file) < $expires)
            unlink($file);

        }

      }

      public function addAccessLog() {

        remove_action('template_redirect', [$this, 'addAccessLog']);
        remove_action('shutdown',          [$this, 'addAccessLog']);

        if ((defined('REST_REQUEST') && REST_REQUEST) || (defined('DOING_AJAX') && DOING_AJAX))
          return;

        $path = urldecode($_SERVER['REQUEST_URI']);
        $file = basename(parse_url($path, PHP_URL_PATH));
        $code = http_response_code();

        if (in_array($file, ['admin-ajax.php', 'wp-cron.php']) || in_array($code, [301, 302]))
          return;

        $user = is_user_logged_in() ? wp_get_current_user() : false;
        $data = [
          'ip'       => str_pad($_SERVER['REMOTE_ADDR'], 15, ' ', STR_PAD_RIGHT),
          'date'     => $this->getCurrentTime(),
          'username' => $user ? $user->user_login : '',
          'method'   => $_SERVER['REQUEST_METHOD'],
          'path'     => $path,
          'port'     => $_SERVER['SERVER_PORT'],
          'code'     => $code,
          'agent'    => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '',
          'referer'  => isset($_SERVER['HTTP_REFERER']) ? urldecode($_SERVER['HTTP_REFERER']) : ''
        ];

        $log = sprintf(
          '%s - [%s]%s "%s %s :%s" %s - %s%s' . PHP_EOL,
          $data['ip'],
          $data['date']['time'],
          $data['username'] ? (' {' . $data['username'] . '}') : '',
          $data['method'],
          $data['path'],
          $data['port'],
          $data['code'],
          $data['agent'],
          ($data['referer'] && (strpos($data['referer'], site_url('/')) === false)) ? (' [' . $data['referer'] . ']') : ''
        );

        $path  = $this->createDirectory();
        $path .= $data['date']['file'] . '-' . ($user ? 'users' : 'visitors') . '.log';
        $file  = fopen($path, 'a');
        fwrite($file, $log);
        fclose($file);

      }

      private function getCurrentTime() {

        $date = new \DateTime();
        $date->setTimezone(new \DateTimeZone(get_option('timezone_string')));

        $data = [
          'file' => $date->format('Ymd'),
          'time' => $date->format('d-M-Y H:i:s e')
        ];

        return $data;

      }

      private function createDirectory() {

        $path = ABSPATH . 'wp-content/logs/';

        if (!file_exists($path)) {

          mkdir($path, 0775, true);
          chmod($path, 0775);

        }

        return $path;

      }

  }