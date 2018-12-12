<?php 
    function load_scripts_and_styles() {
        $googleMapsUrl = '//maps.googleapis.com/maps/api/js?key=' . GOOGLE_MAPS_API_KEY;
        wp_enqueue_script('google-map', $googleMapsUrl, NULL, microtime(), true);
        wp_enqueue_script('main-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, microtime(), true); //slideshow behavior
        wp_enqueue_style('custom-google-font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
        wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
        wp_enqueue_style('main_styles', get_stylesheet_uri(), NULL, microtime());
        wp_localize_script('main-js', 'mainData', array(
          'root_url' => get_site_url()
        ));
    }
    function manage_display_features() {
        add_theme_support('title-tag'); //wp handles header title
        add_theme_support('post-thumbnails'); // add featured image widget on admin screen
        add_image_size('professorLandscape', 400, 260, true); 
        add_image_size('professorPortrait', 480, 650, true);
        add_image_size('pageBanner', 1500, 350, true);
        add_WP_admin_menu_display_locations();
    }
    function add_WP_admin_menu_display_locations() {
        register_nav_menu('headerMenuLocation', 'Header Menu Location');
        register_nav_menu('footerLocationOne', 'Footer Location One'); 
        register_nav_menu('footerLocationTwo', 'Footer Location Two');
    }
    function adjust_queries($query) {
      if (!is_admin() AND is_post_type_archive('campus') AND $query->is_main_query()) {
        $query->set('posts_per_page', '-1');
      } 
      if (!is_admin() AND is_post_type_archive('program') AND $query->is_main_query()) {
          $query->set('posts_per_page', '-1');
          $query->set('orderby', 'title');
          $query->set('order', 'ASC');
      }
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

    function universityMapKey($api) {
      $api['key'] = GOOGLE_MAPS_API_KEY;
      return $api;
    }

    add_filter('acf/fields/google_map/api', 'universityMapKey');

    function pageBanner($args = NULL) {
      if (!$args['title']) {
          $args['title'] = get_the_title(); //WP Page Title as default
      }
      if (!$args['subtitle']) {
        $args['subtitle'] = get_field('page_banner_subtitle'); //WP Page Subtitle as default
      }
      if (!$args['photo']) {
        if (get_field('page_banner_background_image')) { //Get WP Admin uploaded photo if available
          $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner']; 
        }
        else {
          $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
        }
      }
      ?>
      <div class="page-banner">
        <div class="page-banner__bg-image" 
          style="background-image: url(
          <?php echo $args['photo']; ?>
          );">
        </div>
        <div class="page-banner__content container container--narrow">
          <h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
          <div class="page-banner__intro">
          <p><?php echo $args['subtitle']; ?></p>
          </div>
        </div>  
      </div>
      <?php 
    }

?>