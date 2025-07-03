<?php
/*
 * Plugin Name:       Price by User Role for Woocommerce
 * Description:       Adjust product prices based on user roles. Offer discounts for wholesalers, increase prices for guests, and set exclusive rates for premium members with this easy-to-use plugin.
 * Version:           1.0.7
 * Requires at least: 5.6
 * Requires PHP:      7.4
 * Author:            jthemesstudio
 * Author URI:        https://jthemes.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       price-by-user-role
 * Domain Path:       /languages
 * Requires Plugins:  woocommerce
 */

defined('ABSPATH') || exit;

if ( ! defined( 'PUWC_FILE' ) ) :
    define( 'PUWC_FILE', __FILE__ );
endif;

if ( ! defined( 'PUWC_BASENAME' ) ) :
    define( 'PUWC_BASENAME', plugin_basename( PUWC_FILE ) );
endif;

if ( ! defined( 'PUWC_VERSION' ) ) :
    define( 'PUWC_VERSION', '1.0.7' );
endif;

if ( ! defined( 'PUWC_PATH' ) ) :
    define( 'PUWC_PATH', plugin_dir_path( __FILE__ ) );
endif;

if ( ! defined( 'PUWC_URL' ) ) :
    define( 'PUWC_URL', plugin_dir_url( __FILE__ ) );
endif;


// Load main plugin class
require_once PUWC_PATH . 'includes/class-price-by-user-role.php';

// Initialize the plugin
Price_By_User_Role::instance();