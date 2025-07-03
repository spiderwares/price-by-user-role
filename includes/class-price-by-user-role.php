<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Price_By_User_Role' ) ) :

    /**
     * Main Price_By_User_Role Class
     *
     * @class Price_By_User_Role
     * @version 1.0.0
     */
    final class Price_By_User_Role {

        /**
         * The single instance of the class.
         *
         * @var Price_By_User_Role
         */
        protected static $instance = null;

        /**
         * Singleton instance.
         *
         * @return Price_By_User_Role
         */
        public static function instance() {
            if ( is_null( self::$instance ) ) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        /**
         * Constructor.
         */
        private function __construct() {
            $this->init_hooks();
        }

        /**
         * Initialize actions and filters.
         */
        private function init_hooks() {
            add_action( 'plugins_loaded', array( $this, 'check_woocommerce_dependency' ), 10 );
            add_action( 'puwc_init', array( $this, 'includes' ) );
        }

        /**
         * Check if WooCommerce is active before initializing plugin.
         */
        public function check_woocommerce_dependency() {
            if ( ! function_exists( 'WC' ) ) {
                add_action( 'admin_notices', array( $this, 'woocommerce_admin_notice' ) );
            } else {
                do_action( 'puwc_init' );
            }
        }

        /**
         * Display admin notice if WooCommerce is not active.
         */
        public function woocommerce_admin_notice() {
            ?>
            <div class="error notice is-dismissible">
                <p><?php esc_html_e( 'Prices by User Role for WooCommerce is active but requires WooCommerce to function.', 'price-by-user-role' ); ?></p>
            </div>
            <?php
        }

        /**
         * Load plugin components based on context.
         */
        public function includes() {
            if ( is_admin() ) :
                include_once PUWC_PATH. 'includes/class-puwc-install.php';
                include_once PUWC_PATH. 'includes/admin/class.puwc-global-setting.php';
                include_once PUWC_PATH. 'includes/admin/class.puwc-product-cat-setting.php';
                include_once PUWC_PATH. 'includes/admin/class.puwc-single-product-setting.php';
            endif;

            if (!is_admin() || !isset($GLOBALS['pagenow']) || $GLOBALS['pagenow'] !== 'edit.php' || !isset($_GET['post_type']) || $_GET['post_type'] !== 'product') :
                include_once PUWC_PATH. 'includes/public/class.puwc-price-controller.php';
            endif;
        }

    }

endif;

// Initialize the plugin.
return Price_By_User_Role::instance();
