<?php
/**
 * Price Controller for WooCommerce.
 */

if ( !defined( 'ABSPATH' ) ) :
    exit;
endif;

/**
 * Class Puwc_Price_Controller
 */
class Puwc_Price_Controller {
    public $option;
    public $userRole;

    /**
     * Puwc_Price_Controller constructor.
     */
    public function __construct() {
        $this->get_current_user_role();
        $this->event_handler();
    }

    /**
     * Event handler for WooCommerce hooks and filters.
     *
     * @return void
     */
    public function event_handler() {
        // Hide Product Price 
        add_filter('woocommerce_get_price_html', array($this, 'hide_product_price'), 99, 2);
        add_filter('woocommerce_get_price_html', array($this, 'display_markup_discount_rules'), 99, 2);
        add_filter('woocommerce_sale_flash', array($this, 'hide_sale_flash'), 99, 3);

        // Hide add to cart button
        add_action('woocommerce_is_purchasable', array($this, 'hide_add_to_cart_button'), 99, 2);

        // Price Filters
        add_filter('woocommerce_product_get_price', array($this, 'get_product_price'), 99, 2);
        add_filter('woocommerce_product_get_sale_price', array($this, 'get_product_sale_price'), 99, 3);
        add_filter('woocommerce_product_get_regular_price', array($this, 'get_product_regular_price'), 99, 3);

        add_filter('woocommerce_variation_prices_price', array($this, 'get_variation_product_prices_price'), 99, 3);
        
        add_filter('woocommerce_product_variation_get_price', array($this, 'get_variation_product_price'), 99, 2);
        add_filter('woocommerce_product_variation_get_sale_price', array($this, 'get_variation_product_sale_price'), 99, 3);
        add_filter('woocommerce_product_variation_get_regular_price', array($this, 'get_variation_product_regular_price'), 99, 3);
    }

    /**
     * Get the current user role.
     *
     * @return void
     */
    public function get_current_user_role() {
        $user = wp_get_current_user();
        $this->userRole = isset($user->roles) && !empty($user->roles) ? $user->roles[0] : 'guest';
    }

    /**
     * Check if PUWC is enabled for a product.
     *
     * @param  int $productID The product ID.
     * @return bool True if enabled, false otherwise.
     */
    public function is_enabled($productID) {
        if ( empty( $productID ) ) :
            return false;
        endif;

        $option          = get_option('puwc_setting', array());
        $filtered_option = apply_filters('puwc_matched_options', $option, $productID);
        $this->option    = $filtered_option;
        return $filtered_option; 
    }

    /**
     * Calculate the product price based on the rules.
     *
     * @param  float      $price   The original price.
     * @param  WC_Product $product The product object.
     * @return float The calculated price.
     */
    public function calculate_product_price($price, $product) {
        $productID = $product->get_parent_id() ? $product->get_parent_id() : $product->get_id();
        $isEnabled = $this->is_enabled($product->get_id());
        if (!$isEnabled || empty($price) ) :
            return $price;
        endif;

        $incdec       = apply_filters('puwc_increment_or_decrement', isset($this->option[$this->userRole]['incdec']) ? $this->option[$this->userRole]['incdec'] : false);
        $fixedPercent = apply_filters('puwc_fixed_or_percent', isset($this->option[$this->userRole]['fixedPercent']) ? $this->option[$this->userRole]['fixedPercent'] : false);
        $toPrice      = apply_filters('puwc_price_to_incdec', isset($this->option[$this->userRole]['price']) ? $this->option[$this->userRole]['price'] : false);

        if ($toPrice <= 0) {
            return $price;
        }
        $toIncDec = $fixedPercent == 'percentage' ? ((float)$price * (float)$toPrice / 100) : $toPrice;
        $price    = in_array($incdec, array('positive', 'negative')) ? ($incdec == 'positive' ? (float)$price + (float)$toIncDec : (float)$price - (float)$toIncDec) : (float)$price;
        $price    = $price < 0 ? 0 : $price;
        $price    = apply_filters('puwc_product_price', $price, $incdec, $fixedPercent, $toPrice);
        return $price;
    }

