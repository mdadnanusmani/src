<?php

  $classes = [];

  if ($section['media_type'] == 'image') {

    $classes[] = ($section['image_narrow']) ? 'col-9 col-mdl-12' : 'col-6 col-mdl-12';

  } else if ($section['media_type'] == 'video') {

    $classes[] = ($section['media_alignment'] == 'right') ? 'col-4 col-mdl-12' : 'col-4 offset-col-2 col-mdl-12';

  }

?>
<div class="<?= implode(' ', $classes); ?> textMedia__content hideScroll hideScroll--<?= ($section['media_alignment'] == 'left') ? 'right' : 'left'; ?>">
  <div class="wysiwyg <?= $section['is_large'] ? 'wysiwyg--large' : ''; ?>">
    <?= $section['content']; ?>
  </div>
</div>