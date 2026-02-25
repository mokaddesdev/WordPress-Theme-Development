<div class="cta-text">
    <h3>
        <?php 
        $cta_title = get_theme_mod('cta_title', 'Take the next step toward your personal and professional goals with Lesson.');
        if ($cta_title) echo esc_html($cta_title); 
        ?>
    </h3>

    <p>
        <?php 
        $cta_description = get_theme_mod('cta_description', 'Join now to receive personalized recommendations from the full Coursera catalog.');
        if ($cta_description) echo esc_html($cta_description); 
        ?>
    </p>

    <?php 
    $cta_button_text = get_theme_mod('cta_button_text', 'Join now'); 
    $cta_button_url  = get_theme_mod('cta_button_url', '#'); 
    ?>
    <div class="yellow-bg-btn join-now">
        <a href="<?php echo esc_url($cta_button_url); ?>">
            <?php if ($cta_button_text) echo esc_html($cta_button_text); ?>
        </a>
    </div>
</div>
