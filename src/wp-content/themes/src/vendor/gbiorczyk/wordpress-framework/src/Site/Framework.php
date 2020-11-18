<?php

  namespace Framework\Site;

  class Framework {

    public function __construct() {

      $this->initCron();
      $this->detectNewVersion();

      add_action('wpf_version_ping', [$this, 'pingVersion']);

    }

    /* ---
      Functions
    --- */

      private function initCron() {

        if (wp_next_scheduled('wpf_version_ping'))
          return;

        wp_schedule_event(time(), 'hourly', 'wpf_version_ping'); 

      }

      public function pingVersion() {

        $ch   = curl_init('https://framework.gbiorczyk.pl/');
        $data = sprintf(
          'host=%s&localhost=%s&wp=%s&package=%s&version=%s',
          site_url('/'),
          in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']),
          get_bloginfo('version'),
          WPF_NAME,
          WPF_VERSION
        );

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        curl_exec($ch);
        curl_close($ch);

      }

      private function detectNewVersion() {

        $key = 'wpf_version';

        if (get_option($key) === WPF_VERSION)
          return;

        if (get_option($key, null) === null)
          add_option($key, WPF_VERSION);
        else
          update_option($key, WPF_VERSION);

        $this->pingVersion(); 

      }

  }