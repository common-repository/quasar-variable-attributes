<?php
/*
Plugin Name: Quasar Variable Attributes
Plugin URI: https://quasar-variable-attributes.quasar-form.com
Description: Make the choice of options in your variable products beautiful and convenient
Version: 2.2
Author: nucleus_genius

*/

//v
define( 'quasar_variable_free_attributes_version', '2.1' );
define( 'quasar_variable_free_attributes_url', plugins_url( '/', __FILE__ ) );

// add button admin
function quasar_variable_free_attributes_main_addpanel() {
   add_menu_page('Quasar-attributes', 'Quasar Attr', 'manage_options', 'quasar-variable-attributes/admin.php', '', plugins_url( '/assets/img/icon2.png', __FILE__  ));
}
add_action('admin_menu', 'quasar_variable_free_attributes_main_addpanel' ); 


add_filter( 'plugin_action_links_'.plugin_basename(__FILE__), 'quasar_variable_free_attributes_link', 10, 4 );
function quasar_variable_free_attributes_link( $plugin_link, $quasar_form_url  ) {
   
    
    if ( is_plugin_active('quasar-variable-attributes/quasar-variable-attributes-main.php') ) {
        
        if ( !is_plugin_active('quasar-variable-attributes-pro/quasar-variable-attributes-main.php') ) {
             $plugin_link[] = '<a href="/wp-admin/admin.php?page=quasar-variable-attributes%2Fadmin.php">'.__('Setting','quasar-attr-variable').'</a>';
        }
    }
    $plugin_link[] = '<a href="https://quasar-variable-attributes.quasar-form.com/support/" style="color: #3ab39b; font-weight: bold;" target="_blank">'.__('Support','quasar-attr-variable').'</a>';
	return $plugin_link;
}

//creating a database when activating the plugin
function quasar_variable_free_attributes_addtable (){
	global $wpdb;
	//setting attr
    $table_name = $wpdb->base_prefix . 'quasar_attribute_option';
    $sql = "CREATE TABLE $table_name (
			id int(11) NOT NULL AUTO_INCREMENT,
			mainparams mediumtext NOT NULL,
			UNIQUE KEY id (id)
			);";
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
	
	//option
	$table_name = $wpdb->base_prefix . 'quasar_attribute_attr';
    $sql = "CREATE TABLE $table_name (
			id int(11) NOT NULL AUTO_INCREMENT,
			mainparams mediumtext NOT NULL,
			UNIQUE KEY id (id)
			);";
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
	
    //default option
    $quasar_form_option = $wpdb->get_results( "SELECT * FROM {$wpdb->base_prefix}quasar_attribute_attr", ARRAY_A  );
    if ( count($quasar_form_option) == 0 ) {
       $wpdb->query( $wpdb->prepare( "INSERT INTO {$wpdb->base_prefix}quasar_attribute_attr( `mainparams` ) VALUES ( %s )",  ''));
    }
    $quasar_form_option = $wpdb->get_results( "SELECT * FROM {$wpdb->base_prefix}quasar_attribute_option", ARRAY_A  );
    if ( count($quasar_form_option) == 0 ) {
        $wpdb->query( $wpdb->prepare( "INSERT INTO {$wpdb->base_prefix}quasar_attribute_option( `mainparams` ) VALUES ( %s )",  '{\"setting\":{\"style\":{\"margin-m-attr\":\"10px\",\"margin-m-name\":\"10px\",\"margin-m-value\":\"10px\",\"padding\":\"10px;10px;10px;10px\",\"color-name\":\"#000000\",\"font-size-name\":\"15px\",\"font-weight-name\":\"600\",\"style-design\":\"style-1\",\"style-design-c\":\"style-1\",\"margin-m-attr-c\":\"9px\",\"margin-m-name-c\":\"12px\",\"margin-m-value-c\":\"10px\",\"padding-c\":\"10px;10px;12px;14px\",\"color-name-c\":\"#000000\",\"font-size-name-c\":\"14px\",\"font-weight-name-c\":\"400\",\"font-weight-price-c\":\"700\",\"font-size-price-c\":\"15px\",\"color-price-c\":\"#777777\",\"price-indent-c\":\"9px\",\"price-align-c\":\"center\",\"quantity-design\":\"no\",\"button-design\":\"no\",\"price-design\":\"no\",\"color-button-c\":\"#ffffff\",\"b-color-button-с\":\"#26bcee\",\"font-weight-button-c\":\"500\",\"font-size-button-c\":\"15px\",\"button-indent-c\":\"16px\",\"button-align-c\":\"center\",\"padding-button\":\"15px;15px;10px;10px\",\"button-border-w\":\"0px\",\"button-border-c\":\"#ffffff\",\"button-border-r\":\"6px\",\"color-quantity-с\":\"#303030\",\"font-size-q-с\":\"16px\",\"b-quantity-с\":\"#ffffff\",\"b-c-quantity-с\":\"#e2e2e2\",\"b-w-quantity-с\":\"1px\",\"b-r-quantity-с\":\"5px\",\"padding-quantity\":\"10px;0px;2px;2px\",\"max-width-v-cart\":\"400px\"},\"setting\":{\"show-acrhive\":\"yes\",\"position-cart\":\"variant3\",\"position-archive\":\"variant1\",\"show-stock-zero\":\"yes\",\"position-currency\":\"right\",\"show-quantity\":\"no\",\"change-img\":\"no\",\"responsive-category\":\"900\",\"responsive-cart\":\"800\",\"responsive-category-hide\":\"no\",\"show-variable-in-related\":\"yes\",\"show-variable-in-upsell\":\"yes\"},\"localization\":{\"loc-add-cart\":\"\",\"loc-select-option\":\"\",\"loc-option-not-available\":\"\",\"loc-choose-option\":\"\",\"loc-fill-all\":\"\"}}}'));
    }
    

    
	//we collect a database of site domains that use our plugin. No data other than the domain is sent
	$quasar_form_option = explode('/', get_site_url());
	$responsieve = wp_remote_get( 'https://quasar-form.com/genevalidation_attr.php?domen='.$quasar_form_option[2] );
	

}
register_activation_hook( __FILE__, 'quasar_variable_free_attributes_addtable' );



//add media button script all page
function quasar_variable_free_attributes_button_script() {
    //script
    wp_enqueue_script('quasar_variable_free_attributes-admin-all', quasar_variable_free_attributes_url. '/assets/js/admin-all.js', array('jquery'), quasar_variable_free_attributes_version );
    //css
    wp_enqueue_style('quasar_variable_free_attributes-admin-all-css', quasar_variable_free_attributes_url.'/assets/css/admin-all.css', array(), quasar_variable_free_attributes_version  ); 
} 
add_action('admin_enqueue_scripts', 'quasar_variable_free_attributes_button_script');


//lang dirname
function quasar_variable_free_attributes_lang() {
	load_plugin_textdomain( 'quasar-attr-variable', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' ); 
}
add_action( 'plugins_loaded', 'quasar_variable_free_attributes_lang' );


//frontend style and script
function quasar_variable_free_attributes_frontend(){
    wp_enqueue_style('quasar-attribute-frontend-style', quasar_variable_free_attributes_url.'/assets/css/frontend.css', array(), quasar_variable_free_attributes_version );
    
    //add frontend js
    wp_enqueue_script('quasar-attribute-frontend-script', quasar_variable_free_attributes_url.'/assets/js/frontend.js', array('jquery') , quasar_variable_free_attributes_version, true);
  
}
add_action('wp_footer','quasar_variable_free_attributes_frontend');



//add script admin page 
function quasar_variable_free_attributes_admin_script( $hook ){
    if( $hook != 'quasar-variable-attributes/admin.php' ) { return; }
    
    //hide notifications
    remove_all_actions('admin_notices');

    //admin
    wp_register_script('quasar-attribute-admin-script', quasar_variable_free_attributes_url.'/assets/js/admin.js', array(), quasar_variable_free_attributes_version  );
    wp_enqueue_script('quasar-attribute-admin-script');
    
    //admin fa fa
    wp_enqueue_style('quasar-attribute-font-awesome', quasar_variable_free_attributes_url.'/assets/font-awesome/css/font-awesome.min.css', array(), quasar_variable_free_attributes_version  ); 
    
    //admin ajax
    wp_localize_script('quasar-attribute-admin-script', 'params',
        array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('q-ajax-nonce')
        )
    ); 

    //admin css
    wp_enqueue_style('quasar-attribute-admin-style', quasar_variable_free_attributes_url.'/assets/css/admin.css', array(), quasar_variable_free_attributes_version );
    
    wp_enqueue_script('jquery-color');
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_script('iris');
    wp_enqueue_media();
    //admin alfa color picker
    wp_enqueue_style( 'quasar-attribute-color-picker-alpha' );
    wp_enqueue_script( 'quasar-attribute-color-picker-alpha',  quasar_variable_free_attributes_url. '/lib/wp-color-picker-alpha-master/dist/wp-color-picker-alpha.min.js' , array( 'wp-color-picker' ) , quasar_variable_free_attributes_version , true);
    
    //color localization
    wp_localize_script('quasar-attribute-color-picker-alpha', 'localizationColor',
        array(
            'color' => esc_html__('Select Color','quasar-attr-variable'),
            'clear' => esc_html__('Clear','quasar-attr-variable'),
        )
    ); 
  
}
add_action('admin_enqueue_scripts','quasar_variable_free_attributes_admin_script');







