<!-- File name is important; this edits the archive settings for the custom post type of 'event' -->
<!-- WP archive page (i.e. when you click on an author or category link) -->
<?php 
  get_header();
  pageBanner(array(
  'title' => 'All Events',
  'subtitle' => "See what's going on.",
  )); 
?>
<div class="container container--narrow page-section">
  <?php while(have_posts()) { the_post(); 
    get_template_part('template-parts/content', 'event'); // 2nd arg appends onto filename with '-'
    } ?>
  <?php echo paginate_links(); ?>
  <hr class="section-break">
  <p>Looking for a recap of past events? <a href="<?php echo site_url('/past-events') ?>"> Check out our past events archive</a><p>
</div>

<?php get_footer(); ?>