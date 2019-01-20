<?php
    if (!is_user_logged_in()) {
        wp_redirect(esc_url(site_url('/')));
        exit;
    }
?>
<?php acf_form_head(); ?> 
<?php get_header(); ?>
<?php
    while(have_posts()) {
        the_post();
        pageBanner(array(
            'title' => get_the_title()
        ));
        ?>
        <div class="container-fluid">
            <div class="form-row">
                <div class="new-student">
                    <h2 class="headline headline--medium">New Registration</h2>
                    <!-- acf -->
                    <div class="student-form-container">
                    <?php acf_form(array(
                                        'post_id'		=> 'new_post',
                                        'new_post'		=> array(
                                            'post_type'		=> 'student',
                                            'post_status'		=> 'publish'
                                        ),
                                        'submit_value'		=> 'Create New Student'
                                    )); ?>
                    </div>
                    <!-- acf -->

                </div>
                <div class="students">
                    <div class="mt-2 student-search">
                        <form class="form-inline">
                            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                        </form>
                    </div>
                    <div class="student-list">
                        <ul>
                            <?php 
                            $student = new WP_Query(array(
                                'post_type' => 'student',
                                'posts_per_page' => -1,
                                'author' => get_current_user_id()
                            ));

                            while($student->have_posts()) {
                                $student->the_post();
                            ?>
                            <li data-id="<?php the_ID(); ?>"><?php echo str_replace('Private: ', '', esc_attr(get_the_title())); ?>
                            </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php }
?>
<?php get_footer(); ?>