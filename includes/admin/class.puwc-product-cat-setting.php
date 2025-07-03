<?php
if (!defined('ABSPATH')) {
    exit;
}

class Puwc_Product_Cat_Setting extends Puwc_Global_Setting {
    
    public function __construct() {
        add_action('product_cat_edit_form_fields', array( $this, 'product_cat_fields' ), 20 );
    }

    // Add custom fields to product category
    public function product_cat_fields($term) {
        $option_value   = get_term_meta($term->term_id, 'puwc_setting', true);
        $option_value   = !empty($option_value) ? $option_value : array();
        global $wp_roles;
        $wp_roles->role_names['guest'] = esc_html__('Visitor (Unregistered Users)', 'price-by-user-role');
        
        include_once PUWC_PATH . '/includes/admin/views/puwc-product-cat-fields-html.php';
    }

}

new Puwc_Product_Cat_Setting();