//Add custom product setting tab for product setting
function quasar_variable_free_attributes_product_data_tabs( $default_tabs ) {

    $default_tabs['custom_tab'] = array(
        'label'   =>  __( 'Images for attributes', 'quasar-attr-variable' ),
        'target'  =>  'quasar_attr_tab',
        'priority' => 60,
        'class'   => array('quasar-attr-tab')
    );
    return $default_tabs;
}
add_filter( 'woocommerce_product_data_tabs', 'quasar_variable_free_attributes_product_data_tabs', 10, 1 );


//Contents custom product setting tab.
function quasar_variable_free_attr_product_data_panels() {
    global $post;



    // Note the 'id' attribute needs to match the 'target' parameter set above
    echo '<div id="quasar_attr_tab" class="panel woocommerce_options_panel">';
    woocommerce_wp_text_input( 
        array(
            'id'        => 'quasar_attr_img_q',
            'label'     => __( 'IMG attr', 'woocommerce' ),
            'type'      => 'text',
        ) 
    );
    

    //text for no variable product
	echo 
	'<div class="wrap-error-img-tab-q">
	   <div class="error-no-variable-roduct-q">'.esc_html__('You can only assign images to attributes in variable products.', 'quasar-attr-variable' ).'</div>
	    <div class="error-no-variable-roduct-q">
	       <div class="two-col-help-message-no-variable-q">
	           <div class="text-for-pro-v">'.esc_html__('This functionality is only available in the Pro version of the plugin.', 'quasar-attr-variable' ).'</div>
	       </div>
	   </div>
	</div>';



    echo '</div>'; //end tab
}
add_action( 'woocommerce_product_data_panels', 'quasar_variable_free_attr_product_data_panels', 10, 0 );


//save custom  setting field for woccomerce
function quasar_variable_free_attributes_product_object( $product ) {
    
    //update meta
    $product->update_meta_data( 'quasar_attr_img_q', sanitize_text_field( $_POST['quasar_attr_img_q'] ) );
}
add_action( 'woocommerce_admin_process_product_object', 'quasar_variable_free_attributes_product_object', 10, 1 );









$quasar_attr_array_option = [];
$quasar_attr_array_setting = [];
if( !is_admin() ){
	global $wpdb,$quasar_attr_array_option,$quasar_attr_array_setting;
    $quasar_form_attr_base = $wpdb->get_results( "SELECT * FROM {$wpdb->base_prefix}quasar_attribute_attr WHERE id='1'", ARRAY_A  );
    foreach($quasar_form_attr_base as $row){
        $quasar_attr_array_option = json_decode( $row['mainparams'] , true ); 
        if ( !$quasar_attr_array_option ){  $quasar_attr_array_option  = json_decode( stripslashes($row['mainparams']) , true ); }
    }
    
    $quasar_form_attr_base = $wpdb->get_results( "SELECT * FROM {$wpdb->base_prefix}quasar_attribute_option WHERE id='1'", ARRAY_A  );
    foreach( $quasar_form_attr_base as $row ){
        $quasar_attr_array_setting = json_decode( $row['mainparams'] , true ); 
        if ( !$quasar_attr_array_setting ){ $quasar_attr_array_setting = json_decode( stripslashes($row['mainparams']) , true ); }
    }
   
} 
if ( !isset($quasar_attr_array_setting['setting']['setting']['prioritet-category']) ){ $quasar_attr_array_setting['setting']['setting']['prioritet-category'] = '25'; } 
if ( !isset($quasar_attr_array_setting['setting']['setting']['prioritet-cart']) ){ $quasar_attr_array_setting['setting']['setting']['prioritet-cart'] = '25'; } 


