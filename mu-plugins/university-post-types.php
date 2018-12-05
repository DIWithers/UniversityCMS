<!-- Note: Hit Save in Settings -> Permalink if Page Not Found to update  -->
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
            'rewrite' => array('slug' => 'events'),
            'menu_icon' => 'dashicons-calendar',
            'has_archive' => true,
            'supports' => array('title', 'editor', 'excerpt')
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
            'supports' => array('title', 'editor')
        ));
    }
    add_action('init', 'add_custom_post_types');
?>