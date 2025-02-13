<?php defined('ABSPATH') || exit; ?>

<tr class="form-field puwc-upgrade-tr">
    <th><h2><?php esc_html_e('Price by User Role ', 'price-by-user-role'); ?></h2></th>
    <td>
        <div class="puwc-button-wrapper">
            <a class="puwc-button" target="_blank" href="https://codecanyon.net/item/price-by-user-roles-in-woocommerce-plugin/52908083?srsltid=AfmBOoo3mMoceVmf6GVX4quOvFqkxbg1iMut8GxrTfAgbk03KzzVe_MT">
                <span class="puwc-content">Buy Premium Now to access below Features</span>
            </a>
        </div>
    </td>
</tr>

<tr class="form-field puwc-setting" >
    <th scope="row" valign="top"><label for="puwc_setting[priority]"><?php esc_html_e('Priority', 'price-by-user-role'); ?></label></th>
    <td>
        <input type="number" name="puwc_setting[priority]" id="puwc_setting[priority]" value="<?php echo esc_attr($option_value['priority'] ?? 1); ?>" step="1" min="1" class="tiny-text" />
        <p class="description"><?php esc_html_e('Please enter the priority for the Price by User Role for this category.', 'price-by-user-role'); ?></p>
    </td>
</tr>

<tr class="form-field puwc-setting" >
    <th scope="row" valign="top"><label for="puwc_setting[apply_rules_on]"><?php esc_html_e('Apply Rules on', 'price-by-user-role'); ?></label></th>
    <td>
        <select name="puwc_setting[apply_rules_on]" id="puwc_setting[apply_rules_on]" class="tiny-text">
            <option value="both_price" <?php selected(esc_attr($option_value['apply_rules_on'] ?? 'both_price'), 'both_price'); ?>><?php esc_html_e('On Both Products', 'price-by-user-role'); ?></option>
            <option value="on_sale_price" <?php selected(esc_attr($option_value['apply_rules_on'] ?? 'both_price'), 'on_sale_price'); ?>><?php esc_html_e('On Sale Products', 'price-by-user-role'); ?></option>
            <option value="on_regular_price" <?php selected(esc_attr($option_value['apply_rules_on'] ?? 'both_price'), 'on_regular_price'); ?>><?php esc_html_e('On Regular Products', 'price-by-user-role'); ?></option>
        </select>       
        <p class="description"><?php esc_html_e('Please choose the option that specifies the price (Regular Price or Sale Price) to which you wish to apply the following rules.', 'price-by-user-role'); ?></p>
    </td>
</tr>

<?php if( isset( $wp_roles->roles ) ) : ?>
    <?php foreach ($wp_roles->roles as $role_slug => $role ) :  ?>
        <tr class="form-field puwc-setting" valign="top">
            <th scope="row" class="titledesc">
                <label for="puwc_setting[<?php echo esc_attr($role_slug); ?>]">
                    <?php echo esc_html($role['name']); ?>
                </label>
            </th>

            <td class="forminp">
                <label for="puwc_setting[<?php echo esc_attr($role_slug); ?>][isEnable]">
                    <strong>Enable</strong>
                    <input 
                        name="puwc_setting[<?php echo esc_attr($role_slug); ?>][isEnable]" 
                        id="puwc_setting[<?php echo esc_attr($role_slug); ?>][isEnable]" 
                        type="checkbox" 
                        value="1" 
                        class="puwc-field-enable puwc_checkbox puwc-form-field">
                </label>

                <label for="puwc_setting[<?php echo esc_attr($role_slug); ?>][incdec]">
                    <strong>Discount or Markup</strong>
                    <select 
                        class="puwc-field-incdec puwc-form-field" 
                        name="puwc_setting[<?php echo esc_attr($role_slug); ?>][incdec]">
                        <option value="positive">Markup(+)</option>
                        <option value="negative">Discount(-)</option>
                    </select>
                </label>

                <label for="puwc_setting[<?php echo esc_attr($role_slug); ?>][fixedPercent]">
                    <strong>Fixed or Percentage</strong>
                    <select 
                        class="puwc-field-fixedpercent puwc-form-field" 
                        name="puwc_setting[<?php echo esc_attr($role_slug); ?>][fixedPercent]">
                        <option value="fixed">Fixed Value($)</option>
                        <option value="percentage">Percentage(%)</option>
                    </select>
                </label>

                <label for="puwc_setting[<?php echo esc_attr($role_slug); ?>][price]">
                    <strong>Value</strong>
                    <input 
                        name="puwc_setting[<?php echo esc_attr($role_slug); ?>][price]" 
                        id="puwc_setting[<?php echo esc_attr($role_slug); ?>][price]" 
                        type="number" 
                        step="0.00001" 
                        value="0" 
                        class="puwc-field-price puwc-form-field" 
                        placeholder="N/A">
                </label>

                <label for="puwc_setting[<?php echo esc_attr($role_slug); ?>][hideAddToCart]">
                    <strong>Hide Add to Cart</strong>
                    <input 
                        name="puwc_setting[<?php echo esc_attr($role_slug); ?>][hideAddToCart]" 
                        id="puwc_setting[<?php echo esc_attr($role_slug); ?>][hideAddToCart]" 
                        type="checkbox" 
                        value="1" 
                        class="puwc-field-hideaddtocart puwc_checkbox puwc-form-field">
                </label>

                <label for="puwc_setting[<?php echo esc_attr($role_slug); ?>][hidePrice]">
                    <strong>Hide Price</strong>
                    <input 
                        name="puwc_setting[<?php echo esc_attr($role_slug); ?>][hidePrice]" 
                        id="puwc_setting[<?php echo esc_attr($role_slug); ?>][hidePrice]" 
                        type="checkbox" 
                        value="1" 
                        class="puwc-field-hideprice puwc_checkbox puwc-form-field">
                </label>

                <label for="puwc_setting[<?php echo esc_attr($role_slug); ?>][hidePriceText]">
                    <strong>Text for Hidden Price</strong>
                    <input 
                        name="puwc_setting[<?php echo esc_attr($role_slug); ?>][hidePriceText]" 
                        id="puwc_setting[<?php echo esc_attr($role_slug); ?>][hidePriceText]" 
                        type="text" 
                        value="" 
                        class="puwc-field-hidepricetext puwc-form-field">
                    <small>
                        <strong>{product_price}</strong> to display product price
                    </small>
                </label>

                <label for="puwc_setting[<?php echo esc_attr($role_slug); ?>][showDiscount][]">
                    <strong>Show Discount/Markup</strong>
                    <select 
                        multiple 
                        class="wc-enhanced-select puwc-field-showDiscount puwc-form-field" 
                        name="puwc_setting[<?php echo esc_attr($role_slug); ?>][showDiscount][]">
                        <option value="single">Product Page</option>
                        <option value="shop">Shop Page</option>
                        <option value="product_cat">Product Category</option>
                    </select>
                </label>
            </td>
        </tr>
    <?php endforeach; 
endif; ?>