//add variable
function quasar_variable_free_attributes_add_button($q){
    global  $quasar_attr_array_option,$product,$post,$quasar_attr_array_setting;
    
    //variable product
    if ( $product->is_type( 'variable' ) ) {
        
        $currency = get_woocommerce_currency();
        $currency = get_woocommerce_currency_symbol( $currency = $currency );
        
        
        $product = wc_get_product( $product->get_id() );
        $variation_attribute = $product->get_variation_attributes(); // get all attributes by variations
        $defoult_attr_value_array = $product->get_default_attributes( );
		$label_attribute = '';
		$string_attribute = '';
		$id_number = 0;
		$id_number_2 = 0;
		$variations = $product->get_available_variations();
		//not variable
        if ($variations){
            
            //localization fix
            if ( !isset($quasar_attr_array_setting['setting']['localization']['loc-add-cart']) ){ $quasar_attr_array_setting['setting']['localization']['loc-add-cart'] = esc_html__('Add to cart','quasar-attr-variable'); }
            if ( $quasar_attr_array_setting['setting']['localization']['loc-add-cart'] =='' ){ $quasar_attr_array_setting['setting']['localization']['loc-add-cart'] = esc_html__('Add to cart','quasar-attr-variable');  }
            
            if ( !isset($quasar_attr_array_setting['setting']['localization']['loc-select-option']) ){ $quasar_attr_array_setting['setting']['localization']['loc-select-option'] = esc_html__('Select options','quasar-attr-variable'); }
            if ( $quasar_attr_array_setting['setting']['localization']['loc-select-option'] =='' ){ $quasar_attr_array_setting['setting']['localization']['loc-select-option'] = esc_html__('Select options','quasar-attr-variable'); }
            
            if ( !isset($quasar_attr_array_setting['setting']['localization']['loc-fill-all']) ){ $quasar_attr_array_setting['setting']['localization']['loc-fill-all'] = esc_html__('Select a value in each option','quasar-attr-variable'); }
            if ( $quasar_attr_array_setting['setting']['localization']['loc-fill-all'] =='' ){ $quasar_attr_array_setting['setting']['localization']['loc-fill-all'] = esc_html__('Select a value in each option','quasar-attr-variable'); }
            
            if ( !isset($quasar_attr_array_setting['setting']['localization']['loc-option-not-available']) ){ $quasar_attr_array_setting['setting']['localization']['loc-option-not-available'] = esc_html__('This option is not available','quasar-attr-variable'); }
            if ( $quasar_attr_array_setting['setting']['localization']['loc-option-not-available'] =='' ){ $quasar_attr_array_setting['setting']['localization']['loc-option-not-available'] = esc_html__('This option is not available','quasar-attr-variable'); }
            
            if ( !isset($quasar_attr_array_setting['setting']['localization']['loc-choose-option']) ){ $quasar_attr_array_setting['setting']['localization']['loc-choose-option'] = esc_html__('Choose an option','quasar-attr-variable'); }
            if ( $quasar_attr_array_setting['setting']['localization']['loc-choose-option'] =='' ){ $quasar_attr_array_setting['setting']['localization']['loc-choose-option'] = esc_html__('Choose an option','quasar-attr-variable'); }
            
    		//for category page --------------------------------------------------------------------------------------------------------------------------------
    		if ( $q == 2 ){
    		    //filter related
    		    global $woocommerce_loop;
    		    if ( $woocommerce_loop['name'] == 'related' ) {
    		        if ( $quasar_attr_array_setting['setting']['setting']['show-variable-in-related'] =='no' ){
    		            echo "<span class='not-variable-attr'></span>";
    		            return;
    		        }
    		    }
    		    //filter up-sells
    		    if ( $woocommerce_loop['name'] == 'up-sells' ) {
    		        if ( $quasar_attr_array_setting['setting']['setting']['show-variable-in-upsell'] =='no' ){
    		            echo "<span class='not-variable-attr'></span>";
    		            return;
    		        }
    		    }

                $string_attribute = '';
                
                //variable string
                $array_variable_param = [];
                $keyNumber = 0;
                $variable_al_selection ='';
                $array_empty_attr = [];
                $array_all_attr =[];
               
                foreach ($variations as $key => $value ){
    
                    //zavisimosti
                    $zavisimosti = '';
                    $key_name_attr = '';
                    $attr_value = '';
    
                    
                    //perebor vsex attributov odnoi variacii
                    foreach ( $variations[$key]['attributes'] as $key2 => $value2 ){
                        //vetka esli est zavisimosti
                        if ( $value2 !='' ){
                            $key2 = explode('_', $key2);
                            $key_name_attr = urldecode( array_pop($key2) );
                            $attr_value = urldecode($value2);
                            $zavisimosti.= $key_name_attr.':'.$attr_value.';' ;
                            if ( !isset($array_empty_attr[$key_name_attr]) ){ $array_empty_attr[$key_name_attr] = [];}
    						array_push($array_empty_attr[$key_name_attr], $attr_value );
                        }
                        //vetka all value
                        if ( $value2 =='' ){
                            $key2 = explode('_', $key2);
                            $name_attr_all = urldecode( array_pop($key2) );
    						$array_all_attr[$name_attr_all] = 'all_q';
                        }
                       
    
                    }
                    if ( isset($array_variable_param[$key_name_attr][$attr_value]['zavisemost_variable']) ) { 
                        $array_variable_param[$key_name_attr][$attr_value] = [ 
                            'prise' => $array_variable_param[$key_name_attr][$attr_value]['prise'].'/'.$variations[$key]['display_price'], 
                            'prise-regular' => $array_variable_param[$key_name_attr][$attr_value]['prise-regular'].'/'.$variations[$key]['display_regular_price'],
                            'data-id' => $array_variable_param[$key_name_attr][$attr_value]['data-id'].'/'.$variations[$key]['variation_id'],
                            'data-img' => $array_variable_param[$key_name_attr][$attr_value]['data-img'].';'.$variations[$key]['image']['url'],
                            'zavisemost_variable' => $array_variable_param[$key_name_attr][$attr_value]['zavisemost_variable'].'/'.$zavisimosti,
                        ];
                        
                    }
                    else {
                        $array_variable_param[$key_name_attr][$attr_value] = [ 
                            'prise' => $variations[$key]['display_price'], 
                            'prise-regular' => $variations[$key]['display_regular_price'], 
                            'data-id' => $variations[$key]['variation_id'],
                            'data-img' => $variations[$key]['image']['url'],
                            'zavisemost_variable' => $zavisimosti,
                        ];
                    }    
    
                    //vetka esli net zavisimosti (all option)
                    if ( $keyNumber== 0 ){
                        if ( $zavisimosti =='' ) {
                            
                            foreach ( $variations[$key]['attributes'] as $key2 => $value2 ){
    
                                $variable_al_selection = 'prise:'.$variations[$key]['display_price'].';id:'.$variations[$key]['variation_id'].';'.$variations[$key]['image']['url'].';'.$variations[$key]['display_regular_price'];
    
                                break 1;
                            }
                        }
                        
                        
                    }
                    $keyNumber++;
                    
                }
    
    			$label_attribute = '';
    			$original_name_attr ='';
                ///attribute string
                foreach ( $variation_attribute as $key => $value ){
                    $string_val = '';
                    $type = '';
                    //array
                    if ( taxonomy_exists($key) ){
                        $original_name_attr = $key;
                        
                        $label_attribute = explode('_', $key);
                        $label_attribute = array_pop($label_attribute);
                        $name_attribute = '';
                    }
                    else {
                        $original_name_attr = $key;
                        $name_attribute = mb_strtolower($key);
                        $label_attribute = $key;
                    } 
                    if ( !isset($quasar_attr_array_option) ){$quasar_attr_array_option = [];}
                    //search attr from array base
                    if ( array_key_exists($label_attribute, $quasar_attr_array_option) ){
                        $type = $quasar_attr_array_option[$label_attribute]['style']['data-style'];
                        $style_attr = $quasar_attr_array_option[$label_attribute]['style'];
                        $name_attribute = $quasar_attr_array_option[$label_attribute]['style']['name'];
                    }
                    else {
                        $name_attribute = wc_attribute_label($key);
                    }
                    
                    
                    
                    //defoult value attr
                    $defoult_attr = '';
                    if ( $defoult_attr_value_array ){
                        foreach ( $defoult_attr_value_array as $val_d => $key_d ){
                            if ( taxonomy_exists( urldecode($val_d) ) ){
                                $name_defoult_attr = explode('_', $val_d);
                                $name_defoult_attr = array_pop($name_defoult_attr);
                                $name_defoult_attr = urldecode($name_defoult_attr);
                            }
                            else {
                                $name_defoult_attr = urldecode($val_d);
                            }
                            //activ defoult
                            $number_condition = 0;
                            if ( $name_defoult_attr == $label_attribute ){
                                $number_condition++;
                            }
                            else {
                                //for space in name custom attr
                                $name_defoult_attr = str_replace( '-',  ' ',   $name_defoult_attr );
                                if ( $name_defoult_attr == $label_attribute ){
                                    $number_condition++;
                                }
                            }
                            if ( $number_condition > 0 ){
                                $defoult_attr = urldecode($key_d) ;
                            }
                        }
                    }
                    //for checbox IMG
                    if ( $type == 'checkboximg' ){
                        $array_img = get_post_meta($product->get_id(), 'quasar_attr_img_q', true );
                        $array_img = json_decode( stripslashes( $array_img ) , true );
                    }
                    else {
                        $array_img = [];
                    }
    
                    foreach ( $value as $val ){
                        $id_number++;
                        //validation emty attr
    					$index = mb_strtolower($label_attribute);
    					$number_condition = 0;
    					if ( isset($array_empty_attr[$index]) ){
    					     $number_condition++;
    					}
    					else {
    					    //for space in name custom attr
    					   $index = str_replace( ' ',  '-',  $index  );
    					   if ( isset($array_empty_attr[$index]) ){
    					   	     $number_condition++;
    					   	     $label_attribute = $index;
    					    }
    					}
    					
    				    if ( $number_condition > 0 ){
    				        $val_slug = urldecode($val);
                            if ( in_array($val_slug, $array_empty_attr[$index]) ) {
                                $term = get_term_by( 'slug', $val, $key );
                                if ( $term == '' ){$label_val = $val; }
                                else {$label_val = $term->name;}
                                $val = urldecode($val);
                                if ( !isset($array_variable_param[$label_attribute][$val]['prise']) ){ $array_variable_param[$label_attribute][$val]['prise'] = '';}
                                if ( !isset($array_variable_param[$label_attribute][$val]['prise-regular']) ){ $array_variable_param[$label_attribute][$val]['prise-regular'] = ''; }
                                if ( !isset($array_variable_param[$label_attribute][$val]['data-id']) ){ $array_variable_param[$label_attribute][$val]['data-id'] = ''; }
                                if ( !isset($array_variable_param[$label_attribute][$val]['data-img']) ){ $array_variable_param[$label_attribute][$val]['data-img'] = ''; }
                                if ( !isset($array_variable_param[$label_attribute][$val]['zavisemost_variable']) ){ $array_variable_param[$label_attribute][$val]['zavisemost_variable'] = ''; }
                                
                                if ( $type == '' ){
                                    $string_val.= '<option class="el-value-list-attr-q" data-prise="'.esc_attr( $array_variable_param[$label_attribute][$val]['prise'] ).'" data-prise-regular="'.esc_attr( $array_variable_param[$label_attribute][$val]['prise-regular'] ).'" data-id="'.esc_attr( $array_variable_param[$label_attribute][$val]['data-id'] ).'" data-img="'.esc_attr( $array_variable_param[$label_attribute][$val]['data-img'] ).'" data-addiction="'.esc_attr( $array_variable_param[$label_attribute][$val]['zavisemost_variable'] ).'" data-name="'.esc_attr( $val ).'" data-val-name="'.esc_attr( $val ).'">'.esc_html( $label_val ).'</option>';
                                }
                                if ( $type == 'checkbox' || $type == 'color' || $type == 'html' || $type == 'dropdown' || $type == 'checkboximg' ){
                                    $string_val.= quasar_variable_free_attr_create_value($type, $style_attr, $label_attribute ,$label_val,$array_img,$id_number,$id_number_2,'categoty',urldecode($val), $array_variable_param[$label_attribute][$val]['prise'],$array_variable_param[$label_attribute][$val]['data-id'], $array_variable_param[$label_attribute][$val]['data-img'],$array_variable_param[$label_attribute][$val]['zavisemost_variable'],$val,$array_variable_param[$label_attribute][$val]['prise-regular'] );
                                }
                            }
                            
                            else {
                                //all option
                                if ( isset($array_all_attr[$index]) ) {
                                    $term = get_term_by( 'slug', $val, $key );
                                    if ( isset( $term->name)){ $label_val = $term->name; }
                                    else { $label_val = $val; }
                                    
                                    if ( $type == ''){ $string_val.= '<option class="el-value-list-attr-q" data-prise="" data-id="" data-name="" data-img="" data-addiction="" data-val-name="'.esc_attr( urldecode($val) ).'" >'.esc_html( $label_val ).'</option>'; }
                                    if ( $type == 'checkbox' || $type == 'color' || $type == 'html' || $type == 'dropdown' || $type == 'checkboximg' ){
                                        $string_val.= quasar_variable_free_attr_create_value($type, $style_attr, $label_attribute ,$label_val,$array_img, $id_number,$id_number_2,'categoty',urldecode($val));
                                    }
                                }
                            }
                            
    				    }
                        else {
                            //all option
                            if ( isset($array_all_attr[$index]) ){
                                $term = get_term_by( 'slug', $val, $key );
                                if ( isset( $term->name)){ $label_val = $term->name; }
                                else { $label_val = $val; }
    
                                if ( $type == ''){ $string_val.= '<option class="el-value-list-attr-q" data-prise="" data-id="" data-name="" data-img="" data-val-name="'.esc_attr( urldecode($val) ).'"  data-addiction="">'.esc_html( $label_val ).'</option>'; }
                                if ( $type == 'checkbox' || $type == 'color' || $type == 'html' || $type == 'dropdown' || $type == 'checkboximg' ){
                                    $string_val.= quasar_variable_free_attr_create_value($type, $style_attr,$label_attribute ,$label_val,$array_img,$id_number,$id_number_2,'categoty',urldecode($val));
                                }
                            }
                        }
                    }
                    
    
                    //style margin name attr
                    $style_name = 'padding-right:'. $quasar_attr_array_setting['setting']['style']['margin-m-name-c'].'; ';
                    if ( $quasar_attr_array_setting['setting']['style']['style-design'] == 'style-2' ) {
                        $style_name = 'margin-bottom:'. $quasar_attr_array_setting['setting']['style']['margin-m-name-c'].'; ';
                    }
                    $style_name.= 'color: '.$quasar_attr_array_setting['setting']['style']['color-name-c'].'; font-size:'.$quasar_attr_array_setting['setting']['style']['font-size-name-c'].'; font-weight:'.$quasar_attr_array_setting['setting']['style']['font-weight-name-c'];
                    
                    //wrap attr block ------------
                    //defoult style 
                    if ( $type == ''){
                        $string_attribute.= '<div class="wrap-section-attr-q" style="'.esc_attr( 'margin-bottom:'.$quasar_attr_array_setting['setting']['style']['margin-m-attr-c'] ).'">';
                            $string_attribute.= '<div class="name-attr-q" data-defoult="'.esc_attr( $defoult_attr ).'" style="'.esc_attr( $style_name ).'">'.esc_html( $name_attribute  ).'</div>';
                            $string_attribute.= '<div class="wrap-select-defoult wrap-element-attr-q" data-label="'.esc_attr( $name_attribute  ).'" data-name="'.esc_attr( $label_attribute ).'" data-original-name="'.esc_attr( urlencode($original_name_attr) ).'"><div class="block-select-q"><select><option class="el-value-list-attr-q defoult-op" data-prise="" data-id="" data-name="" data-img="" data-addiction="">'.esc_html( $quasar_attr_array_setting['setting']['localization']['loc-choose-option'] ).'</option>'. wp_specialchars_decode( $string_val ) .'</select></div></div>';
                        $string_attribute.= '</div>';
                    }
                    //checkbox style
                    if ( $type == 'checkbox' ){
                        $string_attribute.= '<div class="wrap-section-attr-q" style="'.esc_attr( 'margin-bottom:'.$quasar_attr_array_setting['setting']['style']['margin-m-attr-c'] ).'">';
                            $string_attribute.= '<div class="name-attr-q" data-defoult="'.esc_attr( $defoult_attr ).'" style="'.esc_attr( $style_name ).'">'.esc_html( $name_attribute  ).'</div>';
                            $string_attribute.= '<div class="wrap-checkbox-attr-q wrap-element-attr-q" data-label="'.esc_attr( $name_attribute  ).'" data-name="'.esc_attr( $label_attribute ).'" data-original-name="'.esc_attr( urlencode($original_name_attr) ).'">'.wp_specialchars_decode( $string_val ).'</div>';
                        $string_attribute.= '</div>';
                    }
                    //color style
                    if ( $type == 'color' ){
                        $string_attribute.= '<div class="wrap-section-attr-q" style="'.esc_attr( 'margin-bottom:'.$quasar_attr_array_setting['setting']['style']['margin-m-attr-c'] ).'">';
                            $string_attribute.= '<div class="name-attr-q" data-defoult="'.esc_attr( $defoult_attr ).'" style="'.esc_attr( $style_name ).'">'.esc_html( $name_attribute  ).'</div>';
                            $string_attribute.= '<div class="wrap-checkbox-attr-q color-style-q wrap-element-attr-q" data-label="'.esc_attr( $name_attribute  ).'" data-name="'.esc_attr( $label_attribute ).'" data-original-name="'.esc_attr( urlencode($original_name_attr) ).'">'.wp_specialchars_decode( $string_val ).'</div>';
                        $string_attribute.= '</div>';
                    }
                    //html style
                    if ( $type == 'html' ){
                        $string_attribute.= '<div class="wrap-section-attr-q" style="'.esc_attr( 'margin-bottom:'.$quasar_attr_array_setting['setting']['style']['margin-m-attr-c'] ).'">';
                            $string_attribute.= '<div class="name-attr-q" data-defoult="'.esc_attr( $defoult_attr ).'" style="'.esc_attr( $style_name ).'">'.esc_html( $name_attribute  ).'</div>';
                            $string_attribute.= '<div class="wrap-html-attr-q wrap-element-attr-q" data-label="'.esc_attr( $name_attribute  ).'" data-name="'.esc_attr( $label_attribute ).'" data-original-name="'.esc_attr( urlencode($original_name_attr) ).'">'.wp_specialchars_decode( $string_val ).'</div>';
                        $string_attribute.= '</div>';
                    }
                    //img style
                    if ( $type == 'checkboximg' ){
                        $string_attribute.= '<div class="wrap-section-attr-q" style="'.esc_attr( 'margin-bottom:'.$quasar_attr_array_setting['setting']['style']['margin-m-attr-c'] ).'">';
                            $string_attribute.= '<div class="name-attr-q" data-defoult="'.esc_attr( $defoult_attr ).'" style="'.esc_attr( $style_name ).'">'.esc_html( $name_attribute  ).'</div>';
                            $string_attribute.= '<div class="wrap-html-attr-q img-attr-q wrap-element-attr-q" data-label="'.esc_attr( $name_attribute  ).'" data-name="'.esc_attr( $label_attribute ).'" data-original-name="'.esc_attr( urlencode($original_name_attr) ).'">'.wp_specialchars_decode( $string_val ).'</div>';
                        $string_attribute.= '</div>';
                    }
                    //dropdown style
                    if ( $type == 'dropdown' ){
                        $padding = explode(';', $style_attr['padding'] );
                        $style_1 = 'font-size: '.$style_attr['font-size'].';color:'.$style_attr['font-color'].';background-color:'.$style_attr['background-color'].';border-width:'.$style_attr['border-width'].';border-color:'.$style_attr['border-color'].';border-radius:'.$style_attr['border-radius'].';padding-left:'.$padding['0'].';padding-right:'.$padding['1'].';padding-top:'.$padding['2'].';padding-bottom:'.$padding['3'];
                        
                        
                        $string_attribute.= '<div class="wrap-section-attr-q" style="'.esc_attr( 'margin-bottom:'.$quasar_attr_array_setting['setting']['style']['margin-m-attr-c'] ).'">';  
                            $string_attribute.= '<div class="name-attr-q" data-defoult="'.esc_attr( $defoult_attr ).'" style="'.esc_attr( $style_name ).'">'.esc_html( $name_attribute  ).'</div>';
                            $string_attribute.= '<div class="wrap-select-attr-q wrap-element-attr-q" data-label="'.esc_attr( $name_attribute  ).'" data-name="'.esc_attr( $label_attribute ).'" data-original-name="'.esc_attr( urlencode($original_name_attr) ).'"><div class="block-select-q"><span class="st-for-select" style="border-color:'.esc_attr( $style_attr['font-color'] ).'"></span><select style="'.esc_attr( $style_1 ).'"><option class="el-value-list-attr-q defoult-op" data-prise="" data-id="" data-name="" data-img="" data-addiction="">'.esc_html( $quasar_attr_array_setting['setting']['localization']['loc-choose-option'] ).'</option>'. wp_specialchars_decode( $string_val ) .'</select></div></div>';
                        $string_attribute.= '</div>';
                            
                    }
                    $id_number_2++;
                }
    
                
                $class ='wrap-quasar-attribute-q category-quasar-attribute-q';
                //style block
                if ( $quasar_attr_array_setting['setting']['style']['style-design-c'] =='style-2') {
                    $class = $class.' style-design-2';
                }
                $padding = explode(';', $quasar_attr_array_setting['setting']['style']['padding-c'] );  
                
                //responsive
                $class = $class.' responsive-c-q-'.$quasar_attr_array_setting['setting']['setting']['responsive-category'].' hide-c-q-'.$quasar_attr_array_setting['setting']['setting']['responsive-category-hide'];
                
                
                $currency = get_woocommerce_currency();
                $currency = get_woocommerce_currency_symbol( $currency = $currency );
    
    
                //style add to cartbutton
                $padding_2 = explode(';', $quasar_attr_array_setting['setting']['style']['padding-button'] );
                if ( $quasar_attr_array_setting['setting']['style']['button-design'] == 'yes' ){
                    $style_cart = 'border-radius:'.$quasar_attr_array_setting['setting']['style']['button-border-r'].'; border-color:'.$quasar_attr_array_setting['setting']['style']['button-border-c'].'; border-width:'.$quasar_attr_array_setting['setting']['style']['button-border-w'].'; font-weight:'.$quasar_attr_array_setting['setting']['style']['font-weight-button-c'].'; font-size:'.$quasar_attr_array_setting['setting']['style']['font-size-button-c'].'; color:' .$quasar_attr_array_setting['setting']['style']['color-button-c'].'; background-color:'.$quasar_attr_array_setting['setting']['style']['b-color-button-с'].'; padding-left:'.$padding_2['0'].';padding-right:'.$padding_2['1'].';padding-top:'.$padding_2['2'].';padding-bottom:'.$padding_2['3'] ;
                }
                else {
                    $style_cart =''; 
                }
                //style quantity
                $padding_2 = explode(';', $quasar_attr_array_setting['setting']['style']['padding-quantity'] );
                if ( $quasar_attr_array_setting['setting']['style']['quantity-design'] == 'yes' ){
                    $style_quantity ='color:'.$quasar_attr_array_setting['setting']['style']['color-quantity-с'].'; font-size:'.$quasar_attr_array_setting['setting']['style']['font-size-q-с'].'; background-color:'.$quasar_attr_array_setting['setting']['style']['b-quantity-с'].'; border-color:'.$quasar_attr_array_setting['setting']['style']['b-c-quantity-с'].'; border-width:'.$quasar_attr_array_setting['setting']['style']['b-w-quantity-с'].'; border-radius:'.$quasar_attr_array_setting['setting']['style']['b-r-quantity-с'].'; padding-left:'.$padding_2['0'].';padding-right:'.$padding_2['1'].';padding-top:'.$padding_2['2'].';padding-bottom:'.$padding_2['3'] ;
                }
                else {
                    $style_quantity = '';
                }
    
                //price
                if ( $quasar_attr_array_setting['setting']['setting']['position-currency'] =='left' ){   
                    $pice = esc_attr( $currency ).esc_attr( $product->get_variation_price() ) .' - '.esc_attr( $currency ).esc_attr( $product->get_variation_price('max') );
                }
                else {
                    $pice = esc_attr( $product->get_variation_price() ).esc_attr( $currency ).' - '.esc_attr( $product->get_variation_price('max') ).esc_attr( $currency );
                }
                //fix prise
                if ( $product->get_variation_price() == '' || ( $product->get_variation_price() == $product->get_variation_price('max') ) ){ 
                    if ( $quasar_attr_array_setting['setting']['setting']['position-currency'] =='left' ){   
                        $pice = esc_attr( $currency ).esc_attr( $product->get_variation_price('max') );
                    }
                    else {
                        $pice = esc_attr( $product->get_variation_price('max') ).esc_attr( $currency );
                    }
                    
                    //sale
                    if ( $product->get_variation_regular_price() != $product->get_variation_price('max') ){
                        
                        if ( $quasar_attr_array_setting['setting']['setting']['position-currency'] =='left' ){   
                            $pice = '<span class="sale-prise-q">'.$currency.$product->get_variation_regular_price().'</span>'.$pice;
                        }
                        else {
                            $pice = '<span class="sale-prise-q">'.$product->get_variation_regular_price().$currency.'</span>'.$pice;
                        }
                    }
                }
                
                //price design
                if ( $quasar_attr_array_setting['setting']['style']['price-design'] == 'yes' ){
                    $price_design = 'color: '.esc_attr( $quasar_attr_array_setting['setting']['style']['color-price-c'] ).'; font-size: '.esc_attr( $quasar_attr_array_setting['setting']['style']['font-size-price-c'] ).'; font-weight: '.esc_attr( $quasar_attr_array_setting['setting']['style']['font-weight-price-c'] );
                }
                else {
                    $price_design = '';
                }
                
                //class quanity
                if ( $quasar_attr_array_setting['setting']['setting']['show-quantity'] =='yes' ) {
                    $button_wrap_class= 'wrap-button-add-to-cart-q';
                }
                else {
                    $button_wrap_class = 'wrap-button-add-to-cart-q qunatity-none-q'; 
                }
                
                //link card
                if ( !isset($quasar_attr_array_setting['setting']['setting']['redirect-cart']) ){ $quasar_attr_array_setting['setting']['setting']['redirect-cart'] = ''; }
                if ( $quasar_attr_array_setting['setting']['setting']['redirect-cart'] =='yes' ) {
                    $button_linK_card = wc_get_cart_url();
                }
                else {
                    $button_linK_card = '';
                }
                
                if ( !isset($quasar_attr_array_setting['setting']['setting']['class-change-img']) ){ $quasar_attr_array_setting['setting']['setting']['class-change-img'] = '.attachment-woocommerce_thumbnail'; }
                
                //block
                return 
                '<div class="'.esc_attr( $class ).'" data-img-change="'.esc_attr( $quasar_attr_array_setting['setting']['setting']['change-img'] ).'" data-img="'.esc_url( get_the_post_thumbnail_url($post->ID) ).'" data-img-class="'.esc_attr( $quasar_attr_array_setting['setting']['setting']['class-change-img'] ).'" style="'.esc_attr( 'padding-left:'.$padding['0'].';padding-right:'.$padding['1'].';padding-top:'.$padding['2'].';padding-bottom:'. $padding['3'] ).'" data-id="'.esc_attr( $product->get_id() ).'"  data-all-variable="'.esc_attr( $variable_al_selection ).'">
                    <div class="wrap-prise-block-attr-q">
                        <div class="prise-block-attr-q align-price-'.esc_attr( $quasar_attr_array_setting['setting']['style']['price-align-c'] ).'" style="margin-bottom: '.esc_attr( $quasar_attr_array_setting['setting']['style']['price-indent-c'] ).';">
                            <span class="price-attr-q price" style="'.esc_attr( $price_design ).'"
                                data-min="'.esc_attr( $product->get_variation_price() ).'" 
                                data-max="'.esc_attr( $product->get_variation_price('max') ).'" 
                                data-currency ="'.esc_attr( $currency ).'"
                                data-price ="'.esc_attr( $pice ).'"
                                data-align-currency ="'.esc_attr( $quasar_attr_array_setting['setting']['setting']['position-currency'] ).'">
                                '.wp_specialchars_decode( $pice ).'
                            </span>
                        </div>
                    </div>
                    
                    <div class="variable-attr-block-q">'.wp_specialchars_decode( $string_attribute ).'</div>
                    <div class="'.esc_attr( $button_wrap_class ).'" style="margin-top:'.esc_attr( $quasar_attr_array_setting['setting']['style']['button-indent-c'] ).';">
                        <div class="number-quasar-attr">
                            <input style="'.esc_attr( $style_quantity ).'" type="number" value="1" min="1">
                        </div>
                        <div class="wrap-button-add-to-c-q align-button-attr-q-'.esc_attr( $quasar_attr_array_setting['setting']['style']['button-align-c'] ).'">
                            <a href="'.esc_attr( get_permalink( $product->get_id() ) ).'" 
                                style="'.esc_attr( $style_cart ).'"
                                data-link="'.esc_attr( get_permalink( $product->get_id() ) ).'" 
                                data-text-cart="'.esc_attr( $quasar_attr_array_setting['setting']['localization']['loc-add-cart'] ).'"
                                data-text-select-option="'.esc_attr( $quasar_attr_array_setting['setting']['localization']['loc-select-option'] ).'" 
                                data-text-fill-all="'.esc_attr( $quasar_attr_array_setting['setting']['localization']['loc-fill-all'] ).'"
                                data-text-not-v="'.esc_attr( $quasar_attr_array_setting['setting']['localization']['loc-option-not-available'] ).'" 
                                data-card-url= "'.esc_attr( $button_linK_card ).'"
                                class="ajax_add_to_cart button product_type_variable add_to_cart_button button-add-to-cart-q">'.esc_attr( $quasar_attr_array_setting['setting']['localization']['loc-select-option'] ).'</a>
                        </div>
                    </div>
                    
                </div>';
            }
    		//for page cart product  ---------------------------------------------------------------------------------------------------------------------------------
    		if ( $q == 1 ){
                //attribute string
                
                foreach ( $variation_attribute as $key => $value ){
                    $string_val = '';
                    $type = '';
                    //array
                    if ( taxonomy_exists($key) ){
                        $original_name_attr = $key;
                        
                        $label_attribute = explode('_', $key);
                        $label_attribute = array_pop($label_attribute);
                        $name_attribute = '';
                    }
                    else {
                        $original_name_attr = $key;
                        $name_attribute = mb_strtolower($key);
                        $label_attribute = $key;
                    } 
                    if ( !isset($quasar_attr_array_option) ){$quasar_attr_array_option = [];}
                    //search attr from array base
                    if ( array_key_exists($label_attribute, $quasar_attr_array_option) ){
                        $type = $quasar_attr_array_option[$label_attribute]['style']['data-style'];
                        $style_attr = $quasar_attr_array_option[$label_attribute]['style'];
                        $name_attribute = $quasar_attr_array_option[$label_attribute]['style']['name'];
                    }
                    else {
                        $name_attribute = wc_attribute_label($key);
                    }
   
                     
                    //defoult value attr
                    $defoult_attr = '';
                    if ( $defoult_attr_value_array ){
                        foreach ( $defoult_attr_value_array as $val_d => $key_d ){
                            if ( taxonomy_exists( urldecode($val_d) ) ){
                                $name_defoult_attr = explode('_', $val_d);
                                $name_defoult_attr = array_pop($name_defoult_attr);
                                $name_defoult_attr = urldecode($name_defoult_attr);
                            }
                            else {
                                $name_defoult_attr = urldecode($val_d);
                            }
                            //activ defoult
                            $number_condition = 0;
                            if ( $name_defoult_attr == $label_attribute ){
                                $number_condition++;
                            }
                            else {
                                //for space in name custom attr
                                $name_defoult_attr = str_replace( '-',  ' ',   $name_defoult_attr );
                                if ( $name_defoult_attr == mb_strtolower($label_attribute) ){
                                    $number_condition++;
                                }
                            }
                            if ( $number_condition > 0 ){
                                 $defoult_attr = urldecode($key_d) ;
                            }
                        }
                    }
                    
                       
                    //for checbox IMG
                    if ( $type == 'checkboximg' ){
                        $array_img = get_post_meta($product->get_id(), 'quasar_attr_img_q', true );
                        $array_img = json_decode( stripslashes( $array_img ) , true );
                    }
                    else {
                        $array_img = [];
                    };
                    
                    //array attribute value
                    foreach ( $value as $val ){
                            
                        $id_number++;
                        $term = get_term_by( 'slug', $val, $key );
                        if ( isset( $term->name)){ $label_val = $term->name; }
                        else { $label_val = $val; }
                        
                        //style margin name attr
                        $style_name = 'margin-right:'. $quasar_attr_array_setting['setting']['style']['margin-m-name'].';';
                        
                        if ( $quasar_attr_array_setting['setting']['style']['style-design'] == 'style-2' ) {
                            $style_name = 'margin-bottom:'. $quasar_attr_array_setting['setting']['style']['margin-m-name'].';';
                        }
                        $style_name.= 'color: '.$quasar_attr_array_setting['setting']['style']['color-name'].'; font-size:'.$quasar_attr_array_setting['setting']['style']['font-size-name'].'; font-weight:'.$quasar_attr_array_setting['setting']['style']['font-weight-name'];
       
                        //defoult style
                        if ( $type == ''){
                            $string_val.= '<option class="el-value-list-attr-q" data-val-name="'.esc_attr( urldecode($val) ).'">'.$label_val.'</option>';
                        }
                        if ( $type == 'checkbox' || $type == 'color' || $type == 'html' || $type == 'dropdown' || $type == 'checkboximg' ){
                            $string_val.= quasar_variable_free_attr_create_value($type, $style_attr,$label_attribute ,$label_val,$array_img,$id_number,$id_number_2,'cart',urldecode($val));
                        }
                        
                    }
                        
                    //wrap attr block ------------
                    //defoult style
                    if ( $type == ''){
                        $string_attribute.= '<div class="wrap-section-attr-q" style="'.esc_attr( 'margin-bottom:'.$quasar_attr_array_setting['setting']['style']['margin-m-attr'] ).'">';
                            $string_attribute.= '<div class="name-attr-q" data-defoult="'.esc_attr( $defoult_attr ).'"  style="'.esc_attr( $style_name ).'">'.esc_html( $name_attribute  ).'</div>';
                            $string_attribute.= '<div class="wrap-select-defoult wrap-element-attr-q" data-label="'.esc_attr( $name_attribute  ).'" data-name="'.esc_attr( $label_attribute ).'"><div class="block-select-q"><select><option class="el-value-list-attr-q defoult-op" data-prise="" data-id="" data-name="" data-img="" data-addiction="">'.esc_html( $quasar_attr_array_setting['setting']['localization']['loc-choose-option'] ).'</option>'. wp_specialchars_decode( $string_val ) .'</select></div></div>';
                        $string_attribute.= '</div>';
                    }
                    //checkbox style
                    if ( $type == 'checkbox' ){
                        $string_attribute.= '<div class="wrap-section-attr-q" style="'.esc_attr( 'margin-bottom:'.$quasar_attr_array_setting['setting']['style']['margin-m-attr'] ).'">';
                            $string_attribute.= '<div class="name-attr-q" data-defoult="'.esc_attr( $defoult_attr ).'" style="'.esc_attr( $style_name ).'">'.esc_html( $name_attribute  ).'</div>';
                            $string_attribute.= '<div class="wrap-checkbox-attr-q wrap-element-attr-q" data-label="'.esc_attr( $name_attribute  ).'" data-name="'.esc_attr( $label_attribute ).'">'.wp_specialchars_decode( $string_val ).'</div>';
                        $string_attribute.= '</div>';
                    }
                    //color style
                    if ( $type == 'color' ){
                        $string_attribute.= '<div class="wrap-section-attr-q" style="'.esc_attr( 'margin-bottom:'.$quasar_attr_array_setting['setting']['style']['margin-m-attr'] ).'">';
                            $string_attribute.= '<div class="name-attr-q" data-defoult="'.esc_attr( $defoult_attr ).'" style="'.esc_attr( $style_name ).'">'.esc_html( $name_attribute  ).'</div>';
                            $string_attribute.= '<div class="wrap-checkbox-attr-q color-style-q wrap-element-attr-q" data-label="'.esc_attr( $name_attribute  ).'" data-name="'.esc_attr( $label_attribute ).'">'.wp_specialchars_decode( $string_val ).'</div>';
                        $string_attribute.= '</div>';
                    }
                    //html style
                    if ( $type == 'html' ){
                        $string_attribute.= '<div class="wrap-section-attr-q" style="'.esc_attr( 'margin-bottom:'.$quasar_attr_array_setting['setting']['style']['margin-m-attr'] ).'">';
                            $string_attribute.= '<div class="name-attr-q" data-defoult="'.esc_attr( $defoult_attr ).'" style="'.esc_attr( $style_name ).'">'.esc_html( $name_attribute  ).'</div>';
                            $string_attribute.= '<div class="wrap-html-attr-q wrap-element-attr-q" data-label="'.esc_attr( $name_attribute  ).'" data-name="'.esc_attr( $label_attribute ).'">'.wp_specialchars_decode( $string_val ).'</div>';
                        $string_attribute.= '</div>';
                    }
                    //img style
                    if ( $type == 'checkboximg' ){
                        $string_attribute.= '<div class="wrap-section-attr-q" style="'.esc_attr( 'margin-bottom:'.$quasar_attr_array_setting['setting']['style']['margin-m-attr'] ).'">';
                            $string_attribute.= '<div class="name-attr-q" data-defoult="'.esc_attr( $defoult_attr ).'" style="'.esc_attr( $style_name ).'">'.esc_html( $name_attribute  ).'</div>';
                            $string_attribute.= '<div class="wrap-html-attr-q img-attr-q wrap-element-attr-q" data-label="'.esc_attr( $name_attribute  ).'" data-name="'.esc_attr( $label_attribute ).'">'.wp_specialchars_decode( $string_val ).'</div>';
                        $string_attribute.= '</div>';
                    }
                    //dropdown style
                    if ( $type == 'dropdown' ){
                        $padding = explode(';', $style_attr['padding'] );
                        $style_1 = 'font-size: '.$style_attr['font-size'].';color:'.$style_attr['font-color'].';background-color:'.$style_attr['background-color'].';border-width:'.$style_attr['border-width'].';border-color:'.$style_attr['border-color'].';border-radius:'.$style_attr['border-radius'].';padding-left:'.$padding['0'].';padding-right:'.$padding['1'].';padding-top:'.$padding['2'].';padding-bottom:'.$padding['3'];
                        
    
                        $string_attribute.= '<div class="wrap-section-attr-q" style="'.esc_attr( 'margin-bottom:'.$quasar_attr_array_setting['setting']['style']['margin-m-attr'] ).'">';  
                            $string_attribute.= '<div class="name-attr-q" data-defoult="'.esc_attr( $defoult_attr ).'" style="'.esc_attr( $style_name ).'">'.esc_html( $name_attribute  ).'</div>';
                            $string_attribute.= '<div class="wrap-select-attr-q wrap-element-attr-q" data-label="'.esc_attr( $name_attribute  ).'" data-name="'.esc_attr( $label_attribute ).'"><div class="block-select-q"><span class="st-for-select" style="border-color:'.esc_attr( $style_attr['font-color'] ).'"></span><select style="'.esc_attr( $style_1 ).'"><option class="el-value-list-attr-q defoult-op" data-prise="" data-id="" data-name="" data-img="" data-addiction="">'.esc_html( $quasar_attr_array_setting['setting']['localization']['loc-choose-option'] ).'</option>'. wp_specialchars_decode( $string_val ) .'</select></div></div>';
                        $string_attribute.= '</div>';
                            
                    }
                    $id_number_2++;
                }
               
                $class ='wrap-quasar-attribute-q cart-product-quasar-attribute-q';
                //style block
                if ( $quasar_attr_array_setting['setting']['style']['style-design'] =='style-2' ) {
                    $class = $class.' style-design-2';
                }
                //responsive
                $class = $class.' responsive-cart-q-'.$quasar_attr_array_setting['setting']['setting']['responsive-cart'];
                
                $padding = explode(';', $quasar_attr_array_setting['setting']['style']['padding'] );  
                //block
                return '<div class="'.esc_attr( $class ).'" style="'.esc_attr( 'max-width:'.$quasar_attr_array_setting['setting']['style']['max-width-v-cart'].'; padding-left:'.$padding['0'].';padding-right:'.$padding['1'].';padding-top:'.$padding['2'].';padding-bottom:'. $padding['3'] ).'"  data-id="'.esc_attr( $product->get_id() ).'"><div class="variable-attr-block-q">'.wp_specialchars_decode( $string_attribute ).'</div> <div class="variable-not-found" data-text="'.esc_attr( $quasar_attr_array_setting['setting']['localization']['loc-option-not-available'] ).'" data></div> </div>';
    		}
        }
    }
    
}


