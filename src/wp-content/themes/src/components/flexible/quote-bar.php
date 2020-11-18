<section class="quoteBar section <?= apply_filters('section_classes', $section); ?>" <?= apply_filters('section_name', $section); ?>>
  <div class="quoteBar__inner">
    <div class="container">
      <div class="quoteBar__bg hideScroll hideScroll--left"></div>
      <div class="quoteBar__content hideScroll">
        <div class="quoteBar__texts">
          <div class="quoteBar__textWhite"></div>
          <div class="quoteBar__textBlue"><?= $section['text']; ?></div>
        </div>
        <div class="quoteBar__author">
          <div class="quoteBar__authorImage" style="background-image: url(<?= $section['author']['image']['sizes']['image-small']; ?>);"></div>
          <div class="quoteBar__authorText"><?= $section['author']['name']; ?></div>
        </div>
      </div>
    </div>
  </div>
</section>