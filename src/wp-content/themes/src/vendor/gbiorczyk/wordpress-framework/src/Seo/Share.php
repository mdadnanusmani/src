<?php

  namespace Framework\Seo;

  class Share {

    public function __construct() {

      add_action('acf/save_post', [$this, 'cacheSettings']);
      add_action('wp_head',       [$this, 'showTags']);

    }

    /* ---
      Cache
    --- */

      public function cacheSettings($postID) {

        if (($postID != 'options') || !isset($_GET['page']) || ($_GET['page'] != 'wpf-seo-share'))
          return;

        $settings = $this->getSettings();
        $this->saveSettings($settings);

      }

      private function getSettings() {

        $default    = get_field('wpf_seo_share_default',    'option');
        $posttypes  = get_field('wpf_seo_share_posttypes',  'option');
        $taxonomies = get_field('wpf_seo_share_taxonomies', 'option');

        $list            = [];
        $list['default'] = $this->getItemData($default);

        if ($posttypes) {

          foreach ($posttypes as $posttype) {

            $key = 'posttype-' . $posttype['wpf_seo_share_posttype'];
            $data = $this->getItemData($posttype);

            if ($data)
              $list[$key] = $this->getItemData($data);

          }

        }

        if ($taxonomies) {

          foreach ($taxonomies as $taxonomy) {

            $key  = 'taxonomy-' . $posttype['wpf_seo_share_taxonomy'];
            $data = $this->getItemData($taxonomy);

            if ($data)
              $list[$key] = $this->getItemData($data);

          }

        }

        return $list;

      }

      private function getItemData($item) {

        $data = [
          'title' => isset($item['title']) ? $item['title'] : '',
          'desc'  => isset($item['desc']) ? $item['desc'] : '',
          'image' => []
        ];

        if (isset($item['image']) && $item['image']) {

          $data['image'] = [
            'url'    => isset($item['image']['url'])    ? $item['image']['url']    : '',
            'width'  => isset($item['image']['width'])  ? $item['image']['width']  : '',
            'height' => isset($item['image']['height']) ? $item['image']['height'] : ''
          ];

        }

        foreach ($data as $key => $value) {

          if (($value == '') || ($value == []))
            unset($data[$key]);

        }

        return $data;

      }

      private function saveSettings($list) {

        if (get_option('wpf_og_settings', null) !== null)
          update_option('wpf_og_settings', $list);
        else
          add_option('wpf_og_settings', $list);

      }

    /* ---
      Tags
    --- */

      public function showTags() {

        $enable = (function_exists('get_field') && get_field('wpf_seo_share_active', 'option'));

        if (!$enable)
          return;

        $global  = $this->getGlobalSettings();
        $current = is_archive() ? $global : $this->getItemData(get_field('wpf_seo_share'));
        $data    = array_merge($global, $current);

        ?>
          <?php if (isset($current['title'])) : ?>
            <meta property="og:title" content="<?= $current['title']; ?>" />
          <?php endif; ?>
          <?php if (isset($current['desc'])) : ?>
            <meta name="description" content="<?= $current['desc']; ?>" />
            <meta property="og:description" content="<?= $current['desc']; ?>" />
          <?php endif; ?>
          <?php if (isset($data['image'])) : ?>
            <meta property="og:image" content="<?= $data['image']['url']; ?>" />
            <meta property="og:image:width" content="<?= $data['image']['width']; ?>" />
            <meta property="og:image:height" content="<?= $data['image']['height']; ?>" />
          <?php endif; ?>
        <?php

      }

      private function getGlobalSettings() {

        global $wp_query;

        if (!isset($wp_query->queried_object))
          return [];

        $settings = get_option('wpf_og_settings', []);
        $global   = isset($settings['default']) ? $settings['default'] : [];

        if (isset($wp_query->queried_object->post_type)) {

          $key  = 'posttype-' . $wp_query->queried_object->post_type;
          $data = isset($settings[$key]) ? $settings[$key] : [];

          if ($data)
            return array_merge($global, $data);

        } else if (isset($wp_query->queried_object->taxonomy)) {

          $key  = 'taxonomy-' . $wp_query->queried_object->taxonomy;
          $data = isset($settings[$key]) ? $settings[$key] : [];

          if ($data)
            return array_merge($global, $data);

        }

        return $global;

      }

  }