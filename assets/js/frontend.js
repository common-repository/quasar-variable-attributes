(function ($) {
$(document).ready(function () {
    
//select variable
//checkbox
$(document).on('change','.variable-attr-block-q input', function(){
    change_checkbox_attr( $(this) );
});

//for addon by one click
$(document).on('change','.form-main-elemen .wrap-section-attr-q input', function(){
    change_checkbox_attr( $(this),1 );
});



function change_checkbox_attr(x,y = 0){
    let val =  x.next('label').find('span').html();
    let block_this_attr = x.closest('.wrap-section-attr-q');
    let attr = block_this_attr.find('.name-attr-q').html();
    let block = block_this_attr.find('.wrap-checkbox-attr-q');
    if ( block.length === 0 ){
        block = block_this_attr.find('.wrap-html-attr-q');
    }
    //defoult checkbox or HTML
    if ( !block.hasClass('color-style-q') && !block.hasClass('img-attr-q') ){
        //defoult style
        block_this_attr.find('label').each(function(){
            $(this).css({
                'color' : $(this).attr('data-color'),
                'background-color' : $(this).attr('data-background'),
                'border-color' : $(this).attr('data-border-color'),
            });
        });    
        //activ style
        let label = x.next('label');
        label.css({
            'color' : label.attr('data-color-a'),
            'background-color' : label.attr('data-background-a'),
            'border-color' : label.attr('data-border-color-a'),
        });
        
    }
    //color 
    if ( block.hasClass('color-style-q') || block.hasClass('img-attr-q') ){
        //defoult style
        block_this_attr.find('label').each(function(){
            $(this).css({
                'border-color' : $(this).attr('data-border-color'),
            });
        });    
        //activ style
        let label = x.next('label');
        label.css({
            'border-color' : label.attr('data-border-color-a'),
        });
        
        //selected variable original
        val = x.next('label').find('.color-check-q').attr('data-value');
    }
    //html and color
    if ( block.hasClass('wrap-html-attr-q') ){
        val = x.next('label').find('.html-val-q').attr('data-value');
    }

    //selected variable original
    if ( !x.closest('.wrap-quasar-attribute-q').hasClass('category-quasar-attribute-q') ){
        if ( y === 0 ){
            all_update_original();
            $('.cart-product-quasar-attribute-q').removeClass('stop-clear');
        }
        
    }
}


$('.cart-product-quasar-attribute-q  .variable-attr-block-q').on('change','select', function(){
    all_update_original();
    $('.cart-product-quasar-attribute-q').removeClass('stop-clear');
});


function all_update_original(){
    let num_2 = 0;
    //re selected original
    $('.cart-product-quasar-attribute-q').find('.wrap-section-attr-q').each(function(){
        let block_this_attr = $(this);
        let select = block_this_attr.find('select');
        let attr = block_this_attr.find('.name-attr-q').html();
        
        //select
        if ( select.length > 0 ){
            let val = select.val();
            //set variable original
            $('.variations_form .variations').find('label').each(function(){
                if ( $(this).html() == attr ){
                    let number = 0;
                    $(this).closest('tr').find('select').find('option').each(function(){
                        if ( $(this).html() == val ){ $(this).prop("selected", true); number++; }
                    });
                    if ( number === 0 ){
                        num_2 = 1;
                    }
                }
            });
            
        }
        //checkbox
        else {
            block_this_attr.find('input').each(function(){
                if ( $(this).prop("checked") ){ 
                    
                    let val = $(this).next('label').find('span').html();
                    if ( typeof val == 'undefined' ){
                        val = $(this).next('label').find('.element-val-attr-q').attr('data-value');
                    }
                    //selected variable original
                    $('.variations_form .variations').find('label').each(function(){
                        if ( $(this).html() == attr ){
                            let number = 0;
                            $(this).closest('tr').find('select').find('option').each(function(){
                                if ( $(this).html() == val ){ $(this).prop("selected", true); number++;}
                            });
                            if ( number === 0 ){
                                num_2 = 1;
                            }
                        }
                    });
                }
            });  
                
        }
    });
    



    //recalculate variable original activ
    $('.variations_form .variations').find('select:first').find('option:first').trigger('change');
    
    //zapolneni all variable
    let num = 0;
    $('.cart-product-quasar-attribute-q').find('.wrap-section-attr-q').each(function(){
        if ( $(this).find('select').length > 0 ){
            if ( $(this).find('option:selected').hasClass('defoult-op') ){num++;}
        }
        else {
            if ( $(this).find('input:checked').length === 0 ){num++;}
        }
    });
    if ( num === 0 ){
        //clear original value and restart
        if ( num_2 === 1 ){
            if ( !$('.cart-product-quasar-attribute-q').hasClass('stop-clear') ){
                $('.cart-product-quasar-attribute-q').addClass('stop-clear');
                clear_originl_variable_val(1);
            }
        }
        
        //show text not variable for cart page
        num = 0;
        let text_block = $('.cart-product-quasar-attribute-q').find('.variable-not-found');
        $('.variations_form .variations').find('select').find('option:selected').each(function(){
            if ( $(this).attr('value') === '' ){ 
                num++;
            }
        });
        if ( num > 0 ){
            text_block.html( text_block.attr('data-text') ).css('display', 'flex');
        }
        else {
            text_block.html( text_block.attr('data-text') ).css('display', 'none');
        }
    }
    
    
    
    
    
}

function clear_originl_variable_val(q=0){
    //clear select original variable all
    $('.variations_form .variations').find('select').each(function(){
        $(this).find('option').each(function(){
            if ( $(this).attr('value') === '' ){ $(this).prop("selected", true);}
        });
    });
    $('.variations_form .variations').find('select:first').find('option:first').trigger('change');
    if (q == 1 ){
        all_update_original();
    }
}

$('.variable-attr-block-q label').hover(
    function(){
        if ( $(this).attr('data-tolltip') !=='' ){
            if ( $(this).find('.wrap-tooltip-attr').length === 0 ){
                let create = '<div class="wrap-tooltip-attr"><div class="tooltip-att-q">'+$(this).attr('data-tolltip')+'</div></div>';
                $(this).append( create );
            }
        }
    },
    //else
    function(){
        $(this).find('.wrap-tooltip-attr').remove();
    }
    
);


//selected variable -----------------------------------
$(document).on('change', '.category-quasar-attribute-q select', function(){
    let form = $(this).closest('.wrap-quasar-attribute-q');
    let option = $(this).find('option:selected');
    if ( option.attr('data-prise') == 'none' ){
        form.find('.currency-q').addClass('none-el-woo-q');
        form.find('.price-attr-q').html('');
        $('.active-q-b').parent().attr('data-full', 'not');
    }
    else {
        let priseVariable = Number(option.attr('data-prise') );
        form.find('.currency-q').removeClass('none-el-woo-q');
        form.find('.price-attr-q').html( priseVariable );
       
        //recalculate standart 
        form.find('.number-quasar-attr input').trigger('keyup');
    }
});

//variable checkbox
$(document).on('change', '.category-quasar-attribute-q .wrap-element-attr-q input', function(){
    let form = $(this).closest('.wrap-quasar-attribute-q');

    let id = $(this).attr('id');
    let object =  $(this).parent().find('label[for="'+id+'"]');
    object.addClass('aktive-variable-check-q').css({'color' :  object.attr('data-a-c'), 'background-color' :  object.attr('data-a-b') });
    
    
    //recalculate standart 
    form.find('.number-quasar-attr input').trigger('keyup');
});


function quantityProduct(x){
 
    let val = x.val();
    let form = x.closest('.wrap-quasar-attribute-q');
    let currency = form.find('.price-attr-q').attr('data-currency');
    let align_currency = form.find('.price-attr-q').attr('data-align-currency');
    let filling = 0;
    let id_v ='';
    let imgSetting = form.attr('data-img-change');
    let img_class = form.attr('data-img-class');
    if ( img_class === '' ) { img_class ='.attachment-woocommerce_thumbnail'; }
    let img_v ='';
    let all_variable = form.attr('data-all-variable');
    let valString = "";
    form.find('.type-img-product img').css('height', form.find('.type-img-product img').css('height') );
    let stop = 0;
    let id_variable = '';

    let prise = 'none';
    let prise_regular = '';
    let addiction = 0;
    let arrayAddiction = '';
    let numberFixed = 0;
    
    let quntity_for_url = '&quantity='+form.find('.number-quasar-attr input').val();
    form.find('.el-value-list-attr-q').each(function(){
        if ( $(this).prop("nodeName") == 'INPUT' ){
            if ( $(this).prop('checked') ){  
                valString = valString + '&attribute_'+$(this).closest('.wrap-element-attr-q').attr('data-original-name')+'='+encodeURI( $(this).next('label').attr('data-val-name') ).replace(/\(/g, '%28').replace(/\)/g, '%29');
            }
        }
        if ( $(this).prop("nodeName") == 'OPTION' ){
            if ( $(this).prop('selected') ){ 
                valString = valString + '&attribute_'+$(this).closest('.wrap-element-attr-q').attr('data-original-name')+'='+encodeURI( $(this).attr('data-val-name') ).replace(/\(/g, '%28').replace(/\)/g, '%29');
            }
        }
                    
        if ( $(this).prop('checked') || $(this).prop('selected') ){
                    
            if ( $(this).attr('data-prise') !=='' && stop == 0 ) {
                                    
                prise = $(this).attr('data-prise');
                prise_regular = $(this).attr('data-prise-regular');
                id_variable = $(this).attr('data-id');
                //validation all variable
                let stringaddiction = $(this).attr('data-addiction');
                let numberVariation2 = -1;
                addiction = 0;
                //many addiction
                if ( stringaddiction.match(/\//g) ) { 
                    
                    arrayAddiction = stringaddiction.split('/');
                    $.each(arrayAddiction, function(index1,value1){
                        let numberVariation = 0;
                        value1 = value1.split(';');
                        $.each(value1, function(index,value){
                                               
                            if ( value !=='' ){
                                let val = value.split(':');
                                let input = '';
                                form.find('.wrap-element-attr-q').each(function(){
                                    let condition_num = 0;
                                    if ( $(this).attr('data-name') == val[0] ){
                                         condition_num ++;
                                    }
                                    //for space in custom attr
                                    else {
                                        if ( $(this).attr('data-name').replace(/\s/g, '-') == val[0]){
                                            condition_num ++;
                                        }
                                    }
                                    if ( condition_num > 0){ //for space in custom attr
                                        if ( $(this).find('input').length > 0 ){
                                            input = $(this).find('input[data-name="'+val[1]+'"]');
                                        }
                                        else {
                                            $(this).find('option:selected').each(function(){
                                                if ( $(this).attr('data-name') != val[1] ){numberVariation++;}
                                            });
                                        }
                                    }
                                });
                                
                                if ( input!='' ){
                                    if ( !input.prop('checked') ){ numberVariation++; }
                                }
                            }
                                    
                        });
                        if ( numberVariation == 0 ){
                            numberVariation2 = index1;
                        }
                    });
                                        
                    if ( numberVariation2 != -1 ){
                        prise = prise.split('/');
                        prise = prise[numberVariation2];
                        prise_regular = prise_regular.split('/');
                        prise_regular = prise_regular[numberVariation2];
                        id_variable = id_variable.split('/');
                        id_variable = id_variable[numberVariation2];
                        id_v = $(this).attr('data-id').split('/');
                        id_v = id_v[numberVariation2];
                        img_v = $(this).attr('data-img').split(';');
                        img_v = img_v[numberVariation2];
                        numberFixed++;
                        stop++; //ostanovit posle activ variable
                    }
                    else {addiction++;}
                }
                //one addiction
                else {
                    arrayAddiction = $(this).attr('data-addiction').split(';');
                    id_v = $(this).attr('data-id');
                    img_v = $(this).attr('data-img');
                                      
                    $.each(arrayAddiction, function(index,value){
                        if ( value !=='' ){
                            let val = value.split(':');
                            input = '';
                            form.find('.wrap-element-attr-q').each(function(){
                                let condition_num = 0;;
                                if ( $(this).attr('data-name') == val[0] ){
                                    condition_num ++;
                                }
                                //for space in custom attr
                                else {
                                    if ( $(this).attr('data-name').replace(/\s/g, '-') == val[0]){
                                        condition_num ++;
                                    }
                                }
                                if ( condition_num > 0){ //for space in custom attr
                                    if ( $(this).find('input').length > 0 ){
                                        input = $(this).find('input[data-name="'+val[1]+'"]');
                                    }
                                    else {
                                        $(this).find('option:selected').each(function(){;
                                            //1 level proverki
                                            if ( $(this).attr('data-name') != val[1] ){
                                                //2 level proverki;
                                                if ( $(this).attr('data-name').replace(/\s/g, '-') != val[1] ){  addiction++; }
                                            }
                                        });
                                    }
                                }
                            });
                            if ( input!='' ){
                                if ( !input.prop('checked') ){ addiction++; }
                            }
                        }
                    });
                    if ( addiction == 0 ) { numberFixed++;  stop++;}
                }
            }
        }

    });
    //link
    let link = form.find('.wrap-button-add-to-c-q a');
    let link_card = '';
    if ( link.attr('data-card-url') !='' ){
        if ( typeof link.attr('data-card-url') !='undefined' ){
            let otn_link = link.attr('data-card-url').split('/');
            $.each(otn_link, function(index,value){
                if ( index > 2 ){
                    link_card = link_card +'/'+value;
                }
            });
        }
        
    }
    //variable selected
    if ( prise !=='none' && prise !=='' && addiction == 0 && all_variable =='' ) {
        //total product price
        prise_regular = Number(prise_regular) * Number(val);
        prise = Number(prise) * Number(val);
        if ( align_currency =='left'){ prise = currency+prise; prise_regular = currency+prise_regular; }
        else { prise = prise+currency; prise_regular = prise_regular+currency; }
        //condition variable choose
        let num = 0;
        form.find('.wrap-section-attr-q').each(function(){
            if ( $(this).find('select').length > 0 ){
                if ( $(this).find('option:selected').hasClass('defoult-op') ){num++;}
            }
            else {
                if ( $(this).find('input:checked').length == 0 ){num++;}
            }
        });
        //all variable choose
        if ( num == 0 ){
            //change link card
            if ( link_card !='' ){
                //redirect to card
                link.attr('href',link_card+'?add-to-cart='+id_variable+quntity_for_url+valString);
            }
            else {
                link.attr('href','?add-to-cart='+id_variable+quntity_for_url+valString);
            }
            //change text button
            link.html( link.attr('data-text-cart') );
            //change img product
            if ( imgSetting == 'yes' ){ 
                form.closest('.product').find(img_class).attr({'src' : img_v, 'srcset' : img_v});
            }
            //not sale
            if ( prise == prise_regular ){
                form.find('.price-attr-q').html(prise);
            }
            //sale
            else {
                form.find('.price-attr-q').html("<span class='sale-prise-q'>"+prise_regular+"</span>" + prise);
            }
            
        }
        else {
            //back all
            link.html( link.attr('data-text-select-option') );
            link.attr('href', link.attr('data-link') );
            form.find('.price-attr-q').html( link.attr('data-text-fill-all') );
            //back img product
            if ( imgSetting == 'yes' ){
                form.closest('.product').find(img_class).attr({'src' : form.attr('data-img') , 'srcset' : form.attr('data-img') });
            }
            
        }
    }
    //variable all value
    else {
        if ( all_variable !='' ){
            let vaslue = all_variable.split(';');
            //total product price
            prise_array = vaslue[0].split(':');
            prise = prise_array[1];
            prise_regular = vaslue [3];
            id_variable = vaslue[1].split(':');
            id_variable = id_variable[1];
            
            prise_regular = Number(prise_regular) * Number(val);
            prise = Number(prise) * Number(val);
            if ( align_currency =='left'){ prise = currency+prise; prise_regular = currency+prise_regular; }
            else { prise = prise+currency; prise_regular = prise_regular+currency; }
            //condition variable choose
            let num = 0;
            form.find('.wrap-section-attr-q').each(function(){
                if ( $(this).find('select').length > 0 ){
                    if ( $(this).find('option:selected').hasClass('defoult-op') ){num++;}
                }
                else {
                    if ( $(this).find('input:checked').length == 0 ){num++;}
                }
            });
            //all variable choose
            if ( num == 0 ){
                //change link cart
                let link = form.find('.wrap-button-add-to-c-q a');
                //change link card
                if ( link_card !='' ){
                    //redirect to card
                    link.attr('href',link_card+'?add-to-cart='+id_variable+quntity_for_url+valString);
                }
                else {
                    link.attr('href','?add-to-cart='+id_variable+quntity_for_url+valString);
                }
                //change text button
                link.html( link.attr('data-text-cart') );
                //change img product
                if ( imgSetting == 'yes' ){
                    form.closest('.product').find(img_class).attr({'src' : img_v, 'srcset' : img_v});
                }
                //not sale
                if ( prise == prise_regular ){
                    form.find('.price-attr-q').html(prise);
                }
                //sale
                else {
                    form.find('.price-attr-q').html("<span class='sale-prise-q'>"+prise_regular+"</span>" + prise);
                }
            }
            else {
                link.html( link.attr('data-text-select-option') );
                link.attr('href', link.attr('data-link') );
                form.find('.price-attr-q').html( link.attr('data-text-fill-all') );
                
            }
        
            id_v = vaslue[1].split(':');
            id_v = id_v[1];
            if ( imgSetting == 'yes' ){
                img_v = vaslue[2];
                form.closest('.product').find(img_class).attr({'src' : img_v, 'srcset' : img_v});
            }
        }
        else {
            if ( numberFixed == 0 ){//net activnix variable
                let link = form.find('.wrap-button-add-to-c-q a');
                //back img product
                if ( imgSetting == 'yes' ){
                    form.closest('.product').find(img_class).attr({'src' : form.attr('data-img') , 'srcset' : form.attr('data-img') });
                }
                
                //back text button
                link.html( link.attr('data-text-select-option') );
                link.attr('href', link.attr('data-link') );
                
                let num = 0;
                form.find('.wrap-section-attr-q').each(function(){
                    if ( $(this).find('select').length > 0 ){
                        if ( $(this).find('option:selected').hasClass('defoult-op') ){num++;}
                    }
                    else {
                        if ( $(this).find('input:checked').length == 0 ){num++;}
                    }
                });
                //all variable choose
                if ( num == 0 ){
                    form.find('.price-attr-q').html( link.attr('data-text-not-v') )

                }
                else {
                    form.find('.price-attr-q').html( link.attr('data-text-fill-all') );
                }
                
            }
        }
    }

}



//standart quantity
$(document).on('keyup change', '.category-quasar-attribute-q .number-quasar-attr input' , function(){
    quantityProduct( $(this) );
});


//defoult value attr
$('.name-attr-q').each(function(){ 
    if ( typeof $(this).attr('data-defoult') !='undefined' ){
        
        let data_defoult = $(this).attr('data-defoult');
        if ( data_defoult !='' ){
            if ( $(this).next().find('select').length > 0 ){
                $(this).next().find('option').not('.defoult-op').each(function(){
                    let number_condition = 0 ;
                    if ( $(this).attr('data-val-name') == data_defoult ){
                        number_condition++;
                    }
                    else {
                        if ( $(this).attr('data-val-name').replace(/\s/g,'-').toLowerCase() == data_defoult ){
                            number_condition++;
                        }
                    }
                    if ( number_condition > 0 ){ 
                        $(this).attr('selected', true).trigger('change') 
                    }
                });
            }
            else {
                $(this).next().find('label').each(function(){
                    let number_condition = 0 ;
                    if (  $(this).attr('data-val-name') == data_defoult ){
                        number_condition++;
                    }
                    else {
                        if ( $(this).attr('data-val-name').replace(/\s/g,'-').toLowerCase() == data_defoult ){
                            number_condition++;
                        }
                    }
                    if ( number_condition > 0 ){ 
                        $(this).prev('input').attr('checked', true).trigger('change');
                    }
                });   
            }
        }
    }
});

//disable variable in product (for related)
$('.not-variable-attr').each(function(){ 
    $(this).closest('.product').find('.add_to_cart_button').addClass('button-add-to-cart-q');
    $(this).remove();
});


    
});
})(jQuery);
