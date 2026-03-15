<?php
/**
 * Template Name: Explore Category
 * 
 * @package lessonlms
 */
$category_heading = get_theme_mod( '_explore_category_heading', 'Explore Categories');

$category_desc = get_theme_mod( '_explore_category_desc', 'Discover categories designed to help you excel in your professional and personal growth.');
?>
<div class="explore-section">
    <div class="container">

        <!-- category heading -->
        <div class="explore-category-heading">
            <?php if ( $category_heading ) : ?>
            <h1>
                <?php echo esc_html( $category_heading ); ?>
            </h1>
            <?php endif; ?>

            <?php if ( $category_desc ) : ?>
            <p>
                <?php echo esc_html( $category_desc ); ?>
            </p>
            <?php endif; ?>
        </div>

        <!-- category card  -->
        <div class="explore-category-cards">
            <?php
            $categories   = get_terms(array(
                'taxonomy'      => 'course_category',
                'hide_empty'    => true,
            ));
            if ( ! empty( $categories ) && is_array( $categories ) ) :

                foreach ( $categories as $catagory ) : ?>

                    <a class="home-category-link" data-category-id="<?php echo esc_attr( $catagory->term_id ); ?>" href="<?php echo esc_url( get_post_type_archive_link( 'courses' ) ); ?>">
                        <div class="explore-category-single-card">
                            <h3>
                                <?php echo esc_html( $catagory->name ); ?>
                            </h3>
                        </div>
                    </a>
            <?php
                endforeach;
                endif;
            ?>
        </div>
    </div>
</div>