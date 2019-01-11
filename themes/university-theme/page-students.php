<?php
    if (!is_user_logged_in()) {
        wp_redirect(esc_url(site_url('/')));
        exit;
    }
?>
<!-- todo: two thirds student form, one third all students -->
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

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">First Name</span>
                        </div>
                        <input type="text" class="form-control" aria-label="FirstName" id="first_name" required>
                    </div> 

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Last Name</span>
                        </div>
                        <input type="text" class="form-control" aria-label="LastName" id="last_name">
                    </div> 

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Middle Initial</span>
                        </div>
                        <input type="text" class="form-control" aria-label="MiddleInitial" id="middle_initial">
                    </div> 

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Mailing Address</span>
                        </div>
                        <input type="text" class="form-control" aria-label="MailingAddress" id="mailing_address">
                    </div>    

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Apt No.</span>
                        </div>
                        <input type="text" class="form-control" aria-label="ApartmentNumber" id="apartment_number">
                    </div>       

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">City</span>
                        </div>
                        <input type="text" class="form-control" aria-label="City" id="city">
                    </div>       

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">State</span>
                        </div>
                        <input type="text" class="form-control" aria-label="State" id="state">
                    </div>              

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Zip Code</span>
                        </div>
                        <input type="text" class="form-control" aria-label="ZipCode" id="zip_code">
                    </div>   

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Phone Number 1</span>
                        </div>
                        <input type="text" class="form-control" aria-label="PhoneNumber1" id="phone_number_one">
                    </div>    

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Phone Number 2</span>
                        </div>
                        <input type="text" class="form-control" aria-label="PhoneNumber2" id="phone_number_two" placeholder="Optional">
                    </div>   

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Date Of Birth</span>
                        </div>
                        <input type="date" class="form-control" aria-label="DateOfBirth" id="date_of_birth">
                    </div>     

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Gender</span>
                        </div>
                        <select type="date" class="form-control" aria-label="Genger" id="gender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="undisclosed">Prefer Not to Say</option>

                        </select>
                    </div>     
                    
                    <div class="input-group mb-3">
                        <label for="student_photo">Student Photo</label>
                        <input type="file" class="form-control-file" aria-label="StudentPhoto" id="student_photo">
                    </div>                                                                                               

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