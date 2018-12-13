<?php

    function registerSearch() {
        register_rest_route('university/v1', 'search', array(
            'methods' => WP_REST_SERVER::READABLE,
            'callback' => 'getSearchResults'
        ));
    }
    function getSearchResults($data) {
        $query = new WP_Query(array(
            'post_type' => array('post', 'page', 'professor', 'program', 'campus', 'event'),
            's' => sanitize_text_field($data['keyword']),
            'posts_per_page' => -1
        ));
        $results=array(
            'generalInfo' => array(),
            'professors' => array(),
            'programs' => array(),
            'events' => array(),
            'campuses' => array()
        );
        
        //categorize results
        while($query->have_posts()) {
            $query->the_post();
            if (get_post_type() == 'post' OR get_post_type() == 'page') {
                array_push($results['generalInfo'], array(
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'postType' => get_post_type(),
                    'authorName' => get_the_author()
                ));
            }
            if (get_post_type() == 'professor') {
                array_push($results['professors'], array(
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
                ));
            }
            if (get_post_type() == 'program') {
                array_push($results['programs'], array(
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'id' => get_the_id()
                ));
            }
            if (get_post_type() == 'campus') {
                array_push($results['campuses'], array(
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink()
                ));
            }
            if (get_post_type() == 'event') {
                $rawDate = get_field('event_date', false, false);
                $eventDate = new DateTime($rawDate);
                $description = "";
                if (has_excerpt()) $description = get_the_excerpt();
                else $description = wp_trim_words(get_the_content(), 18);

                array_push($results['events'], array(
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'month' => $eventDate->format('M'),
                    'day' => $eventDate->format('d'),
                    'description' => $description
                ));
            }
        }
        //Relate searched programs to professors
        $programsMetaQuery = array('relation' => 'OR');
        foreach ($results['programs'] as $item) {
            array_push(
                $programsMetaQuery,
                array(
                    'key' => 'related_programs',
                    'compare' => 'LIKE',
                    'value' => $item['id']
                )
            );
        }
        $programRelationshipQuery = new WP_Query(array(
            'post_type' => 'professor',
            'meta_query' => $programsMetaQuery
        ));
        while($programRelationshipQuery->have_posts()) {
            $programRelationshipQuery->the_post();
            if (get_post_type() == 'professor') {
                array_push($results['professors'], array(
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
                ));
            }
        }

        $results['professors'] = array_values(array_unique($results['professors'], SORT_REGULAR)); //remove dups and keys
        return $results;
    }

    add_action('rest_api_init', 'registerSearch');
?>