<?php

namespace JWP\JLP;

/**
 * Plugin activator class
 */
class Activator {

    /**
     * Runs the activator
     *
     * @return void
     */
    public function run() {
        $this->add_info();
    }

    /**
     * Adds activation info
     *
     * @return void
     */
    public function add_info() {
        $activated = get_option( 'jwp_lp_installed' );

        if ( ! $activated ) {
            update_option( 'jwp_lp_installed', time() );
        }

        update_option( 'jwp_lp_version', JWP_LP_VERSION );
    }
}