<?php

  namespace SiteManagement;

  class SiteManagement {

    public $config;

    public function __construct() {

      $this->helpers  = new Helpers\_Core($this);
      $this->intranet = new Intranet\_Core($this);
      $this->site     = new Site\_Core($this);

    }

  }