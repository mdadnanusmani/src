<?php if ($section['image']) : ?> 
  <section class="imageSection section <?= apply_filters('section_classes', $section); ?>" <?= apply_filters('section_name', $section); ?>>
    <div class="imageSection__inner hideScroll">
      <div class="container">
        <img src="<?= $section['image']['sizes']['image-large']; ?>" class="imageSection__image" alt="<?= $section['image']['alt']; ?>">
      </div>
    </div>
  </section>
<?php endif; ?>