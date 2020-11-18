<?php

  $items = apply_filters('news_list', $section['sort_by'], 3);

  if ($items) :

?>
  <section class="newsList section <?= apply_filters('section_classes', $section); ?>" <?= apply_filters('section_name', $section); ?>>
    <div class="newsList__inner">
      <div class="container">
        <div class="section__header">
          <h3 class="section__headline hideScroll hideScroll--left"><?= $section['headline']; ?></h3>
          <?php if ($section['header_link'] && $section['header_link']['title']) : ?> 
            <a href="<?= $section['header_link']['url']; ?>" target="<?= $section['header_link']['target']; ?>" class="section__headerButton button--inline hideScroll hideScroll--right"><?= $section['header_link']['title']; ?></a>
          <?php endif; ?>
        </div>
        <div class="newsList__items hideScroll">
          <div class="row row--flex row--fluid">
            <?php foreach ($items as $index => $item) : ?>
              <a href="<?= $item['url']; ?>" class="contentBox contentBox--large col-4 col-4 col-md-12">
                <div class="contentBox__outer">
                  <div class="contentBox__inner">
                    <div class="contentBox__header">
                      <div class="contentBox__category icon-<?= $item['category_icon']; ?>"><?= $item['category']; ?></div>
                      <div class="contentBox__date"><?= $item['date']; ?></div>
                    </div>
                    <h4 class="contentBox__title"><?= $item['title']; ?></h4>
                    <div class="contentBox__button button button--inline"><?= __('See more', 'lang'); ?></div>
                  </div>
                </div>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>