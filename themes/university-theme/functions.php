<?php 
    function load_scripts_and_styles() {
        wp_enqueue_script('main-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, microtime(), true); //slideshow behavior
        wp_enqueue_style('custom-google-font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
        wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
        wp_enqueue_style('main_styles', get_stylesheet_uri(), NULL, microtime());
    }
    function manage_display_features() {
        add_theme_support('title-tag'); //wp handles header title
        add_WP_admin_menu_display_locations();
    }
    function add_WP_admin_menu_display_locations() {
        register_nav_menu('headerMenuLocation', 'Header Menu Location');
        register_nav_menu('footerLocationOne', 'Footer Location One'); 
        register_nav_menu('footerLocationTwo', 'Footer Location Two');
    }
    function adjust_queries($query) {
        // not admin screen, only for event archives, do not manipulate custom queries
        if (!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) {
            $today = date('Ymd');
            $query->set('posts_per_page', '10');
            $query->set('meta_key', 'event_date');
            $query->set('orderby', 'meta_value_num');
            $query->set('order', 'ASC');
            $query->set('meta_query', array(
                array(
                  'key' => 'event_date',
                  'compare' => '>=',
                  'value' => $today, 
                  'type' => 'numeric'
                )
            ));
        }
    }

    add_action('wp_enqueue_scripts','load_scripts_and_styles');
    add_action('after_setup_theme','manage_display_features');
    add_action('pre_get_posts', 'adjust_queries');

?>