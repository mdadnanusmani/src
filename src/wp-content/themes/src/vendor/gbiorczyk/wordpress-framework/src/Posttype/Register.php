<?php

  namespace Framework\Posttype;

  class Register {

    private $core, $slug, $args;

    public function __construct($core) {

      $this->core = $core;

    }

    /* ---
      Actions
    --- */

      public function registerNewsPostType($args) {

        $this->slug = $args['slug'];
        $this->args = $this->getPostTypeArgs($args);

        add_action('init', [$this, 'registerPostTypes']);

        $menu = new Menu();
        $menu->addSeparator();

      }

    /* ---
      Functions
    --- */

      private function getPostTypeArgs($config) {

        $args    = isset($config['args']) ? $config['args'] : [];
        $slug    = $config['slug'];
        $rewrite = $config['rewrite'] ? $config['rewrite'] : $slug;
        $langs   = (isset($config['langs']) && $config['langs']) ? $config['langs'] : [];
        $labels  = new Labels($config['labels']);

        $settings = [
          'labels'        => $this->core->posttype->labels->getLabels($config['labels']),
          'public'        => true,
          'has_archive'   => true,
          'rewrite'       => [
            'slug' => $rewrite
          ],
          'menu_position' => 30,
          'menu_icon'     => $config['icon'],
          'supports'      => ['title', 'revisions']
        ];

        foreach ($args as $key => $value) {

          if (!isset($settings[$key]))
            $settings[$key] = $value;
          else
            $settings[$key] = is_array($value) ? array_unique(array_merge($settings[$key], $value)) : $value;

        }

        if ($langs && isset($this->core->translate->posttypes))
          $this->core->translate->posttypes->translatePostType($slug, $langs, $settings['has_archive']);

        return $settings;

      }

      public function registerPostTypes() {

        register_post_type($this->slug, $this->args);

      }

  }