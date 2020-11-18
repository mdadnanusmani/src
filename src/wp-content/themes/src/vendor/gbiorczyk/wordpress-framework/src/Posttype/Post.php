<?php

  namespace Framework\Posttype;

  class Post {

    public function __construct() {

      add_filter('register_post_type_args', [$this, 'posttypeFilter'], 10, 2);
      add_filter('register_taxonomy_args',  [$this, 'taxonomyFilter'], 10, 3);

    }

    /* ---
      Functions
    --- */

      public function posttypeFilter($args, $postType) {

        if (!in_array($postType, ['post']))
          return $args;

        $args['public']  = false;
        $args['show_ui'] = false;

        return $args;

      }

      public function taxonomyFilter($args, $taxonomy, $object) {

        if (!in_array($taxonomy, ['category', 'post_tag', 'post_format']))
          return $args;

        $args['public']  = false;
        $args['show_ui'] = false;

        return $args;

      }

  }