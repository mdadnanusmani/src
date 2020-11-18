<section class="contactMap section <?= apply_filters('section_classes', $section); ?>" <?= apply_filters('section_name', $section); ?>>
  <div class="contactMap__inner">
    <div class="container">
      <div class="row row--flex">
        <div class="col-5 col-mdl-12">
          <div class="contactMap__form">
            <h3 class="section__headline contactMap__headline"><?= $section['headline']; ?></h3>
            <?= apply_filters('wpf_contact_form', $section['form']); ?>
          </div>
        </div>
        <div class="col-7 col-mdl-12">
          <div class="contactMap__map" data-key="<?= get_field('google_maps_key', 'option'); ?>" data-lat="<?= $section['location']['lat']; ?>" data-lng="<?= $section['location']['long']; ?>"></div>
        </div>
      </div>
    </div>
  </div>
</section>