<?php

  namespace Framework\Loader;

  class Cssinline {

    private $path;

    /* ---
      Actions
    --- */

      public function printCss($path) {

        $this->path = $path;

        add_action('wp_head', [$this, 'printStyles'], 1000);

      }

    /* ---
      Functions
    --- */

      public function printStyles() {

        $path     = trim($this->path, '/');
        $handle   = md5($this->path);
        $themeUrl = get_template_directory_uri() . '/';
        $filePath = get_template_directory() . '/' . $path;
        $nesting  = explode('/', dirname($path));
        $content  = file_exists($filePath) ? file_get_contents($filePath) : '';
        $count    = count($nesting);

        for ($i = $count; $i > 0; $i--) {

          $replace = $themeUrl;

          if ($i < $count)
            $replace .= implode('/', array_slice($nesting, 0, ($count - $i))) . '/';

          $content = preg_replace('/(\.\.\/){' . $i . '}/i', $replace, $content);

        }

        ?>
          <style id="css-<?= $handle; ?>"><?= $content; ?></style>
        <?php

      }

  }