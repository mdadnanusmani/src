  <?php

    get_template_part('components/layout/footer/_core');

    get_template_part('components/template/data-hover');
    get_template_part('components/template/popup');
    get_template_part('components/template/upload-file');

    wp_footer();

  ?>

  <div class="scrollTool">
    <button class="scrollTool__up scrollTool__up--hidden"></button>
    <button class="scrollTool__top scrollTool__top--hidden"></button>
    <button class="scrollTool__down scrollTool__down--hidden"></button>
  </div>
</body>
</html>