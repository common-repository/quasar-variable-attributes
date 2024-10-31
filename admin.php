<?php 

    $url = plugins_url( '/assets/img/', __FILE__ );
    echo '<div class="img-dir-q">'.esc_url( $url ).'</div>';
    
?>

<div class='header-form-quasar'>
    <div class='swap-header-q'>
        <div class='swap-logo-header-q'>
            <div class='logo-header-q'>
                <div class='version-q-form'><span class='name-plugin-q'>Quasar Variable Attributes</span> <?php esc_html_e('Version','quasar-attr-variable');?> <span>2.2</span></div>
            </div> 
        </div>
    </div>  
</div>

<div class='swap-top-menu-q'>
    <div class='menu-top-q setting-q activ-tab-q' data-tab='1'><?php esc_html_e('Attributes','quasar-attr-variable'); ?></div>
    <div class='menu-top-q setting-q' data-tab='3'><?php esc_html_e('Settings','quasar-attr-variable'); ?></div>
    <div class='menu-top-q setting-q' data-tab='2'><?php esc_html_e('Design','quasar-attr-variable'); ?></div>
    <div class='menu-top-q setting-q' data-tab='4'><?php esc_html_e('Localization','quasar-attr-variable'); ?></div>
    <div class='menu-top-q setting-q' data-tab='5'><?php esc_html_e('Import/export settings','quasar-attr-variable'); ?></div>
</div>

<!-- remove block -->
<div class='swap-modal-remove'> 
    <div class='podtverdit-modal' data-remove=''>
        <div class='yes-remove'><?php esc_html_e('Yes','quasar-attr-variable'); ?> </div>
        <div class='not-remove'><?php esc_html_e('No','quasar-attr-variable'); ?> </div>
    </div> 
