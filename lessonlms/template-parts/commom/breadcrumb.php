<?php

/**
 * Template Name: Pages Breadcrumb
 * 
 * @package lessonlms
 */
$image_dir     = get_template_directory_uri();
$image_path    = '/assets/images/courses-image1.png';
$default_image = $image_dir . $image_path;
$get_bg_img    = get_the_post_thumbnail_url($id, 'large');
$img_thumb     = has_post_thumbnail();
$bg_image      = $img_thumb ? $get_bg_img : $default_image;
$id            = get_the_ID();
$get_title     = get_the_title();
$title         = $get_title;

if (is_post_type_archive('courses')) :
    $title     = post_type_archive_title('', false);
elseif (is_home()) :
    $title = 'Blog';
elseif (is_archive()) :
    $title = get_the_archive_title();
endif;
$trim_word     = wp_trim_words($title, 8);
?>

<section class="page-section" style="background-image: url('<?php echo esc_url($bg_image); ?>') ;">
    <div class="overlay">
        <div class="container">
            <h1 class="page-title" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1000">
                <?php echo esc_html($trim_word); ?>
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
                        /
                    </li>
                    <li>
                        <?php echo esc_html($trim_word); ?>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</section>