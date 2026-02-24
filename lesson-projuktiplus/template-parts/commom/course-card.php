<?php
/**
 * Template Name: Common Course Card Design
 * 
 * @package lessonlms
 */
    $single_id      = get_the_ID();
    $stats          = lessonlms_get_review_stats( $single_id );
    $average_rating = $stats['average_rating'];
    $average_rating = ! empty( $average_rating ) ? $stats['average_rating'] : '0.0';
    $price          = get_post_meta( $single_id, 'regular_price', true);
    $price          = ! empty( $price ) ? $price : '0.00';
    $permalink      = get_permalink();
    $course_descrip = wp_trim_words(get_the_content(), 10);
    $course_title   = get_the_title();

    $image_html     = '';
    if (has_post_thumbnail()) {
        $image_html = get_the_post_thumbnail(
            $single_id,
            'custom-courses-image',
            array(
                'class' => 'courses-image-size',
                'alt'   => $course_title,
            )
        );
    }
//     echo '<pre>';
// var_dump($single_id);
// var_dump(get_post_meta($single_id));
// echo '</pre>';
?>

<div class="course">
    <div class="img">
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
        <?php
// $single_id  = get_the_ID();
// $product_id = get_post_meta( $single_id, '_course_product', true );

// if ( $product_id && class_exists( 'WooCommerce' ) ) :

//     $product = wc_get_product( $product_id );

//     if ( $product && $product->is_purchasable() ) :

//         echo sprintf(
//             '<a href="%s" data-quantity="1" class="button add_to_cart_button ajax_add_to_cart" data-product_id="%s" data-product_sku="%s" aria-label="%s" rel="nofollow">%s</a>',
//             esc_url( $product->add_to_cart_url() ),
//             esc_attr( $product_id ),
//             esc_attr( $product->get_sku() ),
//             esc_attr( $product->add_to_cart_description() ),
//             esc_html( $product->add_to_cart_text() )
//         );

//     endif;

// endif;
?>
        <!-- price & button -->
        <div class="price-btn">
           <?php
$single_id  = get_the_ID();
$product_id = get_post_meta( $single_id, '_course_product', true );

if ( $product_id ) {

    $price = get_post_meta( $product_id, '_price', true );

    if ( $price !== '' ) {
        echo '<span class="price">$' . esc_html( $price ) . '</span>';
    }
}
?>
            <div class="black-btn book-now">
                <a href="<?php echo esc_url( $permalink ); ?>">
                    <?php echo esc_html__( 'Book Now', 'lessonlms' ); ?>
                </a>
                
            </div>
        </div>
    </div>
</div>
