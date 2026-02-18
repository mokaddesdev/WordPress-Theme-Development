<?php 
/**
 * Template Name: Student Dashboard Sidebar
 * 
 */
 ?>
<!-- LEFT SIDEBAR -->
    <nav class="std-sidebar">

        <ul class="sidebar-menu-tabs-items">
            <li class="active-menu" data-sidetab="dashboard" data-nonce="<?php echo wp_create_nonce('sidebar_menu_ajax_action'); ?>">
                Dashboard
            </li>
            <li data-sidetab="profile" data-nonce="<?php echo wp_create_nonce( 'sidebar_menu_ajax_action' )?>">
                Profile
            </li>
            <li data-sidetab="enrollments" data-nonce="<?php echo wp_create_nonce( 'sidebar_menu_ajax_action' )?>">
                See Courses
            </li>
             <li class="active-menu" data-sidetab="dashboard" data-nonce="<?php echo wp_create_nonce('sidebar_menu_ajax_action'); ?>">
                Leadership
            </li>
            <li>
                <a href="<?php echo esc_url(wp_logout_url(), 'lessonlms'); ?>">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <?php echo esc_html__('Logout', 'lessonlms'); ?>  
                </a>
            </li>

        </ul>

    </nav>