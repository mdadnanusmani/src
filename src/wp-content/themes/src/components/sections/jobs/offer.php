<?php

  $info  = get_field('info');
  $terms = wp_get_post_terms($post->ID, 'jobs-category');

?>
<section class="offerSection section">
  <div class="offerSection__inner">
    <div class="offerSection__wrapper">
      <div class="container">
        <div class="row">
          <div class="col-8 col-mdl-12">
            <div class="offerSection__content">
              <h1 class="offerSection__title hideScroll hideScroll--left"><?= get_the_title(); ?></h1>
              <?php if ($terms) : ?>
                <div class="offerSection__position hideScroll"><?= $terms[0]->name; ?></div>
              <?php endif; ?>
              <div class="offerSection__text wysiwyg hideScroll"><?= get_field('content'); ?></div>
              <?php if ($info) : ?>
                <div class="offerSection__benefits">
                  <h3 class="offerSection__benefitsTitle hideScroll hideScroll--left"><?= $info['headline']; ?></h3>
                  <ul class="offerSection__benefitsItems">
                    <?php foreach ($info['items'] as $index => $item) : ?>
                      <li class="offerSection__benefitsItem icon-<?= $item['icon']; ?> hideScroll">
                        <h4 class="offerSection__benefitsItemTitle"><?= $item['title']; ?></h4>
                        <div class="offerSection__benefitsItemDesc"><?= $item['desc']; ?></div>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              <?php endif; ?>
            </div>
          </div>
          <div class="col-4 col-mdl-12">
            <div class="offerSection__box hideScroll hideScroll--right">
              <div class="offerSection__boxInner">
                <h5 class="offerSection__boxTitle"><?= __('Offer details', 'lang'); ?></h5>
                <ul class="offerSection__boxRows">
                  <?php if (get_field('details_published')) : ?>
                    <li class="offerSection__boxRow">
                      <div class="offerSection__boxRowLabel"><?= __('Published', 'lang'); ?></div>
                      <div class="offerSection__boxRowValue"><?= get_field('details_published'); ?></div>
                    </li>
                  <?php endif; ?>
                  <?php if (get_field('details_closing')) : ?>
                    <li class="offerSection__boxRow">
                      <div class="offerSection__boxRowLabel"><?= __('Closing', 'lang'); ?></div>
                      <div class="offerSection__boxRowValue"><?= get_field('details_closing'); ?></div>
                    </li>
                  <?php endif; ?>
                  <?php if (get_field('details_location')) : ?>
                    <li class="offerSection__boxRow">
                      <div class="offerSection__boxRowLabel"><?= __('Location', 'lang'); ?></div>
                      <div class="offerSection__boxRowValue"><?= get_field('details_location'); ?></div>
                    </li>
                  <?php endif; ?>
                  <?php if (get_field('details_expertise_level')) : ?>
                    <li class="offerSection__boxRow">
                      <div class="offerSection__boxRowLabel"><?= __('Expertise level', 'lang'); ?></div>
                      <div class="offerSection__boxRowValue"><?= get_field('details_expertise_level'); ?></div>
                    </li>
                  <?php endif; ?>
                  <?php if (get_field('details_employment_type')) : ?>
                    <li class="offerSection__boxRow">
                      <div class="offerSection__boxRowLabel"><?= __('Type of employment', 'lang'); ?></div>
                      <div class="offerSection__boxRowValue"><?= get_field('details_employment_type'); ?></div>
                    </li>
                  <?php endif; ?>
                  <?php if (get_field('details_reference')) : ?>
                    <li class="offerSection__boxRow">
                      <div class="offerSection__boxRowLabel"><?= __('Reference No.', 'lang'); ?></div>
                      <div class="offerSection__boxRowValue"><?= get_field('details_reference'); ?></div>
                    </li>
                  <?php endif; ?>
                  <?php if (get_field('details_nationality')) : ?>
                    <li class="offerSection__boxRow">
                      <div class="offerSection__boxRowLabel"><?= __('Nationality', 'lang'); ?></div>
                      <div class="offerSection__boxRowValue"><?= get_field('details_nationality'); ?></div>
                    </li>
                  <?php endif; ?>
                  <?php if (get_field('details_vacancies')) : ?>
                    <li class="offerSection__boxRow">
                      <div class="offerSection__boxRowLabel"><?= __('Number of vacancies', 'lang'); ?></div>
                      <div class="offerSection__boxRowValue"><?= get_field('details_vacancies'); ?></div>
                    </li>
                  <?php endif; ?>
                </ul>
                <div class="offerSection__boxButtonWrapper">
                  <a href="#apply-now" class="offerSection__boxButton button--border button--blue button--large"><?= __('Apply now', 'lang'); ?></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>