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
                <div class="logo">
                    <!----- logo ----->
                <?php if ( has_custom_logo() ) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                    </a>
                <?php endif; ?>
                </div>

                <!----- main-menu and button ----->
                <div class="menu-button-wrapper">
                    <nav class="main-menu">
                        <?php wp_nav_menu( array( 
                            'theme_location' => 'primary_menu'
                        ) ); ?>
                    </nav>
                          <!----- shop cart and profile ----->
                    <div class="shop-cart-profile">
                             <!-- shop cart button -->
                     <div class="shop-cart-btn">
                        <i class="fa-solid fa-basket-shopping"></i>
                     </div>
                    <style>
                        .shop-cart-profile{
                            display: flex;
                            flex-direction: row;
                            align-items: center;
                            gap: 10px;
                        }
                     .profile-info{
  position: relative;
  display: inline-block;
}

.profile-btn{
  cursor: pointer;
}

.profile-cart {
  visibility: hidden;
  opacity: 0;
  transition: 0.3s ease-in-out;
  position: absolute;
  top: 100%;
  right: 0;
  background-color: white;
  width: 230px;
  height: 50px;
  border: 1px solid #f333;
  padding: 8px;
}

.profile-info:hover .profile-cart{
  visibility: visible;
  opacity: 1;
}
.profile-btn i, .dashboard-icon, .logout-icon, .shop-cart-btn i{
    font-size: 18px;
font-style: normal;
line-height: 28px; 
    color: #171100;
}
                    </style>
                     <?php
                     $current_user = is_user_logged_in();
                     if ( ! empty( $current_user ) ) :
                     ?>
<div class="profile-info">
    <button class="profile-btn"> <i class="fa-regular fa-circle-user"></i></button>

    <ul class="profile-cart">
        <li>
            <a href="<?php echo esc_url( home_url("/student-dashboard") ); ?>">
            <span class="dashboard-icon"><i class="fa-solid fa-gauge"></i></span>
                <?php echo esc_html__( 'Dashboard', 'lessonlms' ); ?>
            </a>
        </li>
        <li>
            <a href="<?php echo esc_url( wp_logout_url() ); ?>">
                <span class="logout-icon"><i class="fa-solid fa-arrow-right-from-bracket"></i></span>
                <?php echo esc_html__( 'Logout', 'lessonlms' ); ?>
            </a>
        </li>
    </ul>
</div>
                    <?php else: ?>
                        <!-- sign-up-btn -->
                      <div class="button btn-black">
                        <a href="<?php echo esc_url( wp_registration_url() ); ?>">
                        <?php echo esc_html__( 'Sign Up', 'lessonlms' ); ?>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>

                    <!----- phone menu ----->
                    <div class="menu-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 6h18M3 12h18M3 18h18" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </div>
                </div>
                
                <!----- menu item for phone ----->
                <div id="navPhone" class="menu-item-phone">

                    <!----- logo ----->
                    <div class="logo-div">
                        <div class="logo">
                            <a href="index.html">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="logo">
                            </a>
                        </div>

                        <div class="x-icon menu-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <line x1="18" y1="6" x2="6" y2="18" stroke-linecap="round" />
                                <line x1="6" y1="6" x2="18" y2="18" stroke-linecap="round" />
                            </svg>
                        </div>
                    </div>



                    <div class="menu-div">
                        <nav class="main-menu-phone">
                            <?php wp_nav_menu(array(
                                'theme_location' => 'mobile_menu'
                            )); ?>
                        </nav>
                          <?php
                     $current_user = is_user_logged_in();
                     if ( ! empty( $current_user ) ) :
                     ?>
                        <!----- sign-up-btn ----->
                        <div class="button btn-black">
                            <a href="#">Sign Up</a>
                        </div>
                        <?php endif;?>
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