<footer class="footer">
  <div class="footer__inner">
    <div class="container">
      <div class="row">
        <div class="col-8 col-md-12">
          <?php

            if (!is_post_type_archive('intranet') && !is_singular('intranet'))
              get_template_part('components/layout/footer/menu');
            else
              get_template_part('components/layout/footer/intranet');

          ?>
        </div>
        <div class="col-4 col-md-8 offset-col-md-2 col-sml-12">
          <div class="footer__links hideScroll hideScroll--right">
            <?php

              get_template_part('components/layout/footer/partners');
              get_template_part('components/layout/footer/socials');

            ?>
          </div>
          <?php

            if (!is_post_type_archive('intranet') && !is_singular('intranet'))
              get_template_part('components/layout/footer/newsletter');

          ?>
        </div>
      </div>
      <div class="footer__bottom">
        <div class="footer__copyright hideScroll hideScroll--left"><?= strip_tags(get_field('footer_copyright', 'option'), '<a>'); ?></div>
        <div class="footer__author hideScroll hideScroll--right"><?= strip_tags(get_field('footer_author', 'option'), '<a>'); ?></div>
      </div>
    </div>
  </div>
</footer>