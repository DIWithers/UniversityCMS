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
            'menu_icon' => 'dashicons-welcome-learn-more',
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
    }
    add_action('init', 'add_custom_post_types');
?>