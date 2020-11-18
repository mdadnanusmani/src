<?php

  namespace Framework\Cache;

  class Generate {

    private $config, $cacheActive;

    public function __construct() {

      add_action('get_header', [$this, 'lockRenderPage'], 0);
      add_action('get_header', [$this, 'startContent'],   0);
      add_action('shutdown',   [$this, 'endContent'],     0);

    }

    /* ---
      Functions
    --- */

      public function lockRenderPage() {

        if (defined('WPF_CACHE_LOADED') && WPF_CACHE_LOADED)
          exit;

      }

      public function startContent() {

        if (!$this->checkCacheAbility())
          return;

        $this->cacheActive = true;
        ob_start();

      }

      private function checkCacheAbility() {

        if (is_admin() || (!is_front_page() && !is_home() && !is_archive() && !is_single()))
          return;

        if ((isset($_POST) && $_POST) || (isset($_GET) && $_GET))
          return;

        if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/(bot|crawl|slurp|spider|mediapartners|validator\.w3\.org)/i', $_SERVER['HTTP_USER_AGENT']))
          return;

        if (is_user_logged_in())
          return;

        return true;

      }

      public function endContent() {

        if (!$this->cacheActive)
          return;

        $output = ob_get_contents();
        ob_end_clean();

        $this->saveCache($output);
        echo $output;

      }

      private function saveCache($content) {

        $path = ABSPATH . '/wp-content/cache/';
        $file = str_replace('?renew_cache', '', $_SERVER['REQUEST_URI']);
        $file = trim($file, '/');
        $file = preg_replace('/\//i', '_', $file);
        $file = '_' . substr($file, 0, 249) . '.html';

        if (!file_exists($path))
          mkdir($path, 0777, true);

        $content = preg_replace('/(\r\n)+|\r+|\n+|\t+/i', ' ', $content);
        $content = preg_replace('/>\s+</', '><', $content);
        $content = preg_replace('/\s+/', ' ', $content);

        $path .= $file;
        $file  = fopen($path, 'w');
        fwrite($file, $content);

      }

  }