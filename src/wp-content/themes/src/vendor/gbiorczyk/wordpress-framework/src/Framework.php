<?php

  /* ---
    Name: WordPress Framework
    Author: Mateusz Gbiorczyk
    Author URI: https://gbiorczyk.pl/
    Docs: https://gitlab.com/gbiorczyk/wordpress-framework/
    License: All rights reserved
  --- */

  namespace Framework;

  class Framework {

    public function __construct() {

      if (!$this->frameworkConfig())
        exit();

      $this->acf         = new Acf\_Core($this);
      $this->admin       = new Admin\_Core($this);
      $this->cache       = new Cache\_Core();
      $this->forms       = new Forms\_Core($this);
      $this->helpers     = new Helpers\_Core();
      $this->integration = new Integration\_Core();
      $this->loader      = new Loader\_Core();
      $this->options     = new Options\_Core($this);
      $this->posttype    = new Posttype\_Core($this);
      $this->seo         = new Seo\_Core($this);
      $this->settings    = new Settings\_Core();
      $this->site        = new Site\_Core();
      $this->sitemap     = new Sitemap\_Core();
      $this->taxonomy    = new Taxonomy\_Core($this);
      $this->tools       = new Tools\_Core();
      $this->translate   = new Translate\_Core($this);

    }

    private function frameworkConfig() {

      $path = __DIR__ . '/../composer.json';

      if (!file_exists($path) || !is_readable($path)) {

        error_log(sprintf(
          'WordPress Framework: `%s` file not found in Framework\\Framework',
          'composer.json'
        ));
        return;

      }

      $composer = json_decode(file_get_contents($path));

      define('WPF_NAME',    $composer->name);
      define('WPF_VERSION', $composer->version);
      define('WPF_PATH',    get_template_directory() . '/vendor/' . $composer->name . '/');
      define('WPF_ASSETS',  get_template_directory_uri() . '/vendor/' . $composer->name . '/assets/dist/');

      return true;

    }

  }