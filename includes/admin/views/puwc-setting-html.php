<?php defined('ABSPATH') || exit;
if(isset($setting['type']) && $setting['type'] == 'puwc_field' ) : ?>   
    <tr class="puwc-setting" valign="top">
        <th scope="row" class="titledesc">
            <label for="<?php echo esc_attr($setting['id'].'['.$userrole.']'); ?>">
                <?php echo esc_html($setting['title']); ?>
                <?php echo wp_kses_post(isset($tooltip_html) ? $tooltip_html : ''); ?>
            </label>
        </th>
        
        <td class="forminp">
            <label for="<?php echo esc_attr($setting['id'].'['.$userrole.']'); ?>[isEnable]">
                <strong><?php echo wp_kses_post($setting['lblcb']); ?></strong>
                <input
                    name="<?php echo esc_attr($setting['id'].'['.$userrole.']'); ?>[isEnable]"
                    id="<?php echo esc_attr($setting['id'].'['.$userrole.']'); ?>"
                    type="checkbox"
                    value="1"
                    class="<?php echo esc_attr("puwc-field-enable puwc_checkbox " . $setting['class']); ?>"
                    <?php checked(isset($option_value[$userrole]['isEnable']) ? $option_value[$userrole]['isEnable'] : false, true); ?>
                />
            </label>

            <label for="<?php echo esc_attr($setting['id'].'['.$userrole.']'); ?>[incdec]">
                <strong><?php echo wp_kses_post($setting['incdeclbl']); ?></strong>
                <select 
                    class="<?php echo esc_attr('puwc-field-incdec ' . $setting['class']); ?>"
                    name="<?php echo esc_attr($setting['id'].'['.$userrole.']'); ?>[incdec]">
                    <?php foreach ( $incdec as $value => $label ) : ?>
                        <option value="<?php echo esc_attr($value); ?>" <?php selected(isset($option_value[$userrole]['incdec']) ? $option_value[$userrole]['incdec'] : false, $value); ?>><?php echo esc_html($label); ?></option>
                    <?php endforeach; ?>
                </select>
            </label>

            <label for="<?php echo esc_attr($setting['id'].'['.$userrole.']'); ?>[fixedPercent]">
                <strong><?php echo wp_kses_post($setting['fixperlbl']); ?></strong>
                <select 
                    class="<?php echo esc_attr('puwc-field-fixedpercent ' . $setting['class']); ?>"
                    name="<?php echo esc_attr($setting['id'].'['.$userrole.']'); ?>[fixedPercent]" >
                    <?php foreach ( $fixedPercent as $value => $label ) : ?>
                        <option value="<?php echo esc_attr($value); ?>" <?php selected(isset($option_value[$userrole]['fixedPercent']) ? $option_value[$userrole]['fixedPercent'] : false, $value); ?>><?php echo esc_html($label); ?></option>
                    <?php endforeach; ?>
                </select>
            </label>

            <label for="<?php echo esc_attr($setting['id'].'['.$userrole.']'); ?>[fixedPercent]">
                <strong><?php echo wp_kses_post($setting['pricelbl']); ?></strong>
                <input
                    name="<?php echo esc_attr($setting['id'].'['.$userrole.']'); ?>[price]"
                    id="<?php echo esc_attr($setting['id'].'['.$userrole.']'); ?>"
                    type="number"
                    step="0.00001"
                    value="<?php echo esc_attr(isset($option_value[$userrole]['price']) ? $option_value[$userrole]['price'] : 0); ?>"
                    class="<?php echo esc_attr('puwc-field-price ' . $setting['class']); ?>"
                    placeholder="<?php echo esc_attr($setting['placeholder']); ?>"
                />
            </label>

            <label for="<?php echo esc_attr($setting['id'].'['.$userrole.']'); ?>[hideAddToCart]">
                <strong><?php echo wp_kses_post($setting['addtocartlbl']); ?></strong>
                <input
                    name="<?php echo esc_attr($setting['id'].'['.$userrole.']'); ?>[hideAddToCart]"
                    id="<?php echo esc_attr($setting['id'].'['.$userrole.']'); ?>"
                    type="checkbox"
                    value="1"
                    class="<?php echo esc_attr("puwc-field-hideaddtocart puwc_checkbox ". $setting['class']); ?>"
                    <?php checked(isset($option_value[$userrole]['hideAddToCart']) ? $option_value[$userrole]['hideAddToCart'] : 0, 1); ?>
                />
            </label>

            <label for="<?php echo esc_attr($setting['id'].'['.$userrole.']'); ?>[hidePrice]">
                <strong><?php echo wp_kses_post($setting['hidepricelbl']); ?></strong>
                <input
                    name="<?php echo esc_attr($setting['id'].'['.$userrole.']'); ?>[hidePrice]"
                    id="<?php echo esc_attr($setting['id'].'['.$userrole.']'); ?>"
                    type="checkbox"
                    value="1"
                    class="<?php echo esc_attr("puwc-field-hideprice puwc_checkbox ". $setting['class']); ?>"
                    <?php checked(isset($option_value[$userrole]['hidePrice']) ? $option_value[$userrole]['hidePrice'] : 0, 1); ?>
                />
            </label>

            <label for="<?php echo esc_attr($setting['id'].'['.$userrole.']'); ?>[hidePriceText]">
                <strong><?php echo wp_kses_post($setting['hidepricetextlbl']); ?></strong>
                <input
                    name="<?php echo esc_attr($setting['id'].'['.$userrole.']'); ?>[hidePriceText]"
                    id="<?php echo esc_attr($setting['id'].'['.$userrole.']'); ?>"
                    type="text"
                    value="<?php echo esc_attr(isset($option_value[$userrole]['hidePriceText']) ? $option_value[$userrole]['hidePriceText'] : ''); ?>"
                    class="<?php echo esc_attr('puwc-field-hidepricetext ' . $setting['class']); ?>"
                />
                <small>
                    <?php 
                        echo sprintf( 
                            wp_kses( 
                                esc_html__('%s to display product price', 'price-by-user-role'), 
                                array( 'strong' => array() )
                            ), 
                            '<strong>{product_price}</strong>'
                        ); 
                    ?>
                </small>
            </label>
            
            <label for="<?php echo esc_attr($setting['id'].'['.$userrole.']'); ?>[showDiscount][]">
                <strong><?php echo wp_kses_post($setting['showDiscountlbl']); ?></strong>
                <select 
                    multiple
                    class="<?php echo esc_attr('wc-enhanced-select puwc-field-showDiscount ' . $setting['class']); ?>"
                    name="<?php echo esc_attr($setting['id'].'['.$userrole.']'); ?>[showDiscount][]">
                    <?php foreach ( $pageRuleSet as $value => $label ) : ?>
                        <option value="<?php echo esc_attr($value); ?>" <?php selected(in_array($value, isset($option_value[$userrole]['showDiscount']) ? (array)$option_value[$userrole]['showDiscount'] : array())); ?>><?php echo esc_html($label); ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </td>
    </tr>
<?php endif; ?>
