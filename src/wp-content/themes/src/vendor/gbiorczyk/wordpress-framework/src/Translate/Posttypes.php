<?php

  namespace Framework\Translate;

  class Posttypes {

    private $list;

    public function __construct() {

      add_filter('init',                   [$this, 'postTypeArchiveRewriteRules']);
      add_filter('init',                   [$this, 'postTypePermalinksStructure']);
      add_filter('post_type_link',         [$this, 'postTypeLinkFilter'],        10, 3);
      add_filter('post_type_archive_link', [$this, 'postTypeArchiveLinkFilter'], 10, 2);
      add_filter('pll_translation_url',    [$this, 'translationUrlFilter'],      10, 2);

    }

    /* ---
      Actions
    --- */

      public function translatePostType($slug, $list, $hasArchive = true) {

        $this->list[$slug] = [
          'translations' => $list,
          'has_archive'  => $hasArchive
        ];

      }

    /* ---
      Rewrite rules
    --- */

      public function postTypeArchiveRewriteRules() {

        if (!$this->list)
          return;

        global $wp_rewrite;
        $defaultLang = pll_default_language();

        foreach ($this->list as $postType => $data) {

          $translations = $data['translations'];
          $default      = isset($translations[$defaultLang]) ? $translations[$defaultLang] : '';

          if ($default) {

            unset($wp_rewrite->extra_rules_top[$default . '/?$']);
            unset($wp_rewrite->extra_rules_top[$default . '/page/([0-9]{1,})/?$']);

          }

          foreach ($translations as $lang => $translation) {

            if ($data['has_archive'])
              add_rewrite_rule($translation . '/?$', 'index.php?post_type=' . $postType, 'top');

            add_rewrite_rule($translation . '/page/([0-9]{1,})/?$', 'index.php?post_type=' . $postType . '&paged=$matches[1]', 'top');

          }

        }

      }

      public function postTypePermalinksStructure() {

        if (!$this->list)
          return;

        global $wp_rewrite;
        $defaultLang = pll_default_language();

        foreach ($this->list as $postType => $data) {

          $translations = $data['translations'];
          unset($wp_rewrite->extra_permastructs[$postType]);

          foreach ($translations as $lang => $translation) {

            $args = [
              'slug'      => $translation,
              'walk_dirs' => ''
            ];

            if ($lang == $defaultLang)
              add_permastruct($postType . '_' . $lang, $translation . '/%' . $postType . '%', $args);
            else
              add_permastruct($postType . '_' . $lang, '%language%/' . $translation . '/%' . $postType . '%', $args);

          }

        }

      }

    /* ---
      Links
    --- */

      public function postTypeLinkFilter($link, $post, $leavename) {

        if (!$this->list || !isset($this->list[$post->post_type]) || !in_array($post->post_status, ['publish', 'future']))
          return $link;

        $lang        = pll_get_post_language($post->ID);
        $defaultLang = pll_default_language();
        $slug        = !$leavename ? $post->post_name : '%postname%';

        if (!$lang)
          return $link;

        if ($lang != $defaultLang)
          $link = site_url('/') . $lang . '/' . $this->list[$post->post_type]['translations'][$lang] . '/' . $slug . '/';
        else
          $link = site_url('/') . $this->list[$post->post_type]['translations'][$defaultLang] . '/' . $slug . '/';

        return $link;

      }

      public function postTypeArchiveLinkFilter($link, $postType) {

        if (!$this->list || !isset($this->list[$postType]))
          return $link;

        $lang        = pll_current_language();
        $defaultLang = pll_default_language();

        if (!isset($this->list[$postType]['translations'][$lang]))
          return $link;

        if ($lang != $defaultLang)
          $link = site_url('/') . $lang . '/' . $this->list[$postType]['translations'][$lang] . '/';
        else
          $link = site_url('/') . $this->list[$postType]['translations'][$lang] . '/';

        return $link;

      }

      public function translationUrlFilter($url, $lang) {

        if (!is_archive())
          return $url;

        global $wp_query;
        $postType    = $wp_query->query_vars['post_type'];
        $defaultLang = pll_default_language();

        if (!isset($this->list[$postType]) || !isset($this->list[$postType]['translations'][$lang]))
          return $url;

        if ($lang == $defaultLang)
          $url = site_url('/') . $this->list[$postType]['translations'][$lang] . '/';
        else
          $url = site_url('/') . $lang . '/' . $this->list[$postType]['translations'][$lang] . '/';

        return $url;

      }

  }