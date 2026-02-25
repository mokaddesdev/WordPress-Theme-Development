    <?php 
    /**
     * Register Testimonial Custom Post Type
     */
    function lessonlms_testimonial_register()
    {
        $labels = array(
            "name"               => __( "Testimonials", "lessonlms" ),
            "singular_name"      => __( "Testimonial", "lessonlms" ),
            "name_admin_bar"     =>  __( "Testimonial", "lessonlms" ),
            "add_new"            => __( "Add New", "lessonlms" ),
            "add_new_item"       => __( "Add New Testimonial", "lessonlms" ),
            "new_item"           => __( "New Testimonial", "lessonlms"),
            "edit_item"          => __( "Edit Testimonial", "lessonlms" ),
            "view_item"          => __( "View Testimonial", "lessonlms" ),
            "all_items"          => __( "All Testimonials", "lessonlms" ),
            "search_item"        => __( "Search Testimonials", "lessonlms" ),
            "not_found"          => __( "No Testimonials found.", "lessonlms" ),
            "not_found_in_trash" => __( "No Testimonials found in trash.", "lessonlms" ),
        );
        $args = array(
            "labels"=> $labels,
            'description'        => 'Testimonial custom post type.',
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'show_in_rest'       => true,
            'rewrite'            => array( 'slug' => 'testimonials' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_icon'          => 'dashicons-format-quote',
            'menu_position'      => 33,
            'supports'           => array( 'title', 'editor', 'thumbnail'),
        );

        register_post_type( 'testimonials', $args );
    }
    add_action( 'init', 'lessonlms_testimonial_register' );

     require_once get_template_directory() . '/inc/meta-boxes/testimonial-meta-box.php';

