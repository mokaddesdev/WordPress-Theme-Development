<?php
/**
 * Features Section
 * 
 * @package lessonlms
 */
$features_image_one = get_theme_mod( 'features_image_one', get_template_directory_uri() . '/assets/images/feature1.png' );
$features_image_two = get_theme_mod( 'features_image_two', get_template_directory_uri() . '/assets/images/feature2.png' );

$features_title     = get_theme_mod( 'features_title', 'Learner outcomes  through our awesome platform' );
$alt_text           = ! empty( $features_title ) ? $features_title : 'Feature Image';
$features_desc_one  = get_theme_mod( 'features_description_one', '87% of people learning for professional development report career benefits like getting a promotion, a raise, or starting a new career.' );
$features_desc_two  = get_theme_mod( 'features_description_two', 'Lesson Impact Report (2022)' );
$features_btn_text  = get_theme_mod( 'features_button_text', 'Sign Up' );
$login_user         = is_user_logged_in();
?>
<section class="features">
    <div class="container">
        <div class="features-wrapper">
            <div class="features-img">
                <?php if ( $features_image_one ) : ?>
                    <img class="img-1" src="<?php echo esc_url( $features_image_one ); ?>"
                        alt="<?php echo esc_attr( $alt_text ); ?>">
                <?php endif; ?>

                <?php if ( $features_image_two ) : ?>
                    <img class="img-2" src="<?php echo esc_url( $features_image_two ); ?>"
                        alt="<?php echo esc_attr( $alt_text ); ?>">
                <?php endif; ?>
            </div>
            <div class="features-text">
                <?php if ( $features_title ) : ?>
                    <h3>
                        <?php echo esc_html( $features_title ); ?>
                    </h3>
                <?php endif; ?>
                <?php if ( $features_desc_one ) : ?>
                    <p>
                        <?php echo esc_html( $features_desc_one ); ?>
                    </p>
                <?php endif; ?>

                <?php if ( $features_desc_two ) : ?>
                    <span>
                        <?php echo esc_html( $features_desc_two ); ?>
                    </span>
                <?php endif; ?>

                <div class="yellow-bg-btn sign-up">
                    <?php
                    if ( $login_user ) :
                        ?>
                        <a href="<?php echo esc_url( home_url("/my-account/") ); ?>">
                            <?php echo esc_html__( 'Go to Profile', 'lessonlms' ); ?>
                        </a>
                    <?php else : ?>
                        <a href="<?php echo esc_url( wp_registration_url() ); ?>">
                            <?php echo esc_html( $features_btn_text ); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>