$quasar_variable_free_attr_number_id = 0;
function quasar_variable_free_attr_create_value($type,$style_attr,$label_attribute,$label_val,$array_img='',$id_number=0,$id_number_2=0,$target='',$name_val='',$prise = '',$id = 0,$img ='',$zavisimost='',$name='',$regular_price =''){
    global $quasar_attr_array_option,$quasar_attr_array_setting,$product,$quasar_variable_free_attr_number_id;
    $quasar_variable_free_attr_number_id++;
    $unique_id = $product->get_id().$id_number.'q'.$quasar_variable_free_attr_number_id;
    //area block
    $margin_val = $quasar_attr_array_setting['setting']['style']['margin-m-value'];
    if ( $target == 'categoty' ){
        $margin_val = $quasar_attr_array_setting['setting']['style']['margin-m-value-c'];
    }
    $string_val = '';
    
    //for new variable
    if ( !isset($quasar_attr_array_option[$label_attribute]['value']['arrayValue'][$label_val]['tooltip']) ){ $quasar_attr_array_option[$label_attribute]['value']['arrayValue'][$label_val]['tooltip']='';}

    
    
    
    //checkbox style
    if ( $type == 'checkbox' ||  $type == 'checkboximg' ){
        
        if ( $target != 'categoty' ){
            $padding = explode(';', $style_attr['padding'] );
            $style_1 = 'font-size: '.$style_attr['font-size'].';color:'.$style_attr['font-color'].';background-color:'.$style_attr['background-color'].';border-width:'.$style_attr['border-width'].';border-color:'.$style_attr['border-color'].';border-radius:'.$style_attr['border-radius'].';padding-left:'.$padding['0'].';padding-right:'.$padding['1'].';padding-top:'.$padding['2'].';padding-bottom:'.$padding['3'].'; margin-right:'.esc_attr( $margin_val ).'; margin-bottom:'.esc_attr( $margin_val );
        }
        else {
            $padding = explode(';', $style_attr['padding-c'] );
            $style_1 = 'font-size: '.$style_attr['font-size-c'].';color:'.$style_attr['font-color'].';background-color:'.$style_attr['background-color'].';border-width:'.$style_attr['border-width'].';border-color:'.$style_attr['border-color'].';border-radius:'.$style_attr['border-radius'].';padding-left:'.$padding['0'].';padding-right:'.$padding['1'].';padding-top:'.$padding['2'].';padding-bottom:'.$padding['3'].'; margin-right:'.esc_attr( $margin_val ).'; margin-bottom:'.esc_attr( $margin_val );
        }        ;      
        $string_val.= '<input class="el-value-list-attr-q" type="radio" id="'.esc_attr( $unique_id ).'" name="'.esc_attr( $product->get_id().$id_number_2 ).'" data-prise="'.esc_attr( $prise ).'" data-id="'.esc_attr( $id ).'" data-prise-regular="'.esc_attr( $regular_price  ).'" data-img="'.esc_attr( $img ).'" data-addiction="'.esc_attr( $zavisimost ).'" data-name="'.esc_attr( $name ).'"><label for="'.esc_attr( $unique_id ).'" style="'.esc_attr( $style_1 ).'" data-color="'.esc_attr( $style_attr['font-color'] ).'" data-color-a="'.esc_attr( $style_attr['font-color-a'] ).'" data-background="'.$style_attr['background-color'].'" data-background-a="'.esc_attr( $style_attr['background-color-a'] ).'" data-border-color="'.esc_attr( $style_attr['border-color'] ).'" data-border-color-a="'.esc_attr( $style_attr['border-color-a'] ).'" data-val="'.esc_attr( $label_val ).'" data-val-name="'.esc_attr( $name_val ).'" data-tolltip="'.esc_attr( $quasar_attr_array_option[$label_attribute]['value']['arrayValue'][$label_val]['tooltip'] ).'"><span>'.esc_html( $label_val ).'</span></label>';
    }
    //color style
    else if ( $type == 'color' ){
        if ( !isset($quasar_attr_array_option[$label_attribute]['value']['arrayValue'][$label_val]['color-val']) ){ $quasar_attr_array_option[$label_attribute]['value']['arrayValue'][$label_val]['color-val']='#959292';}
        
        if ( $target != 'categoty' ){
            $padding = explode(';', $style_attr['padding'] );
            $style_1 = 'font-size: '.$style_attr['font-size'].';color:'.$style_attr['font-color'].';background-color:'.$style_attr['background-color'].';border-width:'.$style_attr['border-width'].';border-color:'.$style_attr['border-color'].';border-radius:'.$style_attr['border-radius'].';padding-left:'.$padding['0'].';padding-right:'.$padding['1'].';padding-top:'.$padding['2'].';padding-bottom:'.$padding['3'].'; margin-right:'.esc_attr( $margin_val ).'; margin-bottom:'.esc_attr( $margin_val );
        }
        else {
            $padding = explode(';', $style_attr['padding-c'] );
            $style_1 = 'font-size: '.$style_attr['font-size-c'].';color:'.$style_attr['font-color'].';background-color:'.$style_attr['background-color'].';border-width:'.$style_attr['border-width'].';border-color:'.$style_attr['border-color'].';border-radius:'.$style_attr['border-radius'].';padding-left:'.$padding['0'].';padding-right:'.$padding['1'].';padding-top:'.$padding['2'].';padding-bottom:'.$padding['3'].'; margin-right:'.esc_attr( $margin_val ).'; margin-bottom:'.esc_attr( $margin_val );
        }
        $string_val.= '<input class="el-value-list-attr-q"  type="radio" id="'.esc_attr( $unique_id ).'" name="'.esc_attr( $product->get_id().$id_number_2 ).'" data-prise="'.esc_attr( $prise ).'" data-id="'.esc_attr( $id ).'" data-prise-regular="'.esc_attr( $regular_price  ).'" data-img="'.esc_attr( $img ).'" data-addiction="'.esc_attr( $zavisimost ).'" data-name="'.esc_attr( $name ).'"><label for="'.esc_attr( $unique_id  ).'" style="'.esc_attr( $style_1 ).'" data-color-a="'.esc_attr( $style_attr['font-color-a'] ).'"  data-border-color-a="'.esc_attr( $style_attr['border-color-a'] ).'"  data-background="'.$style_attr['background-color'].'" data-background-a="'.esc_attr( $style_attr['background-color-a'] ).'" data-border-color="'.esc_attr( $style_attr['border-color'] ).'" data-val="'.esc_attr( $label_val ).'" data-val-name="'.esc_attr( $name_val ).'" data-tolltip="'.esc_attr( $quasar_attr_array_option[$label_attribute]['value']['arrayValue'][$label_val]['tooltip'] ).'"><div class="color-check-q element-val-attr-q" style="background-color:'.esc_attr( $quasar_attr_array_option[$label_attribute]['value']['arrayValue'][$label_val]['color-val'] ).'; border-radius: '.esc_attr( $style_attr['border-radius'] ).'; width: '.esc_attr( $style_attr['size'] ).'; height:'.esc_attr( $style_attr['size'] ).';" data-value="'.esc_attr( $label_val ).'"></div></label>';
    }
    //html style
    else if ( $type == 'html' ){
        if ( !isset($quasar_attr_array_option[$label_attribute]['value']['arrayValue'][$label_val]['html-val']) ){ $quasar_attr_array_option[$label_attribute]['value']['arrayValue'][$label_val]['html-val']='';}
        
        if ( $target != 'categoty' ){
            $padding = explode(';', $style_attr['padding'] );
            $style_1 = 'color:'.$style_attr['font-color'].';background-color:'.$style_attr['background-color'].';border-width:'.$style_attr['border-width'].';border-color:'.$style_attr['border-color'].';border-radius:'.$style_attr['border-radius'].';padding-left:'.$padding['0'].';padding-right:'.$padding['1'].';padding-top:'.$padding['2'].';padding-bottom:'.$padding['3'].'; margin-right:'.esc_attr( $margin_val ).'; margin-bottom:'.esc_attr( $margin_val );
        }
        else {
            $padding = explode(';', $style_attr['padding-c'] );
            $style_1 = 'color:'.$style_attr['font-color'].';background-color:'.$style_attr['background-color'].';border-width:'.$style_attr['border-width'].';border-color:'.$style_attr['border-color'].';border-radius:'.$style_attr['border-radius'].';padding-left:'.$padding['0'].';padding-right:'.$padding['1'].';padding-top:'.$padding['2'].';padding-bottom:'.$padding['3'].'; margin-right:'.esc_attr( $margin_val ).'; margin-bottom:'.esc_attr( $margin_val );
        }
        
        $html_content = str_replace('StRelKa', '<',$quasar_attr_array_option[$label_attribute]['value']['arrayValue'][$label_val]['html-val']);
        //disable design
        if ( $quasar_attr_array_option[$label_attribute]['style']['disable-design']== 'yes' ){
            $string_val.= '<input class="el-value-list-attr-q"  type="radio" id="'.esc_attr( $unique_id ).'" name="'.esc_attr( $product->get_id().$id_number_2 ).'" data-prise="'.esc_attr( $prise ).'" data-prise-regular="'.esc_attr( $regular_price  ).'" data-id="'.esc_attr( $id ).'" data-img="'.esc_attr( $img ).'" data-addiction="'.esc_attr( $zavisimost ).'" data-name="'.esc_attr( $name ).'"><label style="margin-right:'.esc_attr( $margin_val ).'; margin-bottom:'.esc_attr( $margin_val ).'" for="'.esc_attr( $unique_id  ).'" data-val="'.esc_attr( $label_val ).'" data-val-name="'.esc_attr( $name_val ).'" data-tolltip="'.esc_attr( $quasar_attr_array_option[$label_attribute]['value']['arrayValue'][$label_val]['tooltip'] ).'"><div class="html-val-q element-val-attr-q" data-value="'.esc_attr( $label_val ).'">'.wp_specialchars_decode( $html_content ).'</div></label>';
        }
        else {
            $string_val.= '<input class="el-value-list-attr-q" type="radio" id="'.esc_attr( $unique_id ).'" name="'.esc_attr( $product->get_id().$id_number_2 ).'" data-prise="'.esc_attr( $prise ).'" data-prise-regular="'.esc_attr( $regular_price  ).'" data-id="'.esc_attr( $id ).'" data-img="'.esc_attr( $img ).'" data-addiction="'.esc_attr( $zavisimost ).'" data-name="'.esc_attr( $name ).'"><label style="'.esc_attr( $style_1 ).'" for="'.esc_attr( $unique_id ).'" data-color="'.esc_attr( $style_attr['font-color'] ).'" data-color-a="'.esc_attr( $style_attr['font-color-a'] ).'" data-background="'.esc_attr( $style_attr['background-color'] ).'" data-background-a="'.esc_attr( $style_attr['background-color-a'] ).'" data-border-color="'.esc_attr( $style_attr['border-color'] ).'" data-border-color-a="'.esc_attr( $style_attr['border-color-a'] ).'" data-val="'.esc_attr( $label_val ).'" data-val-name="'.esc_attr( $name_val ).'" data-tolltip="'.esc_attr( $quasar_attr_array_option[$label_attribute]['value']['arrayValue'][$label_val]['tooltip'] ).'"><div class="html-val-q element-val-attr-q" data-value="'.esc_attr( $label_val ).'">'.wp_specialchars_decode( $html_content ).'</div></label>';
        }
    }
    //drodown style
    else if ( $type == 'dropdown' ){
        if ( $target != 'categoty' ){
            $style_1 = 'color: '.esc_attr( $style_attr['font-color'] ).'; font-size: '.esc_attr( $style_attr['font-size'] );
        }
        else {
            $style_1 = 'color: '.esc_attr( $style_attr['font-color'] ).'; font-size: '.esc_attr( $style_attr['font-size-c'] ); 
        }
        $string_val.= '<option class="el-value-list-attr-q" data-prise="'.esc_attr( $prise ).'" data-prise-regular="'.esc_attr( $regular_price  ).'" data-id="'.esc_attr( $id ).'" data-img="'.esc_attr( $img ).'" data-addiction="'.esc_attr( $zavisimost ).'" data-name="'.esc_attr( $name ).'" data-val-name="'.esc_attr( $name_val ).'" style="'.esc_attr( $style_1 ).'">'.esc_html( $label_val ).'</option>';
    }
    
    
    return $string_val;
}


   
//add button position 1
add_action( 'woocommerce_after_add_to_cart_button', 'quasar_variable_free_attributes_add_button_1', $quasar_attr_array_setting['setting']['setting']['prioritet-cart'] );
function quasar_variable_free_attributes_add_button_1(){
    global  $quasar_attr_array_setting,$product,$product_category_url;
    //position
    if ( $quasar_attr_array_setting['setting']['setting']['position-cart'] == 'variant1' ){
        //stock
        if ( $quasar_attr_array_setting['setting']['setting']['show-stock-zero'] == 'yes' ){
            echo quasar_variable_free_attributes_add_button(1,$product_category_url);
        }
        else {
            //stock != 0
            if ( $product->is_in_stock() ) {
                echo quasar_variable_free_attributes_add_button(1,$product_category_url) ;
            }
        }
    }
}


