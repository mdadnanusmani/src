<?php if ($section['items']) : ?> 
  <section class="statsBoxes section <?= apply_filters('section_classes', $section); ?>" <?= apply_filters('section_name', $section); ?>>
    <div class="statsBoxes__inner">
      <div class="container">
        <div class="statsBoxes__items">
          <div class="statsBoxes__item statsBoxes__item--wide hideScroll hideScroll--left">
            <div class="wysiwyg wysiwyg--large"><?= $section['text']; ?></div>
          </div>
          <?php foreach ($section['items'] as $index => $item) : ?>
            <div class="statsBoxes__item statsBoxes__item--number">
              <div class="statsBoxes__itemInner hideScroll" data-animation-number>
                <div class="statsBoxes__itemNumber" data-number="<?= $item['value']; ?>" data-suffix="<?= $item['suffix']; ?>"></div>
                <h5 class="statsBoxes__itemTitle"><?= $item['title']; ?></h5>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>