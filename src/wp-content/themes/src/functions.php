<?php

  /* ---
    Name: WordPress Framework
    Author: Mateusz Gbiorczyk
    Docs: https://gitlab.com/gbiorczyk/wordpress-framework/
    License: All rights reserved
  --- */

  require_once 'vendor/autoload.php';
  $framework  = new Framework\Framework();
  $management = new SiteManagement\SiteManagement();

  $path = 'functions/framework/';
  require_once $path . 'post-types.php';
  require_once $path . 'taxonomies.php';
  require_once $path . 'translate.php';
  require_once $path . 'include.php';
  require_once $path . 'acf.php';
  require_once $path . 'admin.php';
  require_once $path . 'settings.php';
  require_once $path . 'cache.php';
  require_once $path . 'forms.php';
  require_once $path . 'tools.php';