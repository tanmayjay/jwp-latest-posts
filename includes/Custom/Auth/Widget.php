<?php

namespace JWP\JLP\Custom\Auth;

/**
 * Dashboard widget handler class
 */
class Widget {

    /**
     * Initializes the creation of widget
     *
     * @return void
     */
    public function create() {
        add_action( 'wp_dashboard_setup', [ self::class, 'add' ] );
    }

    /**
     * Adds the dashboard wizard
     *
     * @return void
     */
    public static function add() {

        if ( current_user_can( 'edit_dashboard' ) ) {
            
            wp_add_dashboard_widget( 
                'jwp_lp_widget', 
                esc_html__( 'Latest Posts', JWP_LP_DOMAIN ), 
                [ self::class, 'render' ],
                [ self::class, 'configure' ],
                'normal', 
                'high' 
            );
        } else {

            wp_add_dashboard_widget( 
                'jwp_lp_widget', 
                esc_html__( 'Latest Posts', JWP_LP_DOMAIN ), 
                [ self::class, 'render' ],
                'normal', 
                'high' 
            );
        }

        global $wp_meta_boxes;
        
        $default_dashboard     = $wp_meta_boxes['dashboard']['normal']['core'];
        $example_widget_backup = array( 'jwp_lp_widget' => $default_dashboard['jwp_lp_widget'] );

        unset( $default_dashboard['jwp_lp_widget'] );

        $sorted_dashboard = array_merge( $example_widget_backup, $default_dashboard );
        $wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
    }

    /**
     * Renders the posts in the widget
     *
     * @return void
     */
    public static function render() {

        wp_enqueue_style( 'jwp-lp-style' );

        $number_posts = get_option( 'jwp_lpw_number_posts', 5 );
        $order        = get_option( 'jwp_lpw_order', 'desc' );
        $categories   = get_option( 'jwp_lpw_categories' );
        $order_by     = 'ID';

        if ( $order == 'rand' ) {
            $order_by = $order;
            $order    = '';
        }

        $args = array(
            'numberposts'  => $number_posts,
            'category__in' => $categories,
            'order'        => $order,
            'orderby'      => $order_by
        );
        
        $posts = get_posts( $args );

        if ( $posts ) {
            $template = __DIR__ . '/views/post-list.php';
            include $template;
        } else {
            print( '<h4>No post to show</h4>' );
        }

    }

    /**
     * Configures the post filtering
     *
     * @return void
     */
    public static function configure() {

        if ( ! current_user_can( 'edit_dashboard' ) ) {
            return;
        }

        if( isset( $_POST['dashboard-widget-nonce'] ) && ! wp_verify_nonce( $_POST['dashboard-widget-nonce'], 'edit-dashboard-widget_jwp_lp_widget' ) ) {
            return;
        }

        $total_post = jwp_lp_count_posts();
        $terms      = jwp_lp_get_category_terms();
        
        foreach ( $terms as $term ) {
            $term_ids[] = intval( $term->term_id );
        }

        $orders = array(
            'Ascending'  => 'asc',
            'Descending' => 'desc',
            'Random'     => 'rand'
        );

        $number_posts = get_option( 'jwp_lpw_number_posts', 5 );
        $order        = get_option( 'jwp_lpw_order', 'desc' );
        $categories   = get_option( 'jwp_lpw_categories' );

        if ( ! $categories ) {
            $categories = [];
            $categories = array_merge( $categories, $term_ids );
        }
        
        if ( isset( $_POST['numberposts'] ) ) {
            $number_posts = intval( $_POST['numberposts'] );
            update_option( 'jwp_lpw_number_posts', $number_posts );
        }
        
        if ( isset( $_POST['order'] ) ) {
            $order = $_POST['order'];
            update_option( 'jwp_lpw_order', $order );
        }
        
        if ( isset( $_POST['category'] ) ) {
            $category = $_POST['category'];
            update_option( 'jwp_lpw_categories', $category );
        }

        $template = __DIR__ . '/views/post-config.php';

        include $template;
    }
}