//add button position 2
add_action( 'woocommerce_before_quantity_input_field', 'quasar_variable_free_attributes_add_button_2', $quasar_attr_array_setting['setting']['setting']['prioritet-cart']  );
function quasar_variable_free_attributes_add_button_2(){
    global  $quasar_attr_array_setting,$product,$product_category_url;
    //position
    if ( $quasar_attr_array_setting['setting']['setting']['position-cart'] == 'variant2' ){
        //stock
        if ( $quasar_attr_array_setting['setting']['setting']['show-stock-zero'] == 'yes' ){
            echo quasar_variable_free_attributes_add_button(1,$product_category_url);
        }
        else {
            //stock != 0
            if ( $product->is_in_stock() ) {
                echo quasar_variable_free_attributes_add_button(1,$product_category_url) ;
            }
        }
    }
}
//add button position 3
add_action( 'woocommerce_single_product_summary', 'quasar_variable_free_attributes_add_button_3', $quasar_attr_array_setting['setting']['setting']['prioritet-cart']  );
function quasar_variable_free_attributes_add_button_3(){
    global  $quasar_attr_array_setting,$product,$product_category_url;
    //position
    if ( $quasar_attr_array_setting['setting']['setting']['position-cart'] == 'variant3' ){
        //stock
        if ( $quasar_attr_array_setting['setting']['setting']['show-stock-zero'] == 'yes' ){
            echo quasar_variable_free_attributes_add_button(1,$product_category_url);
        }
        else {
            //stock != 0
            if ( $product->is_in_stock() ) {
                echo quasar_variable_free_attributes_add_button(1,$product_category_url) ;
            }
        }
    }
}

