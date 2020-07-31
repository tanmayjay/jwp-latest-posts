<?php

namespace JWP\JLP;

/**
 * Custom handler class
 */
class Custom {

    /**
     * Class constructor
     */
    function __construct() {
        
        if ( is_user_logged_in() ) {
            $widget = new Custom\Auth\Widget();
            $widget->create();
        }
    }
}