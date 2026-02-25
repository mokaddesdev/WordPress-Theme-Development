<div class="features-text">
    <?php 
    $features_title = get_theme_mod('features_title', 'Learner outcomes through our awesome platform');
    $features_description_one = get_theme_mod('features_description_one', '87% of people learning for professional development report career benefits like getting a promotion, a raise, or starting a new career.');
    $features_description_two = get_theme_mod('features_description_two', 'Lesson Impact Report (2022)');
    $features_button_text = get_theme_mod('features_button_text', 'sign up');
    $features_button_url = get_theme_mod('features_button_url', '#');
    ?>

    <?php if($features_title): ?>
        <h3><?php echo esc_html($features_title); ?></h3>
    <?php endif; ?>

    <?php if($features_description_one): ?>
        <p><?php echo esc_html($features_description_one); ?></p>
    <?php endif; ?>

    <?php if($features_description_two): ?>
        <span><?php echo esc_html($features_description_two); ?></span>
    <?php endif; ?>

    <div class="yellow-bg-btn sign-up">
        <a href="<?php echo esc_url($features_button_url); ?>">
            <?php echo esc_html($features_button_text); ?>
        </a>
    </div>
</div>