//add button position 4
add_action( 'woocommerce_product_meta_end', 'quasar_variable_free_attributes_add_button_4', $quasar_attr_array_setting['setting']['setting']['prioritet-cart'] );
function quasar_variable_free_attributes_add_button_4(){
    global  $quasar_attr_array_setting,$product,$product_category_url;
    //position
    if ( $quasar_attr_array_setting['setting']['setting']['position-cart'] == 'variant4' ){
        //stock
        if ( $quasar_attr_array_setting['setting']['setting']['show-stock-zero'] == 'yes' ){
            echo quasar_variable_free_attributes_add_button(1,$product_category_url);
        }
        else {
            //stock != 0
            if ( $product->is_in_stock() ) {
                echo quasar_variable_free_attributes_add_button(1,$product_category_url) ;
            }
        }
    }
}

            
//archive & category position 1
add_action( 'woocommerce_after_shop_loop_item', 'quasar_variable_free_attributes_archive_button_1', $quasar_attr_array_setting['setting']['setting']['prioritet-category']  );
function quasar_variable_free_attributes_archive_button_1(){
    global  $quasar_attr_array_setting,$product,$product_category_url;
    //position
    if ( $quasar_attr_array_setting['setting']['setting']['position-archive']== 'variant1' ){
        //enable
        if ( $quasar_attr_array_setting['setting']['setting']['show-acrhive'] == 'yes' ){
            //stock
            if ( $quasar_attr_array_setting['setting']['setting']['show-stock-zero'] == 'yes' ){
                echo quasar_variable_free_attributes_add_button(2,$product_category_url);
            }
            else {
                //stock != 0
                if ( $product->is_in_stock() ) {
                    echo quasar_variable_free_attributes_add_button(2,$product_category_url) ;
                }
            }
        }
    }
}

