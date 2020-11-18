<section class="textSection section <?= apply_filters('section_classes', $section); ?>" <?= apply_filters('section_name', $section); ?>>
  <div class="textSection__inner">
    <div class="container">
      <div class="wysiwyg <?= $section['is_large'] ? 'wysiwyg--large' : ''; ?> hideScroll">
        <?= $section['content']; ?>
      </div>
    </div>
  </div>
</section>