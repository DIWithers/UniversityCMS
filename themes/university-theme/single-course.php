<!-- Whenever a custom post type is registered, WP is automatically on the lookout for a file in your theme folder named "single-[postType]" to use for display -->
<?php get_header(); 
    pageBanner();
?>
<!-- Individual Post -->
<?php
    while(have_posts()) {
        the_post(); ?>
        <?php $referer = wp_get_referer(); ?>
        <div class="container container--narrow page-section">
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                <?php if ($referer) { ?>
                    <a class="metabox__blog-home-link" href="<?php echo $referer ?>">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> 
                         BACK
                    </a> 
                <?php }
                    else { ?>
                    <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>">
                        <i class="fa fa-home" aria-hidden="true"></i> 
                        All Programs
                    </a> 
                    <?php }
                ?>

                    <span class="metabox__main">
                        <?php the_title(); ?> 
                    </span>
                </p>
            </div>
            <div class="generic-content"><?php the_content(); ?></div>
    <?php }
    ?>
