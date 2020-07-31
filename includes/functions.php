<?php

/**
 * Retrives total number of published post
 *
 * @return int
 */
function jwp_lp_count_posts() {
    return wp_count_posts()->publish;
}

/**
 * Retrieve the terms with category taxonomy
 *
 * @return object
 */
function jwp_lp_get_category_terms() {
    $terms = get_terms( array(
        'taxonomy'   => 'category',
        'hide_empty' => false,
    ) );
    
    return $terms;
}