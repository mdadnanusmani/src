<?php

  namespace SiteManagement\Helpers;

  class Jobs {

    public function __construct() {

        add_filter('jobs_list', [$this, 'getPosts']);

    }

    /* ---
      Functions
    --- */

      public function getPosts() {

        $args = [
          'posts_per_page' => -1,
          'post_type'      => 'jobs',
          'meta_key'       => 'details_published',
          'orderby'        => 'meta_value_num',
          'order'          => 'DESC',
          'meta_query'     => [
            [
              'key'     => 'details_closing',
              'compare' => '>=',
              'value'   => date('Ymd')
            ]
          ]
        ];

        $list  = [
          'cats'  => [],
          'items' => []
        ];
        $posts = get_posts($args);

        if (!$posts)
          return $list;

        foreach ($posts as $post) {

          $terms           = wp_get_post_terms($post->ID, 'jobs-category');
          $list['items'][] = [
            'url'         => get_permalink($post),
            'category'    => $terms ? $terms[0]->name : '',
            'category_id' => $terms ? $terms[0]->term_id : '',
            'title'       => $post->post_title,
            'published'   => get_field('details_published', $post->ID),
            'closing'     => get_field('details_closing', $post->ID)
          ];

          if ($terms) {

            $list['cats'][$terms[0]->term_id] = [
              'id'    => $terms[0]->term_id,
              'title' => $terms[0]->name
            ];

          }

        }

        usort($list['cats'], function($a, $b) {

          if ($a['title'] == $b['title'])
            return 0;

          return $a['title'] > $b['title'];

        });

        return $list;

      }

  }