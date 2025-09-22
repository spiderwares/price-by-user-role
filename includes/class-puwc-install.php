<?php
/**
 * Installation related functions and actions.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'PUWC_install' ) ) :

    /**
     * PUWC_install Class
     *
     * Handles installation processes like creating database tables,
     * setting up roles, and creating necessary pages on plugin activation.
     */
    class PUWC_install {

        /**
         * Hook into WordPress actions and filters.
         */
        public static function init() {
            add_filter( 'plugin_action_links_' . PUWC_BASENAME, array( __CLASS__, 'plugin_action_links' ) );
        }

        /**
         * Install plugin.
         *
         * Creates tables, roles, and necessary pages on plugin activation.
         */
        public static function install() {
            if ( ! is_blog_installed() ) :
                return;
            endif;   
        }


        /**
         * Add plugin action links.
         *
         * @param array $links Array of action links.
         * @return array Modified array of action links.
         */
        public static function plugin_action_links( $links ) {
            $action_links = array(
                'settings' => sprintf(
                    '<a href="%s" aria-label="%s">%s</a>',
                    admin_url( 'admin.php?page=wc-settings&tab=puwc' ),
                    esc_attr__( 'Price By User Role Settings', 'price-by-user-role' ),
                    esc_html__( 'Settings', 'price-by-user-role' )
                ),
                'upgrade' => sprintf(
                    '<a href="%s" target="_blank" style="color:#bf3131; font-weight:bold;" aria-label="%s">%s</a>',
                    esc_url( 'https://codecanyon.net/item/price-by-user-roles-in-woocommerce-plugin/52908083?srsltid=AfmBOoo3mMoceVmf6GVX4quOvFqkxbg1iMut8GxrTfAgbk03KzzVe_MT' ), // 🔗 replace with your actual upgrade URL
                    esc_attr__( 'Upgrade To Pro', 'price-by-user-role' ),
                    esc_html__( 'Upgrade To Pro', 'price-by-user-role' )
                ),
            );
            return array_merge( $action_links, $links );
        }

    }

    // Initialize the installation process
    PUWC_install::init();

endif;
