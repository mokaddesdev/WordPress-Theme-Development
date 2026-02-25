<!DOCTYPE html>
<html <?php language_attributes(); ?> style="scroll-behavior: smooth;">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php bloginfo('name'); ?>-<?php bloginfo('description'); ?>
    </title>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <header>
        <div class="container">
            <div class="header-wrapper">
                <!----- logo ----->
                <div class="logo">
                    <?php if (has_custom_logo()): ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/header-logo.png"
                                alt="<?php echo esc_attr(get_bloginfo('name')) ?>" />
                        </a>
                    <?php endif; ?>
                </div>

                <!----- main-menu and button ----->
                <div class="menu-button-wrapper">
                    <nav class="main-menu">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'header_menu',
                            'container'      => false,
                            'menu_class'     => '',
                            'fallback_cb'    => false
                        ));
                        ?>
                    </nav>
                    <!----- sign-up-btn ----->
                    <div class="button btn-black">
                        <?php
                        $user_login = is_user_logged_in();
                        $user_dashboard = home_url('/my-account/');
                        if ($user_login) :
                        ?>
                            <a href="<?php echo esc_url($user_dashboard); ?>"> Dashboard </a>
                        <?php else : ?>
                            <a href="<?php echo esc_url(home_url('my-account')); ?>">Sign Up</a>
                        <?php endif; ?>
                    </div>

                    <!----- phone menu ----->
                    <div class="menu-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path d="M3 6h18M3 12h18M3 18h18" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" />
                        </svg>
                    </div>
                </div>

                <!----- menu item for phone ----->
                <div id="navPhone" class="menu-item-phone">

                    <!----- logo ----->
                    <div class="logo-div">
                        <div class="logo">
                            <?php if (has_custom_logo()) : ?>
                                <?php the_custom_logo(); ?>
                            <?php else: ?>
                                <a href="<?php echo esc_url(home_url('/')); ?>">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/header-logo.png"
                                        alt="<?php echo esc_attr(get_bloginfo('name')) ?>" />
                                </a>
                            <?php endif; ?>
                        </div>

                        <div class="x-icon menu-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <line x1="18" y1="6" x2="6" y2="18" stroke-linecap="round" />
                                <line x1="6" y1="6" x2="18" y2="18" stroke-linecap="round" />
                            </svg>
                        </div>
                    </div>

                    <div class="menu-div">
                        <nav class="main-menu-phone">
                            <?php
                            wp_nav_menu(array(
                                'theme_location' => 'mobile_menu',
                                'fallback_cb'    => false,
                            ));
                            ?>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <button class="scroll-top-btn"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
        </svg>
    </button>