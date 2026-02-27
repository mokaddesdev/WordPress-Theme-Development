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
    <header class="header-area">
        <div class="container">
            <div class="logo">
                <img src="<?php echo get_template_directory_uri()?>/assets/images/header-logo.png" alt="Header Logo">
            </div>
            <nav class="menus">
                <!-- mobile menu -->
                <div class="head">
                    <div class="logo">
                        <img src="" alt="">
                    </div>
                    <button type="button" class="menu-close-btn btn-icon">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <ul class="menu">
                    <li><a href="#">Home</a></li>
                    <li class="dropdown"><a href="#">
                        About
                        <i class="fa-solid fa-angle-down"></i>
                    </a>
                    <ul class="sub-menus">
                        <li><a href="#">A</a></li>
                        <li><a href="#">A</a></li>
                        <li><a href="#">A</a></li>
                        <li><a href="#">A</a></li>
                    </ul>
                    </li>
                    <li><a href="#">Courses</a></li>
                    <li  class="dropdown">
                        <a href="#">
                            Blog
                            <i class="fa-solid fa-angle-down"></i>
                        </a>
                        <ul class="sub-menus">
                        <li><a href="#">A</a></li>
                        <li><a href="#">A</a></li>
                        <li><a href="#">A</a></li>
                        <li><a href="#">A</a></li>
                    </ul>
                </li>
                    <li><a href="#">News</a></li>
                </ul>
            </nav>
            <div class="header-right">
                <button type="button" class="search-btn btn-icon"><i class="fa-solid fa-magnifying-glass"></i></button>
                <button type="button" class="shoping-cart-btn btn-icon"><i class="fa-solid fa-cart-shopping"></i></button>
                <!-- open menus -->
                 <button type="button" class="open-menu btn-icon"><i class="fa-solid fa-bars"></i></button>
            </div>
        </div>
    </header>
 

    <button class="scroll-top-btn"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
        </svg>
    </button>