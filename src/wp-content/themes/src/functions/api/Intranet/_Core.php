<?php

  namespace SiteManagement\Intranet;

  class _Core {

    private $core;

    public function __construct($core) {

      $this->core    = $core;
      $this->access  = new Access();
      $this->data    = new Data();
      $this->formats = new Formats();
      $this->roles   = new Roles();
      $this->users   = new Users();

    }

  }