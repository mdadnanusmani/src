<?php if ($section['items']) : ?> 
  <section class="imageText section <?= apply_filters('section_classes', $section); ?>" <?= apply_filters('section_name', $section); ?>>
    <div class="imageText__inner">
      <div class="container">
        <div class="imageText__items">
          <?php foreach ($section['items'] as $index => $item) : ?>
            <div class="imageText__item hideScroll <?= ($index % 2 == 0) ? 'hideScroll--left' : 'hideScroll--right imageText__item--reverse'; ?>">
              <div class="row row--flex">
                <div class="col-5 col-md-12 imageText__itemImageWrapper">
                  <div class="imageText__itemImage">
                    <div class="imageText__itemImageInner" style="background-image: url(<?= $item['image']['sizes']['image-medium']; ?>);"></div>
                  </div>
                </div>
                <div class="col-7 col-md-12 imageText__itemContentWrapper">
                  <div class="imageText__itemContent wysiwyg wysiwyg--black"><?= $item['content']; ?></div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>