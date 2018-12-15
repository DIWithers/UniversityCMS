<!-- If your theme folder contains a 'search.php' file, Wordpress will use it to power the results page after a search -->
<?php 
  get_header();
  pageBanner(array(
    'title' => 'Search Results',
    'subtitle' => 'You searched for &ldquo;' . esc_html(get_search_query()) . '&rdquo;'
  ));
?>
<div class="container container--narrow page-section">
  <?php 
    while(have_posts()) { 
        the_post(); 
        get_template_part('template-parts/content', get_post_type());
    ?>

  <?php } ?>
  <?php echo paginate_links(); ?>
</div>

<?php get_footer(); ?>