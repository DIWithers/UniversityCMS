<?php 
function likeRoutes() {
    register_rest_route('university/v1', 'manageLike', array(
        'methods' => 'POST',
        'callback' => 'createLike'
    ));
    register_rest_route('university/v1', 'manageLike', array(
        'methods' => 'DELETE',
        'callback' => 'deleteLike'
    ));
}
function createLike($data) {
    if (is_user_logged_in()) {
        $professor = sanitize_text_field($data['professorId']);
        $likeExistsQuery = new WP_Query(array(
            'author' => get_current_user_id(),
            'post_type' => 'like',
            'meta_query' => array(
                array(
                    'key' => 'liked_professor_id',
                    'compare' => '=',
                    'value' => $professor
                )
            )
        ));
        if ($likeExistsQuery->found_posts == 0 AND get_post_type($professor) == 'professor') {
            return wp_insert_post(array(
                'post_type' => 'like',
                'post_status' => 'publish',
                'meta_input' => array(
                    'liked_professor_id' => $professor
                )
            ));
        }
        else {
            die("Like already exists.");
        }
    }
    else {
        die('You must be logged in to create a Like.');
    }
}
function deleteLike($data) {
    $likeId = sanitize_text_field($data['like']);
    //can only delete your own like
    $isMyPost = get_current_user_id() == get_post_field('post_author', $likeId);
    if ($isMyPost AND get_post_type($likeId) == 'like') {
        wp_delete_post($likeId, true);
    }
    else {
        die ("You do not have permission to perform this operation. ");
    }
}
add_action('rest_api_init', 'likeRoutes');
?>