<?php

  $classes = [];

  if ($section['media_type'] == 'image') {

    $classes[] = ($section['image_narrow']) ? 'col-3 col-mdl-12' : 'col-6 col-mdl-12';
    $classes[] = 'textMedia__media';

  } else if ($section['media_type'] == 'video') {

    $classes[] = ($section['media_alignment'] == 'right') ? 'col-6 offset-col-2 col-mdl-12' : 'col-6 col-mdl-12';
    $classes[] = 'textMedia__media textMedia__media--video';

  }

?>
<div class="<?= implode(' ', $classes); ?> hideScroll">
  <div class="textMedia__mediaInner">
    <?php if ($section['media_type'] == 'video') : ?>
      <div class="textMedia__video">
        <div class="textMedia__videoWrapper" data-video="<?= apply_filters('youtube_video_id', $section['youtube_video']); ?>"></div>
        <div class="textMedia__videoPlaceholder" style="background-image: url(<?= $section['image_poster']['sizes']['image-medium']; ?>);"></div>
        <a href="#" class="textMedia__videoButton textMedia__videoButton--play"><?= __('Play video', 'lang'); ?></a>
        <a href="#" class="textMedia__videoButton textMedia__videoButton--pause textMedia__videoButton--hidden"><?= __('Pause video', 'lang'); ?></a>
      </div>
    <?php else : ?>
      <div class="textMedia__image">
        <img src="<?= $section['image']['url']; ?>" class="textMedia__imageInner" alt="<?= $section['image_poster']['sizes']['alt']; ?>">
      </div>
    <?php endif; ?>
  </div>
</div>