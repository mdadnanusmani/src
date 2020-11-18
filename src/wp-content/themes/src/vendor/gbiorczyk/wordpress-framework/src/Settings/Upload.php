<?php

  namespace Framework\Settings;

  class Upload {

    private $list;

    /* ---
      Actions
    --- */

      public function addTypesForUpload($list) {

        $this->list = $list;

        add_action('upload_mimes', [$this, 'setAllowTypes']);
        add_action('map_meta_cap', [$this, 'allowUnfilteredUpload'], 0, 2);

      }

    /* ---
      Functions
    --- */

      public function setAllowTypes($mimes) {

        if (!$this->list)
          return $mimes;

        foreach ($this->list as $extension => $type)
          $mimes[$extension] = $type;

        return $mimes;

      }

      public function allowUnfilteredUpload($caps, $cap) {

        if (!$this->list || (!array_key_exists('xls', $this->list) && !array_key_exists('xlsx', $this->list)))
          return $caps;

        if ($cap == 'unfiltered_upload') {

          $caps   = [];
          $caps[] = $cap;

        }

        return $caps;

      }

      

  }