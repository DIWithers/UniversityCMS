<?php get_header(); ?>
<!-- Individual Page -->
<?php
    while(have_posts()) {
        the_post(); ?>
        <div class="page-banner">
            <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg')?>);"></div>
            <div class="page-banner__content container container--narrow">
                <h1 class="page-banner__title"><?php the_title(); ?></h1>
                <div class="page-banner__intro">
                    <p>Subtitle here</p>
                </div>
            </div>  
        </div>
        <div class="container container--narrow page-section">
            <?php $parentID = wp_get_post_parent_id(get_the_ID()) ?>
            <?php if ($parentID) { ?>
                <div class="metabox metabox--position-up metabox--with-home-link">
                    <p>
                        <a class="metabox__blog-home-link" href="<?php echo get_permalink($parentID); ?>">
                            <i class="fa fa-home" aria-hidden="true"></i> 
                            Back to <?php echo get_the_title($parentID); ?>
                        </a> 
                        <span class="metabox__main"><?php the_title(); ?></span>
                    </p>
                </div>
            <?php  }
            ?>
            <?php 
                $isParent = get_pages(array(
                    'child_of' => get_the_ID()
                ));
                if ($parentID or $isParent) { 
            ?>
                <div class="page-links">
                    <h2 class="page-links__title">
                        <a href="<?php echo get_permalink($parentID) ?>"><?php echo get_the_title($parentID) ?></a>
                    </h2>
                    <ul class="min-list">
                        <?php 
                            wp_list_pages(array(
                                'title_li' => NULL,
                                'child_of' => $parentID ? $parentID : get_the_ID(),
                                'sort_column' => 'menu_order'
                            ));
                        ?>
                    </ul>
                </div>
            <?php } ?>
            <div class="generic-content">
                <?php the_content(); ?>
            </div>
        </div>
    <?php }
?>
<?php get_footer(); ?>