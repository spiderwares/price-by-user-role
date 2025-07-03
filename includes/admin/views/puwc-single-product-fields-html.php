<?php defined('ABSPATH') || exit; ?>
<div class="puwc-container">
    <?php if( ! class_exists( 'Price_By_User_Role_PRO' ) ): ?>
        <div class="puwc-overlay">
            <div class="puwc-button-wrapper">
                <a class="puwc-button" target="_blank" href="https://codecanyon.net/item/price-by-user-roles-in-woocommerce-plugin/52908083?srsltid=AfmBOoo3mMoceVmf6GVX4quOvFqkxbg1iMut8GxrTfAgbk03KzzVe_MT">
                    <span class="puwc-content"><?php esc_html_e( 'Buy Premium Now', 'price-by-user-role' ); ?></span>
                </a>
            </div>
        </div>
    <?php endif; ?>
    <table>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="puwc_setting[apply_rules_on]"><?php esc_html_e('Apply Rules on', 'price-by-user-role'); ?></label></th>
            <td>
                <select name="puwc_setting[apply_rules_on]" id="puwc_setting[apply_rules_on]" class="tiny-text">
                    <option value="both_price" <?php selected(esc_attr($option_value['apply_rules_on'] ?? 'both_price'), 'both_price'); ?>><?php esc_html_e('On Both', 'price-by-user-role'); ?></option>
                    <option value="on_sale_price" <?php selected(esc_attr($option_value['apply_rules_on'] ?? 'both_price'), 'on_sale_price'); ?>><?php esc_html_e('When Product is on Sale', 'price-by-user-role'); ?></option>
                    <option value="on_regular_price" <?php selected(esc_attr($option_value['apply_rules_on'] ?? 'both_price'), 'on_regular_price'); ?>><?php esc_html_e('When Product is not on Sale', 'price-by-user-role'); ?></option>
                </select>
                <p class="description"><?php esc_html_e('This option will work with variation level as well as', 'price-by-user-role'); ?></p>
            </td>
        </tr>

        <?php if( isset( $wp_roles->role_names ) ) : ?>
            <?php foreach ($wp_roles->role_names as $role_slug => $role ) :  ?>
                <tr class="puwc-setting" valign="top">
                    <th scope="row" class="titledesc">
                        <label for="puwc_setting[<?php echo esc_attr($role_slug); ?>]">
                            <?php echo esc_html($role); ?>
                        </label>
                    </th>

                    <td class="forminp">
                        <label for="puwc_setting[<?php echo esc_attr($role_slug); ?>][isEnable]">
                            <strong><?php esc_html_e( 'Enable', 'price-by-user-role' ); ?></strong>
                            <input 
                                name="puwc_setting[<?php echo esc_attr($role_slug); ?>][isEnable]" 
                                id="puwc_setting[<?php echo esc_attr($role_slug); ?>][isEnable]" 
                                type="checkbox" 
                                value="1" <?php checked( ! empty($option_value[$role_slug]['isEnable']), 1 ); ?>
                                class="puwc-field-enable puwc_checkbox puwc-form-field">
                        </label>

                        <label for="puwc_setting[<?php echo esc_attr($role_slug); ?>][incdec]">
                            <strong><?php esc_html_e( 'Discount or Markup', 'price-by-user-role' ); ?></strong>
                            <select 
                                class="puwc-field-incdec puwc-form-field" 
                                name="puwc_setting[<?php echo esc_attr($role_slug); ?>][incdec]">
                                <option value="positive" <?php selected($option_value[$role_slug]['incdec'] ?? '', 'positive'); ?>><?php esc_html_e( 'Markup(+)', 'price-by-user-role' ); ?></option>
                                <option value="negative" <?php selected($option_value[$role_slug]['incdec'] ?? '', 'negative'); ?>><?php esc_html_e( 'Discount(-)', 'price-by-user-role' ); ?></option>
                            </select>
                        </label>

                        <label for="puwc_setting[<?php echo esc_attr($role_slug); ?>][fixedPercent]">
                            <strong><?php esc_html_e( 'Fixed or Percentage', 'price-by-user-role' ); ?></strong>
                            <select 
                                class="puwc-field-fixedpercent puwc-form-field" 
                                name="puwc_setting[<?php echo esc_attr($role_slug); ?>][fixedPercent]">
                                <option value="fixed" <?php selected($option_value[$role_slug]['fixedPercent'] ?? '', 'fixed'); ?>><?php esc_html_e( 'Fixed Value($)', 'price-by-user-role' ); ?></option>
                                <option value="percentage" <?php selected($option_value[$role_slug]['fixedPercent'] ?? '', 'percentage'); ?>><?php esc_html_e( 'Percentage(%)', 'price-by-user-role' ); ?></option>
                            </select>
                        </label>

                        <label for="puwc_setting[<?php echo esc_attr($role_slug); ?>][price]">
                            <strong><?php esc_html_e( 'Value', 'price-by-user-role' ); ?></strong>
                            <input 
                                name="puwc_setting[<?php echo esc_attr($role_slug); ?>][price]" 
                                id="puwc_setting[<?php echo esc_attr($role_slug); ?>][price]" 
                                type="number" 
                                step="0.00001" 
                                value="<?php echo esc_attr( $option_value[$role_slug]['price'] ?? '' ); ?>" 
                                class="puwc-field-price puwc-form-field" 
                                placeholder="N/A">
                        </label>

                        <label for="puwc_setting[<?php echo esc_attr($role_slug); ?>][hideAddToCart]">
                            <strong><?php esc_html_e( 'Hide Add to Cart', 'price-by-user-role' ); ?></strong>
                            <input 
                                name="puwc_setting[<?php echo esc_attr($role_slug); ?>][hideAddToCart]" 
                                id="puwc_setting[<?php echo esc_attr($role_slug); ?>][hideAddToCart]" 
                                type="checkbox" 
                                value="1" <?php checked( ! empty($option_value[$role_slug]['hideAddToCart']), 1 ); ?>
                                class="puwc-field-hideaddtocart puwc_checkbox puwc-form-field">
                        </label>

                        <label for="puwc_setting[<?php echo esc_attr($role_slug); ?>][hidePrice]">
                            <strong><?php esc_html_e( 'Hide Price', 'price-by-user-role' ); ?></strong>
                            <input 
                                name="puwc_setting[<?php echo esc_attr($role_slug); ?>][hidePrice]" 
                                id="puwc_setting[<?php echo esc_attr($role_slug); ?>][hidePrice]" 
                                type="checkbox" 
                                value="1" <?php checked( ! empty($option_value[$role_slug]['hidePrice']), 1 ); ?>
                                class="puwc-field-hideprice puwc_checkbox puwc-form-field">
                        </label>

                        <label for="puwc_setting[<?php echo esc_attr($role_slug); ?>][hidePriceText]">
                            <strong><?php esc_html_e( 'Text for Hidden Price', 'price-by-user-role' ); ?></strong>
                            <input 
                                name="puwc_setting[<?php echo esc_attr($role_slug); ?>][hidePriceText]" 
                                id="puwc_setting[<?php echo esc_attr($role_slug); ?>][hidePriceText]" 
                                type="text" 
                                value="<?php echo esc_attr( $option_value[$role_slug]['hidePriceText'] ?? '' ); ?>" 
                                class="puwc-field-hidepricetext puwc-form-field">
                            <small><strong>{product_price}</strong><?php esc_html_e( ' to display product price', 'price-by-user-role' ); ?></small>
                        </label>

                        <label for="puwc_setting[<?php echo esc_attr($role_slug); ?>][showDiscount][]">
                            <strong><?php esc_html_e( 'Show Discount/Markup', 'price-by-user-role' ); ?></strong>
                            <select 
                                multiple 
                                class="wc-enhanced-select puwc-field-showDiscount puwc-form-field" 
                                name="puwc_setting[<?php echo esc_attr($role_slug); ?>][showDiscount][]">
                                <option value="single" <?php selected( in_array('single', $option_value[$role_slug]['showDiscount'] ?? []) ); ?>><?php esc_html_e( 'Product Page', 'price-by-user-role' ); ?></option>
                                <option value="shop" <?php selected( in_array('shop', $option_value[$role_slug]['showDiscount'] ?? []) ); ?>><?php esc_html_e( 'Shop Page', 'price-by-user-role' ); ?></option>
                                <option value="product_cat" <?php selected( in_array('product_cat', $option_value[$role_slug]['showDiscount'] ?? []) ); ?>><?php esc_html_e( 'Product Category', 'price-by-user-role' ); ?></option>
                            </select>
                        </label>
                    </td>
                </tr>
            <?php endforeach; ?> 
        <?php endif; ?>
    </table>
</div>    