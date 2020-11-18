<section class="partnersQuote section <?= apply_filters('section_classes', $section); ?>" <?= apply_filters('section_name', $section); ?>>
  <div class="partnersQuote__inner">
    <div class="partnersQuote__innerBg" style="background-image: url(<?= $section['quote']['bg_image']['sizes']['image-large']; ?>);"></div>
    <div class="container">
      <div class="row row--flex">
        <div class="col-6 col-md-12 partnersQuote__quote">
          <div class="partnersQuote__quoteInner hideScroll">
            <h5 class="partnersQuote__quoteText">"<?= $section['quote']['text']; ?>"</h5>
            <div class="partnersQuote__quoteAuthor">
              <div class="partnersQuote__quoteAuthorImage" style="background-image: url(<?= $section['quote']['author']['image']['sizes']['image-small']; ?>);"></div>
              <div class="partnersQuote__quoteAuthorName"><?= $section['quote']['author']['name']; ?></div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-12 partnersQuote__partners hideScroll hideScroll--right">
          <div class="partnersQuote__partnersInner">
            <div class="gSlider">
              <div class="gSlider__itemsOuter">
                <div class="gSlider__items">
                  <?php foreach ($section['items'] as $index => $item) : ?>
                    <div class="gSlider__item partnersQuote__partner">
                      <a href="<?= $item['url']; ?>" target="_blank" class="partnersQuote__partnerLink">
                        <img src="<?= $item['image']['url']; ?>" class="partnersQuote__partnerLogo" alt="<?= $item['image']['alt']; ?>">
                      </a>
                    </div>
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
      </div>
    </div>
  </div>
</section>