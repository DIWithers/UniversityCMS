<?php
    if (!is_user_logged_in()) {
        wp_redirect(esc_url(site_url('/')));
        exit;
    }
?>
<?php get_header(); ?>
<?php
    while(have_posts()) {
        the_post();
        pageBanner(array(
            'title' => get_the_title()
        ));
        ?>
        <div class="container container--narrow page-section">
            Custom code will go here
        </div>
    <?php }
?>
<?php get_footer(); ?>