<?php

/**
 * Template Name: Price Image Card
 * 
 * @package lessonlms
 */

$regular_price  = get_post_meta(get_the_ID(), "regular_price", true) ?: '0.00';
$original_price  = get_post_meta(get_the_ID(), "original_price", true) ?: '0.00';

$video_hours  = get_post_meta(get_the_ID(), "video_hours", true) ?: '0.00';
$downlable_resource  = get_post_meta(get_the_ID(), "downlable_resource", true) ?: '0';
$total_articles  = get_post_meta(get_the_ID(), "total_articles", true) ?: '0';

if ($original_price > $regular_price && !empty($regular_price)) {
    $discount_price = (($original_price - $regular_price) / $original_price) * 100;
    $discount_price = round($discount_price, 2);
}


?>

<div class="single-couses-image-box">
    <?php
    if (has_post_thumbnail()): ?>

        <?php the_post_thumbnail('full'); ?>

    <?php endif; ?>

<div class="courses-card-box">

    <div class="course-price-list">
        <?php if ($regular_price): ?>
            <h2>
                $<?php echo esc_html($regular_price); ?>
            </h2>
        <?php endif; ?>

        <?php if ($original_price): ?>
            <h3>
                $<?php echo esc_html($original_price); ?>
            </h3>
        <?php endif; ?>
        <?php if ($discount_price): ?>
            <p>
                <?php echo esc_html($discount_price) . '%' . __('off', 'lessonlms'); ?>
            </p>
        <?php endif; ?>
    </div>
   <?php
$current_user_id = get_current_user_id();
$course_id = get_the_ID();

$user_enrollments = get_user_meta($current_user_id, '_user_enrollments', true);
$is_enrolled = false;

if (!empty($user_enrollments) && is_array($user_enrollments)) {
    foreach ($user_enrollments as $enrollment) {
        $user_enroll_course_id = intval($enrollment['course_id']);
        if ($user_enroll_course_id === $course_id) {
            $is_enrolled = true;
            break;
        }
    }
}
?>

<div class="enroll">
    <?php if (!$current_user_id): ?>
        <!-- Not Logged In -->
        <button class="enroll-btn yellow-bg-btn"
                data-course-id="<?php echo esc_attr($course_id); ?>">
            Enroll Now
        </button>

    <?php elseif ($is_enrolled): ?>
        <!-- Logged in + Enrolled -->
            <a href="<?php echo esc_url(home_url('/start-your-learning/?course_id=' . $user_enroll_course_id)); ?>"
           class="enroll-btn black-btn">
            Start Learning
        </a>

    <?php else: ?>
        <!-- Logged in but NOT enrolled -->
        <button class="enroll-btn yellow-bg-btn" data-course-id="<?php echo esc_attr($course_id); ?>">
            Enroll Now
        </button>
    <?php endif; ?>
</div>
    <h3>This courses includes:</h3>
    <div class="courses-card-items item1">

        <?php get_template_part('template-parts/single-course/svg/price-card-video', 'svg'); ?>

        <div class="text">
            <?php if ($video_hours): ?>
                <p>
                    <?php echo esc_html($video_hours) . ' ' . __('hours on-demand vedio', 'lessonlms'); ?>
                </p>
            <?php endif; ?>
        </div>
    </div>

    <div class="courses-card-items item2">
        <?php get_template_part('template-parts/single-course/svg/price-card-article', 'svg'); ?>

        <div class="text">
            <p>
                <?php echo esc_html($total_articles) . ' ' . __('articles', 'lessonlms'); ?>
            </p>
        </div>
    </div>

    <div class="courses-card-items item3">
        <?php get_template_part('template-parts/single-course/svg/price-card-download', 'svg'); ?>

        <div class="text">

            <p>
                <?php echo esc_html($downlable_resource) . ' ' . __('downable resource', 'lessonlms'); ?>
            </p>

        </div>
    </div>

    <div class="courses-card-items item3">
        <?php get_template_part('template-parts/single-course/svg/price-card-access', 'svg'); ?>

        <div class="text">
            <p>
                <?php echo esc_html_e('Full lifetime Access', 'lessonlms'); ?>
            </p>
        </div>
    </div>
    <div class="courses-card-items item3">
        <?php get_template_part('template-parts/single-course/svg/price-card-mobile', 'svg'); ?>

        <div class="text">
            <p>
                <?php echo esc_html_e('Access on mobile and TV', 'lessonlms'); ?>
            </p>
        </div>
    </div>
    <div class="courses-card-items item3">
        <?php get_template_part('template-parts/single-course/svg/price-card-certification', 'svg'); ?>
        <div class="text">
            <p>
                <?php echo esc_html_e('Certificate on completion', 'lessonlms'); ?>
            </p>
        </div>
    </div>
</div>
</div>