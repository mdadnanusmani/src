<?php

  new CacheManagement();

  class CacheManagement {

    function __construct() {

      $this->initCache();
      add_filter('wp_redirect', [$this, 'lockRedirect'], 999, 2);

    }

    /* ---
      Functions
    --- */

      private function initCache() {

        if (!isset($_SERVER['PHP_SELF']) || ($_SERVER['PHP_SELF'] != '/index.php'))
          return;

        if ((isset($_POST) && $_POST) || (isset($_GET) && $_GET))
          return;

        if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/(bot|crawl|slurp|spider|mediapartners|validator\.w3\.org)/i', $_SERVER['HTTP_USER_AGENT']))
          return;

        if ($this->isUserLoggedIn())
          return;

        $file = $this->findCacheFile();

        if (!$file)
          return;

        define('WPF_CACHE_LOADED', true);
        $this->setUserStats();

        header('Connection: close');
        ob_start();

        include $file;

        header('Content-Length:' . ob_get_length());
        ob_end_flush();
        flush();

      }

      private function isUserLoggedIn() {

        if (isset($_COOKIE) && $_COOKIE) {

          foreach ($_COOKIE as $key => $value) {
            
            if (strpos($key, 'wordpress_logged_in_') !== false)
              return true;

          }

        }

        return;

      }

      private function findCacheFile() {

        $path  = ABSPATH . '/wp-content/cache/';
        $file  = preg_replace('/\//i', '_', trim($_SERVER['REQUEST_URI'], '/')) . '.html';
        $path .= '_' . substr($file, 0, 249);

        if (!file_exists($path) || ((time() - filemtime($path)) > WPF_CACHE_TIMEOUT))
          return;

        return $path;

      }

    /* ---
      Stats
    --- */

      private function setUserStats() {

        if (isset($_COOKIE['wpf_stats_visit']))
          return;

        define('WPF_UNIQUE_USER', 1);

        date_default_timezone_set('Asia/Riyadh');
        $expires = strtotime(date('Y-m-d') . '23:59:59');
        setcookie('wpf_stats_visit', 1, $expires, '/; samesite=strict', NULL, NULL, NULL);

      }

    /* ---
      Redirect
    --- */

      public function lockRedirect($location, $status) {

        if (!defined('WPF_CACHE_LOADED') || !WPF_CACHE_LOADED)
          return $location;

        return false;

      }

  }