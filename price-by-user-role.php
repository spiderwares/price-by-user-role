<?php
/*
 * Plugin Name:       Price by User Role
 * Description:       Adjust product prices based on user roles. Offer discounts for wholesalers, increase prices for guests, and set exclusive rates for premium members with this easy-to-use plugin.
 * Version:           1.0.3
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

if (! defined('PUWC_FILE') ) :
    define('PUWC_FILE', __FILE__);
endif;

if (! defined('PUWC_BASENAME') ) :
    define('PUWC_BASENAME', plugin_basename(PUWC_FILE));
endif;

if (! defined('PUWC_VERSION') ) :
    define('PUWC_VERSION', '1.0.3');
endif;

if (! defined('PUWC_PATH') ) :
    define('PUWC_PATH', plugin_dir_path(__FILE__));
endif;

if (! defined('PUWC_URL') ) :
    define('PUWC_URL', plugin_dir_url(__FILE__));
endif;


if (! function_exists('puwc_constructor') ) :

    function puwc_constructor()
    {
        if(is_admin() ) :
            include_once 'includes/admin/class.puwc-global-setting.php';
            include_once 'includes/admin/class.puwc-product-cat-setting.php';
            include_once 'includes/admin/class.puwc-single-product-setting.php';
        else :
            include_once 'includes/public/class.puwc-price-controller.php';
        endif;
    }
    add_action('puwc_init', 'puwc_constructor');

endif;


if (! function_exists('puwc_woocommerce_admin_notice') ) :

    function puwc_woocommerce_admin_notice()
    {
        ?>
        <div class="error">
            <p><?php esc_html_e('Prices by User Role for WooCommerce is enabled but not effective. It requires WooCommerce to work.', 'price-by-user-role'); ?></p>
        </div>
        <?php
    }

endif;


if (! function_exists('puwc_install') ) :

    function puwc_install()
    {
        if (! function_exists('WC') ) :
            add_action('admin_notices', 'puwc_woocommerce_admin_notice');
     else :
         do_action('puwc_init');
     endif;
    }
    add_action('plugins_loaded', 'puwc_install', 10);

endif;
