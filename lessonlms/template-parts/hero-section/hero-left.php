 <?php
    /**
     * Template Name: Hero Left
     *
     * @package lessonlms
     */
    $hero_image      = get_theme_mod( 'hero_image' );
    $default_img_uri = get_template_directory_uri();
    $top_categories  = get_terms( array(
        'taxonomy'   => 'course_category',
        'orderby'    => 'count',
        'order'      => 'DESC',
        'number'     => 3,
        'hide_empty' => true,
    ) );

    if (! is_array( $top_categories ) || is_wp_error( $top_categories ) ) :
        $top_categories = [];
    endif;
    ?>

 <div class="hero-img-box">
     <?php if ($hero_image) : ?>
         <img src="<?php echo esc_url( $hero_image ); ?>" alt="<?php echo esc_attr( get_bloginfo('name') ); ?>">
     <?php else: ?>
         <img src="<?php echo $default_img_uri ?>/assets/images/heor-img.png" alt="hero-img">
     <?php endif; ?>

     <!----- absolute card box ----->
     <div class="card-box">
         <?php if (! empty( $top_categories ) && is_array( $top_categories ) ) :
                $icons = ['design.svg', 'development.svg', 'marketing.svg'];
                foreach ( $top_categories as $index => $top_category ) : ?>
                 <div class="card-items item<?php echo esc_attr( $index + 1 ); ?>">
                     <?php
                        echo lessonlms_asset_svg( 'hero-section', $icons[$index] ?? 'default.svg', $top_category->name . 'svg' );
                        ?>
                     <div class="text">
                         <span>
                            <?php
                            echo esc_html( $top_category->count ) . ' ' ;
                            echo esc_attr__( 'Courses', 'lessonlms' );
                            ?>
                        </span>
                         <p class="common-heading-two">
                            <?php echo esc_html( $top_category->name ); ?>
                            </p>
                     </div>
                 </div>
         <?php endforeach;
                wp_reset_postdata();
            endif; ?>
     </div>
 </div>