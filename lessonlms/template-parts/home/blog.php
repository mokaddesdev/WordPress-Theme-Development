<?php
/**
 * 
 */
    $arg = [
        'post_type'      => 'post',
        'posts_per_page' => 6,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];
    $blog_posts = new WP_Query( $arg );
?>
<section class="blog">
    <div class="container">
        <!-- Header -->
        <?php
/**
 * Blog Heading
 * 
 * @package lessonlms
 */
    $blog_title       = get_theme_mod( 'blog_section_title', 'Our Blog' );
    $blog_description = get_theme_mod( 'blog_section_description', 'Read our regular travel blog and know the latest update of tour and travel' );
    $blog_button_url  = get_theme_mod( 'blog_button_url', get_permalink( get_option( 'page_for_posts' ) )
    );
    $blog_button_text = get_theme_mod( 'blog_button_text', 'See Blogs' );
?>

<div class="blog-header d-flex justify-between align-center">
    <div class="blog-heading">
        <h3><?php echo esc_html( $blog_title ); ?></h3>
        <p><?php echo esc_html( $blog_description ); ?></p>
    </div>
    
    <div class="yellow-bg-btn see-courses-btn">
        <a href="<?php echo esc_url( $blog_button_url ); ?>">
            <?php echo esc_html( $blog_button_text ); ?>
        </a>
    </div>
</div>


        <!-- Blog Posts -->
        <div class="blog-wrapper">
            <?php
            if ( $blog_posts->have_posts() ):
                while ( $blog_posts->have_posts() ):
                    $blog_posts->the_post();
                    get_template_part( 'template-parts/commom/blog', 'card' );
                endwhile;

                wp_reset_postdata();
            else:
                echo '<p>' . esc_html__( 'No Blog post found', 'lessonlms' ) . '</p>';
            endif;
            ?>
        </div>
    </div>
</section>
