<?php 
    function add_custom_post_types() {
        register_post_type('event', array(
            'public' => true,
            'labels' => array(
                'name' => 'Events',
                'singular_name' => 'Event',
                'add_new_item' => 'Add New Event',
                'edit_item' => 'Edit Event',
                'all_items' => 'All Events'
            ),
            'menu_icon' => 'dashicons-calendar'
        ));
    }
    add_action('init', 'add_custom_post_types');
?>