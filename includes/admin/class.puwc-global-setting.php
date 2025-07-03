<?php

if (!defined('ABSPATH')) {
    exit;
}

class Puwc_Global_Setting
{
    public $id;
    public $label;
   
    public function __construct()
    {
        $this->id    = 'puwc';
        $this->label = esc_html__('Price by User Role', 'price-by-user-role');
        $this->event_handler();
    }

    public function event_handler()
    {
        add_filter('woocommerce_settings_tabs_array', array( $this, 'add_settings_tab' ), 25, 1);

        add_action('woocommerce_settings_' . $this->id, array( $this, 'settings_tab' ));
        add_action('woocommerce_admin_field_puwc_field', array( $this, 'puwc_admin_fields' ));
        add_action('admin_enqueue_scripts',  array( $this, 'enqueue_style' ));
        add_action('woocommerce_settings_save_' . $this->id, array( $this, 'save_puwc_woocommerce_settings' ));

    }

    function enqueue_style()
    {
        global $pagenow;
        $screen    = get_current_screen();
        $screen_id = $screen ? $screen->id : '';

        if (in_array($screen_id, wc_get_screen_ids()) ) :

            wp_enqueue_style(
                'puwc_admin_styles',
                PUWC_URL . 'assets/css/admin-styles.css',
                array(),
                PUWC_VERSION
            );

            
            if( ! class_exists( 'Price_By_User_Role_PRO' ) ):  
                wp_enqueue_style(
                    'puwc-upgrade-style',
                    PUWC_URL . 'assets/css/admin-upgrade.css',
                    array(),
                    PUWC_VERSION
                );
            endif;

        endif;
    }
    
    public function add_settings_tab( $settings_tabs )
    {
        $settings_tabs[$this->id] = $this->label;
        return $settings_tabs;
    }

    // Render settings tab
    public function settings_tab()
    {
        woocommerce_admin_fields($this->get_settings());
    }

    public function get_settings()
    {
        global $wp_roles;
        // Append guest user role
        $wp_roles->role_names['guest'] = esc_html__('Visitor (Unregistered Users)', 'price-by-user-role');

        $settings = [];
        $settings[] = array(
            'title' => esc_html__('Price by User Role', 'price-by-user-role'),
            'type'  => 'title',
            'desc'  => esc_html__('Your price adjustments based on user roles are governed by the settings outlined below. These settings determine how your product prices are modified to accommodate different user roles.', 'price-by-user-role'),
            'id'    => 'puwc_setting',
        );

        $settings[] = array(
            'title'     => esc_html__('Apply Rules on', 'price-by-user-role'),
            'type'      => 'select',
            'options'   => array(
                'both_price'         => esc_html__('On Both Products', 'price-by-user-role'),
                'on_sale_price'      => esc_html__('On Sale Products', 'price-by-user-role'),
                'on_regular_price'   => esc_html__('On Regular Products', 'price-by-user-role'),
            ),
            'custom_attributes' => array(
                'disabled'  => true
            ),
            'desc'   => sprintf(
                /* translators: %1$s is the link start tag, %2$s is the link end tag. */
                esc_html__( '%1$sBuy Premium%2$s To Activate this feature', 'price-by-user-role' ),
                '<a target="_blank" href="https://codecanyon.net/item/price-by-user-roles-in-woocommerce-plugin/52908083?srsltid=AfmBOoqkc-BJAM08OZ0W3mLPlO0vcMVEHmH_SUll9pOmQTTZ7iuUW-Gs">',
                '</a>'
            ),
            'id'        => 'puwc_setting[apply_rules_on]',
        );

        if (!empty($wp_roles)) :
            foreach ( $wp_roles->role_names as $userrole => $rolelbl ) :
                $settings[] = array(
                    'title'                 => $rolelbl,
                    'desc'                  => esc_html__('The postal code, if any, in which your business is located.', 'price-by-user-role' ),
                    'type'                  => 'puwc_field',
                    'class'                 => 'puwc-form-field',
                    'id'                    => 'puwc_setting', 
                    'css'                   => 'width:200px; min-height: 34px;',
                    'lblcb'                 => esc_html__('Enable', 'price-by-user-role'),
                    'incdeclbl'             => esc_html__('Discount or Markup', 'price-by-user-role'),
                    'fixperlbl'             => esc_html__('Fixed or Percentage', 'price-by-user-role'),
                    'pricelbl'              => esc_html__('Value', 'price-by-user-role'),
                    'addtocartlbl'          => esc_html__('Hide Add to Cart', 'price-by-user-role'),
                    'hidepricelbl'          => esc_html__('Hide Price', 'price-by-user-role'),
                    'showDiscountlbl'       => esc_html__('Show Discount/Markup', 'price-by-user-role'),
                    'hidepricetextlbl'      => esc_html__('Text for Hidden Price', 'price-by-user-role'),
                    'userrole'              => $userrole,
                    'placeholder'           => esc_html__('N/A', 'price-by-user-role')
                );
            endforeach;
            $settings[] = array( 'type' => 'sectionend', 'id' => 'puwc_setting' );
        endif;
        return apply_filters('puwc_setting_fields_args', $settings);
    }

    public function puwc_admin_fields( $setting )
    {
        $userrole     = isset($setting['userrole']) ? $setting['userrole'] : '';
        $option_value = get_option('puwc_setting', array());
        
        $incdec = array(
            'positive'  =>  esc_html__('Markup(+)', 'price-by-user-role'),
            'negative'  =>  esc_html__('Discount(-)', 'price-by-user-role')
        );

        $fixedPercent = array(
            'fixed'         =>  wp_kses_post(sprintf(esc_html__('Fixed Value(%s)', 'price-by-user-role'), get_woocommerce_currency_symbol())),
            'percentage'    =>  esc_html__('Percentage(%)', 'price-by-user-role')
        ); 

        $pageRuleSet = apply_filters( 
            'puwc_ruleset_for_product_page',
            array(
                'single'      =>  esc_html__('Product Page', 'price-by-user-role'),
                'shop'        =>  esc_html__('Shop Page', 'price-by-user-role'),
                'product_cat' =>  esc_html__('Product Category', 'price-by-user-role'),
            )
        ); 
        include PUWC_PATH . '/includes/admin/views/puwc-setting-html.php';
    }

    /**
     * Recursively sanitize input data.
     *
     * This function walks through an array of input values and sanitizes each value.
     * If a value is an array, it will recursively sanitize its contents.
     * Scalars are sanitized using WooCommerce's wc_clean() function.
     *
     * @param array $data The data array to be sanitized.
     * @return array The sanitized data.
     */
    public function sanitize_recursive($data){
        $sanitized_data = array();
        foreach ( $data as $key => $value ) :
            if (is_array($value)) :
                $sanitized_data[$key] = $this->sanitize_recursive($value); // Recursively sanitize nested arrays
            else :
                // Sanitize individual fields
                $sanitized_data[$key] = is_scalar($value) ? wc_clean($value) : $value;
            endif;
        endforeach;
        return $sanitized_data;
    }

    public function save_puwc_woocommerce_settings() {
        woocommerce_update_options( $this->get_settings() );
    }
}

new Puwc_Global_Setting();
