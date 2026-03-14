<?php
/**
 * Template Name: Common Course Card Design
 * 
 * @package lessonlms
 */
    $single_id      = get_the_ID();
    $stats          = lessonlms_get_review_stats( $single_id );
    $average_rating = ! empty( $stats['average_rating'] ) ? $stats['average_rating'] : '0.0';
    $permalink      = get_permalink();
    $course_descrip = wp_trim_words( get_the_content(), 10);
    $course_title   = wp_trim_words( get_the_title(), 5 );
    $course_product = get_post_meta( $single_id, '_course_product', true );
    $in_cart        = false;
    if ( function_exists('WC') && WC()->cart ) {
        foreach( WC()->cart->get_cart() as $cart_item ) {
            if ( $cart_item['product_id'] == $course_product) {
            $in_cart        = true;
            break;
            }
        }
        
    }

    $user_login = is_user_logged_in();
    $user_id = get_current_user_id();
    $user_enrollments = get_user_meta( $user_id, '_user_enrollments', true);
    $is_enroll = false;
    if ( ! empty( $user_enrollments ) && is_array( $user_enrollments ) ) {
        foreach ( $user_enrollments as $enroll ) {
            $user_enroll_id = intval( $enroll['course_id'] );
            if ( $user_enroll_id == $single_id ) {
                $is_enroll = true;
                break;
            }
        }
    }

    $image_html     = '';
    if ( has_post_thumbnail( $single_id ) ) {
        $image_html = get_the_post_thumbnail(
            $single_id,
            'custom-courses-image',
            array(
                'class' => 'courses-image-size',
                'alt'   => $course_title,
            )
        );
    }
?>

<div class="course">
    <div class="img">
        <?php if ( $is_enroll === false && ! empty( $course_product ) ) : ?>
            <?php if ( $user_login ) : ?>
                <!-- wishlist-btn -->
              <div class="wishlist-btn">
                <form method="post" class="add-to-wishlist-form">
                        <?php wp_nonce_field( 'add_to_wishlist', 'add_to_wishlist_nonce' ); ?>
                        <input type="hidden" name="course_id" value="<?php echo esc_attr( $single_id ); ?>">

                        <button type="submit" class="add-to-wishlist">
                            <i class="fa-solid fa-heart"></i>
                            <span class="tooltip-text">Add to Wishlist</span>
                        </button>
                    </form>
                </div>

                <?php

               
                ?>
                <style>
                    .wishlist-btn{
                        position: relative;
                        display: inline-block;
                    }
                    .course-add-to-cart:hover{
                        color: red;
                    }
                    .tooltip-text{
                        position: absolute;
                        left: 0;
                        top: 0;
                        background: inherit;
                        z-index: 2000;
                        color: white;
                        padding: 4px 10px;
                        font-size: 16px;
                        font-weight: 700;
                        border-radius: 4px;
                        white-space: nowrap;
                        visibility: hidden;
                        opacity: 0;
                        transition: 0.3s;
                    }
                    .course-add-to-cart:hover .tooltip-text{
                        opacity: 1;
                        visibility: visible;
                    }
                </style>

                <!-- add-to-cart -->
                <div class="add-to-cart">
                    <?php if ( $in_cart === false ) : ?>
                    <form method="post">
                        <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $course_product ); ?>">
                        <input type="hidden" name="course_id" value="<?php echo esc_attr( $single_id ); ?>">
                        <button type="submit" class="course-add-to-cart">
                        <i class="fa-solid fa-basket-shopping"></i>
                        </button>
                    </form>
                    <?php else : ?>
                        <div class="go-cart-page-btn">
                            <a href="<?php echo esc_url( wc_get_cart_url() ); ?>">
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else : ?>
                <div class="add-course-is-not-login">
                    <button class="add-to-cart-no-login">
                         <i class="fa-solid fa-heart"></i>
                    </button>
                    <button class="add-to-wishlist-no-login">
                        <i class="fa-solid fa-basket-shopping"></i>
                    </button>
                </div>
            <?php endif; ?>
        <?php endif;?>
        <a href="<?php echo esc_url( $permalink ); ?>">
            <?php echo wp_kses_post( $image_html ); ?>
        </a>
    </div>

    <div class="course-details">
        <!-- course title & rating -->
        <div class="flex">
            <span class="c-title">
                <a href="<?php echo esc_url( $permalink ); ?>">
                    <?php echo esc_html( $course_title ); ?>
                </a>
            </span>

            <div class="rating">
                <?php get_template_part('assets/svg/rating'); ?>
                <span><?php echo esc_html( $average_rating ); ?></span>
            </div>
        </div>

        <p><?php echo esc_html( $course_descrip ); ?></p>
        <?php if ( $is_enroll == false ) : ?>
        <!-- price & button -->
        <div class="price-btn">
            <?php if( ! empty( $course_product ) ) : ?>
            <!-- price -->
             <span>
                <?php
                $product = wc_get_product( $course_product );
                if ( $product->is_on_sale() ) : ?>
                 <span class="sale-price">
                    <?php echo wc_price($product->get_sale_price() ); ?>
                 </span>
                 <span class="regular-price">
                     <?php echo wc_price( $product->get_regular_price() ); ?>
                 </span>
                </span>
                <?php else : ?>
                    <span class="course-price">
                        <?php echo esc_html( wc_price($product->get_price() ) ); ?>
                    </span>
             <?php endif; ?>
             <?php else : ?>
                <span>Fee Enroll</span>
             <?php endif; ?>
            <div class="black-btn book-now">
                <a href="<?php echo esc_url( $permalink ); ?>">
                    <?php echo esc_html__( 'Book Now', 'lessonlms' ); ?>
                </a>
            </div>
        </div>
        <?php else : ?>
             <a href="<?php echo esc_url( home_url('/start-your-learning/?course_id=' . $user_enroll_id ) ); ?>"
           class="enroll-btn black-btn">
            Start Learning
        </a>
        <?php endif;?>
    </div>
</div>