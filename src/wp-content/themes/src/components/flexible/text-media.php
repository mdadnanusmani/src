<section class="textMedia section <?= apply_filters('section_classes', $section); ?>" <?= apply_filters('section_name', $section); ?>>
  <div class="textMedia__inner">
    <div class="container">
      <div class="row row--flex">
        <?php 

          if ($section['media_alignment'] == 'left') {

            include 'text-media--media.php';
            include 'text-media--content.php';

          } else {

            include 'text-media--content.php';
            include 'text-media--media.php';

          }

        ?>
      </div>
    </div>
  </div>
</section>