jQuery(document).ready(function() {
    
    let val = jQuery('#quasar_attr_img_q').val();
    //start
    if ( jQuery('.img-attr-val-q').length > 0 ){
        jQuery('.img-attr-val-q').each(function(){
            if ( jQuery(this).attr('data-img') !=='' ){
                jQuery(this).css('background-image', 'url('+ jQuery(this).attr('data-img')+')').find('span').css('display', 'none');
            }
        }); 
        quasar_save_img_attr();
    }
    
    
    //add img attr value
    jQuery(document).on('click', '.img-attr-val-q', function(){
        let button =  jQuery(this);
        //media button
        wp.media.editor.send.attachment = function(props, attachment) {
            let attachmentURL = wp.media.attachment(attachment.id).get("url");
            button.attr('data-img', attachmentURL).css('background-image', 'url('+attachmentURL+')').find('span').css('display', 'none').closest('.add-img-quasar-attr').find('.remove-img-attr-q').css('display', 'flex');
            quasar_save_img_attr();
            quasar_attr_remove_show();
        };
        wp.media.editor.open(button);
    });
    
    //remove img  attr value
    jQuery(document).on('click', '.remove-img-attr-q', function(){
        jQuery(this).css('display', 'none').prev('.img-attr-val-q').css('background-image', 'none').attr('data-img', '').find('span').css('display', 'flex');
    });
    
    function quasar_attr_remove_show(){
        jQuery('.img-attr-val-q').each(function(){
            if ( jQuery(this).attr('data-img') !=='' ){ jQuery(this).next('.remove-img-attr-q').css('display', 'flex') }
        });
    }
    quasar_attr_remove_show();
    
    //save
    function quasar_save_img_attr(){
        let arraySave = {};
        jQuery('.variable-attr-block-q').find('.wrap-section-attr-q').each(function(){
            //name attr
            let name = jQuery(this).find('.name-attr-q').next().attr('data-label');
            //array value
            var array_val = {};
            jQuery(this).find('.img-attr-val-q').each(function(){
                let img = jQuery(this).attr('data-img');
                let name_value = jQuery(this).prev('.name-attr-val-q').attr('data-label');
                array_val[name_value] = {img};
            });  
            
            //array
            arraySave[name] = {
                'value' : array_val ,
            };
            
        });
        
        arraySave = JSON.stringify(arraySave);//conver array to json string
        jQuery('#quasar_attr_img_q').val(arraySave);//write
    }
    
    //create window
    jQuery('#quasar_attr_tab').on('click', '.help-product' , function(e){
        if( jQuery(e.target).hasClass('help-q') ){
            jQuery('.swap-modal-help-q').remove();
            jQuery(this).append('<div class="swap-modal-help-q"> <div class="modal-help-q"></div> <div class="close-help-q">X</div> </div>');
            if ( jQuery(this).hasClass('help-product') ){ 
                jQuery('.modal-help-q').html( '<img src="'+jQuery(this).attr('data-img')+'"/>' );
                jQuery('.swap-modal-help-q').css({'top' : '-50px' });
            }
            
            jQuery('.not-active-field').removeClass('not-active-field');
        }
    });

    //close window
    jQuery('#quasar_attr_tab').on('click', '.close-help-q' , function(){
        jQuery(this).closest('.swap-modal-help-q').remove();
    }); 
    
    //close window 2
    jQuery('#wpbody').on('click' , function(e){
        if ( jQuery(this).find('.help-block-in-tab .swap-modal-help-q').length > 0 ){
            if ( jQuery(e.target).attr('class')!='swap-modal-help-q' && jQuery(e.target).attr('class')!='modal-help-q' && jQuery(e.target).parent().attr('class')!='modal-help-q' && !jQuery(e.target).hasClass('help-q') && !jQuery(e.target).hasClass('img-help-q')  ){ 
                jQuery('#wpbody').find('.swap-modal-help-q').remove();
            }
        }
    });
    

});