    /**
     * Get the product price.
     *
     * @param  float      $price   The original price.
     * @param  WC_Product $product The product object.
     * @return float The modified price.
     */
    public function get_product_price($price, $product) {
        return apply_filters(
            'puwc_product_get_price',
            $this->calculate_product_price($price, $product),
            $product
        );
    }

    /**
     * Get the regular product price.
     *
     * @param  float      $price   The original regular price.
     * @param  WC_Product $product The product object.
     * @return float The modified regular price.
     */
    public function get_product_regular_price($price, $product) {
        return apply_filters(
            'puwc_product_get_regular_price',
            $this->calculate_product_price($price, $product),
            $product
        );
    }

    /**
     * Get the sale product price.
     *
     * @param  float      $price   The original sale price.
     * @param  WC_Product $product The product object.
     * @return float The modified sale price.
     */
    public function get_product_sale_price($price, $product) {
        return apply_filters(
            'puwc_product_get_sale_price',
            $this->calculate_product_price($price, $product),
            $product
        );
    }

    /**
     * Get the variation product price.
     *
     * @param  float      $price   The original variation price.
     * @param  WC_Product $product The product object.
     * @return float The modified variation price.
     */
    public function get_variation_product_price($price, $product) {
        return apply_filters(
            'puwc_variation_product_get_price',
            $this->calculate_product_price($price, $product),
            $product
        );
    }

    /**
     * Get the regular variation product price.
     *
     * @param  float      $price   The original regular variation price.
     * @param  WC_Product $product The product object.
     * @return float The modified regular variation price.
     */
    public function get_variation_product_regular_price($price, $product) {
        return apply_filters(
            'puwc_variation_product_get_regular_price',
            $this->calculate_product_price($price, $product),
            $product
        );
    }

    /**
     * Get the variation product prices price.
     *
     * @param  float      $price   The original variation price.
     * @param  WC_Product $product The product object.
     * @return float The modified variation price.
     */
    public function get_variation_product_prices_price($price, $product) {
        return apply_filters(
            'puwc_variation_product_get_prices_price',
            $this->calculate_product_price($price, $product),
            $product
        );
    }

    /**
     * Get the variation product sale price.
     *
     * @param  float      $price   The original sale price.
     * @param  WC_Product $product The product object.
     * @return float The modified sale price.
     */
    public function get_variation_product_prices_sale_price($price, $product) {
        return apply_filters(
            'puwc_variation_product_get_prices_sale_price',
            $this->calculate_product_price($price, $product),
            $product
        );
    }

    /**
     * Get the variation product regular price.
     *
     * @param  float      $price   The original regular price.
     * @param  WC_Product $product The product object.
     * @return float The modified regular price.
     */
    public function get_variation_product_prices_regular_price($price, $product) {
        return apply_filters(
            'puwc_variation_product_get_prices_regular_price',
            $this->calculate_product_price($price, $product),
            $product
        );
    }

    /**
     * Get the variation product sale price.
     *
     * @param  float      $price   The original sale price.
     * @param  WC_Product $product The product object.
     * @return float The modified sale price.
     */
    public function get_variation_product_sale_price($price, $product) {
        if (!empty($price)) :
            return apply_filters(
                'puwc_variation_product_get_prices_regular_price',
                $this->calculate_product_price($price, $product),
                $product
            );
        endif;
        return $price;
    }

