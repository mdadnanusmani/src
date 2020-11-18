<?php

  namespace Framework\Helpers;

  class Instagram {

    private $path = 'https://api.instagram.com/v1/users/self/media/recent?access_token=%s&count=%d';

    public function __construct() {

      add_filter('wpf_helper_instagram', [$this, 'instagram'], 10, 2);

    }

    /* ---
      Actions
    --- */

      public function instagram($token, $limit) {

        return $this->getInstagramImages($token, $limit);

      }

    /* ---
      Functions
    --- */

      public function getInstagramImages($token, $limit) {

        $list    = [];
        $content = $this->getPage($token, $limit);

        if (!$content)
          return $list;

        foreach ($content as $index => $image) {

          $sizes = [];

          foreach ($image['images'] as $size) {

            $width         = $size['width'];
            $sizes[$width] = $size['url'];

          }

          $data = [
            'url'      => $image['link'],
            'src'      => end($sizes),
            'sizes'    => $sizes,
            'caption'  => isset($image['caption']['text']) ? $image['caption']['text'] : '',
            'date'     => $image['created_time'],
            'stats'    => [
              'comments' => $image['comments']['count'],
              'likes'    => $image['likes']['count']
            ],
            'is_video' => ($image['type'] == 'video') ? true : false
          ];

          $data   = apply_filters('wpf_helpers_instagram_item', $data, $image);
          $list[] = $data;

        }

        return $list;

      }

      private function getPage($token, $count) {

        $url = sprintf($this->path, $token, $count);
        $ch  = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);

        if (!$response)
          return [];

        $json = json_decode($response, true);

        if (!$json || !isset($json['data']))
          return [];

        return $json['data'];

      }

  }