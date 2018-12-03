<?php 
    function add_custom_post_types() {
        register_post_type('event', array(
            'public' => true,
            'labels' => array(
                'name' => 'Events'
            ),
            'menu_icon' => 'dashicons-calendar'
        ));
    }
    add_action('init', 'add_custom_post_types');
?>