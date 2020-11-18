<?php

  namespace SiteManagement\Helpers;

  class _Core {

    private $core;

    public function __construct($core) {

      $this->core     = $core;
      $this->jobs     = new Jobs();
      $this->news     = new News();
      $this->people   = new People();
      $this->search   = new Search();
      $this->products = new Products();
      $this->sections = new Sections();
      $this->youtube  = new Youtube();

    }

  }