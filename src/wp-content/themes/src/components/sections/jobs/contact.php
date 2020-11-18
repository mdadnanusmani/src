<?php

  $headline = get_field('job_apply_headline', 'option');
  $form     = get_field('job_apply_form', 'option');

  if ($form) :

?>
  <section class="contactSection section" data-name="apply-now">
    <div class="contactSection__inner">
      <div class="container">
        <div class="contactSection__form">
          <h3 class="section__headline contactSection__headline"><?= $headline; ?></h3>
          <?= apply_filters('wpf_contact_form', $form); ?>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php endif;