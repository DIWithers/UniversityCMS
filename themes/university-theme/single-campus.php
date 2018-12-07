<!-- Whenever a custom post type is registered, WP is automatically on the lookout for a file in your theme folder named "single-[postType]" to use for display -->
<?php get_header(); 
    pageBanner();
?>
<!-- Individual Post -->
<?php
    while(have_posts()) {
        the_post(); ?>
        <div class="container container--narrow page-section">
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                    <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus'); ?>">
                        <i class="fa fa-home" aria-hidden="true"></i> 
                        All Campuses
                    </a> 
                    <span class="metabox__main">
                        <?php the_title(); ?> 
                    </span>
                </p>
            </div>
            <div class="generic-content"><?php the_content(); ?></div>
                <div class="acf-map">
                    <?php $mapLocation = get_field('map_location'); ?>
                    <div 
                    class="marker" 
                    data-lat="<?php echo $mapLocation['lat']?>" 
                    data-lng="<?php echo $mapLocation['lng']?>">
                    <h3><?php the_title() ?></h3>
                    <p><?php echo $mapLocation['address'] ?></p>
                    </div>
                </div>
                <div><p><?php echo $mapLocation['address'] ?></p></div>
            <?php
                $relatedPrograms = new WP_Query(array(
                    'posts_per_page' => -1,
                    'post_type' => 'program',
                    'orderby' => 'title',
                    'order' => 'ASC',
                    'meta_query' => array(
                        array(
                            'key' => 'related_campus',
                            'compare' => 'LIKE',
                            'value' => '"' . get_the_ID() . '"'
                        )
                    )
                ));
                if ($relatedPrograms->have_posts()) {
                    echo '<hr class="section-break">';
                    echo '<h2 class="headline headline--medium">Programs Available</h2>';
                    echo '<ul class="min-list link-list">';
                    while($relatedPrograms->have_posts()) {
                        $relatedPrograms->the_post();
                ?>
                    <li>
                        <a href="<?php the_permalink();?>"><?php the_title(); ?>
                        </a>
                    </li>
                <?php
                    }
                    echo '</ul>';
                }
                wp_reset_postdata(); // important when running multiple custom queries
                $today = date('Ymd');
                $homepageEvents = new WP_Query(array(
                    'posts_per_page' => 2,
                    'post_type' => 'event',
                    'meta_key' => 'event_date',
                    'orderby' => 'meta_value_num',
                    'order' => 'ASC',
                    'meta_query' => array(
                        array(
                            'key' => 'event_date',
                            'compare' => '>=',
                            'value' => $today, 
                            'type' => 'numeric'
                        ),
                        array(
                            'key' => 'related_programs',
                            'compare' => 'LIKE',
                            'value' => '"' . get_the_ID() . '"'
                        )
                    )
                ));
                if ($homepageEvents->have_posts()) {
                    echo '<hr class="section-break">';
                    echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title() . ' Events</h2>';
                    while($homepageEvents->have_posts()) {
                        $homepageEvents->the_post();
                        get_template_part('template-parts/content', 'event'); // 2nd arg appends onto filename with '-'
                    }
                }
            ?>
        </div>
    <?php }
?>
<?php get_footer(); ?>