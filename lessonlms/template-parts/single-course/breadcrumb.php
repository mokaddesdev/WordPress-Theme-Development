<?php

/**
 * Template Name: Breadcrumb
 * 
 * @package lessonlms
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
            <h1 class="page-title" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1000">
                <?php echo esc_html(wp_trim_words($title, 5)); ?>
            </h1>

            <!-- Breadcrumb Start -->
            <nav class="custom-breadcrumb" aria-label="breadcrumb" data-aos="fade-up" data-aos-easing="linear"
                data-aos-duration="1000">
                <ul>
                    <li>
                        <a href="<?php echo home_url(); ?>">
                            <?php echo esc_html__('Home', 'lessonlms'); ?>
                        </a>
                    </li>

                    <li class="breadcrumb-icon">
                        <svg>
                            <use href="#breadcrumb-icon" ></use>
                        </svg>
                    </li>

                    <li>
                        <a href="<?php echo get_post_type_archive_link('courses'); ?>">
                            <?php echo esc_html__('Courses', 'lessonlms'); ?>
                        </a>

                    </li>

                    <li class="breadcrumb-icon">
                        <svg>
                            <use href="#breadcrumb-icon" ></use>
                        </svg>
                    </li>

                    <li>
                        <?php echo esc_html(wp_trim_words($title, 5)); ?>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</section>