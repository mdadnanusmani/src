<?php

  namespace SiteManagement\Helpers;

  class Search {

    public function __construct() {

        add_filter('search_item', [$this, 'getPostItem'], 10, 1);

    }

    /* ---
      Functions
    --- */

      public function getPostItem($post) {

        $postType = get_post_type_object(get_post_type($post));
        $data     = [
          'url'      => get_permalink($post),
          'category' => $postType->labels->name,
          'date'     => date_i18n(get_option('date_format'), strtotime($post->date)),
          'title'    => $post->post_title
        ];

        return $data;

      }

  }