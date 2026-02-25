<div class="cta-img">
    <?php 
    $cta_image = get_theme_mod('cta_image', get_template_directory_uri() . '/assets/images/cta-right.png'); 
    if ($cta_image): ?>
        <img src="<?php echo esc_url($cta_image); ?>" alt="<?php echo esc_attr(get_theme_mod('cta_title', 'CTA Image')); ?>">
    <?php endif; ?>
</div>
