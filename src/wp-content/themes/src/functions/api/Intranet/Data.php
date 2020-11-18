<?php

  namespace SiteManagement\Intranet;

  class Data {

    public function __construct() {

      add_filter('intranet_data', [$this, 'getData']);

    }

    /* ---
      Functions
    --- */

      public function getData() {

        $list  = [];
        $posts = get_posts([
          'posts_per_page' => -1,
          'post_type'      => 'intranet'
        ]);

        if (!$posts)
          return $list;

        foreach ($posts as $post) {

          $terms = wp_get_post_terms($post->ID, 'intranet-category');

          if (!$terms)
            continue;

          $termID = $terms[0]->term_id;

          if (!isset($list[$termID]))
            $list[$termID] = $this->getTermItem($terms[0]);

          $list[$termID]['items'][] = $this->getPostItem($post, $terms[0]);

        }

        usort($list, function($a, $b) {

          if ($a['priority'] == $b['priority'])
            return 0;

          return $a['priority'] > $b['priority'];

        });

        return $list;

      }

      public function getTermItem($term) {

        $data = [
          'id'       => $term->term_id,
          'priority' => get_field('priority', $term->taxonomy . '_' . $term->term_id),
          'icon'     => get_field('icon', $term->taxonomy . '_' . $term->term_id),
          'title'    => $term->name,
          'items'    => []
        ];

        return $data;

      }

      public function getPostItem($post, $term) {

        $type = get_field('content_type', $term->taxonomy . '_' . $term->term_id);
        $data = [
          'url'   => '',
          'date'  => '',
          'title' => $post->post_title,
          'logo'  => ''
        ];

        if ($type == 'page')
          $data['url'] = get_permalink($post);

        if ($type == 'file')
          $data['url'] = get_field('file', $post->ID);

        if ($type == 'link') {

          $image        = get_field('image', $post->ID);
          $data['url']  = get_field('link', $post->ID);
          $data['logo'] = $image ? $image['url'] : '';
          $data['desc'] = get_field('desc', $post->ID);

        }

        if (get_field('show_date', $term->taxonomy . '_' . $term->term_id))
          $data['date'] = date_i18n(get_option('date_format'), strtotime($post->date));

        return $data;

      }

  }