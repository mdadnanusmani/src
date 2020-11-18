<?php

  $newsletter = get_field('footer_newsletter', 'option');
  if ($newsletter) :

?>
  <div class="footer__newsletter hideScroll">
    <h5 class="footer__newsletterTitle"><?= $newsletter['title']; ?></h5>
    <?= apply_filters('wpf_contact_form', $newsletter['form']); ?>
  </div>
<?php endif;