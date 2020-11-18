<?php

  namespace SiteManagement\Helpers;

  class Products {

    public function __construct() {

        add_filter('products_list', [$this, 'getPosts']);

    }

    /* ---
      Functions
    --- */

      public function getPosts($currentId) {

        $args = [
          'posts_per_page' => -1,
          'post_type'      => 'products',
          'post__not_in'   => [$currentId],
          'orderby'        => 'rand'
        ];

        $list  = [];
        $posts = get_posts($args);

        if (!$posts)
          return $list;

        foreach ($posts as $post)
          $list[] = $this->getPostItem($post);

        return $list;

      }

      private function getPostItem($post) {

        $header = get_field('header', $post->ID);
        $terms  = wp_get_post_terms($post->ID, 'news-category');
        $data   = [
          'icon'  => get_field('icon', $post->ID),
          'color' => get_field('product_color', $post->ID),
          'title' => $post->post_title,
          'desc'  => '',
          'link'  => [
            'url'    => get_permalink($post),
            'target' => '_self',
            'title'  => ''
          ]
        ];

        return $data;

      }

  }