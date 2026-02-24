<?php 
/**
 * Template Name: Student Dashboard Sidebar
 * 
 * @package lessonlms
 */
 ?>
<!-- LEFT SIDEBAR -->
    <nav class="std-sidebar">
        <ul class="std-side-menu">
            <li class="side-tab-active" data-sidetab="dashboard">
                <i class="fa-solid fa-gauge"></i>
                <?php echo esc_html__( 'Dashboard', 'lessonlms' ); ?>
            </li>
            <li data-sidetab="profile">
                <i class="fa-regular fa-circle-user"></i> 
                 <?php echo esc_html__('Profile', 'lessonlms'); ?>
            </li>
            <li data-sidetab="enroll-course">
                <i class="fa-solid fa-book-open"></i>
                 <?php echo esc_html__('Your Courses', 'lessonlms'); ?>
            </li>
            <li>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'courses' ) ); ?>">
                    <i class="fa-solid fa-book"></i> 
                    <?php echo esc_html__('New Courses', 'lessonlms'); ?>
                </a>
            </li>
             <li data-sidetab="leadership">
                <i class="fa-solid fa-trophy"></i> 
                <?php echo esc_html__('Leadership', 'lessonlms'); ?>
            </li>
            <li>
                <a href="<?php echo esc_url(wp_logout_url(), 'lessonlms'); ?>">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <?php echo esc_html__('Logout', 'lessonlms'); ?>  
                </a>
            </li>
        </ul>
    </nav>