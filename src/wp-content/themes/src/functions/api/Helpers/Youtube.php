<?php

  namespace SiteManagement\Helpers;

  class Youtube {

    public function __construct() {

      add_filter('youtube_video_id', [$this, 'getVideoId']);

    }

    /* ---
      Functions
    --- */

      public function getVideoId($url) {

        preg_match('#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#', $url, $matches);

        if (!$matches)
          return $url;

        return $matches[0];

      }

  }