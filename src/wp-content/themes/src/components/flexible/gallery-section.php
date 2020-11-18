<?php if ($section['items']) : ?> 
  <section class="gallerySection section <?= apply_filters('section_classes', $section); ?>" <?= apply_filters('section_name', $section); ?>>
    <div class="gallerySection__inner">
      <div class="container">
        <div class="gSlider gallerySection__items hideScroll">
          <div class="gSlider__itemsOuter">
            <div class="gSlider__items">
              <?php foreach ($section['items'] as $index => $item) : ?>
                <a href="#" class="gSlider__item gallerySection__item" data-image="<?= $item['url']; ?>">
                  <img src="<?= $item['sizes']['image-medium']; ?>" class="gallerySection__itemImage" alt="<?= $item['alt']; ?>">
                </a>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="gSlider__nav">
            <a href="#" class="gSlider__navPrev gSlider__navPrev--disabled"></a>
            <a href="#" class="gSlider__navNext"></a>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>