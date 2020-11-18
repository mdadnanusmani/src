<section class="newsletterSection section <?= apply_filters('section_classes', $section); ?>" <?= apply_filters('section_name', $section); ?>>
  <div class="newsletterSection__inner">
    <div class="container">
      <h3 class="newsletterSection__headline hideScroll hideScroll--left"><?= $section['headline']; ?></h3>
      <div class="newsletterSection__form hideScroll">
        <?= apply_filters('wpf_contact_form', $section['form']); ?>
      </div>
    </div>
  </div>
</section>