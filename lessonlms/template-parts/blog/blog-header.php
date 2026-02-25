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
