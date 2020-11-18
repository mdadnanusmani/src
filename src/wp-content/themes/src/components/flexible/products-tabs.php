<?php if ($section['items']) : ?> 
  <section class="productsTabs section section--gray" <?= apply_filters('section_name', $section); ?>>
    <div class="productsTabs__inner">
      <div class="container">
        <div class="productsTabs__buttons hideScroll hideScroll--left">
          <?php foreach ($section['items'] as $index => $item) : ?>
            <a href="#" class="productsTabs__button <?= ($index == 0) ? 'productsTabs__button--active' : ''; ?>">
              <div class="productsTabs__buttonIcon icon-<?= $item['icon']; ?>" data-hover="blue"></div>
              <h4 class="productsTabs__buttonTitle"><?= $item['title']; ?></h4>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="productsTabs__itemsWrapper">
        <div class="container">
          <div class="productsTabs__items hideScroll">
            <?php foreach ($section['items'] as $index => $item) : ?>
              <div class="productsTabs__item <?= ($index == 0) ? 'productsTabs__item--active' : ''; ?> <?= ($index % 2 == 1) ? 'productsTabs__item--reverse' : ''; ?>">
                <div class="productsTabs__itemBg" style="background-image: url(<?= $item['bg_image']['sizes']['image-medium']; ?>);"></div>
                <div class="productsTabs__itemContent wysiwyg wysiwyg--white"><?= $item['text']; ?></div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>