<?php
if (!defined('ABSPATH')) {
    exit;
}

class Puwc_Single_Product_Setting extends Puwc_Global_Setting
{

    public function __construct()
    {
        add_action('add_meta_boxes', array( $this, 'product_field_metabox' ), 10, 1);
    }

    public function product_field_metabox()
    {
        add_meta_box(
            'puwc_single_product_fields',
            esc_html__('Price by User Role', 'price-by-user-role' ),
            array( $this, 'single_product_fields' ),
            'product',
            'normal',
            'core'
        );
    }

    // Add custom fields to product category
    public function single_product_fields($product){
        global $wp_roles;
        $wp_roles->role_names['guest'] = esc_html__('Visitor (Unregistered Users)', 'price-by-user-role');
        // $option_value = [];
        $option_value = get_post_meta( $product->ID, 'puwc_setting', true );
        
        include_once PUWC_PATH . '/includes/admin/views/puwc-single-product-fields-html.php';
    }
}
    
new Puwc_Single_Product_Setting();
