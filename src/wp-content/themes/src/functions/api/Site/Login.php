<?php

  namespace SiteManagement\Site;

  class Login {

    public function __construct() {

      add_action('login_enqueue_scripts', [$this, 'removeDefaultStyles']);
      add_action('login_head',            [$this, 'addStyles']);
      add_filter('login_headerurl',       [$this, 'changeLogoUrl']);
      add_filter('login_headertitle',     [$this, 'changeLogoTitle']);
      add_action('login_footer',          [$this, 'parseForm']);
      add_action('login_footer',          [$this, 'showFooter']);

    }

    /* ---
      Functions
    --- */

      public function removeDefaultStyles() {

        wp_dequeue_style('login');

      }

      public function addStyles() {

        ?>
          <link rel="stylesheet" href="<?= get_template_directory_uri(); ?>/assets/css/styles.css?ver=<?= time(); ?>" type="text/css" media="all" />
        <?php

      }

      public function changeLogoUrl() {

        return home_url();

      }

      public function changeLogoTitle() {

        return get_bloginfo('name');

      }

      public function parseForm() {

        $content = ob_get_contents();
        $content = preg_replace('/<label(.*?)>(.*?)<br \/>/',              '<label$1><span class="placeholder">$2</span><br />', $content);
        $content = preg_replace('/<label for="rememberme"><input (.*?)>/', '<input $1><label for="rememberme">',                 $content);
        $content = preg_replace('/class="button /',                        '/class="button button--bg button--blue ',            $content);

        ob_get_clean();
        echo $content;

      }

      public function showFooter() {

        get_template_part('components/layout/footer/_core');

        ?>
          <script>
            (function() {

              window.addEventListener('load', function() {
              
                var inputs      = document.querySelectorAll('form label input');
                var toggleEvent = function(e) {

                  var label = e.currentTarget.parentNode.querySelector('.placeholder');

                  if (e.currentTarget.value || (e.currentTarget.value == '---'))
                    label.classList.add('placeholder--active');
                  else
                    label.classList.remove('placeholder--active') ;

                }

                var length = inputs.length;
                for (var i = 0; i < length; i++) {

                  if (inputs[i].value)
                    inputs[i].parentNode.querySelector('.placeholder').classList.add('placeholder--active');

                  inputs[i].addEventListener('focus', function(e) {
                    e.currentTarget.parentNode.querySelector('.placeholder').classList.add('placeholder--active');
                  });

                  inputs[i].addEventListener('blur',   toggleEvent);
                  inputs[i].addEventListener('keyup',  toggleEvent);
                  inputs[i].addEventListener('change', toggleEvent);

                }

              
              });

            })();
          </script>
        <?php

        wp_footer();

      }

  }