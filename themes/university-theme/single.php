<?php get_header(); ?>
<!-- Individual Post -->
<?php
    while(have_posts()) {
        the_post(); ?>
        <h2><?php the_title(); ?></h2>
        <?php the_content(); ?>
    <?php }
?>
<?php get_footer(); ?>