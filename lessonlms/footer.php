<?php
/**
 * Footer Template
*
* @package lessonlms
*/
$footer_text        = get_theme_mod( 'footer_about_text', 'Need to help for your dream Career? trust us. With Lesson, study becomes a lot easier with us.' );
$footer_logo        = get_theme_mod( 'footer_logo', get_template_directory_uri() .'/assets/images/footer-logo.png');
$footer_menu1_title = get_theme_mod( 'footer_menu1_title','Company' );
$footer_menu2_title = get_theme_mod( 'footer_menu2_title','Services' );

$footer_address     = get_theme_mod( "footer_address","Address");
$footer_loca_title  = get_theme_mod( 'footer_location_title', 'Location:' );
$footer_loca_des    = get_theme_mod( 'footer_location_description', '27 Division St, New York, NY 10002, USA' );

$footer_email_title = get_theme_mod( 'footer_email_title', 'Email:' );
$footer_email       = get_theme_mod( 'footer_email', 'email@gmail.com' );
$footer_phone_title = get_theme_mod( 'footer_phone_title','Phone:' );
$footer_phone_des   = get_theme_mod( 'footer_phone_description', '+ 000 1234 567 890' );
?>


<footer>
    <div class="container">
        <div class="footer-wrapper">
            <!-- edit footer -->
            <!----- about company ----->
            <div class="about-company">
                <div class="f-logo">
                    <?php if ( ! empty( $footer_logo ) ) : ?>
                    <img src="<?php echo esc_url( $footer_logo ); ?>"
                        alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                    <?php endif;?>
                </div>
                <!-- #region-->
                <?php if ( ! empty( $footer_text ) ) : ?>
                <p> <?php echo esc_html( $footer_text ); ?> </p>
                <?php endif; ?>

                <div class="social-links">
                    <!----- twitter ----->
                    <a href="<?php echo esc_url( get_theme_mod( 'footer_twitter_link' ) ); ?>">

                    </a>
                    <!----- facebook ----->
                    <a href="<?php echo esc_url( get_theme_mod( 'footer_facebook_link' ) ); ?>">
                    </a>
                    <!----- linkdine ----->
                    <a href="<?php echo esc_url( get_theme_mod( 'footer_linkedin_link' ) ); ?>">
                    </a>
                    <!----- instagram ----->
                    <a href="<?php echo esc_url( get_theme_mod( 'footer_instagram_link' ) ); ?>">
                    </a>
                </div>
            </div>

            <!----- company links ----->
            <div class="footer-nav company">
                <?php if ( ! empty( $footer_menu1_title ) ) : ?>
                <div><?php echo esc_html( $footer_menu1_title ); ?></div>
                <?php endif;?>
                <hr>
                <?php
                    wp_nav_menu( array(
                        "theme_location"=> "footer_menu1",
                        ) ); 
                ?>
            </div>

            <div class="footer-nav support">
                <?php if ( ! empty( $footer_menu2_title ) ) : ?>
                <div><?php echo esc_html( $footer_menu2_title );?></div>
                <?php endif;?>
                <hr>
                <?php
                    wp_nav_menu( array(
                        "theme_location"=> "footer_menu2",
                        ) );
                ?>
            </div>
            <div class="footer-nav address">
                <?php if ( ! empty( $footer_address ) ) : ?>
                <div><?php echo esc_html( $footer_address );?></div>
                <?php endif;?>
                <hr>
                <!----- location ----->
                <div class="address-details location">
                    <a href="https://maps.app.goo.gl/5QJbeQc3kLpr9bX49">
                        <span>
                            <?php if ( ! empty( $footer_loca_title) ) : ?>
                            <strong><?php echo esc_html( $footer_loca_title );?></strong>
                            <?php endif; ?>
                            <?php if( ! empty( $footer_loca_des ) ) : ?>
                            <?php echo esc_html( $footer_loca_des ); ?>
                            <?php endif; ?>
                        </span>
                    </a>
                </div>

                <!----- email ----->
                <div class="address-details email">
                    <a href="mailto:<?php echo esc_html( $footer_email ); ?>">
                        <span>
                            <?php if( $footer_email_title ) : ?>
                            <strong>
                                <?php echo esc_html( $footer_email_title );?>
                            </strong>
                            <?php endif; ?>
                            <?php if ( $footer_email ) : ?>
                            <?php echo esc_html( $footer_email ); ?>
                            <?php endif; ?>
                        </span>
                    </a>
                </div>

                <!----- contact number ----->
                <div class="address-details phone">
                    <a href="tel:<?php echo esc_html( get_theme_mod( 'footer_phone_title' ) );?>">
                        <span>
                            <?php if ( $footer_phone_title ) :?>
                            <strong><?php echo esc_html( $footer_phone_title );?></strong>
                            <?php endif;?>
                            <?php if ( $footer_phone_description ) :?>
                            <?php echo esc_html( $footer_phone_description );?>
                            <?php endif;?>
                        </span>
                    </a>
                </div>
            </div>
        </div>

        <div class="copyright-area">
            <p><?php echo esc_html__( 'Copyright', 'lessonLMS' ); ?> &copy; <?php echo date('Y' );?>
                <?php bloginfo( 'name' );?> <?php echo esc_html__( 'All rights reserved', 'lessonLMS' ); ?></p>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>

</html>