<?php

  namespace SiteManagement\Helpers;

  class News {

    public function __construct() {

        add_filter('news_list', [$this, 'getPosts'],    10, 3);
        add_filter('news_data', [$this, 'getPostItem'], 10, 1);

    }

    /* ---
      Functions
    --- */

      public function getPosts($sortBy, $count = 3, $currentId = 0) {

        $args = [
          'posts_per_page' => $count,
          'post_type'      => 'news',
          'post__not_in'   => [$currentId]
        ];

        if ($sortBy == 'views') {

          $args = array_merge($args, [
            'meta_key' => 'views_count',
            'orderby'  => 'meta_value_num',
            'order'    => 'DESC'
          ]);

        } else if ($sortBy == 'rand') {

          $args = array_merge($args, [
            'orderby' => 'rand'
          ]);

        } else {

          $args = array_merge($args, [
            'orderby' => 'date',
            'order'   => 'DESC'
          ]);

        }

        $list  = [];
        $posts = get_posts($args);

        if (!$posts)
          return $list;

        foreach ($posts as $post)
          $list[] = $this->getPostItem($post);

        return $list;

      }

      public function getPostItem($post) {

        $header = get_field('header', $post->ID);
        $terms  = wp_get_post_terms($post->ID, 'news-category');
        $data   = [
          'url'           => get_permalink($post),
          'category'      => $terms ? $terms[0]->name : '',
          'category_url'  => $terms ? get_term_link($terms[0]->term_id, $terms[0]->taxonomy) : '',
          'category_icon' => $terms ? get_field('icon', $terms[0]->taxonomy . '_' . $terms[0]->term_id) : '',
          'date'          => get_the_time('F d, Y', $post->ID),
          'title'         => $post->post_title,
          'image'         => $header['bg_image'] ? $header['bg_image']['sizes']['image-medium'] : '',
          'desc'          => $header['desc']     ? ((strlen($header['desc']) > 80) ? (substr($header['desc'], 0, 80) . '...') : $header['desc']) : '',
          'desc_full'     => $header['desc'],
          'author'        => get_the_author_meta('first_name', $post->post_author) . ' ' . get_the_author_meta('last_name', $post->post_author)
        ];

        return $data;

      }

  }