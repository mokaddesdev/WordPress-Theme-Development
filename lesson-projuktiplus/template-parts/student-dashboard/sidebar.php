<?php 
/**
 * Template Name: Student Dashboard Sidebar
 * 
 */
 ?>
<!-- LEFT SIDEBAR -->
    <nav class="std-sidebar">

        <ul class="std-side-menu">
            <li class="active-menu" data-sidetab="dashboard" data-nonce="<?php echo wp_create_nonce('sidebar_menu_ajax_action'); ?>">
                <i class="fa-solid fa-gauge"></i>Dashboard
            </li>
            <li data-sidetab="profile" data-nonce="<?php echo wp_create_nonce( 'sidebar_menu_ajax_action' )?>">
                <i class="fa-regular fa-circle-user"></i> Profile
            </li>
            <li data-sidetab="enrollments" data-nonce="<?php echo wp_create_nonce( 'sidebar_menu_ajax_action' )?>">
                <i class="fa-solid fa-book-open"></i>Your Courses
            </li>
            <li>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'courses' ) ); ?>">
                    <i class="fa-solid fa-book"></i> New Courses
                </a>
            </li>
             <li class="active-menu" data-sidetab="dashboard" data-nonce="<?php echo wp_create_nonce('sidebar_menu_ajax_action'); ?>">
                <i class="fa-solid fa-trophy"></i> Leadership
            </li>
            <li>
                <a href="<?php echo esc_url(wp_logout_url(), 'lessonlms'); ?>">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <?php echo esc_html__('Logout', 'lessonlms'); ?>  
                </a>
            </li>

        </ul>

    </nav>