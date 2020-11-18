<?php

  class WPBetterPermalinks {

    private $components = [];

    function __construct() {

      $this->initActions();

    }

    /* ---
      Actions
    --- */

      private function initActions() {

        $this->loadComponentsGroups();
        $this->defaultActions();

      }

    /* ---
      Load groups components
    --- */

      private function loadComponentsGroups() {

        $directories = scandir(__DIR__);

        foreach ($directories as $directory) {
          
          if (!in_array($directory, ['.', '..', '_core.php']))
            $this->loadGroupComponents($directory);

        }

      }

      private function loadGroupComponents($directory) {

        $files = scandir(__DIR__ . '/' . $directory);

        foreach ($files as $file) {

          if (!in_array($file, ['.', '..']))
            $this->loadComponent($directory, $file);

        }

      }

      private function loadComponent($directory, $file) {

        $group     = $directory;
        $component = pathinfo($file, PATHINFO_FILENAME);
        $class     = $this->generateClassName($group, $component);

        require_once __DIR__ . '/' . $directory . '/' . $file;

        if ($file == '_core.php') {

          $this->$group = new $class($this);

        } else {

          $this->$group->$component = new $class($this);
          $this->enqueueActions($group, $component);

        }

      }

      private function generateClassName($group, $component) {

        $class = ucfirst($group) . '_WPBetterPermalinks';
        
        if ($component != '_core')
          $class = ucfirst($component) . '_' . $class;

        return $class;

      }

    /* ---
      Auto-run functions
    --- */

      private function enqueueActions($group, $component) {

        if (!isset($this->components[$group]))
          $this->components[$group] = [];

        $this->components[$group][] = $component;

      }

      private function defaultActions() {

        if (!$this->components)
          return;

        foreach ($this->components as $group => $components) {
          
          if (!method_exists($this->$group, 'initCore') || !$this->$group->initCore())
            continue;

          foreach ($components as $component) {

            if (method_exists($this->$group->$component, 'initActions'))
              $this->$group->$component->initActions();

          }

        }

      }

  }