</div> 

    
<div class='swap-panel-form-q'>
    <div class='text-help-heading'><?php echo esc_html__('Add attributes and style them to fit your needs.','quasar-attr-variable') ?></div>
    
    <!-- tab 1-->
    <div class='wrap-setting-qf-woo tab-class-1'>
   
        <div class='section-setting-q'>
            
            <div class='add-attribute-q'>
                <div class='wrap-alement-add-q'>
                    <span class='plus-at'>+</span><?php echo esc_html__('Add attributes','quasar-attr-variable') ?>
                </div>
                <span class='img-str'><img class='img-help-s' src="<?php echo esc_url($url).'strelka.png'; ?>"/></span>
                
                <div class='wrap-help-attr-2'>
                    <span><?php echo esc_html__('Сlick on an attribute to style it','quasar-attr-variable') ?></span>
                    <span class='img-str'><img class='img-help-s' src="<?php echo esc_url($url).'strelka.png'; ?>"/></span>
                </div>
                
            </div>
            
            <?php
            if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ){ //woocommerce active

                foreach( wc_get_attribute_taxonomies() as $values ) {
                    $term_names = get_terms( array('taxonomy' => 'pa_' . $values->attribute_name, 'fields' => 'names' ) );
                    if ( gettype($term_names) !='object' ){
                        echo '<div class="wrap-attr-q"><div class="name-attr" data-label="'.esc_html( $values->attribute_name ).'">' .$values->attribute_label. '</div><div class="value-attr">' .implode(',', $term_names).'</div></div>';
                    }
                }
            }
            ?>
            
        </div>
        
        <div class='section-setting-q'>
            <div class='wrap-use-attribute'>
            <?php   
                global $wpdb;
                $quasar_form_attr_base = $wpdb->get_results( "SELECT * FROM {$wpdb->base_prefix}quasar_attribute_attr WHERE id='1'", ARRAY_A  );
                //create attr iz base
                if ( count($quasar_form_attr_base) > 0 ){
                    foreach($quasar_form_attr_base as $row){
                        
                        $array_option = json_decode( $row['mainparams'] , true ); 
                        if ( !$array_option ){ $array_option = json_decode( stripslashes($row['mainparams']) , true ); }
                        
                    }
                    if ( $array_option !='' ){
                        foreach( $array_option as $key => $value ){
                            //array value
                            $string_value ='';
                            foreach( $array_option[$key]['value']['arrayValue'] as $key_2 => $value_2 ){
                                //defoult attr
                                if ( $array_option[$key]['style']['data-style'] != 'color' && $array_option[$key]['style']['data-style'] != 'html' &&  $array_option[$key]['style']['data-style'] != 'checkboximg'){
                                    $string_value.= '<div class="value-elem-q" data-tooltip="'.esc_attr( $value_2['tooltip'] ).'" >'.esc_html( $key_2 ).'</div>';
                                }
                                //color
                                if ( $array_option[$key]['style']['data-style']  == 'color' ){
                                    $string_value.= '<div class="value-elem-q" data-tooltip="'.esc_attr( $value_2['tooltip'] ).'" data-color="'.esc_html( $value_2['color-val'] ).'">'.esc_html( $key_2 ).'</div>';
                                }
                                //html
                                if ( $array_option[$key]['style']['data-style']  == 'html' ){
                                    $string_value.= '<div class="value-elem-q" data-tooltip="'.esc_attr( $value_2['tooltip'] ).'" data-html="'.esc_html( $value_2['html-val'] ).'">'.esc_html( $key_2 ).'</div>';
                                }
                                //img
                                if ( $array_option[$key]['style']['data-style']  == 'checkboximg' ){
                                    $string_value.= '<div class="value-elem-q" data-tooltip="'.esc_attr( $value_2['tooltip'] ).'" data-img="'.esc_html( $value_2['img-val'] ).'">'.esc_html( $key_2 ).'</div>';
                                }
                            }
                            
                            if ( !isset($array_option[$key]['style']['label']) ) { $array_option[$key]['style']['label'] ='';}
    
                            echo '
                            <div class="element-attr-use-q" data-style="'.esc_attr( $array_option[$key]['style']['data-style'] ).'"
                                data-label ="'.esc_attr( $key ).'" 
                                data-font-size="'.esc_attr( $array_option[$key]['style']['font-size'] ).'" 
                                data-font-color="'.esc_attr( $array_option[$key]['style']['font-color'] ).'" 
                                data-background-color="'.esc_attr( $array_option[$key]['style']['background-color'] ).'" 
                                data-background-color-a="'.esc_attr( $array_option[$key]['style']['background-color-a'] ).'" 
                                data-border-width="'.esc_attr( $array_option[$key]['style']['border-width'] ).'" 
                                data-border-color="'.esc_attr( $array_option[$key]['style']['border-color'] ).'" 
                                data-border-radius="'.esc_attr( $array_option[$key]['style']['border-radius'] ).'" 
                                data-color-activ="'.esc_attr( $array_option[$key]['style']['font-color-a'] ).'" 
                                data-size = "'.esc_attr( $array_option[$key]['style']['size'] ).'" 
                                data-disable-d = "'.esc_attr( $array_option[$key]['style']['disable-design'] ).'"
                                data-width = "'.esc_attr( $array_option[$key]['style']['width'] ).'"
                                data-height = "'.esc_attr( $array_option[$key]['style']['height'] ).'"
                                data-show-label = "'.esc_attr( $array_option[$key]['style']['show-label'] ).'"
                                data-border-color-a = "'.esc_attr( $array_option[$key]['style']['border-color-a'] ).'"
                            
                                data-padding="'.esc_attr( $array_option[$key]['style']['padding'] ).'" 
                                data-font-size-c = "'.esc_attr( $array_option[$key]['style']['font-size-c'] ).'"
                                data-padding-c="'.esc_attr( $array_option[$key]['style']['padding-c'] ).'"
                                data-width-c = "'.esc_attr( $array_option[$key]['style']['width-c'] ).'"
                                data-height-c = "'.esc_attr( $array_option[$key]['style']['height-c'] ).'">
                                    <span>'.esc_html( $array_option[$key]['style']['name'] ).'</span>
                                    '.$string_value.'
                                    <div class="remove-at-q"><i class="fa fa-timesq"></i></div>
                            </div>'; 
                        }
                    }
                }
             ?>   
            </div>
        </div>
        
        <div class='section-setting-q column-b'>
            <div class='section-heading-q heading-q'><?php echo esc_html__('Attribute design:','quasar-attr-variable') ?></div>
            <div class='wrap-design-attr'></div>
        </div>
        
        <div class='separator-q'></div>
        
        <div class='wrap-dop-customization'>
            <div class='section-setting-q column-b'>
                <div class='section-heading-q heading-q'><?php echo esc_html__('Additional customization:','quasar-attr-variable') ?></div>
                <div class='dop-customization-block-q'></div>
                <div class='separator-q'></div>
            </div>
        </div>

        
        <div class='section-setting-q column-b'>
            <div class='section-heading-q heading-q'><?php echo esc_html__('Attribute tooltip:','quasar-attr-variable') ?></div>
            <div class='wrap-value-customization'></div>
        </div>
        
        <div class='text-help-attr-add'><?php echo esc_html__('Note. If an attribute or attribute value is not in the product published on the site, then this attribute or value may not be in the plugin.','quasar-attr-variable') ?></div>
        <div class='text-help-attr-add'><?php echo esc_html__('If you have changed the attribute name, then in order for its name to change on the site, you need to click the "save" button in the plugin.','quasar-attr-variable') ?></div>
        <div class='text-help-attr-add'><?php echo esc_html__('If you have changed the attribute slug, then this attribute must be removed from the plugin and re-added.','quasar-attr-variable') ?></div>
   
    </div>
    
    
    <div class='modalbox-admin-panel'>
        <div class='admin-col-modal admin-modal-box-col-1'></div>
        <div class='admin-col-modal admin-modal-box-col-2'></div> 
    </div>
    
    
    
    <!-- tab 2-->
    <div class='wrap-setting-qf-woo tab-class-2'>
  
        <div class='section-heading-q heading-q'><?php echo esc_html__('Block design with variations in the product card:','quasar-attr-variable') ?></div>
        <p><?php echo esc_html__('Attribute design is set in the "Attributes" section, in this section you configure the design of the block in which the attributes will be displayed.','quasar-attr-variable') ?></p>
        
        <div class='wrap-two-col-design-q'>
            <div class="wrap-design-setting">
                   
                <div class="wrap-section-attr">
                    <div class="name-attr-q"><?php echo esc_html__('Attribute name','quasar-attr-variable') ?></div>
                    <div class="wrap-attr-element-product">
                        <div class="attr-element-product checkbox-style-q"><?php echo esc_html__('Value 1','quasar-attr-variable') ?></div>
                        <div class="attr-element-product checkbox-style-q"><?php echo esc_html__('Value 2','quasar-attr-variable') ?></div>
                        <div class="attr-element-product checkbox-style-q"><?php echo esc_html__('Value 3','quasar-attr-variable') ?></div>
                    </div>
                </div>
            
                <div class="wrap-section-attr">
                    <div class="name-attr-q"><?php echo esc_html__('Attribute name','quasar-attr-variable') ?></div>
                    <div class="wrap-attr-element-product">
                        <div class="attr-element-product checkbox-style-q"><?php echo esc_html__('Value 1','quasar-attr-variable') ?></div>
                        <div class="attr-element-product checkbox-style-q"><?php echo esc_html__('Value 2','quasar-attr-variable') ?></div>
                        <div class="attr-element-product checkbox-style-q"><?php echo esc_html__('Value 3','quasar-attr-variable') ?></div>
                    </div>
                </div>
            
                <div class="wrap-section-attr">
                    <div class="name-attr-q"><?php echo esc_html__('Attribute name','quasar-attr-variable') ?></div>
                    <div class="wrap-attr-element-product">
                        <div class='wrap-selected-demo-design'>
                            <span class='st-for-select'></span>
                            <select class='attr-element-product'>
                                <option selected><?php echo esc_html__('Value 1','quasar-attr-variable') ?></option>
                                <option><?php echo esc_html__('Value 2','quasar-attr-variable') ?></option>
                                <option><?php echo esc_html__('Value 3','quasar-attr-variable') ?></option>
                            </select>
                        </div>
                    </div>
                </div>
                
            </div>
            
            
            <div class='wrap-design-setting-attr-q'>
                <?php 
                    global $wpdb;
                    $quasar_attr_design = $wpdb->get_results( "SELECT * FROM {$wpdb->base_prefix}quasar_attribute_option WHERE id='1'", ARRAY_A  );
                    foreach( $quasar_attr_design as $row){
                        
                        $array_option = json_decode( $row['mainparams'] , true ); 
                        if ( !$array_option ){  $array_option = json_decode( stripslashes($row['mainparams']) , true ); }
                    }
                ?>
                
                <div class='wrap-design-el'>
                    <span class='heding-field-q'><?php echo esc_html__('Style','quasar-attr-variable') ?></span> 
                    <select id='style-block-variable' class='style-input-q'>
                        <?php
                        if ( $array_option['setting']['style']['style-design'] =='style-1' ){ echo "<option selected data-val='style-1'>".esc_html__('style-1','quasar-attr-variable').'</option>'; }
                        else { echo "<option data-val='style-1'>".esc_html__('style-1','quasar-attr-variable').'</option>'; }
                        if ( $array_option['setting']['style']['style-design'] =='style-2' ){ echo "<option selected data-val='style-2'>".esc_html__('style-2','quasar-attr-variable').'</option>'; }
                        else { echo "<option data-val='style-2'>".esc_html__('style-2','quasar-attr-variable').'</option>'; }
                        ?>
                    </select>
                </div>
                    
                <div class='wrap-design-el'>
                    <span class='name-setting-q'><?php echo esc_html__('Spacing between attributes','quasar-attr-variable') ?><span class='help-q q7'>?</span></span>
                    <input class='style-input-q' id='margin-m-attribute' value='<?php echo esc_attr($array_option['setting']['style']['margin-m-attr']) ?>'>
                </div>  
                
                <div class='wrap-design-el'>
                    <?php $padding = explode(';',$array_option['setting']['style']['padding'] ); ?>
                    <span class='heding-field-q'><?php echo esc_html__('Padding: left, right, top, bottom','quasar-attr-variable') ?></span> 
                    <div class='wrap-padding-f'>
                        <input id='adm-padding-left' class='style-input-q' value='<?php echo esc_attr($padding['0']) ?>'> 
                        <input id='adm-padding-right' class='style-input-q' value='<?php echo esc_attr($padding['1']) ?>'> 
                        <input id='adm-padding-top' class='style-input-q' value='<?php echo esc_attr($padding['2']) ?>'>
                        <input id='adm-padding-bottom' class='style-input-q' value='<?php echo esc_attr($padding['3']) ?>'>
                    </div>
                </div>
                
                <div class='wrap-design-el'>
                    <span class='name-setting-q'><?php echo esc_html__('Maximum width','quasar-attr-variable') ?></span>
                    <input class='style-input-q' id='max-width-v-cart' value='<?php echo esc_attr($array_option['setting']['style']['max-width-v-cart']) ?>'>
                </div>  
                     
                <div class='wrap-text-section-q'>
                    <p><?php echo esc_html__('Attribute name','quasar-attr-variable') ?></p>
                </div> 
                
                <div class='wrap-design-el'>
                    <span class='name-setting-q'><?php echo esc_html__('Spacing between name and value','quasar-attr-variable') ?><span class='help-q q8'>?</span></span>
                    <input class='style-input-q' id='margin-m-name' value='<?php echo esc_attr($array_option['setting']['style']['margin-m-name']) ?>'>
                </div> 
                    
                <div class='wrap-design-el'>
                    <span class='name-setting-q'><?php echo esc_html__('Spacing between values','quasar-attr-variable') ?></span>
                    <input class='style-input-q' id='margin-m-value' value='<?php echo esc_attr( $array_option['setting']['style']['margin-m-value'] ) ?>'>
                </div>
          
                <div class='wrap-design-el'>
                    <span class='name-setting-q'><?php echo esc_html__('Color','quasar-attr-variable') ?></span>
                    <input id='font-color-name-attribute' class='color-setting-start' data-alpha="true" value='<?php echo esc_attr($array_option['setting']['style']['color-name']) ?>'>
                </div>
                
                <div class='wrap-design-el'>
                    <span class='name-setting-q'><?php echo esc_html__('Font size','quasar-attr-variable') ?></span>
                    <input id='font-size-name-attribute' class='style-input-q' value='<?php echo esc_attr($array_option['setting']['style']['font-size-name']) ?>'>
                </div> 
                
                <div class='wrap-design-el'>
                    <span class='heding-field-q'><?php echo esc_html__('font weight','quasar-attr-variable') ?></span> 
                    <select id='font-weight-name-attribute' class='style-input-q'>
                        <?php
                        if ( $array_option['setting']['style']['font-weight-name'] =='400' ){ echo "<option selected data-val='400'>400</option>"; }
                        else { echo "<option data-val='400'>400</option>"; }
                        if ( $array_option['setting']['style']['font-weight-name'] =='500' ){ echo "<option selected data-val='500'>500</option>"; }
                        else { echo "<option data-val='500'>500</option>"; }
                        if ( $array_option['setting']['style']['font-weight-name'] =='600' ){ echo "<option selected data-val='600'>600</option>"; }
                        else { echo "<option data-val='600'>600</option>"; }
                        if ( $array_option['setting']['style']['font-weight-name'] =='700' ){ echo "<option selected data-val='700'>700</option>"; }
                        else { echo "<option data-val='700'>700</option>"; }
                        ?>
                    </select>
                </div>
                
            </div>
        </div>
    </div>
    <div class='wrap-setting-qf-woo category-design tab-class-2'>
        
        <div class='disallow-setting'><?php echo esc_html__('Output in categories is disabled in the settings','quasar-attr-variable') ?></div>
        <div class='section-heading-q heading-q'><?php echo esc_html__('Block design with variations in categories:','quasar-attr-variable') ?></div>
        
        <div class='wrap-two-col-design-q'>
            <div class="wrap-design-setting-category">
                <div class='wrap-demo-img-q'>
                    <img src='<?php echo esc_url($url) ?>/your-img.jpg'/>
                </div>
                <div class="prise-block-attr-q"> 
                    <div class="price-attr-q">$50.00 - $200.00</div>
                </div>
                <div class="wrap-section-attr">
                    <div class="name-attr-q"><?php echo esc_html__('Attribute name','quasar-attr-variable') ?></div>
                    <div class="wrap-attr-element-product">
                        <div class="attr-element-product checkbox-style-q"><?php echo esc_html__('Value 1','quasar-attr-variable') ?></div>
                        <div class="attr-element-product checkbox-style-q"><?php echo esc_html__('Value 2','quasar-attr-variable') ?></div>
                        <div class="attr-element-product checkbox-style-q"><?php echo esc_html__('Value 3','quasar-attr-variable') ?></div>
                    </div>
                </div>
            
                <div class="wrap-section-attr">
                    <div class="name-attr-q"><?php echo esc_html__('Attribute name','quasar-attr-variable') ?></div>
                    <div class="wrap-attr-element-product">
                        <div class="attr-element-product checkbox-style-q"><?php echo esc_html__('Value 1','quasar-attr-variable') ?></div>
                        <div class="attr-element-product checkbox-style-q"><?php echo esc_html__('Value 2','quasar-attr-variable') ?></div>
                        <div class="attr-element-product checkbox-style-q"><?php echo esc_html__('Value 3','quasar-attr-variable') ?></div>
                    </div>
                </div>
            
                <div class="wrap-section-attr">
                    <div class="name-attr-q"><?php echo esc_html__('Attribute name','quasar-attr-variable') ?></div>
                    <div class="wrap-attr-element-product">
                        <div class='wrap-selected-demo-design'>
                            <span class='st-for-select'></span>
                            <select class='attr-element-product'>
                                <option selected><?php echo esc_html__('Value 1','quasar-attr-variable') ?></option>
                                <option><?php echo esc_html__('Value 2','quasar-attr-variable') ?></option>
                                <option><?php echo esc_html__('Value 3','quasar-attr-variable') ?></option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="wrap-number-and-button-q">
                    <div class="wrap-number-add-to-c-q">
                        <input type='number' min='0' value='0'>
                    </div>
                    
                    <div class="wrap-button-add-to-c-q">
                        <div><?php 
                        if ( isset($array_option['setting']['localization']['loc-add-cart']) ){ $array_option['setting']['localization']['loc-add-cart'] = esc_html__('Add to cart','quasar-attr-variable'); }
                        echo esc_html($array_option['setting']['localization']['loc-add-cart']) 
                        ?>
                        </div>
                    </div>
                </div>
                
            </div>
            
            
            <div class='wrap-design-setting-attr-q'>
                <?php 
                    global $wpdb;
                    $quasar_attr_design = $wpdb->get_results( "SELECT * FROM {$wpdb->base_prefix}quasar_attribute_option WHERE id='1'", ARRAY_A  );
                    foreach( $quasar_attr_design as $row){
                        
                        $array_option = json_decode( $row['mainparams'] , true ); 
                        if ( !$array_option ){  $array_option = json_decode( stripslashes($row['mainparams']) , true ); }
                        
                    }
                ?>
                
                <div class='wrap-design-el'>
                    <span class='heding-field-q'><?php echo esc_html__('Style','quasar-attr-variable') ?></span> 
                    <select id='style-block-variable-category' class='style-input-q'>
                        <?php
                        if ( $array_option['setting']['style']['style-design-c'] =='style-1' ){ echo "<option selected data-val='style-1'>".esc_html__('style-1','quasar-attr-variable').'</option>'; }
                        else { echo "<option data-val='style-1'>".esc_html__('style-1','quasar-attr-variable').'</option>'; }
                        if ( $array_option['setting']['style']['style-design-c'] =='style-2' ){ echo "<option selected data-val='style-2'>".esc_html__('style-2','quasar-attr-variable').'</option>'; }
                        else { echo "<option data-val='style-2'>".esc_html__('style-2','quasar-attr-variable').'</option>'; }
                        ?>
                    </select>
                </div>
    
                    
                <div class='wrap-design-el'>
                    <span class='name-setting-q'><?php echo esc_html__('Spacing between attributes','quasar-attr-variable') ?><span class='help-q q7'>?</span></span>
                    <input class='style-input-q' id='margin-m-attribute-c' value='<?php echo esc_attr( $array_option['setting']['style']['margin-m-attr-c'] ) ?>'>
                </div>  
                
                <div class='wrap-design-el'>
                    <?php $padding = explode(';',$array_option['setting']['style']['padding-c'] ); ?>
                    <span class='heding-field-q'><?php echo esc_html__('Padding: left, right, top, bottom','quasar-attr-variable') ?></span> 
                    <div class='wrap-padding-f'>
                        <input id='adm-padding-left-c' class='style-input-q' value='<?php echo esc_attr( $padding['0'] )?>'> 
                        <input id='adm-padding-right-c' class='style-input-q' value='<?php echo esc_attr( $padding['1'] )?>'> 
                        <input id='adm-padding-top-c' class='style-input-q' value='<?php echo  esc_attr( $padding['2'] ) ?>'>
                        <input id='adm-padding-bottom-c' class='style-input-q' value='<?php echo  esc_attr( $padding['3'] )?>'>
                    </div>
                </div>
                
                
                <div class='wrap-text-section-q'>
                    <p><?php echo esc_html__('Attribute name','quasar-attr-variable') ?></p>
                </div> 
                     
                <div class='wrap-design-el'>
                    <span class='name-setting-q'><?php echo esc_html__('Spacing between name and value','quasar-attr-variable') ?><span class='help-q q8'>?</span></span>
                    <input class='style-input-q' id='margin-m-name-c' value='<?php echo esc_attr( $array_option['setting']['style']['margin-m-name-c'] ) ?>'>
                </div> 
                    
                <div class='wrap-design-el'>
                    <span class='name-setting-q'><?php echo esc_html__('Spacing between values','quasar-attr-variable') ?></span>
                    <input class='style-input-q' id='margin-m-value-c' value='<?php echo esc_attr( $array_option['setting']['style']['margin-m-value-c'] ) ?>'>
                </div> 
                
                
                <div class='wrap-design-el'>
                    <span class='name-setting-q'><?php echo esc_html__('Color','quasar-attr-variable') ?></span>
                    <input id='font-color-name-attribute-с' class='color-setting-start' data-alpha="true" value='<?php echo esc_attr( $array_option['setting']['style']['color-name-c'] ) ?>'>
                </div>
                
                <div class='wrap-design-el'>
                    <span class='name-setting-q'><?php echo esc_html__('Font size','quasar-attr-variable') ?></span>
                    <input id='font-size-name-attribute-c' class='style-input-q' value='<?php echo esc_attr( $array_option['setting']['style']['font-size-name-c'] ) ?>'>
                </div> 
                
                <div class='wrap-design-el'>
                    <span class='heding-field-q'><?php echo esc_html__('Font weight','quasar-attr-variable') ?></span> 
                    <select id='font-weight-name-attribute-c' class='style-input-q'>
                        <?php
                        if ( $array_option['setting']['style']['font-weight-name-c'] =='400' ){ echo "<option selected data-val='400'>400</option>"; }
                        else { echo "<option data-val='400'>400</option>"; }
                        if ( $array_option['setting']['style']['font-weight-name-c'] =='500' ){ echo "<option selected data-val='500'>500</option>"; }
                        else { echo "<option data-val='500'>500</option>"; }
                        if ( $array_option['setting']['style']['font-weight-name-c'] =='600' ){ echo "<option selected data-val='600'>600</option>"; }
                        else { echo "<option data-val='600'>600</option>"; }
                        if ( $array_option['setting']['style']['font-weight-name-c'] =='700' ){ echo "<option selected data-val='700'>700</option>"; }
                        else { echo "<option data-val='700'>700</option>"; }
                        ?>
                    </select>
                </div>
                    
                
                <div class='wrap-text-section-q'>
                    <p><?php echo esc_html__('Price','quasar-attr-variable') ?></p>
                </div> 
                
                 <div class='wrap-design-el'>
                    <span class='heding-field-q'><?php echo esc_html__('Enable design from plugin','quasar-attr-variable') ?><span class='help-q q3'>?</span></span> 
                    <select id='enable-price-design' class='style-input-q'>
                        <?php
                        if ( $array_option['setting']['style']['price-design'] =='yes' ){ echo "<option selected data-val='yes'>".esc_html__('Yes','quasar-attr-variable').'</option>'; }
                        else { echo "<option data-val='yes'>".esc_html__('Yes','quasar-attr-variable').'</option>'; }
                        if ( $array_option['setting']['style']['price-design'] =='no' ){ echo "<option selected data-val='no'>".esc_html__('No','quasar-attr-variable').'</option>'; }
                        else { echo "<option data-val='no'>".esc_html__('No','quasar-attr-variable').'</option>'; }
                        ?>
                    </select>
                </div>
    
                <div class='wrap-design-el price-uniq-class'>
                    <span class='name-setting-q'><?php echo esc_html__('Color','quasar-attr-variable') ?></span>
                    <input id='font-color-price-с' class='color-setting-start' data-alpha="true" value='<?php echo esc_attr( $array_option['setting']['style']['color-price-c'] ) ?>'>
                </div>
                
                <div class='wrap-design-el price-uniq-class'>
                    <span class='name-setting-q'><?php echo esc_html__('Font size','quasar-attr-variable') ?></span>
                    <input id='font-size-price-attribute-c' class='style-input-q' value='<?php echo esc_attr( $array_option['setting']['style']['font-size-price-c'] ) ?>'>
                </div> 
                
                <div class='wrap-design-el price-uniq-class'>
                    <span class='heding-field-q'><?php echo esc_html__('Font weight','quasar-attr-variable') ?></span> 
                    <select id='font-weight-price-attribute-c' class='style-input-q'>
                        <?php
                        if ( $array_option['setting']['style']['font-weight-price-c'] =='400' ){ echo "<option selected data-val='400'>400</option>"; }
                        else { echo "<option data-val='400'>400</option>"; }
                        if ( $array_option['setting']['style']['font-weight-price-c'] =='500' ){ echo "<option selected data-val='500'>500</option>"; }
                        else { echo "<option data-val='500'>500</option>"; }
                        if ( $array_option['setting']['style']['font-weight-price-c'] =='600' ){ echo "<option selected data-val='600'>600</option>"; }
                        else { echo "<option data-val='600'>600</option>"; }
                        if ( $array_option['setting']['style']['font-weight-price-c'] =='700' ){ echo "<option selected data-val='700'>700</option>"; }
                        else { echo "<option data-val='700'>700</option>"; }
                        ?>
                    </select>
                </div>
                
                <div class='wrap-design-el price-uniq-class'>
                    <span class='name-setting-q'><?php echo esc_html__('Price indent','quasar-attr-variable') ?></span>
                    <input id='price-indent-c' class='style-input-q' value="<?php echo  esc_attr( $array_option['setting']['style']['price-indent-c'] ) ?>">
                </div> 
                
                <div class='wrap-design-el price-uniq-class'>
                    <span class='name-setting-q'><?php echo esc_html__('Price align','quasar-attr-variable') ?></span>
                    <div class='swap-align-buttons price-align-q' data-val='<?php echo esc_attr( $array_option['setting']['style']['price-align-c'] ) ?>'> 
                        <div class='element-align-q left-al-setting'><i class='fa fa-align-leftq'></i></div> 
                        <div class='element-align-q center-al-setting'><i class='fa fa-align-centerq'></i></div> 
                        <div class='element-align-q right-al-setting'><i class='fa fa-align-rightq'></i></div>   
                    </div>
                </div>
                
                <div class='wrap-text-section-q'>
                    <p><?php echo esc_html__('Button add to cart','quasar-attr-variable') ?></p>
                </div> 
                
                <div class='wrap-design-el'>
                    <span class='heding-field-q'><?php echo esc_html__('Enable design from plugin','quasar-attr-variable') ?><span class='help-q q1'>?</span></span> 
                    <select id='enable-button-design' class='style-input-q'>
                        <?php
                        if ( $array_option['setting']['style']['button-design'] =='yes' ){ echo "<option selected data-val='yes'>".esc_html__('Yes','quasar-attr-variable').'</option>'; }
                        else { echo "<option data-val='yes'>".esc_html__('Yes','quasar-attr-variable').'</option>'; }
                        if ( $array_option['setting']['style']['button-design'] =='no' ){ echo "<option selected data-val='no'>".esc_html__('No','quasar-attr-variable').'</option>'; }
                        else { echo "<option data-val='no'>".esc_html__('No','quasar-attr-variable').'</option>'; }
                        ?>
                    </select>
                </div>
                
                <div class='wrap-design-el button-unique-class'>
                    <span class='name-setting-q'><?php echo esc_html__('Font color','quasar-attr-variable') ?></span>
                    <input id='font-color-button-с' class='color-setting-start' data-alpha="true" value='<?php echo esc_attr( $array_option['setting']['style']['color-button-c'] ) ?>'>
                </div>
                
                <div class='wrap-design-el button-unique-class'>
                    <span class='name-setting-q'><?php echo esc_html__('Background color','quasar-attr-variable') ?></span>
                    <input id='background-color-button-с' class='color-setting-start' data-alpha="true" value='<?php echo esc_attr( $array_option['setting']['style']['b-color-button-с'] ) ?>'>
                </div>
                
                <div class='wrap-design-el button-unique-class'>
                    <span class='name-setting-q'><?php echo esc_html__('Font size','quasar-attr-variable') ?></span>
                    <input id='font-size-button-attribute-c' class='style-input-q' value='<?php echo esc_attr( $array_option['setting']['style']['font-size-button-c'] ) ?>'>
                </div> 
                
                <div class='wrap-design-el button-unique-class'>
                    <span class='heding-field-q'><?php echo esc_html__('Font weight','quasar-attr-variable') ?></span> 
                    <select id='font-weight-button-attribute-c' class='style-input-q'>
                        <?php
                        if ( $array_option['setting']['style']['font-weight-button-c'] =='400' ){ echo "<option selected data-val='400'>400</option>"; }
                        else { echo "<option data-val='400'>400</option>"; }
                        if ( $array_option['setting']['style']['font-weight-button-c'] =='500' ){ echo "<option selected data-val='500'>500</option>"; }
                        else { echo "<option data-val='500'>500</option>"; }
                        if ( $array_option['setting']['style']['font-weight-button-c'] =='600' ){ echo "<option selected data-val='600'>600</option>"; }
                        else { echo "<option data-val='600'>600</option>"; }
                        if ( $array_option['setting']['style']['font-weight-button-c'] =='700' ){ echo "<option selected data-val='700'>700</option>"; }
                        else { echo "<option data-val='700'>700</option>"; }
                        ?>
                    </select>
                </div>
                
                <div class='wrap-design-el button-unique-class'>
                    <span class='name-setting-q'><?php echo esc_html__('Button indent','quasar-attr-variable') ?></span>
                    <input id='button-indent-c' class='style-input-q' value="<?php echo  esc_attr( $array_option['setting']['style']['button-indent-c'] ) ?>">
                </div> 
                
                <div class='wrap-design-el button-unique-class'>
                    <span class='name-setting-q'><?php echo esc_html__('Button align','quasar-attr-variable') ?></span>
                    <div class='swap-align-buttons button-align-q' data-val='<?php echo esc_attr( $array_option['setting']['style']['button-align-c'] ) ?>'> 
                        <div class='element-align-q left-al-setting'><i class='fa fa-align-leftq'></i></div> 
                        <div class='element-align-q center-al-setting'><i class='fa fa-align-centerq'></i></div> 
                        <div class='element-align-q right-al-setting'><i class='fa fa-align-rightq'></i></div>   
                    </div>
                </div>
                
                <div class='wrap-design-el button-unique-class'>
                    <?php $padding = explode(';', $array_option['setting']['style']['padding-button'] ); ?>
                    <span class='heding-field-q'><?php echo esc_html__('Button padding: left, right, top, bottom','quasar-attr-variable') ?></span> 
                    <div class='wrap-padding-f'>
                        <input id='adm-button-padding-left-c' class='style-input-q' value='<?php echo esc_attr( $padding['0'] )?>'> 
                        <input id='adm-button-padding-right-c' class='style-input-q' value='<?php echo esc_attr( $padding['1'] )?>'> 
                        <input id='adm-button-padding-top-c' class='style-input-q' value='<?php echo  esc_attr( $padding['2'] ) ?>'>
                        <input id='adm-button-padding-bottom-c' class='style-input-q' value='<?php echo  esc_attr( $padding['3'] )?>'>
                    </div>
                </div>
                
                <div class='wrap-design-el button-unique-class'>
                    <span class='name-setting-q'><?php echo esc_html__('Border width','quasar-attr-variable') ?></span>
                    <input id='button-border-width-c' class='style-input-q' value="<?php echo  esc_attr( $array_option['setting']['style']['button-border-w'] ) ?>">
                </div>
                
                <div class='wrap-design-el button-unique-class'>
                    <span class='name-setting-q'><?php echo esc_html__('Border color','quasar-attr-variable') ?></span>
                    <input id='border-color-button-с' class='color-setting-start' data-alpha="true"  value='<?php echo esc_attr( $array_option['setting']['style']['button-border-c'] ) ?>'>
                </div>
                
                <div class='wrap-design-el button-unique-class'>
                    <span class='name-setting-q'><?php echo esc_html__('Border radius','quasar-attr-variable') ?></span>
                    <input id='button-border-radius-c' class='style-input-q' value="<?php echo  esc_attr( $array_option['setting']['style']['button-border-r'] ) ?>">
                </div>
                
                <div class='wrap-text-section-q'>
                    <p><?php echo esc_html__('Field quantity','quasar-attr-variable') ?><span class='disable-quantity'><?php echo esc_html__('Field disabled in settings','quasar-attr-variable') ?></span></p>
                </div> 
                
                <div class='wrap-design-el quanity-design-q'>
                    <span class='heding-field-q'><?php echo esc_html__('Enable design from plugin','quasar-attr-variable') ?><span class='help-q q2'>?</span></span> 
                    <select id='enable-quantity-design' class='style-input-q'>
                        <?php
                        if ( $array_option['setting']['style']['quantity-design'] =='yes' ){ echo "<option selected data-val='yes'>".esc_html__('Yes','quasar-attr-variable').'</option>'; }
                        else { echo "<option data-val='yes'>".esc_html__('Yes','quasar-attr-variable').'</option>'; }
                        if ( $array_option['setting']['style']['quantity-design'] =='no' ){ echo "<option selected data-val='no'>".esc_html__('No','quasar-attr-variable').'</option>'; }
                        else { echo "<option data-val='no'>".esc_html__('No','quasar-attr-variable').'</option>'; }
                        ?>
                    </select>
                </div>
                
                <div class='wrap-design-el quanity-design-q'>
                    <span class='name-setting-q'><?php echo esc_html__('Number color','quasar-attr-variable') ?></span>
                    <input id='font-color-quantity-с' class='color-setting-start' data-alpha="true" value='<?php echo esc_attr( $array_option['setting']['style']['color-quantity-с'] ) ?>'>
                </div>
                
                <div class='wrap-design-el quanity-design-q'>
                    <span class='name-setting-q'><?php echo esc_html__('Number size','quasar-attr-variable') ?></span>
                    <input id='font-size-quantity-с' class='style-input-q' value="<?php echo  esc_attr( $array_option['setting']['style']['font-size-q-с'] ) ?>">
                </div>
                
                <div class='wrap-design-el quanity-design-q'>
                    <span class='name-setting-q'><?php echo esc_html__('Background color','quasar-attr-variable') ?></span>
                    <input id='background-quantity-с' class='color-setting-start' data-alpha="true" value='<?php echo esc_attr( $array_option['setting']['style']['b-quantity-с'] ) ?>'>
                </div>
                
                <div class='wrap-design-el quanity-design-q'>
                    <span class='name-setting-q'><?php echo esc_html__('Border color','quasar-attr-variable') ?></span>
                    <input id='border-color-quantity-с' class='color-setting-start' data-alpha="true" value='<?php echo esc_attr( $array_option['setting']['style']['b-c-quantity-с'] ) ?>'>
                </div>
                
                <div class='wrap-design-el quanity-design-q'>
                    <span class='name-setting-q'><?php echo esc_html__('Border widh','quasar-attr-variable') ?></span>
                    <input id='quantity-border-width-c' class='style-input-q' value="<?php echo  esc_attr( $array_option['setting']['style']['b-w-quantity-с'] ) ?>">
                </div>
                
                <div class='wrap-design-el quanity-design-q'>
                    <span class='name-setting-q'><?php echo esc_html__('Border radius','quasar-attr-variable') ?></span>
                    <input id='quantity-border-radius-c' class='style-input-q' value="<?php echo  esc_attr( $array_option['setting']['style']['b-r-quantity-с'] ) ?>">
                </div>
                
                <div class='wrap-design-el quanity-design-q'>
                    <?php $padding = explode(';', $array_option['setting']['style']['padding-quantity'] ); ?>
                    <span class='heding-field-q'><?php echo esc_html__('Quantity padding: left, right, top, bottom','quasar-attr-variable') ?></span> 
                    <div class='wrap-padding-f'>
                        <input id='adm-quantity-padding-left-c' class='style-input-q' value='<?php echo esc_attr( $padding['0'] )?>'> 
                        <input id='adm-quantity-padding-right-c' class='style-input-q' value='<?php echo esc_attr( $padding['1'] )?>'> 
                        <input id='adm-quantity-padding-top-c' class='style-input-q' value='<?php echo  esc_attr( $padding['2'] ) ?>'>
                        <input id='adm-quantity-padding-bottom-c' class='style-input-q' value='<?php echo  esc_attr( $padding['3'] )?>'>
                    </div>
                </div>
            
            </div>
        </div>
        
    </div>
    
    
    <!-- tab 3-->
    <div class='wrap-setting-qf-woo tab-class-3'>
        
        <div class='section-heading-q heading-q'><?php echo esc_html__('Main settings','quasar-attr-variable') ?></div>
        
        <div class='section-setting-q'>
            <div class='block-field-q drop-menu-select'>
                <select id='show-archive-block-variable'>
                    <?php
                    if ( $array_option['setting']['setting']['show-acrhive'] =='yes' ){ echo "<option selected data-val='yes'>".esc_html__('Yes','quasar-attr-variable').'</option>'; }
                    else { echo "<option data-val='yes'>".esc_html__('Yes','quasar-attr-variable').'</option>'; }
                    if ( $array_option['setting']['setting']['show-acrhive'] =='no' ){ echo "<option selected data-val='no'>".esc_html__('No','quasar-attr-variable').'</option>'; }
                    else { echo "<option data-val='no'>".esc_html__('No','quasar-attr-variable').'</option>'; }
                    ?>
                </select>
            </div>
            <div class='text-setting-q'><?php esc_html_e('Show block of variations in categories.','quasar-attr-variable');?><span class="help-q q4">?</span></div>
        </div>
        
        <div class='section-heading-q heading-q margin-heading-q'><?php echo esc_html__('Block location with variations','quasar-attr-variable') ?></div>
        
        <div class='section-setting-q prioritet-category'>
            <div class='block-field-q drop-menu-select prioritet-block'>
                <span><?php echo esc_html__('Product Card','quasar-attr-variable') ?></span>
                <select id='list-position'>
                <?php 
                if ( $array_option['setting']['setting']['position-cart'] == 'variant3' ){ echo '<option selected data-val="variant3">'.esc_html__('After a short description (this option will function with a product without price)','quasar-attr-variable').'</option>'; }
                else { echo '<option data-val="variant3">'.esc_html__('Above the short description','quasar-attr-variable').'</option>'; }
                
                if ( $array_option['setting']['setting']['position-cart'] == 'variant1' ){ echo '<option selected data-val="variant1">'.esc_html__('After add to cart button','quasar-attr-variable').'</option>'; }
                else { echo '<option data-val="variant1">'.esc_html__('After add to cart button','quasar-attr-variable').'</option>'; }
                
                if ( $array_option['setting']['setting']['position-cart'] == 'variant2' ){ echo '<option selected data-val="variant2">'.esc_html__('Before quantity input field','quasar-attr-variable').'</option>'; }
                else { echo '<option data-val="variant2">'.esc_html__('Before quantity input field','quasar-attr-variable').'</option>'; }
                
                
                if ( $array_option['setting']['setting']['position-cart'] == 'variant4' ){ echo '<option selected data-val="variant4">'.esc_html__('Product meta end','quasar-attr-variable').'</option>'; }
                else { echo '<option data-val="variant4">'.esc_html__('Product meta end','quasar-attr-variable').'</option>'; }
                ?>
                </select>
            </div> 
            <div class='block-field-q drop-menu-select prioritet-block prioritet-select'>
                <span><?php echo esc_html__('Priority','quasar-attr-variable') ?><span class='help-q q14'>?</span></span>
                <select id='position-prioritet-cart'>
                    <?php 
                    if ( !isset($array_option['setting']['setting']['prioritet-cart']) ){ $array_option['setting']['setting']['prioritet-cart'] = '25'; } 
                    
                    if ( $array_option['setting']['setting']['prioritet-cart'] == '0' ){ echo '<option selected data-val="0">0</option>'; }
                    else { echo '<option data-val="0">0</option>'; }
                    
                    if ( $array_option['setting']['setting']['prioritet-cart'] == '10' ){ echo '<option selected data-val="10">10</option>'; }
                    else { echo '<option data-val="10">10</option>'; }
                    
                    if ( $array_option['setting']['setting']['prioritet-cart'] == '25' ){ echo '<option selected data-val="25">25</option>'; }
                    else { echo '<option data-val="25">25</option>'; }
                    
                    if ( $array_option['setting']['setting']['prioritet-cart'] == '50' ){ echo '<option selected data-val="50">50</option>'; }
                    else { echo '<option data-val="50">50</option>'; }
                    
                    if ( $array_option['setting']['setting']['prioritet-cart'] == '100' ){ echo '<option selected data-val="100">100</option>'; }
                    else { echo '<option data-val="100">100</option>'; }
                    ?>
                </select>
            </div> 
            <div class='text-setting-q'><?php esc_html_e('Select the position of the variable in the product card.','quasar-attr-variable');?></div>
        </div>
        
        <div class='section-setting-q category-setting-q prioritet-category'>
            <div class='block-field-q drop-menu-select prioritet-block'>
                <span><?php echo esc_html__('Category','quasar-attr-variable') ?></span>
                <select id='list-position-archive'>
                <?php 
                if ( $array_option['setting']['setting']['position-archive'] == 'variant1' ){ echo '<option selected data-val="variant1">'.esc_html__('After add to cart button','quasar-attr-variable').'</option>'; }
                else { echo '<option data-val="variant1">'.esc_html__('Before add to cart button','quasar-attr-variable').'</option>'; }
                
                if ( $array_option['setting']['setting']['position-archive'] == 'variant2' ){ echo '<option selected data-val="variant2">'.esc_html__('Before shop loop item','quasar-attr-variable').'</option>'; }
                else { echo '<option data-val="variant2">'.esc_html__('Before shop loop item','quasar-attr-variable').'</option>'; }
                ?>
                </select>
            </div> 
            <div class='block-field-q drop-menu-select prioritet-block prioritet-select'>
                <span><?php echo esc_html__('Priority','quasar-attr-variable') ?><span class='help-q q14'>?</span></span>
                <select id='position-prioritet-category'>
                    <?php 
                    if ( !isset($array_option['setting']['setting']['prioritet-category']) ){ $array_option['setting']['setting']['prioritet-category'] = '25'; } 
                    
                    if ( $array_option['setting']['setting']['prioritet-category'] == '0' ){ echo '<option selected data-val="0">0</option>'; }
                    else { echo '<option data-val="0">0</option>'; }
                    
                    if ( $array_option['setting']['setting']['prioritet-category'] == '10' ){ echo '<option selected data-val="10">10</option>'; }
                    else { echo '<option data-val="10">10</option>'; }
                    
                    if ( $array_option['setting']['setting']['prioritet-category'] == '25' ){ echo '<option selected data-val="25">25</option>'; }
                    else { echo '<option data-val="25">25</option>'; }
                    
                    if ( $array_option['setting']['setting']['prioritet-category'] == '50' ){ echo '<option selected data-val="50">50</option>'; }
                    else { echo '<option data-val="50">50</option>'; }
                    
                    if ( $array_option['setting']['setting']['prioritet-category'] == '100' ){ echo '<option selected data-val="100">100</option>'; }
                    else { echo '<option data-val="100">100</option>'; }
                    ?>
                </select>
            </div>
            <div class='text-setting-q'><?php esc_html_e('Select the position of the variable in the archive and category pages.','quasar-attr-variable');?></div>
        </div>
        
        <div class='section-setting-q'>
            <div class='block-field-q drop-menu-select'>
                <select id='list-show-stock-zero'>
                <?php 
                if ( $array_option['setting']['setting']['show-stock-zero'] == 'yes' ){ echo '<option selected data-val="yes">'.esc_html__('Yes','quasar-attr-variable').'</option>'; }
                else { echo '<option data-val="yes">'.esc_html__('Yes','quasar-attr-variable').'</option>'; }
                
                if ( $array_option['setting']['setting']['show-stock-zero'] == 'not' ){ echo '<option selected data-val="not">'.esc_html__('No','quasar-attr-variable').'</option>'; }
                else { echo '<option data-val="not">'.esc_html__('No','quasar-attr-variable').'</option>'; }
                ?>
                </select>
            </div> 
            <div class='text-setting-q'><?php esc_html_e('Show a block of variations in products with zero stock.','quasar-attr-variable');?></div>
        </div>
        
        
        <div class='section-heading-q heading-q margin-heading-q category-setting-q'><?php echo esc_html__('Display settings in categories','quasar-attr-variable') ?></div>
        
        <div class='section-setting-q category-setting-q'>
            <div class='block-field-q drop-menu-select'>
                <select id='position-currency-q'>
                    <?php
                    if ( $array_option['setting']['setting']['position-currency'] =='left' ){ echo "<option selected data-val='left'>".esc_html__('To the left of the price','quasar-attr-variable').'</option>'; }
                    else { echo "<option data-val='left'>".esc_html__('To the left of the price','quasar-attr-variable').'</option>'; }
                    if ( $array_option['setting']['setting']['position-currency'] =='right' ){ echo "<option selected data-val='right'>".esc_html__('To the right of the price','quasar-attr-variable').'</option>'; }
                    else { echo "<option data-val='right'>".esc_html__('To the right of the price','quasar-attr-variable').'</option>'; }
                    ?>
                </select>
            </div>
            <div class='text-setting-q'><?php esc_html_e('Сurrency icon position.','quasar-attr-variable');?></div>
        </div>
        
        <div class='section-setting-q category-setting-q'>
            <div class='block-field-q drop-menu-select'>
                <select id='redirect-cart-q'>
                    <?php
                    if ( !isset($array_option['setting']['setting']['redirect-cart']) ){ 
                        $array_option['setting']['setting']['redirect-cart'] ='no';
                    }
                    if ( $array_option['setting']['setting']['redirect-cart'] =='yes' ){ echo "<option selected data-val='yes'>".esc_html__('Yes','quasar-attr-variable').'</option>'; }
                    else { echo "<option data-val='yes'>".esc_html__('Yes','quasar-attr-variable').'</option>'; }
                    if ( $array_option['setting']['setting']['redirect-cart'] =='no' ){ echo "<option selected data-val='no'>".esc_html__('No','quasar-attr-variable').'</option>'; }
                    else { echo "<option data-val='no'>".esc_html__('No','quasar-attr-variable').'</option>'; }
                    ?>
                </select>
            </div>
            <div class='text-setting-q'><?php esc_html_e('Redirect to the shopping cart page after purchasing the product.','quasar-attr-variable');?><span class="help-q q15">?</span></div>
        </div>
        
        <div class='section-setting-q category-setting-q'>
            <div class='block-field-q drop-menu-select'>
                <select id='show-quantity-q'>
                    <?php
                    if ( $array_option['setting']['setting']['show-quantity'] =='yes' ){ echo "<option selected data-val='yes'>".esc_html__('Yes','quasar-attr-variable').'</option>'; }
                    else { echo "<option data-val='yes'>".esc_html__('Yes','quasar-attr-variable').'</option>'; }
                    if ( $array_option['setting']['setting']['show-quantity'] =='no' ){ echo "<option selected data-val='no'>".esc_html__('No','quasar-attr-variable').'</option>'; }
                    else { echo "<option data-val='no'>".esc_html__('No','quasar-attr-variable').'</option>'; }
                    ?>
                </select>
            </div>
            <div class='text-setting-q'><?php esc_html_e('Show quantity field in categories.','quasar-attr-variable');?><span class="help-q q5">?</span></div>
        </div>
        
        <div class='section-setting-q category-setting-q'>
            <div class='block-field-q drop-menu-select'>
                <select id='change-img-q'>
                    <?php
                    if ( $array_option['setting']['setting']['change-img'] =='yes' ){ echo "<option selected data-val='yes'>".esc_html__('Yes','quasar-attr-variable').'</option>'; }
                    else { echo "<option data-val='yes'>".esc_html__('Yes','quasar-attr-variable').'</option>'; }
                    if ( $array_option['setting']['setting']['change-img'] =='no' ){ echo "<option selected data-val='no'>".esc_html__('No','quasar-attr-variable').'</option>'; }
                    else { echo "<option data-val='no'>".esc_html__('No','quasar-attr-variable').'</option>'; }
                    ?>
                </select>
            </div>
            <div class='text-setting-q'><?php esc_html_e('Сhange the product image to the image of the selected variation. This option will not work in all themes.','quasar-attr-variable');?><span class="help-q q6">?</span></div>
        </div>
        
        <div class='section-setting-q category-setting-q'>
            <div class='block-field-q drop-menu-select'>
                <?php 
                    if ( !isset($array_option['setting']['setting']['class-change-img']) ){ $array_option['setting']['setting']['class-change-img'] = '.attachment-woocommerce_thumbnail'; }
                ?>
                <input id='class-img-q' value='<?php echo $array_option['setting']['setting']['class-change-img']; ?>' class='style-input-q'>
            </div>
            <div class='text-setting-q'><?php esc_html_e('Product image class in product category.','quasar-attr-variable');?></div>
        </div>
        
        <div class='section-setting-q category-setting-q'>
            <div class='block-field-q drop-menu-select'>
                <select id='show-variable-in-related'>
                    <?php
                    if ( $array_option['setting']['setting']['show-variable-in-related'] =='yes' ){ echo "<option selected data-val='yes'>".esc_html__('Yes','quasar-attr-variable').'</option>'; }
                    else { echo "<option data-val='yes'>".esc_html__('Yes','quasar-attr-variable').'</option>'; }
                    if ( $array_option['setting']['setting']['show-variable-in-related'] =='no' ){ echo "<option selected data-val='no'>".esc_html__('No','quasar-attr-variable').'</option>'; }
                    else { echo "<option data-val='no'>".esc_html__('No','quasar-attr-variable').'</option>'; }
                    ?>
                </select>
            </div>
            <div class='text-setting-q'><?php esc_html_e('Show variations in related products.','quasar-attr-variable');?><span class="help-q q12">?</span></div>
        </div>
        
        <div class='section-setting-q category-setting-q'>
            <div class='block-field-q drop-menu-select'>
                <select id='show-variable-in-upsell'>
                    <?php
                    if ( $array_option['setting']['setting']['show-variable-in-upsell'] =='yes' ){ echo "<option selected data-val='yes'>".esc_html__('Yes','quasar-attr-variable').'</option>'; }
                    else { echo "<option data-val='yes'>".esc_html__('Yes','quasar-attr-variable').'</option>'; }
                    if ( $array_option['setting']['setting']['show-variable-in-upsell'] =='no' ){ echo "<option selected data-val='no'>".esc_html__('No','quasar-attr-variable').'</option>'; }
                    else { echo "<option data-val='no'>".esc_html__('No','quasar-attr-variable').'</option>'; }
                    ?>
                </select>
            </div>
            <div class='text-setting-q'><?php esc_html_e('Show variations in upsell.','quasar-attr-variable');?><span class="help-q q13">?</span></div>
        </div>
        
        <div class='section-heading-q heading-q margin-heading-q'><?php echo esc_html__('Responsiveness settings','quasar-attr-variable') ?></div>
        
        <div class='section-setting-q category-setting-q'>
            <div class='block-field-q drop-menu-select'>
                <select id='responsive-category'>
                <?php 
                if ( $array_option['setting']['setting']['responsive-category'] == '500' ){ echo '<option selected data-val="500">500px</option>'; }
                else { echo '<option data-val="500">500px</option>'; }
                
                if ( $array_option['setting']['setting']['responsive-category'] == '600' ){ echo '<option selected data-val="600">600px</option>'; }
                else { echo '<option data-val="600">600px</option>'; }
                
                if ( $array_option['setting']['setting']['responsive-category'] == '700' ){ echo '<option selected data-val="700">700px</option>'; }
                else { echo '<option data-val="700">700px</option>'; }
                
                if ( $array_option['setting']['setting']['responsive-category'] == '800' ){ echo '<option selected data-val="800">800px</option>'; }
                else { echo '<option data-val="800">800px</option>'; }
                
                if ( $array_option['setting']['setting']['responsive-category'] == '900' ){ echo '<option selected data-val="900">900px</option>'; }
                else { echo '<option data-val="900">900px</option>'; }
                
                if ( $array_option['setting']['setting']['responsive-category'] == '1000' ){ echo '<option selected data-val="1000">1000px</option>'; }
                else { echo '<option data-val="1000">1000px</option>'; }
                ?>
                </select>
            </div> 
            <div class='text-setting-q'><?php esc_html_e('Select the display size from which the mobile mode will be activated in the options block in the product category.','quasar-attr-variable');?></div>
        </div>
        
        <div class='section-setting-q category-setting-q'>
            <div class='block-field-q drop-menu-select'>
                <select id='responsive-category-hide'>
                <?php 
                if ( $array_option['setting']['setting']['responsive-category-hide'] == 'no' ){ echo '<option selected data-val="no">'.esc_html__('Do not hide variable','quasar-attr-variable').'</option>'; }
                else { echo '<option data-val="no">'.esc_html__('Do not hide variable','quasar-attr-variable').'</option>'; }
                
                if ( $array_option['setting']['setting']['responsive-category-hide'] == '500' ){ echo '<option selected data-val="500">500px</option>'; }
                else { echo '<option data-val="500">500px</option>'; }
                
                if ( $array_option['setting']['setting']['responsive-category-hide'] == '600' ){ echo '<option selected data-val="600">600px</option>'; }
                else { echo '<option data-val="600">600px</option>'; }
                
                if ( $array_option['setting']['setting']['responsive-category-hide'] == '700' ){ echo '<option selected data-val="700">700px</option>'; }
                else { echo '<option data-val="700">700px</option>'; }
                
                if ( $array_option['setting']['setting']['responsive-category-hide'] == '800' ){ echo '<option selected data-val="800">800px</option>'; }
                else { echo '<option data-val="800">800px</option>'; }
                
                if ( $array_option['setting']['setting']['responsive-category-hide'] == '900' ){ echo '<option selected data-val="900">900px</option>'; }
                else { echo '<option data-val="900">900px</option>'; }
                
                if ( $array_option['setting']['setting']['responsive-category-hide'] == '1000' ){ echo '<option selected data-val="1000">1000px</option>'; }
                else { echo '<option data-val="1000">1000px</option>'; }
                ?>
                </select>
            </div> 
            <div class='text-setting-q'><?php esc_html_e('Hide block with variables in categories at display size.','quasar-attr-variable');?></div>
        </div>
        
        <div class='section-setting-q'>
            <div class='block-field-q drop-menu-select'>
                <select id='responsive-cart'>
                <?php 
                if ( $array_option['setting']['setting']['responsive-cart'] == '500' ){ echo '<option selected data-val="500">500px</option>'; }
                else { echo '<option data-val="500">500px</option>'; }
                
                if ( $array_option['setting']['setting']['responsive-cart'] == '600' ){ echo '<option selected data-val="600">600px</option>'; }
                else { echo '<option data-val="600">600px</option>'; }
                
                if ( $array_option['setting']['setting']['responsive-cart'] == '700' ){ echo '<option selected data-val="700">700px</option>'; }
                else { echo '<option data-val="700">700px</option>'; }
                
                if ( $array_option['setting']['setting']['responsive-cart'] == '800' ){ echo '<option selected data-val="800">800px</option>'; }
                else { echo '<option data-val="800">800px</option>'; }
                
                if ( $array_option['setting']['setting']['responsive-cart'] == '900' ){ echo '<option selected data-val="900">900px</option>'; }
                else { echo '<option data-val="900">900px</option>'; }
                
                if ( $array_option['setting']['setting']['responsive-cart'] == '1000' ){ echo '<option selected data-val="1000">1000px</option>'; }
                else { echo '<option data-val="1000">1000px</option>'; }
                ?>
                </select>
            </div> 
            <div class='text-setting-q'><?php esc_html_e('Select the display size from which the mobile mode will be activated in the options block in the product card.','quasar-attr-variable');?></div>
        </div>
    </div>
    
    <!-- tab 4-->
    <div class='wrap-setting-qf-woo tab-class-4'>
        <div class='heading-block-admin-q section-heading-q heading-q'><?php esc_html_e('Localization','quasar-attr-variable'); ?></div>
        <div class='heading-block-admin-q section-heading-q'><?php esc_html_e('This text is displayed in product categories only. Localization in the product card will depend on your theme and WooCommerce.','quasar-attr-variable'); ?></div>
        <div class='wrap-localization-block'>
            <div class='wrap-loc-input-q'>
                <span class='text-loc-heading-q'><?php echo esc_html__('Add to cart','quasar-attr-variable') ?></span>
                <input id='loc-add-cart' class='style-input-q' placeholder='<?php echo esc_html__('Add to cart','quasar-attr-variable') ?>' value='<?php echo esc_attr( $array_option['setting']['localization']['loc-add-cart'] ) ?>'>
            </div>
            <div class='wrap-loc-input-q'>
                <span class='text-loc-heading-q'><?php echo esc_html__('Select options (button)','quasar-attr-variable') ?></span>
                <input id='loc-select-option' class='style-input-q' placeholder='<?php echo esc_html__('Select options','quasar-attr-variable') ?>' value='<?php echo esc_attr( $array_option['setting']['localization']['loc-select-option'] ) ?>'> 
            </div>
            <div class='wrap-loc-input-q'>
                <span class='text-loc-heading-q'><?php echo esc_html__('This option is not available','quasar-attr-variable') ?></span>
                <input id='loc-option-not-available' class='style-input-q' placeholder='<?php echo esc_html__('This option is not available','quasar-attr-variable') ?>' value='<?php echo esc_attr( $array_option['setting']['localization']['loc-option-not-available']) ?>'> 
            </div>
            <div class='wrap-loc-input-q'>
                <span class='text-loc-heading-q'><?php echo esc_html__('Choose an option','quasar-attr-variable') ?></span>
                <input id='loc-choose-option' class='style-input-q' placeholder='<?php echo esc_html__('Choose an option','quasar-attr-variable') ?>' value='<?php echo esc_attr($array_option['setting']['localization']['loc-choose-option'] ) ?>'> 
            </div>
            <div class='wrap-loc-input-q'>
                <span class='text-loc-heading-q'><?php echo esc_html__('Select a value in each option','quasar-attr-variable') ?></span>
                <input id='loc-fill-option' class='style-input-q' placeholder='<?php echo esc_html__('Select a value in each option','quasar-attr-variable') ?>' value='<?php echo esc_attr($array_option['setting']['localization']['loc-fill-all']) ?>'> 
            
            </div>
        </div>

    </div>
    
    <!-- tab 5-->
    <div class='wrap-setting-qf-woo tab-class-5'>
        <p><span class='heading-q'><?php esc_html_e('Import/export','quasar-attr-variable'); ?></span><span class='font-size-14'><?php esc_html_e(' (you can import settings and design sections)','quasar-attr-variable'); ?><span class='help-q q9'>?</span></span></p>
       
        <?php
        foreach( $quasar_attr_design as $row ){
            $export_text = $row['mainparams'];
        }
        ?>

        <div class='copy-export-button'><?php esc_html_e('Select text to export','quasar-attr-variable');?> </div>
        <div class='export-form-swap'> 
            <div class='element-css-q type-input-element style-qform-1 color-p-10 color-class-1 adm-setting-element'>
                <span class='heading-field-q heading-setting-field'><?php esc_attr_e('Export form','quasar-attr-variable');?></span>
                <textarea id ="export-setting-code" class='style-element' placeholder='<?php esc_attr_e('Export text','quasar-attr-variable'); ?>' autocomplete='off'> <?php echo wp_specialchars_decode($export_text )?></textarea>
            </div>
        </div>
        <div class='export-form-swap'>
            <div class='element-css-q type-input-element style-qform-1 color-p-10 color-class-1 adm-setting-element'>
                <span class='heading-field-q heading-setting-field'><?php esc_attr_e('Import form','quasar-attr-variable');?></span>
                <div class='error-export-form'><?php esc_attr_e('Incorrect text of export!','quasar-attr-variable');?></div>
                <textarea id ="import-form-code" class='style-element' placeholder='<?php esc_attr_e('Import text','quasar-attr-variable'); ?>' autocomplete='off'></textarea>
            </div>
            <div class='active-export-button'><?php esc_html_e('Apply import','quasar-attr-variable');?> </div>
            <div class='error-export-button'><?php esc_html_e('Error while saving','quasar-attr-variable');?> </div>
            <div class="save-export-button"> <span><i class='fa fa-checkq'></i></span> <?php esc_html_e('Saved','quasar-attr-variable'); ?> </div>
        </div>
        <div class='message-quick-2'><?php esc_html_e("If you don't copy all the text when importing or exporting, this can lead to errors in the plugin! To import the current version of the settings, restart the page.",'quasar-attr-variable'); ?></div>

    </div>
            

    <div class='wrap-save-button-q'>
        <div class='save-setting-woo'><?php esc_html_e('Save settings','quasar-attr-variable');?></div>
        
        <div class='swap-save-informer-q'>
            <div class="error-saved-lib-q"> <span><i class='fa fa-exclamation-triangleq'></i></span> <?php esc_html_e('Error while saving','quasar-attr-variable'); ?> </div>
            <div class="saved-lib-q"> <span><i class='fa fa-checkq'></i></span> <?php esc_html_e('Saved','quasar-attr-variable'); ?> </div>
        </div>
        
    </div>
    
    

