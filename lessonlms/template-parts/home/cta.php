<?php
/**
 * CTA Section
 * 
 * @package  lessonlms
 */
$cta_title       = get_theme_mod( 'cta_title', 'Take the next step toward your personal and professional goals with Lesson.' );
$cta_desc        = get_theme_mod( 'cta_description', 'Join now to receive personalized recommendations from the full Coursera catalog.' );
$cta_button_text = get_theme_mod( 'cta_button_text', 'Join now' );
?>
<section class="cta">
    <div class="container">
        <div class="cta-wrapper">
            <div class="cta-text">
                <?php if ( ! empty( $cta_title ) ) : ?>
                <h3>
                    <?php echo esc_html( $cta_title ); ?>
                </h3>
                <?php endif; ?>
                <?php
                    if ( ! empty( $cta_desc ) ) :
                ?>
                <p>
                    <?php echo esc_html( $cta_desc ); ?>
                </p>
                <?php endif; ?>

                <div class="yellow-bg-btn join-now">
                    <?php 
                        if ( $cta_button_text )
                        echo esc_html( $cta_button_text );
                    ?>
                </div>
            </div>

            <div class="subscribe-modal">
                <div class="modal-content">
                    <button class="close-btn"><i class="fa-solid fa-xmark"></i></button>
                    <div class="image-form">
                        <div class="newsletter-left">
                            <img src="<?php echo get_template_directory_uri() ?>/assets/images/heor-img.png"
                                alt="Image">
                        </div>
                        <div class="newletter-right">
                            <h2 class="common-heading">
                                newsletter
                            </h2>
                            <p class="common-paragraph">
                                Subscribe to the Boxmailing list to receive updates on new arrivals, special offers and
                                other discount information.
                            </p>
                            <form action="#" class="subscribe-form">
                                <label for="email"></label>
                                <input type="email" name="email" id="email" placeholder="Sign up your email.">
                                <button type="submit" class="black-btn">Subscribe Now</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                .subscribe-modal {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0, 0, 0, 0.6);
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    visibility: hidden;
                    opacity: 0;
                    transition: all 0.3s ease-in-out;
                    z-index: 9999;
                }

                .subscribe-modal.showModal {
                    visibility: visible;
                    opacity: 1;
                }

                .modal-content {
                    position: relative;
                    background: #fff;
                    padding: 30px;
                    border-radius: 12px;
                    max-width: 500px;
                    width: 90%;
                    text-align: center;
                    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
                }

                .close-btn {
                    position: absolute;
                    top: 15px;
                    right: 15px;
                    background: none;
                    border: none;
                    font-size: 20px;
                    cursor: pointer;
                    color: #333;
                    transition: 0.2s;
                }

                .close-btn:hover {
                    color: #e53935;
                }

                .image-form {
                    display: flex;
                    flex-direction: row;
                    gap: 20px;
                }

                .newsletter-left img {
                    max-width: 100%;
                    border-radius: 8px;
                }

                .newletter-right h2 {
                    text-transform: uppercase;
                    text-align: left;
                    padding: 8px;
                }

                .newletter-right p {
                    padding: 10px 0px 20px 0px;
                    text-align: left;
                }

                .subscribe-form input[type="email"] {
                    width: 100%;
                    padding: 12px 15px;
                    border-radius: 6px;
                    border: 1px solid #ccc;
                    font-size: 16px;
                }

                .subscribe-form button {
                    margin-top: 10px;
                    cursor: pointer;
                    transition: 0.2s;
                }

                .subscribe-form button:hover {
                    background: #d32f2f;
                }
            </style>

            <script>
                jQuery(document).ready(function ($) {

                    // Open modal on join-now click
                    $(document).on('click', '.join-now', function () {
                        $(".subscribe-modal").addClass('showModal');
                    });

                    // Close modal on close button click
                    $(".subscribe-modal .close-btn").on('click', function () {
                        $(this).closest(".subscribe-modal").removeClass('showModal');
                    });

                    // Close modal if clicking outside modal-content
                    $(".subscribe-modal").on('click', function (e) {
                        if ($(e.target).is(".subscribe-modal")) {
                            $(this).removeClass('showModal');
                        }
                    });

                });
            </script>

            <div class="cta-img">
                <?php
                $cta_image = get_theme_mod('cta_image', get_template_directory_uri() . '/assets/images/cta-right.png');
                if ($cta_image): ?>
                    <img src="<?php echo esc_url($cta_image); ?>"
                        alt="<?php echo esc_attr(get_theme_mod('cta_title', 'CTA Image')); ?>">
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>