//archive & category position 2
add_action( 'woocommerce_before_shop_loop_item', 'quasar_variable_free_attributes_archive_button_2', $quasar_attr_array_setting['setting']['setting']['prioritet-category'] );
function quasar_variable_free_attributes_archive_button_2(){
    global  $quasar_attr_array_setting,$product,$product_category_url;
    //position
    if ( $quasar_attr_array_setting['setting']['setting']['position-archive']== 'variant2' ){
        //enable
        if ( $quasar_attr_array_setting['setting']['setting']['show-acrhive'] == 'yes' ){
            //stock
            if ( $quasar_attr_array_setting['setting']['setting']['show-stock-zero'] == 'yes' ){
                echo quasar_variable_free_attributes_add_button(2,$product_category_url);
            }
            else {
                //stock != 0
                if ( $product->is_in_stock() ) {
                    echo quasar_variable_free_attributes_add_button(2,$product_category_url) ;
                }
            }
        }
    }
}


//string style in footer
add_action( 'wp_footer', 'quasar_variable_free_footer_style' );
function quasar_variable_free_footer_style(){
    global  $quasar_attr_array_setting;
    if ( $quasar_attr_array_setting['setting']['setting']['show-acrhive'] == 'yes' ){
        echo '<style>ul .product-type-variable .price:not(.price-attr-q) {display:none!important; } ul .product-type-variable .add_to_cart_button:not(.button-add-to-cart-q) {display:none!important; } </style>';
    }
}



