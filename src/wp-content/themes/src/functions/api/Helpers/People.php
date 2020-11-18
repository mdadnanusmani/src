<?php

  namespace SiteManagement\Helpers;

  class People {

    public function __construct() {

        add_filter('people_list', [$this, 'getPosts'], 10, 3);

    }

    /* ---
      Functions
    --- */

      public function getPosts($list) {

        $args = [
          'posts_per_page' => -1,
          'post_type'      => 'people',
          'post__in'       => $list
        ];

        $list  = [
          'cats'  => [],
          'items' => []
        ];
        $cats  = [];
        $items = [];
        $posts = get_posts($args);

        if (!$posts)
          return $list;

        foreach ($posts as $post) {

          $image = get_field('image', $post->ID);
          $terms = wp_get_post_terms($post->ID, 'people-category');

          if (!$terms)
            return;

          $items[$terms[0]->term_id][] = [
            'title'    => $post->post_title,
            'image'    => $image ? $image['sizes']['image-medium'] : '',
            'position' => get_field('position', $post->ID),
            'contacts' => get_field('contacts', $post->ID),
            'content'  => get_field('content', $post->ID)
          ];

          $cats[$terms[0]->term_id] = [
            'id'    => $terms[0]->term_id,
            'title' => $terms[0]->name
          ];

        }

        sort($items);
        foreach ($items as $item)
          $list['items'][] = $item;

        sort($cats);
        foreach ($cats as $item)
          $list['cats'][] = $item;

        return $list;

      }

  }