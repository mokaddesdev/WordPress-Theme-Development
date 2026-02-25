<?php 
    /**
     * Template Name: Hero Section Right Text
     * 
     * @package lessonlms
     */

    $hero_title         = get_theme_mod( 'hero_section_title','Learn without limits and spread knowledge.' );
    $hero_description   = get_theme_mod(
        'hero_section_description',
        'Build new skills for that “this is my year” feeling with courses, certificates, and degrees from world-class universities and companies.' );
    $course_url         = get_post_type_archive_link( 'courses' );
    $course_btn_text    = get_theme_mod( 'courses_button_text','See Courses' );
    $see_vedio_btn      = get_theme_mod( 'watch_button_text','Watch Video' );
    $see_vedio_btn_url  = get_theme_mod( 'watch_button_url','#' );
    $engagement_text    = get_theme_mod( 'recent_engagement_text','Recent engagement' );
    $student_label      = get_theme_mod( 'student_label_text','Students' );
    $course_label       = get_theme_mod( 'course_label_text','Courses' );
    $data               = total_enroll_course_count();
    $total_course_count = $data['courses'];
    $total_enrollments  = $data['enrollments'];

    if ( ! empty( $total_course_count ) && ! is_array( $total_course_count ) ) {
        $format_total_course_count = lessonlms_count_number_format( $total_course_count ); 
    }
    if ( ! empty( $total_enrollments ) && ! is_array( $total_enrollments ) ) {
        $format_total_enrollments = lessonlms_count_number_format( $total_enrollments );
    }
?>

<div class="hero-text-box">
    <h1><?php echo esc_html( $hero_title ); ?></h1>
    <p><?php echo esc_html( $hero_description ); ?></p>

    <div class="hero-btns">
        <div class="yellow-bg-btn See-Courses-btn">
            <a href="<?php echo esc_url( $course_url ); ?>">
                <?php echo esc_html( $course_btn_text ); ?>
            </a>
        </div>

        <div class="watch-video-btn">
            <div class="play-btn">
                <?php get_template_part("assets/svg/hero-section/see-video");?>
            </div>
            <span>
                <a href="<?php echo esc_url( $see_vedio_btn_url ); ?>">
                    <?php echo esc_html( $see_vedio_btn ); ?>
                </a>
            </span>
        </div>
    </div>

    <div class="engagement">
        <span>
            <?php echo esc_html( $engagement_text ); ?>
        </span>
        <div class="engagement-wrapper">
            <h3>
                <?php echo esc_html($format_total_enrollments); ?> 
                <span>
                    <?php echo esc_html( $student_label ); ?>
                </span>
            </h3>
            <h3>
                <?php echo esc_html( $format_total_course_count ); ?>
                <span>
                    <?php get_template_part("assets/svg/hero-section/plus-icon");  ?>
                    <?php echo esc_html( $course_label ); ?>
                </span>
            </h3>
        </div>
    </div>
</div>
