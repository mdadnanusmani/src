<?php

  $list = apply_filters('jobs_list', null);

  if ($list['cats'] && $list['items']) :

?>
  <section class="jobsList section <?= apply_filters('section_classes', $section); ?>" <?= apply_filters('section_name', $section); ?>>
    <div class="jobsList__inner">
      <div class="container">
        <div class="section__header">
          <h3 class="jobsList__headline section__headline hideScroll hideScroll--left"><?= $section['headline']; ?></h3>
          <div class="jobsList__select hideScroll hideScroll--right">
            <select class="jobsList__selectField">
              <option value=""><?= __('All Departments', 'lang'); ?></option>
              <?php foreach ($list['cats'] as $index => $item) : ?>
                <option value="<?= $item['id']; ?>"><?= $item['title']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="jobsList__table hideScroll">
          <div class="jobsList__header">
            <div class="row">
              <div class="col-7 offset-col-1 col-mdl-6">
                <div class="jobsList__headerLabel"><?= __('Position', 'lang'); ?></div>
              </div>
              <div class="col-2 col-mdl-3">
                <div class="jobsList__headerLabel"><?= __('Posted', 'lang'); ?></div>
              </div>
              <div class="col-2 col-mdl-3">
                <div class="jobsList__headerLabel"><?= __('Closing', 'lang'); ?></div>
              </div>
            </div>
          </div>
          <div class="jobsList__items" data-page-limit="<?= $section['items_per_page']; ?>">
            <?php foreach ($list['items'] as $index => $item) : ?>
              <a href="<?= $item['url']; ?>" class="jobsList__item <?= ($index < $section['items_per_page']) ? 'jobsList__item--active' : ''; ?>" data-category="<?= $item['category_id']; ?>">
                <div class="row">
                  <div class="col-7 offset-col-1 col-mdl-6 col-md-12">
                    <h5 class="jobsList__itemTitle"><?= $item['title']; ?></h5>
                    <div class="jobsList__itemDesc"><?= $item['category']; ?></div>
                  </div>
                  <div class="col-2 col-mdl-3 col-md-12">
                    <div class="jobsList__itemDate"><strong><?= __('Posted:', 'lang'); ?></strong> <?= $item['published']; ?></div>
                  </div>
                  <div class="col-2 col-mdl-3 col-md-12">
                    <div class="jobsList__itemDate"><strong><?= __('Closing:', 'lang'); ?></strong> <?= $item['closing']; ?></div>
                  </div>
                </div>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="jobsList__moreWrapper hideScroll">
          <a href="#" class="jobsList__more jobsList__more--active button button--border button--blue"><?= __('Load more', 'lang'); ?></a>
        </div>
      </div>
    </div>
  </section>
<?php endif;