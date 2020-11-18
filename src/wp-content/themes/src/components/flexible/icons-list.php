<?php if ($section['items']) : ?> 
  <section class="iconsList section <?= apply_filters('section_classes', $section); ?>" <?= apply_filters('section_name', $section); ?>>
    <div class="iconsList__inner">
      <div class="container">
        <?php if ($section['headline']) : ?> 
          <h3 class="iconsList__headline section__headline hideScroll hideScroll--left"><?= $section['headline']; ?></h3>
        <?php endif; ?>
        <div class="row row--flex iconsList__items">
          <?php

            $count = count($section['items']);
            foreach ($section['items'] as $index => $item) :

          ?>
            <div class="col-<?= (12 / $count); ?> col-md-12 iconsList__item iconsList__item--<?= $item['color']; ?> hideScroll">
              <a href="<?= $item['link']['url']; ?>" target="<?= $item['link']['target']; ?>" class="iconsList__itemLink">
                <div class="iconsList__itemIcon icon-<?= $item['icon']; ?>" data-hover="<?= $item['color']; ?>"></div>
                <h4 class="iconsList__itemTitle"><?= $item['title']; ?></h4>
                <?php if (isset($item['desc']) && $item['desc']) : ?>
                  <div class="iconsList__itemDesc"><?= $item['desc']; ?></div>
                <?php endif; ?>
                <?php if (isset($item['link']['title']) && $item['link']['title']) : ?>
                  <div class="iconsList__itemButton button button--inline button--<?= $item['color']; ?>"><?= $item['link']['title']; ?></div>
                <?php endif; ?>
              </a>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>