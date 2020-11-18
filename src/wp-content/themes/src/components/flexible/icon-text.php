<section class="iconText section <?= apply_filters('section_classes', $section); ?>" <?= apply_filters('section_name', $section); ?>>
  <div class="iconText__inner">
    <div class="container">
      <div class="iconText__wrapper">
      <div class="iconText__icon icon-<?= $section['icon']; ?> hideScroll hideScroll--left"></div>
        <div class="iconText__text wysiwyg hideScroll hideScroll--right"><?= $section['content']; ?></div>
      </div>
    </div>
  </div>
</section>