<div class="features-img">
    <?php 
    $features_image_one = get_theme_mod('features_image_one', get_template_directory_uri() . '/assets/images/feature1.png');
    $features_image_two = get_theme_mod('features_image_two', get_template_directory_uri() . '/assets/images/feature2.png');
    ?>

    <?php if($features_image_one): ?>
        <img class="img-1" src="<?php echo esc_url($features_image_one); ?>" alt="">
    <?php endif; ?>

    <?php if($features_image_two): ?>
        <img class="img-2" src="<?php echo esc_url($features_image_two); ?>" alt="">
    <?php endif; ?>
</div>
