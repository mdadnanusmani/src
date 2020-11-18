<?php

  namespace SiteManagement\Site;

  class _Core {

    private $core;

    public function __construct($core) {

      $this->core      = $core;
      $this->date      = new Date();
      $this->login     = new Login();
      $this->mailchimp = new Mailchimp();
      $this->news      = new News();
      $this->products  = new Products();
      $this->search    = new Search();

    }

  }