add_action('wp_ajax_save_attr_setting_q', 'quasar_variable_free_attributes_save');
add_action('wp_ajax_save_attr_import_setting_q', 'quasar_variable_free_attributes_export');


// save/update form
function quasar_variable_free_attributes_save(){

    check_ajax_referer( 'q-ajax-nonce', 'nonce_code' );
    
    // Stop if the current user is not an admin or do not have administrative access
	if( ! current_user_can( 'manage_options' ) ) {
		die();
	}
    
    $_POST['arraySave'] = str_replace('<','StRelKa',$_POST['arraySave'] );
    
    $array_save = sanitize_text_field( $_POST['arraySave'] );
    
    $array_save_setting = sanitize_text_field( $_POST['arraySettingSave'] );
    
    //decode
    $array_save = json_decode( stripslashes( $array_save ) , true ); //remove 
    //povtornoe codirovabie for kirilici
    $array_save = json_encode( $array_save );
    
    //decode
    $array_save_setting = json_decode( stripslashes( $array_save_setting ) , true ); //remove 
    //povtornoe codirovabie for kirilici
    $array_save_setting = json_encode( $array_save_setting );
    

    global $wpdb;
    //updating attr
    $wpdb->update( "{$wpdb->prefix}quasar_attribute_attr",
        [ 'mainparams' => $array_save ],
	    [ 'id' => '1' ],
	    [ '%s' ]
	 );
	 
    //updating setting
    $wpdb->update( "{$wpdb->prefix}quasar_attribute_option",
        [ 'mainparams' => $array_save_setting ],
	    [ 'id' => '1' ],
	    [ '%s' ]
	 );
}



// save import export
function quasar_variable_free_attributes_export(){

    check_ajax_referer( 'q-ajax-nonce', 'nonce_code' );
    
    // Stop if the current user is not an admin or do not have administrative access
	if( ! current_user_can( 'manage_options' ) ) {
		die();
	}

    $array_save_setting = sanitize_text_field( $_POST['arraySettingSave'] );
	
	global $wpdb;
    //updating setting
    $wpdb->update( "{$wpdb->prefix}quasar_attribute_option",
        [ 'mainparams' => $array_save_setting ],
	    [ 'id' => '1' ],
	    [ '%s' ]
	 );
}
