<?php 
/**
 * search result show page
 */

$default_image = get_template_directory_uri() . '/assets/images/courses-image1.png';

if (has_post_thumbnail()) {
    $bg_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
} else {
    $bg_image = $default_image;
}
$title = get_the_title();
?>

<section class="page-section" style="background-image: url('<?php echo esc_url($bg_image); ?>') ;">
    <div class="overlay">
        <div class="container">
            <?php if(is_search()) :?>
          <!-- Search Page Heading -->
          <h1 class="page-title" data-aos="fade-down"
             data-aos-easing="linear"
             data-aos-duration="1000">
             <?php
              printf( wp_kses_post( __( 'Search Results for: %s', 'lessonlms' ) ),
               '<span>' . esc_html( get_search_query() ) . '</span>');
               ?>
          </h1>
      <?php endif; ?>

            <!-- Breadcrumb Start -->
            <nav class="custom-breadcrumb" aria-label="breadcrumb" data-aos="fade-up" data-aos-easing="linear"
                data-aos-duration="1000">
                <ul>
                    <li>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <?php echo esc_html__('Home', 'lessonlms'); ?>
                        </a>
                    </li>
                    <li class="breadcrumb-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
                        </svg>
                    </li>
                    <li>
                       <?php
$page_for_posts = get_option( 'page_for_posts' );
if ( $page_for_posts ) :
?>
<a href="<?php echo esc_url( get_permalink( $page_for_posts ) ); ?>">
    <?php echo esc_html__( 'Blog', 'lessonlms' ); ?>
</a>
<?php endif; ?>


                    </li>
                    <li class="breadcrumb-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
                        </svg>
                    </li>
                    <?php if ( is_search() ) : ?>
                  <li>
                    <span class="current"><?php echo esc_html( get_search_query() ); ?></span>
                </li>
                  <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</section>
