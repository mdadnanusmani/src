<?php

  namespace Framework\Taxonomy;

  class Register {

    private $core, $slug, $posttypes, $args;

    public function __construct($core) {

      $this->core = $core;

    }

    /* ---
      Actions
    --- */

      public function registerNewsTaxonomy($args) {

        $this->slug      = $args['slug'];
        $this->posttypes = $args['posttypes'];
        $this->args      = $this->getTaxonomyArgs($args);

        add_action('init', [$this, 'registerTaxonomies']);

      }

    /* ---
      Functions
    --- */

      public function getTaxonomyArgs($config) {

        $args      = isset($config['args']) ? $config['args'] : [];
        $slug      = $config['slug'];
        $rewrite   = $config['rewrite'] ? $config['rewrite'] : $slug;
        $langs     = (isset($config['langs']) && $config['langs']) ? $config['langs'] : [];
        $postTypes = $config['posttypes'];

        $settings = [
          'labels'       => $this->core->taxonomy->labels->getLabels($config['labels']),
          'hierarchical' => isset($config['is_category']) ? $config['is_category'] : true,
          'rewrite'      => [
            'slug' => $rewrite
          ]
        ];

        foreach ($args as $key => $value) {

          if (!isset($settings[$key]))
            $settings[$key] = $value;
          else
            $settings[$key] = is_array($value) ? array_unique(array_merge($settings[$key], $value)) : $value;

        }

        if ($langs && isset($this->core->translate->taxonomies))
          $this->core->translate->taxonomies->translateTaxonomy($slug, $langs);

        return $settings;

      }

      public function registerTaxonomies() {

        register_taxonomy($this->slug, $this->posttypes, $this->args);

      }

  }