</div>

<div class='none-text-q'>
    <div id='copy-style-data' data-style=''></div>
</div>

<div class='none-text-q'>
    <div id='text-search-q'><?php esc_html_e('Search','quasar-attr-variable');?></div>
    <div id='text-attr-add-q'><?php esc_html_e('Attribute added','quasar-attr-variable');?></div>
    <div id='text-attr-add-not-q'><?php esc_html_e('Already added','quasar-attr-variable');?></div>
    <div id='text-tooltip-q'><?php esc_html_e('Tooltip','quasar-attr-variable');?></div>
    <div id='text-type-style-attr-q'><?php esc_html_e('Attribute style','quasar-attr-variable');?></div>
    <div id='text-style1-q'><?php esc_html_e('Checkbox','quasar-attr-variable');?></div>
    <div id='text-style2-q'><?php esc_html_e('Checkbox img (only in pro version)','quasar-attr-variable');?></div>
    <div id='text-style4-q'><?php esc_html_e('Checkbox сolor','quasar-attr-variable');?></div>
    <div id='text-style3-q'><?php esc_html_e('Dropdown','quasar-attr-variable');?></div>
    <div id='text-style5-q'><?php esc_html_e('Checkbox text/HTML','quasar-attr-variable');?></div>
    <div id='text-font-size'><?php esc_html_e('Font size','quasar-attr-variable');?></div>
    <div id='text-font-color'><?php esc_html_e('Text color','quasar-attr-variable');?></div>
    <div id='text-background-color'><?php esc_html_e('Background color','quasar-attr-variable');?></div>
    <div id='text-background-color-a'><?php esc_html_e('Active background color','quasar-attr-variable');?></div>
    <div id='text-color-a'><?php esc_html_e('Active text color','quasar-attr-variable');?></div>
    <div id='text-border-color'><?php esc_html_e('Border color','quasar-attr-variable');?></div>
    <div id='text-border-width'><?php esc_html_e('Border width','quasar-attr-variable');?></div>
    <div id='text-border-raius'><?php esc_html_e('Border radius','quasar-attr-variable');?></div>
    <div id='text-padding-q'><?php esc_html_e('Padding: left, right, top, bottom','quasar-attr-variable');?></div>
    <div id='text-border-color-a'><?php esc_html_e('Active border color','quasar-attr-variable');?></div>
    <div id='text-size-q'><?php esc_html_e('Size','quasar-attr-variable');?></div>
    <div id='text-html-placeholder'><?php esc_html_e('Your HTML','quasar-attr-variable');?></div>
    <div id='text-yes-q'><?php esc_html_e('Yes','quasar-attr-variable');?></div>
    <div id='text-no-q'><?php esc_html_e('No','quasar-attr-variable');?></div>
    <div id='text-disable-design-q'><?php esc_html_e('Disable design','quasar-attr-variable');?></div>
    <div id='text-width-q'><?php esc_html_e('Width','quasar-attr-variable');?></div>
    <div id='text-height-q'><?php esc_html_e('Height','quasar-attr-variable');?></div>
    <div id='text-display-category-q'><?php esc_html_e('Design for category page','quasar-attr-variable');?></div>
    <div id='text-img-short-code-help'><?php esc_html_e('[img-attr] - this short code indicates that the image will be taken from the product settings tab "Image for variations".','quasar-attr-variable');?></div>
    <div id='text-img-link-help'><?php esc_html_e('If you want to use one image for all products, remove the shortcode and paste the link to the image.','quasar-attr-variable');?></div>
    <div id='text-copy-q'><?php esc_html_e('Сopy','quasar-attr-variable');?></div>
    <div id='text-paste-q'><?php esc_html_e('Paste','quasar-attr-variable');?></div>
    <div id='text-copy-text-q'><?php esc_html_e('Copy attribute styles','quasar-attr-variable');?></div>
    
    
    <div id='text-help-1'><?php esc_html_e('If you want to use the design from your theme for the Add to Cart button, disable the button design from the plugin.','quasar-attr-variable');?></div>
    <div id='text-help-2'><?php esc_html_e('If you want to use the design from your theme for the quantity field, disable the design for that field in the plugin.','quasar-attr-variable');?></div>
    <div id='text-help-3'><?php esc_html_e('If you want to use a design from your theme for the product price, disable design for the price in the plugin.','quasar-attr-variable');?></div>
    <div id='text-help-4'>
        <p><?php esc_html_e('Enable the output of a block for choosing variations in product categories.','quasar-attr-variable');?></p>
        <p><?php esc_html_e('Note. When this setting is activated, the styles for the Add to cart button will be loaded from the plugin.','quasar-attr-variable');?></p>
        <p><?php esc_html_e('If you want to avoid this, you can disable the styles from plugin for the Add to cart button in the design section.','quasar-attr-variable');?></p>
        <p><img class='img-help-q' src='<?php echo esc_url($url).esc_html__('help-1en.jpg','quasar-attr-variable')?>'/></p>
    </div>
    <div id='text-help-5'>
        <p><?php esc_html_e('If you disable the display of the quantity field, then when buying a product from the category page, 1 unit of the product will be added to the basket.','quasar-attr-variable');?></p>
        <p><img class='img-help-q' src='<?php echo esc_url($url).esc_html__('help-design-3-en.jpg','quasar-attr-variable')?>'/></p>
    </div>
    <div id='text-help-6'><?php esc_html_e('If this option is enabled, then when you select a variation in a category, the product image will change to the image of this variation. If no image is specified in the variation, nothing will happen.','quasar-attr-variable');?></div>
    <div id='text-help-7'> <p><img class='img-help-q' src='<?php echo esc_url($url).esc_html__('help-design-en.jpg','quasar-attr-variable')?>'/></p></div>
    <div id='text-help-8'> <p><img class='img-help-q' src='<?php echo esc_url($url).esc_html__('help-design-2-en.jpg','quasar-attr-variable')?>'/></p></div>
    <div id='text-help-9'> 
        <p><?php esc_html_e('The screenshot shows the sections from which you can import / export settings.','quasar-attr-variable');?></p>
        <p><img class='img-help-q' src='<?php echo esc_url($url).esc_html__('help-import.jpg','quasar-attr-variable')?>'/></p>
    </div>
    <div id='text-help-10'> 
        <p><?php esc_html_e('Go to edit the product you need and open the tab shown in the screenshot.','quasar-attr-variable');?></p>
        <p><img class='img-help-q' src='<?php echo esc_url($url).esc_html__('help-attr-en.jpg','quasar-attr-variable')?>'/></p>
    </div>
    <div id='text-help-11'> 
        <p><?php esc_html_e('You can combine shortcodes and static images for your attributes.','quasar-attr-variable');?></p>
        <p><img class='img-help-q' src='<?php echo esc_url($url).esc_html__('help-attr-2en.jpg','quasar-attr-variable')?>'/></p>
    </div>
    <div id='text-help-12'><?php esc_html_e('Related products is a block of products that you can see in the product card under the main product. In most topics are selected automatically.','quasar-attr-variable');?></div>
    <div id='text-help-13'><?php esc_html_e('Upsells are products that you have set in the "Linked Products" section in product settings.','quasar-attr-variable');?></div>
    <div id='text-help-14'><?php esc_html_e('If the updated variables in your theme are not displaying correctly, try other priority values. The priority affects where the block with variables will be displayed. This is different for different themes.','quasar-attr-variable');?></div>
    <div id='text-help-15'><?php esc_html_e('If this option is enabled after clicking the add to cart button in the product category, the user will be redirected to the cart page. Note. Some themes may ignore this option.','quasar-attr-variable');?></div>
    
    
    
   

</div>