    /**
     * Hide the add to cart button.
     *
     * @param  bool       $is_purchasable If the product is purchasable.
     * @param  WC_Product $product        The product object.
     * @return bool If the add to cart button should be hidden.
     */
    public function hide_add_to_cart_button($is_purchasable, $product) {
        $hide_add_to_cart = apply_filters('puwc_hide_add_to_cart_button', isset($this->option[$this->userRole]['hideAddToCart']) ? $this->option[$this->userRole]['hideAddToCart'] : false);
        if ($hide_add_to_cart) :
            remove_action('woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20);
            return false;            
        endif;
        return $is_purchasable;
    }

    /**
     * Hide the product price.
     *
     * @param  string     $price   The product price HTML.
     * @param  WC_Product $product The product object.
     * @return string The modified price HTML.
     */
    public function hide_product_price($price, $product) {
        $hide_price = apply_filters('puwc_hide_price', isset($this->option[$this->userRole]['hidePrice']) ? $this->option[$this->userRole]['hidePrice'] : false, $price, $product);
        $hidePriceText = isset($this->option[$this->userRole]['hidePriceText']) ? $this->option[$this->userRole]['hidePriceText'] : false;

        if ($hide_price) :
            $hidePriceText = str_replace('{product_price}', $price, $hidePriceText);
            return apply_filters('puwc_hide_price_text_price', $hidePriceText, $price, $product);
        endif;
        return $price;
    }

    /**
     * Hide the sale flash if the price is hidden.
     *
     * @param  string     $saleFlash The sale flash HTML.
     * @param  WP_Post    $post      The post object.
     * @param  WC_Product $product   The product object.
     * @return string The modified sale flash HTML.
     */
    public function hide_sale_flash($saleFlash, $post, $product) {
        $hide_price = apply_filters('puwc_hide_sale_flash_on_hide_price', isset($this->option[$this->userRole]['hidePrice']) ? $this->option[$this->userRole]['hidePrice'] : false, $product);
        if ($hide_price) :
            return '';
        endif;
        return $saleFlash;
    }

    /**
     * Check if discount markup should be shown.
     *
     * @param  WC_Product $product The product object.
     * @return bool If the discount markup should be shown.
     */
    public function is_show_discount($product) {
        $display_rules = apply_filters('puwc_show_discount_markup_with_price', isset($this->option[$this->userRole]['showDiscount']) ? $this->option[$this->userRole]['showDiscount'] : false, $product);

        if ((in_array('single', (array)$display_rules) && is_product()) 
            || (in_array('shop', (array)$display_rules) && is_shop()) 
            || (in_array('product_cat', (array)$display_rules) && is_product_category()) 
        ) :
            return true;
        endif;
        return false;
    }

    /**
     * Display markup and discount rules.
     *
     * @param  string     $price   The product price HTML.
     * @param  WC_Product $product The product object.
     * @return string The modified price HTML.
     */
    public function display_markup_discount_rules($price, $product) {
        if ($this->is_show_discount($product) && ($product->is_type('simple') || $product->is_type('variation'))) :
            $price              = get_post_meta($product->get_id(), '_price', true);
            $saveAmount         = (float)$product->get_price() - (float)$price;
            $percentageDiscount = $saveAmount != 0 ? (abs( $saveAmount ) / (float)$price) * 100 : 0;
            $saveText           = $saveAmount >= 0 ? esc_html__('Markup: ', 'price-by-user-role') : esc_html__('SAVE: ', 'price-by-user-role');

            $price = apply_filters(
                'puwc_product_price_format',
                sprintf(
                    '<div class="was-now-save">
                        <div class="was"><span class="saving-label">%1$s</span><del>%3$s</del></div>
                        <div class="now"><span class="saving-label">%2$s</span>%4$s</div>
                        <div class="save"><span class="saving-label">%5$s</span>%6$s (%7$s%%)</div>
                    </div>',
                    esc_html__("Regular Price: ", "price-by-user-role"),
                    esc_html__("Your Price:", "price-by-user-role"),
                    wc_price($price),
                    wc_price($product->get_price()),
                    $saveText,
                    wc_price(abs($saveAmount)),
                    round(abs($percentageDiscount)),
                ),
                $price,
                $product->get_price(),
                $saveAmount,
                $percentageDiscount,
                $product
            );
            return $price;
        endif;
        return $price;
    }

}
new Puwc_Price_Controller();