<?php 
/**
 * default settings
 */


function lessonlms_theme_register(){

    add_theme_support('post-thumbnails');

    add_theme_support('custom-logo',array(
        'height' => 34,
        'width'  => 85,
    ));
     
    add_image_size('custom-courses-image',370,278,true);
    add_image_size('custom-blog-image',370,250,true);
    

    register_nav_menus( array(
    'header_menu'  => __('LMS Header Menu','lessonlms'),
    'mobile_menu'  => __('LMS Mobile Menu','lessonlms'),
    'footer_menu1' => __('LMS Footer Menu1','lessonlms'),
    'footer_menu2' => __('LMS Footer Menu2','lessonlms'),
    'footer_menu3' => __('LMS Footer Menu3','lessonlms'),
    ) );
	}

add_action('after_setup_theme','lessonlms_theme_register');

// set up woocommerse
function lessonlms_woocommerce_setup() {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 150,
			'single_image_width'    => 300,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 4,
				'min_columns'     => 1,
				'max_columns'     => 6,
			),
		)
	);
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'lessonlms_woocommerce_setup' );