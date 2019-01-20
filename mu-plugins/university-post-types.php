<?php 
    function add_custom_post_types() {
        register_post_type('campus', array(
            'public' => true,
            'labels' => array(
                'name' => 'Campuses',
                'singular_name' => 'Campus',
                'add_new_item' => 'Add New Campus',
                'edit_item' => 'Edit Campus',
                'all_items' => 'All Campuses'
            ),
            'rewrite' => array('slug' => 'campuses'),
            'menu_icon' => 'dashicons-location-alt',
            'has_archive' => true,
            'supports' => array('title', 'editor', 'excerpt'),
            'capability_type' => 'campus',
            'map_meta_cap' => true
        ));

        register_post_type('event', array(
            'public' => true,
            'labels' => array(
                'name' => 'Events',
                'singular_name' => 'Event',
                'add_new_item' => 'Add New Event',
                'edit_item' => 'Edit Event',
                'all_items' => 'All Events'
            ),
            'rewrite' => array('slug' => 'events'),
            'menu_icon' => 'dashicons-calendar',
            'has_archive' => true,
            'supports' => array('title', 'editor', 'excerpt'),
            'capability_type' => 'event',
            'map_meta_cap' => true
        ));

        register_post_type('program', array(
            'public' => true,
            'labels' => array(
                'name' => 'Programs',
                'singular_name' => 'Program',
                'add_new_item' => 'Add New Program',
                'edit_item' => 'Edit Program',
                'all_items' => 'All Programs'
            ),
            'rewrite' => array('slug' => 'programs'),
            'menu_icon' => 'dashicons-awards',
            'has_archive' => true,
            'supports' => array('title'),
            'capability_type' => 'program',
            'map_meta_cap' => true
        ));

        register_post_type('professor', array(
            'public' => true,
            'labels' => array(
                'name' => 'Professors',
                'singular_name' => 'Professor',
                'add_new_item' => 'Add New Professor',
                'edit_item' => 'Edit Professor',
                'all_items' => 'All Professors'
            ),
            'menu_icon' => 'dashicons-admin-users',
            'supports' => array('title', 'editor', 'thumbnail')
        ));

        register_post_type('note', array(
            'public' => false,
            'show_ui' => true,
            'labels' => array(
                'name' => 'Notes',
                'singular_name' => 'Note',
                'add_new_item' => 'Add New Note',
                'edit_item' => 'Edit Note',
                'all_items' => 'All Notes'
            ),
            'menu_icon' => 'dashicons-welcome-write-blog',
            'supports' => array('title', 'editor', 'author'),
            'capability_type' => 'note',
            'map_meta_cap' => true,
            'show_in_rest' => true,
        ));

        register_post_type('like', array(
            'public' => false,
            'show_ui' => true,
            'labels' => array(
                'name' => 'Likes',
                'singular_name' => 'Like',
                'add_new_item' => 'Add New Like',
                'edit_item' => 'Edit Like',
                'all_items' => 'All Likes'
            ),
            'menu_icon' => 'dashicons-heart',
            'supports' => array('title'),
        ));

        register_post_type('slide', array(
            'show_ui' => true,
            'labels' => array(
                'name' => 'Slides',
                'singular_name' => 'Slide',
                'add_new_item' => 'Add New Slide',
                'edit_item' => 'Edit Slide',
                'all_items' => 'All Slides'
            ),
            'menu_icon' => 'dashicons-slides',
            'supports' => array('title'),
        ));

        register_post_type('student', array(
            'public' => true,
            'show_ui' => true,
            'labels' => array(
                'name' => 'Students',
                'singular_name' => 'Student',
                'add_new_item' => 'Add New Student',
                'edit_item' => 'Edit Student',
                'all_items' => 'All Students'
            ),
            'menu_icon' => 'dashicons-id-alt',
            'supports' => array(''),
            'capability_type' => 'student',
            'map_meta_cap' => true,
            'show_in_rest' => true,
        ));

        register_post_type('course', array(
            'public' => true,
            'labels' => array(
                'name' => 'Courses',
                'singular_name' => 'Course',
                'add_new_item' => 'Add New Course',
                'edit_item' => 'Edit Course',
                'all_items' => 'All Courses'
            ),
            'menu_icon' => 'dashicons-welcome-learn-more',
            'has_archive' => true,
            'supports' => array('title', 'editor'),
            'capability_type' => 'course',
            'map_meta_cap' => true
        ));
    }
    add_action('init', 'add_custom_post_types');
?>