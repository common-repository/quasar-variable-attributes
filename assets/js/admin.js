(function ($) {
$(document).ready(function () {
    

//update - sverka value attr plugin base and woccomerce
$('.wrap-attr-q').each(function(){
    
    
    let element = $(this).find('.name-attr');
    let name = element.attr('data-label');
    let array_value = $(this).find('.value-attr').html();
    if ( array_value !==''){ 
        array_value = array_value.split(',');
        //sverka
        $('.element-attr-use-q').each(function(){
            
            if ( $(this).attr('data-label') == name ){
                $(this).find('.value-elem-q').each(function(){
                    let val = $(this).html();
                    if ( $.inArray( val, array_value) !== -1 ){
                        //remove sovpadenie in array
                        $.each(array_value,function(index,value){
                            if ( value == val ){ array_value.splice(index, 1);}
                        });
                    }
                });
                if ( array_value.length > 0 ){
                    let attr = $(this);
                    $.each( array_value,function(index,value){
                        attr.append('<div class="value-elem-q" data-tooltip="" data-img="" data-html="" data-color="">'+value+'</div>');
                    });
                }
                //update name attrubute
                if ( $(this).find('span').html() != element.html() ){
                    $(this).find('span').html(element.html());
                }
            }
        });
    }
});

//remove dublicat in array
function doSmth(a) {
  for (var q=1, i=1; q<a.length; ++q) {
    if (a[q] !== a[q-1]) {
      a[i++] = a[q];
    }
  }

  a.length = i;
  return a;
}



$('.wrap-alement-add-q').on('click', function(){
    if ( $(this).parent().find('.wrap-popup-q').length === 0 ) {
        let string = '';
        $('.wrap-attr-q').each(function(){
            string = string + '<div class="attr-element" data-label="'+$(this).find('.name-attr').attr('data-label')+'">'+$(this).find('.name-attr').html()+'</div>';
        });
        
        let created = '<div class="wrap-popup-q"><div class="window-popup-q"><div class="message-and-search-q"><div class="wrap-text-s-block-q"><input placeholder="'+$('#text-search-q').html()+'"><span class="yes-a">'+$('#text-attr-add-q').html()+'</span><span class="not-a">'+$('#text-attr-add-not-q').html()+'</span></div><div class="close-block-attr-q"><i class="fa fa-timesq"></i></div></div>'+string+'</div></div>';
        $(this).parent().append(created);
        //filter
        //array use attr
        let array_use_attr = [];
        $('.wrap-use-attribute').find('.element-attr-use-q').each(function(){
            array_use_attr.push( $(this).find('span').html() );
        });
        //remove uge use attr
        $('.window-popup-q').find('.attr-element').each(function(){
            let name = $(this).html();
            let attr = $(this);
            $.each(array_use_attr,function(index,value){
                if (name == value ){ attr.remove(); }
            });
        });
    }
});


$('.add-attribute-q').on('click', '.attr-element', function(){
    let valAttr = $(this).html();
    let element = $(this);
    //not dubl
    let valid = 0;
    $('.wrap-use-attribute').find('.element-attr-use-q').each(function(){
        if ( $(this).html() == valAttr ){ valid++; }
    });
    if ( valid === 0 ){
        $('.wrap-use-attribute').append('<div class="element-attr-use-q elem-this" data-label="'+element.attr('data-label')+'" data-style="checkbox" data-font-size="14px" data-font-color="#000" data-background-color="#fff" data-background-color-a="#3674ff" data-border-width="1px" data-border-color="rgb(217, 217, 217)" data-border-radius="3px" data-size="" data-width="" data-height="" data-show-label="" data-disable-d="" data-padding="20px;20px;5px;5px;" data-font-size-c="13px" data-color-activ="#fff" data-border-color-a="#3674ff" data-padding-c="10px;10px;4px;4px;" data-height-c="30px" data-width-c="30px"><span>'+valAttr+'</span><div class="remove-at-q"><i class="fa fa-timesq"></i></div></div>');
        $('.message-and-search-q .not-a').css({'display' : 'none'});
        $('.message-and-search-q .yes-a').css({'opacity' : '1', 'display' : 'inline'});
        setTimeout(function(){
            $('.message-and-search-q .yes-a').css({'opacity' : '0', 'display' : 'none'});
        },1000); 
        showHelpMessageInAttr();
    }
    else {
        $('.message-and-search-q .yes-a').css({'display' : 'none'});
        $('.message-and-search-q .not-a').css({'opacity' : '1', 'display' : 'inline'});
        setTimeout(function(){
            $('.message-and-search-q span').css({'opacity' : '0', 'display' : 'none'});
        },1000); 
    }
    
    
    //created value
    let arrayVal = [];
    $('.wrap-attr-q').each(function(){
        if ( $(this).find('.name-attr').html() == valAttr ){
            arrayVal = $(this).find('.value-attr').html().split(',');
        }
    });
    $.each(arrayVal,function(index,value){
        $('.elem-this').append( '<div class="value-elem-q" data-tooltip="">'+value+'</div>' );
    });
    $('.elem-this').removeClass('elem-this');
    
   
    element.remove();
});


//close popup
$(document).mouseup(function (e){ 
    //add attribute
    if ( $('.wrap-popup-q').length > 0  ) {
        if  ( (!$(".wrap-popup-q").is(e.target)) && ($(".wrap-popup-q").has(e.target).length === 0 ) || $(e.target).hasClass('add-attribute-q') ){ 
            $('.wrap-popup-q').remove();
        } 
    }
});
$('.wrap-setting-qf-woo').on('click', '.close-block-attr-q', function(){
    $('.wrap-popup-q').remove();
});


//value attribute customization
$(document).on('click', '.element-attr-use-q', function() {
    let object = $(this);
    let valAttr = object.attr('data-label');
    let arrayVal = [];
    let number = 0;
    $('.wrap-dop-customization').css('display', 'none');
    
    $('.wrap-attr-q').each(function(){
        if ( $(this).find('.name-attr').attr('data-label').toLowerCase() == valAttr.toLowerCase() ){
            arrayVal = $(this).find('.value-attr').html().split(',');
        }
    });
    
    $('.wrap-value-customization, .wrap-design-attr').html('');
    let stringDesign = '<div class="wrap-section-attr"><div class="name-attr-q">'+object.find('span').html()+'</div><div class="wrap-attr-element-product">';
    //tooltip array
    $.each(arrayVal,function(index,value){
        //tolltip block
        let tooltipThis = '';
        object.find('.value-elem-q').each(function(){
            if ( $(this).html() == value ){ tooltipThis = $(this).attr('data-tooltip'); }
        });
        let tooltip = '<div class="tooltip-q"><span>'+$('#text-tooltip-q').html()+' <span class="name-attr-t">'+value+'</span></span><textarea>'+tooltipThis+'</textarea></div>';
        $('.wrap-value-customization').append(tooltip);
    });

    //style checkbox --
    if ( object.attr('data-style') =='checkbox' || object.attr('data-style') =='checkboximg' ){
        $.each(arrayVal,function(index,value){
            let padding = object.attr('data-padding').split(';');
            number++;
            if ( number < 7 ){
                //design block
                stringDesign = stringDesign + '<div class="attr-element-product checkbox-style-q" data-background-activ="'+object.attr('data-background-color-a')+'" data-color-activ="'+object.attr('data-color-activ')+'" data-background-defoult="'+object.attr('data-background-color')+'" data-color-defoult="'+object.attr('data-font-color')+'" data-border-color="'+object.attr('data-border-color')+'" data-border-color-a="'+object.attr('data-border-color-a')+'" style="font-size:'+object.attr('data-font-size')+'; color:'+object.attr('data-font-color')+'; background-color:'+object.attr('data-background-color')+'; border-width:'+object.attr('data-border-width')+'; border-color:'+object.attr('data-border-color')+'; border-radius:'+object.attr('data-border-radius')+'; padding-top:'+padding[0]+'; padding-left:'+padding[1]+'; padding-right:'+padding[2]+'; padding-bottom:'+padding[3]+';">'+value+'</div>';
            }
        });
        stringDesign = stringDesign + '</div></div>';
    }
    
    //style color --
    if ( object.attr('data-style') =='color' ){
        $('.dop-customization-block-q').html( '' );
        //color dop setting
        $.each(arrayVal,function(index,value){
            let color = '';
            object.find('.value-elem-q').each(function(){
                if ( $(this).html() == value ){ 
                    color = $(this).attr('data-color'); 
                    if (typeof color ==="undefined" ){
                        $(this).attr('data-color', '#cccccc');
                        color = '#cccccc';
                    }
                }
            });
            //default size
            if ( $(this).attr('data-size') === '' ){ $(this).attr('data-size', '28px'); }
            let setting_color = '<div class="color-setting-d-q"><span class="name-attr-t">'+value+'</span><input class="color-dop-q" data-alpha="true" value='+color+'></div>';
            $('.dop-customization-block-q').append( setting_color );
            $('.color-dop-q').wpColorPicker(colorOptions);
            $('.wrap-dop-customization').css('display', 'block');
        });
        
        $.each(arrayVal,function(index,value){
            let padding = object.attr('data-padding').split(';');
            color = '';
            $('.dop-customization-block-q').find('.color-setting-d-q').each(function(){
                if ( $(this).find('.name-attr-t').html() == value ){ color = $(this).find('input').val() ; }
            });
            

            //design block
            stringDesign = stringDesign + '<div class="attr-element-product checkbox-style-q color-style-q" data-background-activ="'+object.attr('data-background-color-a')+'" data-color-activ="'+object.attr('data-color-activ')+'" data-background-defoult="'+object.attr('data-background-color')+'" data-color-defoult="'+object.attr('data-font-color')+'" data-border-color="'+object.attr('data-border-color')+'" style="font-size:'+object.attr('data-font-size')+'; color:'+object.attr('data-font-color')+'; background-color:'+object.attr('data-background-color')+'; border-width:'+object.attr('data-border-width')+'; border-color:'+object.attr('data-border-color')+'; border-radius:'+object.attr('data-border-radius')+'; padding-top:'+padding[0]+'; padding-left:'+padding[1]+'; padding-right:'+padding[2]+'; padding-bottom:'+padding[3]+';"><div class="color-check-q" style="border-radius: '+object.attr('data-border-radius')+'; background-color: '+color+';" data-name="'+value+'"></div></div>';
            
        });
        stringDesign = stringDesign + '</div></div>';
    }
    
    //style dropdown --
    if ( object.attr('data-style') =='dropdown' ){
        
        let padding = object.attr('data-padding').split(';');
        stringDesign = stringDesign + '<span class="st-for-select" style="border-color:'+object.attr('data-font-color')+';"></span>';
        stringDesign = stringDesign + '<select class="attr-element-product" data-background-activ="'+object.attr('data-background-color-a')+'" data-color-activ="'+object.attr('data-color-activ')+'" style="font-size:'+object.attr('data-font-size')+'; line-height:'+object.attr('data-font-size')+'; color:'+object.attr('data-font-color')+'; background-color:'+object.attr('data-background-color')+'; border-width:'+object.attr('data-border-width')+'; border-color:'+object.attr('data-border-color')+'; border-radius:'+object.attr('data-border-radius')+'; padding-top:'+padding[0]+'; padding-left:'+padding[1]+'; padding-right:'+padding[2]+'; padding-bottom:'+padding[3]+';">';
        
        $.each(arrayVal,function(index,value){
            number++;
            if ( number < 7 ){
                //design block
                stringDesign = stringDesign + '<option style="font-size:'+object.attr('data-font-size')+'; line-height:'+object.attr('data-font-size')+'; color:'+object.attr('data-font-color')+';">'+value+'</div>';
            }
        });
        
        stringDesign = stringDesign + '</select></div>';
        
    }
     
    //style HTML ----------------------------------------
    if ( object.attr('data-style') =='html' ){
        $('.dop-customization-block-q').html( '' );
        //html dop setting
        $.each(arrayVal,function(index,value){
            let html_text = '';
            object.find('.value-elem-q').each(function(){
                if ( $(this).html() == value ){ 
                    html_text = $(this).attr('data-html'); 
                    if (typeof html_text ==="undefined" || html_text === ''){
                        $(this).attr('data-html', '');
                        html_text = $('#text-html-placeholder').html();
                    }
                }
            });
            //convertation html
            if ( typeof html_text !=="undefined" || html_text !== ''){
                html_text = html_text.replace(/StRelKa/g, '<');
            }
            //default size
            let setting_html = '<div class="wrap-attr-html-q"><span class="name-attr-t">'+value+'</span><textarea class="html-textarea-q">'+html_text+'</textarea></div>';
            $('.dop-customization-block-q').append( setting_html );
            $('.wrap-dop-customization').css('display', 'block');
        });
        
        $.each(arrayVal,function(index,value){
            html_text = '';
            $('.dop-customization-block-q').find('.wrap-attr-html-q').each(function(){
                if ( $(this).find('.name-attr-t').html() == value ){ html_text = $(this).find('textarea').val() ; }
            });
            
            number++;
            //design block
            stringDesign = stringDesign + '<div class="attr-element-product html-attr-q" data-background-activ="'+object.attr('data-background-color-a')+'" data-color-activ="'+object.attr('data-color-activ')+'" data-background-defoult="'+object.attr('data-background-color')+'" data-color-defoult="'+object.attr('data-font-color')+'"><div class="html-val-q" data-name="'+value+'">'+html_text+'</div></div>';
            
        });
        stringDesign = stringDesign + '</div></div>';
    }
    

    
    $('.wrap-design-attr').append( stringDesign );
    

});



$(document).on('click', '.element-attr-use-q', function(e){
    let attr = $(this);
    if ( !$(e.target).hasClass('remove-at-q') && !$(e.target).parent().hasClass('remove-at-q') ) {
        //class this element
        $('.element-attr-use-q').removeClass('active-edit-q');
        attr.addClass('active-edit-q');
        let coordinat = this.getBoundingClientRect().top;
        let heightWindow = $(window).height(); //height window
        let heightWindow2 = ( $(window).height() / 100) * 60 ; //60% height window
        let heightWindow3 = ( $(window).height() / 100) * 40 ; //40% height window

        //if height monitor > 550px
        if ( heightWindow > 700 && !$('.modalbox-admin-panel').hasClass('classic-window-q') ){
            $('.modalbox-admin-panel').removeClass('small-window-q').addClass('new-window-q');
            coordinat = Number(coordinat) + 100;
            let coordinatPx = heightWindow2 + 'px';
                
            //scroll
            let poz = $(this).offset().top - heightWindow3;
            $('html, body').animate({
                scrollTop: poz
            }, 500);
            $('.modalbox-admin-panel').attr('position', coordinatPx);
                
        }
        //if height monitor < 550px
        else  {
            $('.modalbox-admin-panel').addClass('small-window-q').removeClass('new-window-q');
        }
        modalpanel(attr);
    }
});
function modalpanel(attr){
    setTimeout(function(){ //fix bug iris
        clearmodaladmin(); 
        
        if ( $('.modalbox-admin-panel').hasClass('small-window-q') ){
            $('.modalbox-admin-panel').css({'display' : 'flex'});
        }
        else {
            let coordinat = $('.modalbox-admin-panel').attr('position');
            $('.modalbox-admin-panel').css({'display' : 'flex', 'top' : coordinat });
        }
        //free disable img
        if ( attr.attr('data-style') =='checkboximg' ){
            attr.attr('data-style','checkbox');
        }
        
        //constructor stye
        nameAttr(attr);
        typeStyle(attr);
        styleCheckbox(attr);
        updateWidthAttrSetting();
    });
}
  
function nameAttr(attr){
    let createdElement = "<div class='setting-field-q adm-name-block'><span class='heding-field-q'>Name</span> <span class='name-a'>"+attr.find('span').html()+"</span></div>";
    $('.admin-modal-box-col-1').append(createdElement);
}
  
//select style field
function typeStyle(attr){
    let style = attr.attr('data-style');
    let createdElement = '';
    createdElement = "<div class='setting-field-q'><span class='heding-field-q'>"+$('#text-type-style-attr-q').html()+"</span> <div id='style-attr'> <select class='admin-dropdown-style-1'>";
        createdElement = createdElement + "<option data-val='checkbox'>"+$('#text-style1-q').html()+"</option>";
        createdElement = createdElement + "<option class='only-pro-option' data-val='checkboximg'>"+$('#text-style2-q').html()+"</option>"; 
        createdElement = createdElement + "<option data-val='color'>"+$('#text-style4-q').html()+"</option>";
        createdElement = createdElement + "<option data-val='html'>"+$('#text-style5-q').html()+"</option>";
        createdElement = createdElement + "<option data-val='dropdown'>"+$('#text-style3-q').html()+"</option>";
    createdElement =  createdElement + "</select></div></div>";


    $('.admin-modal-box-col-1').append(createdElement); 
    let selected = '';
    $('#style-attr').find('option').each(function(){
        if ( $(this).attr('data-val') == style ){ selected = $(this).html(); }
    });
    $('#style-attr').find('select').val( selected );
}  

function styleCheckbox(attr){
    let style = attr.attr('data-style');
    let createdElement = "<div class='setting-field-q'><span class='heding-field-q'>"+$('#text-font-size').html()+"</span><input id='font-size-c' value='"+attr.attr('data-font-size')+"'></div>";
    $('.admin-modal-box-col-1').append(createdElement); 
    
    createdElement = "<div class='setting-field-q'><span class='heding-field-q'>"+$('#text-font-color').html()+"</span><input id='font-color-c' class='color-setting' data-alpha='true' value='"+attr.attr('data-font-color')+"'></div>";
    $('.admin-modal-box-col-1').append(createdElement); 
    
    createdElement = "<div class='setting-field-q'><span class='heding-field-q'>"+$('#text-color-a').html()+"</span><input id='font-color-a' class='color-setting' data-alpha='true' value='"+attr.attr('data-color-activ')+"'></div>";
    $('.admin-modal-box-col-1').append(createdElement); 
    
    createdElement = "<div class='setting-field-q'><span class='heding-field-q'>"+$('#text-background-color').html()+"</span><input id='background-color-c' class='color-setting' data-alpha='true' value='"+attr.attr('data-background-color')+"'></div>";
    $('.admin-modal-box-col-1').append(createdElement); 
    
    createdElement = "<div class='setting-field-q'><span class='heding-field-q'>"+$('#text-background-color-a').html()+"</span><input id='background-color-a' class='color-setting' data-alpha='true' value='"+attr.attr('data-background-color-a')+"'></div>";
    $('.admin-modal-box-col-1').append(createdElement); 
    
    createdElement = "<div class='setting-field-q'><span class='heding-field-q'>"+$('#text-border-width').html()+"</span><input id='font-border-width-c' value='"+attr.attr('data-border-width')+"'></div>";
    $('.admin-modal-box-col-1').append(createdElement); 
    
    createdElement = "<div class='setting-field-q'><span class='heding-field-q'>"+$('#text-border-color').html()+"</span><input id='font-border-color-c' class='color-setting' data-alpha='true' value='"+attr.attr('data-border-color')+"'></div>";
    $('.admin-modal-box-col-1').append(createdElement); 
    
    //add border activ
    createdElement = "<div class='setting-field-q'><span class='heding-field-q'>"+$('#text-border-color-a').html()+"</span><input id='border-color-a' class='color-setting' data-alpha='true' value='"+attr.attr('data-border-color-a')+"'></div>";
    $('.admin-modal-box-col-1').append(createdElement); 
    
    //filter setting design for color
    if ( style =='color' ){
        $('#font-color-a').closest('.setting-field-q').css('display', 'none');
        $('#background-color-a').closest('.setting-field-q').css('display', 'none');
  
        //add size 
        createdElement = "<div class='setting-field-q'><span class='heding-field-q'>"+$('#text-size-q').html()+"</span><input id='size-for-color' value='"+attr.attr('data-size')+"'></div>";
        $('.admin-modal-box-col-1').append(createdElement); 
    }
    
    
    createdElement = "<div class='setting-field-q'><span class='heding-field-q'>"+$('#text-border-raius').html()+"</span><input id='font-border-radius-c' value='"+attr.attr('data-border-radius')+"'></div>";
    $('.admin-modal-box-col-1').append(createdElement); 
    
    //padding
    let padding = attr.attr('data-padding').split(';') ;   
    createdElement = "<div class='setting-field-q wrap-margin-block'><div class='wrap-heading-margin'><span class='heding-field-q'>"+$('#text-padding-q').html()+"</span> </div><div class='wrap-padding-f'><input id='admpaddingleft' class='style-input-q' value='"+padding[0]+"'> <input id='admpaddingright' class='style-input-q' value='"+padding[1]+"'> <input id='admpaddingtop' class='style-input-q' value='"+padding[2]+"'><input id='admpaddingbottom' class='style-input-q' value='"+padding[3]+"'></div></div>";
    $('.admin-modal-box-col-1').append(createdElement); 
    
    
    //filter setting design for HTML
    if ( style =='html' ){
        //disable all style
        let disable_style = attr.attr('data-disable-d');
        createdElement = "<div class='setting-field-q'><span class='heding-field-q'>"+$('#text-disable-design-q').html()+"</span> <div id='disable-design'> <select class='admin-dropdown-style-1'>";
            createdElement = createdElement + "<option data-val='not'>"+$('#text-no-q').html()+"</option>";
            createdElement = createdElement + "<option data-val='yes'>"+$('#text-yes-q').html()+"</option>"; 
        createdElement =  createdElement + "</select></div></div>";
        $('.admin-modal-box-col-1').append(createdElement);
        //selected
        $('#disable-design').find('option').each(function(){
            if ( $(this).attr('data-val') == disable_style ){$(this).prop('selected', true);}
        })

    }
    
    //category wrap
    createdElement = "<div class='wrap-two-block-q'><div class='column-1-q'></div><div class='column-2-q'></div></div>";
    $('.admin-modal-box-col-1').append(createdElement); 
    
    //separator
    createdElement = "<div class='wrap-text-section-q'><p>"+$('#text-display-category-q').html()+"</p></div>";
    $('.column-1-q').append(createdElement); 
    
    //font for category
    createdElement = "<div class='setting-field-q'><span class='heding-field-q'>"+$('#text-font-size').html()+"</span><input id='font-size-categoty' value='"+attr.attr('data-font-size-c')+"'></div>";
    $('.column-1-q').append(createdElement); 
    
    //padding for category
    padding = attr.attr('data-padding-c').split(';') ;   
    createdElement = "<div class='setting-field-q wrap-margin-block'><div class='wrap-heading-margin'><span class='heding-field-q'>"+$('#text-padding-q').html()+"</span> </div><div class='wrap-padding-f'><input id='admpaddingleft-c' class='style-input-q' value='"+padding[0]+"'> <input id='admpaddingright-c' class='style-input-q' value='"+padding[1]+"'> <input id='admpaddingtop-c' class='style-input-q' value='"+padding[2]+"'><input id='admpaddingbottom-c' class='style-input-q' value='"+padding[3]+"'></div></div>";
    $('.column-1-q').append(createdElement); 
    
 

    //filter setting design for HTML
    if ( style =='html' ){
        $('#font-size-c').closest('.setting-field-q').css('display', 'none');
        $('#font-size-categoty').closest('.setting-field-q').css('display', 'none');
    }
    
    //filter setting design for select
    if ( style =='dropdown' ){
        $('#border-color-a').closest('.setting-field-q').css('display', 'none');
        $('#background-color-a').closest('.setting-field-q').css('display', 'none');
        $('#font-color-a').closest('.setting-field-q').css('display', 'none');
       
    }
    //filter setting design for color
    if ( style =='color' ){
        $('#font-size-c').closest('.setting-field-q').css('display', 'none');
        $('#font-size-categoty').closest('.setting-field-q').css('display', 'none');
    }
    
    //add copy style
    createdElement = "<div class='setting-field-q copy-style-field'><span class='heding-field-q'>"+$('#text-copy-text-q').html()+"</span> <div class='swap-copy-q'><div class='element-copy-q copy-qs'>"+$('#text-copy-q').html()+"</div><div class='element-copy-q paste-qs'>"+$('#text-paste-q').html()+"</div> </div></div>";
    $('.column-2-q').append(createdElement); 
    
    if ( $('#copy-style-data').attr('data-style') !='' ) {
        $('.paste-qs').addClass('active-style');
    }
    
    
    
    //input color
    $('.color-setting').wpColorPicker(colorOptions);
}



  
//clear window editor
function clearmodaladmin(){
    $('.admin-modal-box-col-1, .admin-modal-box-col-2').html(''); 
    $('.modalbox-admin-panel').css('display', 'none');
}   

//edit
$('.modalbox-admin-panel').on('keyup change', function(e){
    let editElement = $('.active-edit-q');
    let stylePrev = editElement.attr('data-style');
    let styleNew = $('#style-attr').find('option:selected').attr('data-val');
    editElement.attr({
        'data-font-size' : $('#font-size-c').val(),
        'data-border-width' : $('#font-border-width-c').val(),
        'data-border-radius' : $('#font-border-radius-c').val(),
        'data-padding' : $('#admpaddingleft').val() +';'+$('#admpaddingright').val() +';'+ $('#admpaddingtop').val() +';'+ $('#admpaddingbottom').val(),
        'data-style' : styleNew,
        'data-font-size-c' : $('#font-size-categoty').val(), 
        'data-padding-c' : $('#admpaddingleft-c').val() +';'+$('#admpaddingright-c').val() +';'+ $('#admpaddingtop-c').val() +';'+ $('#admpaddingbottom-c').val(),
    });
    

    

    //edit style real time
    $('.wrap-design-attr').find('.attr-element-product').css({
        'font-size' : $('#font-size-c').val(),
        'border-width' : $('#font-border-width-c').val(),
        'border-radius' : $('#font-border-radius-c').val(),
        'padding-left' : $('#admpaddingleft').val(),
        'padding-right' : $('#admpaddingright').val(),
        'padding-top' : $('#admpaddingtop').val(),
        'padding-bottom' : $('#admpaddingbottom').val(),
    });
    //edit for color
    if ( styleNew == 'color' ){
        $('.color-check-q').css({
            'border-radius' : $('#font-border-radius-c').val(),
            'width': $('#size-for-color').val(),
            'height': $('#size-for-color').val(),
        });
        editElement.attr({
            'data-size' : $('#size-for-color').val(),
        });
    }
    //edit for html
    if ( styleNew == 'html' ){
        let disable_design = $('#disable-design').find('option:selected').attr('data-val');
            if ( disable_design=='yes' ){
                $('#font-color-c').closest('.setting-field-q').css('display', 'none');
                $('#font-color-a').closest('.setting-field-q').css('display', 'none');
                $('#background-color-c').closest('.setting-field-q').css('display', 'none');
                $('#background-color-a').closest('.setting-field-q').css('display', 'none');
                $('#font-border-width-c').closest('.setting-field-q').css('display', 'none');
                $('#font-border-color-c').closest('.setting-field-q').css('display', 'none');
                $('#font-border-radius-c').closest('.setting-field-q').css('display', 'none');
                $('#admpaddingleft').closest('.setting-field-q').css('display', 'none');
            }
            else {
                $('#font-color-c').closest('.setting-field-q').css('display', 'flex');
                $('#font-color-a').closest('.setting-field-q').css('display', 'flex');
                $('#background-color-c').closest('.setting-field-q').css('display', 'flex');
                $('#background-color-a').closest('.setting-field-q').css('display', 'flex');
                $('#font-border-width-c').closest('.setting-field-q').css('display', 'flex');
                $('#font-border-color-c').closest('.setting-field-q').css('display', 'flex');
                $('#font-border-radius-c').closest('.setting-field-q').css('display', 'flex');
                $('#admpaddingleft').closest('.setting-field-q').css('display', 'flex');
            }
        editElement.attr('data-disable-d', disable_design);
    }


    
    if ( stylePrev != styleNew ){
        //fix for style select
        if ( styleNew == 'dropdown' ){
            editElement.attr({
                'data-padding' : '10px' +';'+'45px' +';'+ '10px'+';'+ '10px',
            });
        }
        //fix for style checkbox
        if ( styleNew == 'checkbox' ||  styleNew == 'checkbox' ){
            editElement.attr({
                'data-padding' : '10px' +';'+'10px' +';'+ '10px'+';'+ '10px',
            });
        }
        //fix for color
        if ( styleNew == 'color' || styleNew == 'html'){
            editElement.attr({
                'data-padding' : '3px' +';'+'3px' +';'+ '3px'+';'+ '3px',
                'data-size' : '28px',
                'data-border-color-a' : '#3674ff',
                'data-padding-c' : '3px' +';'+'3px' +';'+ '3px'+';'+ '3px',
            });
        }

    
        editElement.trigger('click');
    }
    
    
});


//color editor
var colorOptions = {
    change: function(event, ui){
        let editElement = $('.active-edit-q');
        let style = editElement.attr('data-style');
        //BACKGROUND
        if ( $(this).attr('id') == 'background-color-c' ){
            //style
            $('.wrap-design-attr').find('.attr-element-product').css({ 'background-color' : ui.color.toString() });
            //base
            editElement.attr({ 'data-background-color' :  ui.color.toString()  });
            //personal style for block style
            if ( style == 'checkbox' ){
                $('.wrap-design-attr').find('.checkbox-style-q').attr({ 'data-background-defoult' : ui.color.toString() });
            }
            
        }
        //COLOR
        if ( $(this).attr('id') == 'font-color-c' ){
            $('.wrap-design-attr').find('.attr-element-product').css({ 'color' : ui.color.toString() });
            //personal style for block style
            if ( style == 'dropdown' ){
                $('.wrap-design-attr').find('.st-for-select').css({ 'border-color' : ui.color.toString() });
            }
            if ( style == 'checkbox' || style == 'color' ){
                $('.wrap-design-attr').find('.checkbox-style-q').attr({ 'data-color-defoult' : ui.color.toString() });
            }
            //base
            editElement.attr({ 'data-font-color' :  ui.color.toString()  });
        }
        //BORDER
        if ( $(this).attr('id') == 'font-border-color-c' ){
            //style
            $('.wrap-design-attr').find('.attr-element-product').css({ 'border-color' : ui.color.toString() });
            //base
            editElement.attr({ 'data-border-color' :  ui.color.toString()  });
        }
        //BORDER - A
        if ( $(this).attr('id') == 'border-color-a' ){
            //base
            editElement.attr({ 'data-border-color-a' :  ui.color.toString()  });
            //for block style real time
            $('.wrap-design-attr').find('.attr-element-product').attr({ 'data-border-color-a' : ui.color.toString() });
        }
        //COLOR - A
        if ( $(this).attr('id') == 'font-color-a' ){
            //style
            $('.wrap-design-attr').find('.attr-element-product').attr({ 'data-color-activ' : ui.color.toString() });
            //base
            editElement.attr({ 'data-color-activ' :  ui.color.toString()  });
            //for block style real time
            if ( style == 'checkbox' || style == 'color' ){
                $('.wrap-design-attr').find('.checkbox-style-q').attr({ 'data-color-activ' : ui.color.toString() });
            }
        }
        //BACKGROUND - A
        if ( $(this).attr('id') == 'background-color-a' ){
            //style
            $('.wrap-design-attr').find('.attr-element-product').attr({ 'background-color-a' : ui.color.toString() });
            //base
            editElement.attr({ 'data-background-color-a' :  ui.color.toString()  });
            //for block style real time
            if ( style == 'checkbox' || style == 'color' ){
                $('.wrap-design-attr').find('.checkbox-style-q').attr({ 'data-background-activ' : ui.color.toString() });
            }
        }
        
        // color dop setting for checkbox color
        if ( $(this).hasClass('color-dop-q') ){
            //color base
            attr_value = $(this).closest('.color-setting-d-q').find('.name-attr-t').html();
            editElement.find('.value-elem-q').each(function(){
                if ( $(this).html() == attr_value ){ 
                    $(this).attr('data-color',  ui.color.toString() ); 
                    $('.color-check-q[data-name="'+attr_value+'"]').css('background-color',  ui.color.toString() );
                }
            });
        }
        //color attr name
        if ( $(this).attr('id') == 'font-color-name-attribute' ){
            $('.wrap-design-setting').find('.name-attr-q').css('color',  ui.color.toString() );
        }
        if ( $(this).attr('id') == 'font-color-name-attribute-с' ){
            $('.wrap-design-setting-category').find('.name-attr-q').css('color',  ui.color.toString() );
        }
        //color price
        if ( $(this).attr('id') == 'font-color-price-с' ){
            $('.wrap-design-setting-category').find('.price-attr-q').css('color',  ui.color.toString() );
        }
        //color button
        if ( $(this).attr('id') == 'font-color-button-с' ){
            $('.wrap-button-add-to-c-q').find('div').css('color',  ui.color.toString() );
        }
        //background color button
        if ( $(this).attr('id') == 'background-color-button-с' ){
            $('.wrap-button-add-to-c-q').find('div').css('background-color',  ui.color.toString() );
        }
        //border color
        if ( $(this).attr('id') == 'border-color-button-с' ){
            $('.wrap-button-add-to-c-q').find('div').css('border-color',  ui.color.toString() );
        }
        //color quantity
        if ( $(this).attr('id') == 'font-color-quantity-с' ){
            $('.wrap-number-add-to-c-q').find('input').css('color',  ui.color.toString() );
        }
        //background color quantity
        if ( $(this).attr('id') == 'background-quantity-с' ){
            $('.wrap-number-add-to-c-q').find('input').css('background-color',  ui.color.toString() );
        }
        //border color quantity
        if ( $(this).attr('id') == 'border-color-quantity-с' ){
            $('.wrap-number-add-to-c-q').find('input').css('border-color',  ui.color.toString() );
        }
        

 
    }
};

//start color
$('.color-setting-start').each(function(){
    $(this).wpColorPicker(colorOptions);
    if ( $(this).attr('id') == 'font-color-name-attribute' ){
        $('.wrap-design-setting').find('.name-attr-q').css('color',  $(this).val() );
    }
    if ( $(this).attr('id') == 'font-color-name-attribute-с' ){
        $('.wrap-design-setting-category').find('.name-attr-q').css('color',  $(this).val() );
    }
    if ( $(this).attr('id') == 'font-color-price-с' ){
        $('.wrap-design-setting-category').find('.price-attr-q').css('color',  $(this).val() );
    }
    //color button
    if ( $(this).attr('id') == 'font-color-button-с' ){
        $('.wrap-button-add-to-c-q').find('div').css('color',  $(this).val() );
    }
    //background color button
    if ( $(this).attr('id') == 'background-color-button-с' ){
        $('.wrap-button-add-to-c-q').find('div').css('background-color',  $(this).val() );
    }
    //border color button
    if ( $(this).attr('id') == 'border-color-button-с' ){
        $('.wrap-button-add-to-c-q').find('div').css('border-color',  $(this).val() );
    }
    //color quantity
    if ( $(this).attr('id') == 'font-color-quantity-с' ){
        $('.wrap-number-add-to-c-q').find('input').css('color',  $(this).val() );
    }
    //background color quantity
    if ( $(this).attr('id') == 'background-quantity-с' ){
        $('.wrap-number-add-to-c-q').find('input').css('background-color',  $(this).val() );
    }
    //border color quantity
    if ( $(this).attr('id') == 'border-color-quantity-с' ){
        $('.wrap-number-add-to-c-q').find('input').css('border-color',  $(this).val() );
    }
    
});


//edit tooltip
$(document).on('keyup', '.tooltip-q textarea' , function(e){
    let nameAtrr = $(this).parent().find('.name-attr-t').html();
    let val = $(this).val();
    $('.active-edit-q .value-elem-q').each(function(){
        if ( $(this).html() == nameAtrr ){ $(this).attr('data-tooltip', val); }
    });
});

//edit html
$(document).on('keyup', '.html-textarea-q' , function(e){
    let nameAtrr = $(this).parent().find('.name-attr-t').html();
    let val = $(this).val();
    $('.active-edit-q .value-elem-q').each(function(){
        if ( $(this).html() == nameAtrr ){ 
            //base
            $(this).attr('data-html', val);
            //design
            $('.html-val-q').each(function(){
                let name = $(this).attr('data-name');
                if ( nameAtrr == name ){  
                    $(this).html( val );
                }
            });
            
        }
    });
});

//edit img
$(document).on('keyup', '.img-textarea-q' , function(e){
    let nameAtrr = $(this).parent().find('.name-attr-t').html();
    let val = $(this).val();
    $('.active-edit-q .value-elem-q').each(function(){
        if ( $(this).html() == nameAtrr ){ 
            //base
            $(this).attr('data-img', val);
            //design
            $('.html-val-q').each(function(){
                let name = $(this).attr('data-name');
                if ( nameAtrr == name ){  
                    if ( val !='[img-attr]'){
                        $(this).find('img').attr('src', val );
                    }
                    else {
                        $(this).find('img').attr('src', $('.img-dir-q').html()+'/img1.jpg' );
                    }
                }
            });
            
        }
    });
});

//img update
function updateImg(){
    $('.img-textarea-q').each(function(){
        let nameAtrr = $(this).parent().find('.name-attr-t').html();
        let val = $(this).val();
        $('.active-edit-q .value-elem-q').each(function(){
            if ( $(this).html() == nameAtrr ){ 
                //base
                $(this).attr('data-img', val);
                //design
                $('.html-val-q').each(function(){
                    let name = $(this).attr('data-name');
                    if ( nameAtrr == name ){  
                        if ( val !='[img-attr]'){
                            $(this).find('img').attr('src', val );
                        }
                        else {
                            $(this).find('img').attr('src', $('.img-dir-q').html()+'/img1.jpg' );
                        }
                    }
                });
                
            }
        });
    });
}


//tab menu
$(document).on('click', '.menu-top-q' , function(e){
    $('.menu-top-q').removeClass('activ-tab-q');
    $(this).addClass('activ-tab-q');
    let tab_id = $(this).attr('data-tab');
    //for text help
    if( tab_id == 1 ){
        $('.text-help-heading').css('display','block');
    }
    else {
        $('.text-help-heading').css('display','none');
    }
    //shoe hide tab
    $('.wrap-setting-qf-woo').each(function(){
        $('.wrap-setting-qf-woo').css('display', 'none');
        $('.tab-class-'+tab_id).css('display', 'block');
    });
    
    updateWidthField();
});
$('.activ-tab-q').trigger('click');


//activ checkbox
$(document).on('click', '.checkbox-style-q' , function(e){
    //standart checkbox
    if ( !$(this).hasClass('color-style-q') && !$(this).hasClass('img-attr-q') ){
        $(this).closest('.wrap-attr-element-product').find('.attr-element-product').each(function(){
            $(this).css({
                'color' : $(this).attr('data-color-defoult'),
                'background-color' : $(this).attr('data-background-defoult'),
                'border-color' : $(this).attr('data-border-color'),
            });
        });
        $(this).css({
            'color' : $(this).attr('data-color-activ'),
            'background-color' : $(this).attr('data-background-activ'),
            'border-color' : $(this).attr('data-border-color-a'),
        });
    }
    //color
    if ( $(this).hasClass('color-style-q') || $(this).hasClass('img-attr-q') ){
        $(this).closest('.wrap-attr-element-product').find('.attr-element-product').each(function(){
            $(this).css({
                'border-color' : $(this).attr('data-border-color'),
            });
        });
        $(this).css({
            'border-color' : $(this).attr('data-border-color-a'),
        });
    }
});


//edit design
$('.wrap-design-setting-attr-q').on('keyup', 'input' , function(e){
    updateDesignSetting();
});

$('.wrap-design-setting-attr-q').on('change', 'select' , function(e){
    updateDesignSetting();
});


function updateDesignSetting(){
    //style cart ---------------------------------------------
    $('.wrap-design-setting .wrap-section-attr').css({ 'margin-bottom' : $('#margin-m-attribute').val() });
    $('.wrap-design-setting .checkbox-style-q').css({ 'margin-right' : $('#margin-m-value').val(),  'margin-bottom' : $('#margin-m-value').val() });
    $('.wrap-design-setting').css({ 
        'padding-left' : $('#adm-padding-left').val(), 
        'padding-right' : $('#adm-padding-right').val(), 
        'padding-top' : $('#adm-padding-top').val(), 
        'padding-bottom' : $('#adm-padding-bottom').val(), 
        'max-width' : $('#max-width-v-cart').val(),
    }).find('.name-attr-q').css({
        'font-size' : $('#font-size-name-attribute').val(),
        'font-weight' : $('#font-weight-name-attribute').find('option:selected').attr('data-val'),
    });

   
    let style = $('#style-block-variable').find('option:selected').attr('data-val');
    if ( style == 'style-2' ) { 
        $('.wrap-design-setting').addClass('style-design-2');
        $('.wrap-design-setting .name-attr-q').css({ 'margin-bottom' : $('#margin-m-name').val(), 'margin-right' : '0px' });
    }
    else { 
        $('.wrap-design-setting .name-attr-q').css({ 'margin-right' : $('#margin-m-name').val(), 'margin-bottom' : '0px' });
        $('.wrap-design-setting').removeClass('style-design-2'); 
        $('#margin-bottom-name').parent().css('display', 'none');
    }
    //style category -----------------------------------------
    $('.wrap-design-setting-category .wrap-section-attr').css({ 'margin-bottom' : $('#margin-m-attribute-c').val() });
    $('.wrap-design-setting-category .checkbox-style-q').css({ 'margin-right' : $('#margin-m-value-c').val(), 'margin-bottom' : $('#margin-m-value-c').val() });
    $('.wrap-design-setting-category').css({ 
        'padding-left' : $('#adm-padding-left-c').val(), 
        'padding-right' : $('#adm-padding-right-c').val(), 
        'padding-top' : $('#adm-padding-top-c').val(), 
        'padding-bottom' : $('#adm-padding-bottom-c').val(), 
    }).find('.name-attr-q').css({
        'font-size' : $('#font-size-name-attribute-c').val(),
        'font-weight' : $('#font-weight-name-attribute-c').find('option:selected').attr('data-val'),
    });
    $('.wrap-design-setting-category').find('.price-attr-q').css({
        'font-size' : $('#font-size-price-attribute-c').val(),
        'font-weight' : $('#font-weight-price-attribute-c').find('option:selected').attr('data-val'),
        'margin-bottom' : $('#price-indent-c').val(),
    });
    style = $('#style-block-variable-category').find('option:selected').attr('data-val');
    if ( style == 'style-2' ) { 
        $('.wrap-design-setting-category').addClass('style-design-2');
        $('.wrap-design-setting-category .name-attr-q').css({ 'margin-bottom' : $('#margin-m-name-c').val(), 'margin-right' : '0px' });
    }
    else { 
        $('.wrap-design-setting-category .name-attr-q').css({ 'margin-right' : $('#margin-m-name-c').val(), 'margin-bottom' : '0px' });
        $('.wrap-design-setting-category').removeClass('style-design-2'); 
    }
    //button addto cart
    $('.wrap-button-add-to-c-q div').css({
        'font-size' : $('#font-size-button-attribute-c').val(),
        'font-weight' : $('#font-weight-button-attribute-c').find('option:selected').attr('data-val'),
        'border-width' : $('#button-border-width-c').val(),
        'border-radius' : $('#button-border-radius-c').val(),
        'padding-left' : $('#adm-button-padding-left-c').val(), 
        'padding-right' : $('#adm-button-padding-right-c').val(), 
        'padding-top' : $('#adm-button-padding-top-c').val(), 
        'padding-bottom' : $('#adm-button-padding-bottom-c').val(), 
    });
    $('.wrap-number-and-button-q').css({
        'margin-top' : $('#button-indent-c').val(),
    });
    //quantity
    $('.wrap-number-add-to-c-q input').css({
        'font-size' : $('#font-size-quantity-с').val(),
        'border-width' : $('#quantity-border-width-c').val(),
        'border-radius' : $('#quantity-border-radius-c').val(),
        'padding-left' : $('#adm-quantity-padding-left-c').val(), 
        'padding-right' : $('#adm-quantity-padding-right-c').val(), 
        'padding-top' : $('#adm-quantity-padding-top-c').val(), 
        'padding-bottom' : $('#adm-quantity-padding-bottom-c').val(), 
    });
    
}
updateDesignSetting();


$('.element-align-q').on('click', function(e){
    let block = $(this).closest('.swap-align-buttons');
    block.find('.active-align').removeClass('active-align');
    $(this).addClass('active-align');
    if ( $(this).hasClass('left-al-setting') ) { block.attr('data-val', 'left'); }
    if ( $(this).hasClass('center-al-setting') ) { block.attr('data-val', 'center'); }
    if ( $(this).hasClass('right-al-setting') ) { block.attr('data-val', 'right'); }
    //align price
    if ( block.hasClass('price-align-q') ){
        $('.prise-block-attr-q').attr('class', 'prise-block-attr-q align-c-'+block.attr('data-val') );
    }
    //align button
    if ( block.hasClass('button-align-q') ){
        $('.wrap-button-add-to-c-q').attr('class', 'wrap-button-add-to-c-q align-c-'+block.attr('data-val') );
    }
   
});

$('.swap-align-buttons').each(function(){
    let val = $(this).attr('data-val');
    if ( val=='left' ){
        $(this).find('.left-al-setting').addClass('active-align');
    }
    if ( val=='center' ){
        $(this).find('.center-al-setting').addClass('active-align');
    }
    if ( val=='right' ){
        $(this).find('.right-al-setting').addClass('active-align');
    }
});



//show setting categoty
function show_setting_category(){
    if ( $('#show-archive-block-variable').find('option:selected').attr('data-val') =='yes' ){
        $('.category-setting-q').css('display', 'flex');
        $('.category-design').removeClass('not-active-setting').find('.disallow-setting').css('display', 'none');
    }
    else {
        $('.category-setting-q').css('display', 'none');
        $('.category-design').addClass('not-active-setting').find('.disallow-setting').css('display', 'block');
        
    }
}
show_setting_category();
$('#show-archive-block-variable').on('change', function(){ show_setting_category() });

//show quntity field
function show_quntity(){
    if ( $('#show-quantity-q').find('option:selected').attr('data-val') =='yes' ){
        $('.disable-quantity').css('display', 'none');
        $('.quanity-design-q').removeClass('not-active-setting');
        $('.wrap-number-add-to-c-q').css('display', 'block');
        $('.wrap-button-add-to-c-q').css({'flex-basis' : '65%', 'width' : '65%' })
    }
    else {
        $('.disable-quantity').css('display', 'flex');
        $('.quanity-design-q').addClass('not-active-setting');
        $('.wrap-number-add-to-c-q').css('display', 'none');
        $('.wrap-button-add-to-c-q').css({'flex-basis' : '100%', 'width' : '100%' });
    }
}
show_quntity()
$('#show-quantity-q').on('change', function(){ show_quntity() });


//hide design
function hide_design_setting(){
    if ( $('#enable-price-design').find('option:selected').attr('data-val') == 'no' ){
        $('.price-uniq-class').addClass('disable-design-from-pl');
    }
    else {
        $('.price-uniq-class').removeClass('disable-design-from-pl');
    }
    //button add to cart
    if ( $('#enable-button-design').find('option:selected').attr('data-val') == 'no' ){
        $('.button-unique-class').addClass('disable-design-from-pl');
    }
    else {
        $('.button-unique-class').removeClass('disable-design-from-pl');
    }
    
    //quantity
    if ( $('#enable-quantity-design').find('option:selected').attr('data-val') == 'no' ){
        $('.quanity-design-q').addClass('disable-design-from-pl');
        $('#enable-quantity-design').parent().removeClass('disable-design-from-pl');
    }
    else {
        $('.quanity-design-q').removeClass('disable-design-from-pl');
    }
}

$('.category-design').on('change', function(){
    hide_design_setting();
});
hide_design_setting();

    
//save data
$('.save-setting-woo').on('click', function(){ 
    
    let arraySave = {};
    let arraySettingSave = {};
    
    $('.wrap-use-attribute').find('.element-attr-use-q').each(function(){
        let name = $(this).find('span').html();
        let label = $(this).attr('data-label');
        let attr = $(this);
        
        //val array
        let arrayValue = {};
        //standart value attr
        if ( attr.attr('data-style') !='color' && attr.attr('data-style') !='html' && attr.attr('data-style') !='checkboximg' ){
            $(this).find('.value-elem-q').each(function(){
                let nameVal = $(this).html();
                arrayValue[nameVal] = {
                    'tooltip' : $(this).attr('data-tooltip'),
                };
            });
        }
        //color
        if ( attr.attr('data-style') =='color' ){
            $(this).find('.value-elem-q').each(function(){
                let nameVal = $(this).html();
                arrayValue[nameVal] = {
                    'tooltip' : $(this).attr('data-tooltip'),
                    'color-val' : $(this).attr('data-color'),
                };
            });
        }
        //html
        if ( attr.attr('data-style') =='html' ){
            $(this).find('.value-elem-q').each(function(){
                let nameVal = $(this).html();
                arrayValue[nameVal] = {
                    'tooltip' : $(this).attr('data-tooltip'),
                    'html-val' : $(this).attr('data-html'),
                };
            });
        }
        //img
        if ( attr.attr('data-style') =='checkboximg' ){
            $(this).find('.value-elem-q').each(function(){
                let nameVal = $(this).html();
                arrayValue[nameVal] = {
                    'tooltip' : $(this).attr('data-tooltip'),
                    'img-val' : decodeURI( $(this).attr('data-img') ),
                };
            });
        }
        //array attr setting
        arraySave[label] = {
            'style' : {
                'data-style' : $(this).attr('data-style'),
                'name' : name,
                'font-size' : $(this).attr('data-font-size'),
                'font-color' : $(this).attr('data-font-color'),
                'background-color' : $(this).attr('data-background-color'),
                'background-color-a' : $(this).attr('data-background-color-a'),
                'border-width' : $(this).attr('data-border-width'),
                'border-color' : $(this).attr('data-border-color'),
                'border-radius' : $(this).attr('data-border-radius'),
                'font-color-a' : $(this).attr('data-color-activ'),
                'padding' : $(this).attr('data-padding'),
                'size' : $(this).attr('data-size'),
                'disable-design' : $(this).attr('data-disable-d'),
                'width' : $(this).attr('data-width'),
                'height' : $(this).attr('data-height'),
                'show-label' : $(this).attr('data-show-label'),
                'border-color-a' : $(this).attr('data-border-color-a'),
                'font-size-c' : $(this).attr('data-font-size-c'),
                'padding-c' : $(this).attr('data-padding-c'),
                'height-c' : $(this).attr('data-width-c'),
                'width-c' : $(this).attr('data-height-c'),
            },
            'value' : {
                arrayValue
            }
        };
    });
    arraySave = JSON.stringify(arraySave);//conver array to json string
    
    //array setting
    let padding = $('#adm-padding-left').val()+';'+$('#adm-padding-right').val()+';'+$('#adm-padding-top').val()+';'+$('#adm-padding-bottom').val();
    let padding_2 = $('#adm-padding-left-c').val()+';'+$('#adm-padding-right-c').val()+';'+$('#adm-padding-top-c').val()+';'+$('#adm-padding-bottom-c').val();
    let padding_3 = $('#adm-button-padding-left-c').val()+';'+$('#adm-button-padding-right-c').val()+';'+$('#adm-button-padding-top-c').val()+';'+$('#adm-button-padding-bottom-c').val();
    let padding_4 = $('#adm-quantity-padding-left-c').val()+';'+$('#adm-quantity-padding-right-c').val()+';'+$('#adm-quantity-padding-top-c').val()+';'+$('#adm-quantity-padding-bottom-c').val();
    arraySettingSave['setting'] = {
        'style' : {
            'margin-m-attr' : $('#margin-m-attribute').val(),
            'margin-m-name' : $('#margin-m-name').val(),
            'margin-m-value' : $('#margin-m-value').val(),
            'padding' : padding,
            'color-name' : $('#font-color-name-attribute').val(),
            'font-size-name' : $('#font-size-name-attribute').val(),
            'font-weight-name' : $('#font-weight-name-attribute').find('option:selected').attr('data-val'),
            'style-design' : $('#style-block-variable').find('option:selected').attr('data-val'),
            'style-design-c' : $('#style-block-variable-category').find('option:selected').attr('data-val'),
            'margin-m-attr-c' : $('#margin-m-attribute-c').val(),
            'margin-m-name-c' : $('#margin-m-name-c').val(),
            'margin-m-value-c' : $('#margin-m-value-c').val(),
            'padding-c' : padding_2,
            'color-name-c' : $('#font-color-name-attribute-с').val(),
            'font-size-name-c' : $('#font-size-name-attribute-c').val(),
            'font-weight-name-c' : $('#font-weight-name-attribute-c').find('option:selected').attr('data-val'),
            'font-weight-price-c' : $('#font-weight-price-attribute-c').find('option:selected').attr('data-val'),
            'font-size-price-c' : $('#font-size-price-attribute-c').val(),
            'color-price-c' : $('#font-color-price-с').val(),
            'price-indent-c' : $('#price-indent-c').val(),
            'price-align-c' : $('.price-align-q').attr('data-val'),
            'quantity-design' : $('#enable-quantity-design').find('option:selected').attr('data-val'),
            'button-design' : $('#enable-button-design').find('option:selected').attr('data-val'),
            'price-design' : $('#enable-price-design').find('option:selected').attr('data-val'),
            'color-button-c' : $('#font-color-button-с').val(),
            'b-color-button-с' : $('#background-color-button-с').val(),
            'font-weight-button-c' : $('#font-weight-button-attribute-c').find('option:selected').attr('data-val'),
            'font-size-button-c' : $('#font-size-button-attribute-c').val(),
            'button-indent-c' : $('#button-indent-c').val(),
            'button-align-c' : $('.button-align-q').attr('data-val'),
            'padding-button' : padding_3,
            'button-border-w' : $('#button-border-width-c').val(),
            'button-border-c' : $('#border-color-button-с').val(),
            'button-border-r' : $('#button-border-radius-c').val(),
            'color-quantity-с' : $('#font-color-quantity-с').val(),
            'font-size-q-с' : $('#font-size-quantity-с').val(),
            'b-quantity-с' : $('#background-quantity-с').val(),
            'b-c-quantity-с' : $('#border-color-quantity-с').val(),
            'b-w-quantity-с' : $('#quantity-border-width-c').val(),
            'b-r-quantity-с' : $('#quantity-border-radius-c').val(),
            'padding-quantity' : padding_4,
            'max-width-v-cart' : $('#max-width-v-cart').val(),

           
        },
        'setting' : {
            'show-acrhive' : $('#show-archive-block-variable').find('option:selected').attr('data-val'),
            'position-cart' : $('#list-position').find('option:selected').attr('data-val'),
            'position-archive' : $('#list-position-archive').find('option:selected').attr('data-val'),
            'show-stock-zero' : $('#list-show-stock-zero').find('option:selected').attr('data-val'),
            'position-currency' : $('#position-currency-q').find('option:selected').attr('data-val'),
            'show-quantity' : $('#show-quantity-q').find('option:selected').attr('data-val'),
            'change-img' : $('#change-img-q').find('option:selected').attr('data-val'),
            'class-change-img' : $('#class-img-q').val(),
            'responsive-category' : $('#responsive-category').find('option:selected').attr('data-val'), 
            'responsive-cart' : $('#responsive-cart').find('option:selected').attr('data-val'), 
            'responsive-category-hide' : $('#responsive-category-hide').find('option:selected').attr('data-val'), 
            'show-variable-in-related' : $('#show-variable-in-related').find('option:selected').attr('data-val'), 
            'show-variable-in-upsell' : $('#show-variable-in-upsell').find('option:selected').attr('data-val'), 
            'prioritet-cart' : $('#position-prioritet-cart').find('option:selected').attr('data-val'),
            'prioritet-category' : $('#position-prioritet-category').find('option:selected').attr('data-val'),
            'redirect-cart' : $('#redirect-cart-q').find('option:selected').attr('data-val'),
            
        },
        'localization' : {
            'loc-add-cart' : $('#loc-add-cart').val(),
            'loc-select-option' : $('#loc-select-option').val(),
            'loc-option-not-available' : $('#loc-option-not-available').val(),
            'loc-choose-option' :  $('#loc-choose-option').val(),
            'loc-fill-all' :  $('#loc-fill-option').val(),
        }
    }
    //fix setting
    arraySettingSave = JSON.stringify(arraySettingSave);//conver array to json string
    //ajax remove form
    $.ajax({
        type: "POST",
        url: params.ajaxurl,
        data: {
            action: 'save_attr_setting_q',
            nonce_code : params.nonce,
            arraySave: arraySave,
            arraySettingSave : arraySettingSave
            
        },
        success: function( response ) {
            
            $('.saved-lib-q').css({'opacity' : '1', 'z-index' : '1'});
            setTimeout(function(){
                $(".saved-lib-q").css({'opacity' : '0', 'z-index' : '-1'});
            },2000);
            
        },
        error: function (error) {
            
            $('.error-saved-lib-q').css({'opacity' : '1', 'z-index' : '1'});
            setTimeout(function(){
                $(".error-saved-lib-q").css({'opacity' : '0', 'z-index' : '-1'});
            },2000);
            
        }
    });


});

//import export
$('.active-export-button').on('click', function(){
    let val =  $('#import-form-code').val();
    val = val.replace(/\\"/g,'"');
    try {
        val = JSON.parse(val);
        if ( typeof val == 'object'){
            let number = 0;
            if ( typeof val['setting']['style']['style-design'] =='undefined' ) {number++;}
            if ( typeof val['setting']['style']['padding']=='undefined' ) {number++;}
            if ( typeof val['setting']['style']['margin-m-name']=='undefined' ) {number++;}
            if ( typeof val['setting']['style']['margin-m-value']=='undefined' ) {number++;}
            if ( typeof val['setting']['style']['color-name']=='undefined' ) {number++;}
            if ( typeof val['setting']['style']['font-size-name']=='undefined' ) {number++;}
            if ( typeof val['setting']['style']['font-weight-name'] =='undefined' ) {number++;}
            if ( typeof val['setting']['style']['style-design-c']=='undefined' ) {number++;}
            if ( typeof val['setting']['style']['padding-c']=='undefined' ) {number++;}
            if ( typeof val['setting']['style']['margin-m-name-c']=='undefined' ) {number++;}
            if ( typeof val['setting']['style']['margin-m-value-c']=='undefined' ) {number++;}
            if ( typeof val['setting']['style']['color-name-c']=='undefined' ) {number++;}
            if ( typeof val['setting']['style']['margin-m-value-c']=='undefined' ) {number++;}
            if ( typeof val['setting']['style']['font-size-name-c']=='undefined' ) {number++;}
            if ( typeof val['setting']['style']['font-weight-name-c']=='undefined' ) {number++;}
            if ( typeof val['setting']['style']['price-design'] =='undefined' ) {number++;}
            if ( typeof val['setting']['style']['color-price-c']=='undefined' ) {number++;}
            if ( typeof val['setting']['style']['font-size-price-c']=='undefined' ) {number++;}
            if ( typeof val['setting']['style']['font-weight-name-c']=='undefined' ) {number++;}
            if ( typeof val['setting']['style']['price-design']=='undefined' ) {number++;}
            if ( typeof val['setting']['style']['color-price-c']=='undefined' ) {number++;}
            if ( typeof val['setting']['style']['font-size-price-c'] =='undefined' ) {number++;}
            if ( typeof val['setting']['style']['font-weight-price-c'] =='undefined' ) {number++;}
            if ( typeof val['setting']['style']['font-weight-name-c'] =='undefined' ) {number++;}
            if ( typeof val['setting']['style']['price-design'] =='undefined' ) {number++;}
            if ( typeof val['setting']['style']['color-price-c'] =='undefined' ) {number++;}
            if ( typeof val['setting']['style']['font-size-price-c'] =='undefined' ) {number++;}
            if ( typeof val['setting']['style']['font-weight-price-c'] =='undefined' ) {number++;}
            if ( typeof val['setting']['style']['price-indent-c'] =='undefined' ) {number++;}
            if ( typeof val['setting']['style']['color-price-c'] =='undefined' ) {number++;}
            if ( typeof val['setting']['style']['font-size-price-c'] =='undefined' ) {number++;}
            if ( typeof val['setting']['style']['font-weight-price-c'] =='undefined' ) {number++;}
            if ( typeof val['setting']['style']['price-indent-c'] =='undefined' ) {number++;}
            if ( typeof val['setting']['style']['price-align-c'] =='undefined' ) {number++;}
            if ( typeof val['setting']['style']['button-design'] =='undefined' ) {number++;}
            if ( typeof val['setting']['style']['color-button-c'] =='undefined' ) {number++;}
            if ( typeof val['setting']['style']['b-color-button-с'] =='undefined' ) {number++;}
            if ( typeof val['setting']['style']['font-size-button-c'] =='undefined' ) {number++;}
            if ( typeof val['setting']['style']['font-weight-button-c'] =='undefined' ) {number++;}
            if ( typeof val['setting']['style']['button-indent-c'] =='undefined' ) {number++;}
            if ( typeof val['setting']['style']['button-align-c'] =='undefined' ) {number++;}
            if ( typeof val['setting']['style']['padding-button'] =='undefined' ) {number++;}
            if ( typeof val['setting']['style']['button-border-w'] =='undefined' ) {number++;}
            if ( typeof val['setting']['style']['button-border-c'] =='undefined' ) {number++;}
            if ( typeof val['setting']['style']['button-border-r'] =='undefined' ) {number++;}
            if ( typeof val['setting']['style']['quantity-design'] =='undefined' ) {number++;}
            if ( typeof val['setting']['style']['color-quantity-с'] =='undefined' ) {number++;}
            if ( typeof val['setting']['style']['font-size-q-с'] =='undefined' ) {number++;}
            if ( typeof val['setting']['style']['b-quantity-с'] =='undefined' ) {number++;}
            if ( typeof val['setting']['style']['font-size-q-с'] =='undefined' ) {number++;}
            if ( typeof val['setting']['style']['b-w-quantity-с'] =='undefined' ) {number++;}
            if ( typeof val['setting']['style']['padding-quantity'] =='undefined' ) {number++;}
            if ( typeof val['setting']['setting']['show-acrhive'] =='undefined' ) {number++;}
            if ( typeof val['setting']['setting']['position-currency'] =='undefined' ) {number++;}
            if ( typeof val['setting']['setting']['show-quantity'] =='undefined' ) {number++;}
            if ( typeof val['setting']['setting']['position-cart'] =='undefined' ) {number++;}
            if ( typeof val['setting']['setting']['show-stock-zero']=='undefined' ) {number++;}
            if ( typeof val['setting']['setting']['responsive-category']=='undefined' ) {number++;}
            if ( typeof val['setting']['setting']['responsive-category-hide']=='undefined' ) {number++;}
            if ( typeof val['setting']['setting']['responsive-cart']=='undefined' ) {number++;}
            if ( typeof val['setting']['localization']['loc-fill-all']=='undefined' ) {number++;}
            if ( typeof val['setting']['localization']['loc-option-not-available']=='undefined' ) {number++;}
            if ( typeof val['setting']['localization']['loc-select-option']=='undefined' ) {number++;}
            if ( typeof val['setting']['localization']['loc-choose-option']=='undefined' ) {number++;}
            if ( typeof val['setting']['localization']['loc-add-cart']=='undefined' ) {number++;}
            if ( number == 0 ){
                let arraySettingSave = $('#import-form-code').val().replace(/\\"/g,'"') ;
                //ajax remove form
                $.ajax({
                    type: "POST",
                    url: params.ajaxurl,
                    data: {
                        action: 'save_attr_import_setting_q',
                        nonce_code : params.nonce,
                        arraySettingSave: arraySettingSave,
                    },
                    success: function( response ) {
                        $('.error-export-button').css({'display' : 'none'});
                        $('.save-export-button').css({'opacity' : '1', 'z-index' : '1'});
                        setTimeout(function(){
                            $(".save-export-button").css({'opacity' : '0', 'z-index' : '-1'});
                            $('.error-export-button').css({'display' : 'inline-block'});
                        },2000);
                        location.reload();
   
                    },
                    error: function (error) {
                        $('.error-export-button').css({'opacity' : '1', 'z-index' : '1'});
                        setTimeout(function(){
                            $(".error-export-button").css({'opacity' : '0', 'z-index' : '-1'});
                        },2000);
                        
                    }
                });
            }
            else {
                $('.export-form-swap').children().addClass('error-esport-q');
                $('.error-export-button').css({'opacity' : '1', 'z-index' : '1'});
                setTimeout(function(){
                    $(".error-export-button").css({'opacity' : '0', 'z-index' : '-1'});
                },2000);
            }

        }
    } 
    catch (e) {
        $('.export-form-swap').children().addClass('error-esport-q');
        $('.export-form-swap').children().addClass('error-esport-q');
        $('.error-export-button').css({'opacity' : '1', 'z-index' : '1'});
        setTimeout(function(){
            $(".error-export-button").css({'opacity' : '0', 'z-index' : '-1'});
        },2000);
    }
  
});

$('#import-form-code').on('click', function(){
    $('.export-form-swap').children().removeClass('error-esport-q');
});

//select export text
$('.copy-export-button').on('click' , function(){
    $('#export-setting-code').select();
});



//remove attr
$(document).on('click', '.remove-at-q', function(){
    $('.element-attr-use-q').removeClass('remove-el');
    $(this).closest('.element-attr-use-q').addClass('remove-el');
    $('.swap-modal-remove').css('display', 'flex');
});

$(document).on('click', '.yes-remove', function(){
    if ( $('.element-attr-use-q').hasClass('active-edit-q') ){
        $('.wrap-design-attr, .wrap-value-customization').html('');
        $('.wrap-dop-customization').css('display','none');
    }
    else {
        if ( $('.active-edit-q').length == 0 ){
            $('.wrap-design-attr, .wrap-value-customization').html('');
            $('.wrap-dop-customization').css('display','none');
        }
    }
    $('.remove-el').remove();
    $('.swap-modal-remove').css('display', 'none');
    showHelpMessageInAttr();
});

$(document).on('click', '.not-remove', function(){
    $('.swap-modal-remove').css('display', 'none');
});





//close edit panel
$(document).mouseup(function (e){ 
    
    //main window
    if ( ($(".modalbox-admin-panel").css('display')==='flex') && (!$(".modalbox-admin-panel").is(e.target)) && ($(".modalbox-admin-panel").has(e.target).length === 0) )  {
            
        if ( !$(e.target).hasClass('mce-container') && !$(e.target).hasClass('mce-text') && !$(e.target).parent().hasClass('mce-container') && !$(e.target).parent().hasClass('mce-container-body') && !$(e.target).parent().hasClass('mce-grid-cell') && !$(e.target).hasClass('mce-grid-cell') ) {
            $(".modalbox-admin-panel").css('display', 'none');
        } 
    }
    
    //close menu
    if ( $(".swap-modal-remove").css('display')==='flex' && !$(".podtverdit-modal").is(e.target) && $(".podtverdit-modal").has(e.target).length === 0 ){
        $('.swap-modal-remove').css('display', 'none');
    }
});



//auto width field setting
function updateWidthField(){
    $('.wrap-design-setting-attr-q .wrap-design-el').each(function(){ 
        if ( $(this).find('label').length === 0 ){
            if ( $(this).find('.wp-picker-container').length === 0 ){  
                $(this).find('input').css('width' , $(this).find('span').css('width') );
                $(this).find('select').css('width' , $(this).find('span').css('width') );
            }
        }
    });
}

function updateWidthAttrSetting(){
    $('.setting-field-q').each(function(){ 
        if ( $(this).find('label').length === 0 ){
            if ( $(this).find('.wp-picker-container').length === 0 ){
                $(this).find('input').css('width' , $(this).find('span').css('width') );
                $(this).find('select').css('width' , $(this).find('span').css('width') );
            }
        }
    }); 
}


//create window
$('.wrap-setting-qf-woo').on('click', '.help-q' , function(e){
    if( $(e.target).hasClass('help-q') ){
        $('.swap-modal-help-q').remove();
        $(this).append('<div class="swap-modal-help-q"> <div class="modal-help-q"></div> <div class="close-help-q"><i class="fa fa-timesq"></i></div> </div>');
        if ( $(this).hasClass('q1') ){ 
            $('.modal-help-q').html( $('#text-help-1').html() );
            $('.swap-modal-help-q').css({'top' : '-80px'});
        }
        if ( $(this).hasClass('q2') ){ 
            $('.modal-help-q').html( $('#text-help-2').html() );
            $('.swap-modal-help-q').css({'top' : '-80px'});
        }
        if ( $(this).hasClass('q3') ){ 
            $('.modal-help-q').html( $('#text-help-3').html() );
            $('.swap-modal-help-q').css({'top' : '-80px'});
        }
        if ( $(this).hasClass('q4') ){ 
            $('.modal-help-q').html( $('#text-help-4').html() );
            $('.swap-modal-help-q').css({'top' : '-80px', 'width' : '650px'});
        }
        if ( $(this).hasClass('q5') ){ 
            $('.modal-help-q').html( $('#text-help-5').html() );
            $('.swap-modal-help-q').css({'top' : '-80px' });
        }
        if ( $(this).hasClass('q6') ){ 
            $('.modal-help-q').html( $('#text-help-6').html() );
            $('.swap-modal-help-q').css({'top' : '-80px' ,'left' : '-480px'  });
        }
        if ( $(this).hasClass('q7') ){ 
            $('.modal-help-q').html( $('#text-help-7').html() );
            $('.swap-modal-help-q').css({'top' : '-80px', 'width' : '490px' });
        }
        if ( $(this).hasClass('q8') ){ 
            $('.modal-help-q').html( $('#text-help-8').html() );
            $('.swap-modal-help-q').css({'top' : '-80px', 'width' : '490px' });
        }
        if ( $(this).hasClass('q9') ){ 
            $('.modal-help-q').html( $('#text-help-9').html() );
            $('.swap-modal-help-q').css({'top' : '-80px', 'width' : '590px'  });
        }
        if ( $(this).hasClass('q10') ){ 
            $('.modal-help-q').html( $('#text-help-10').html() );
            $('.swap-modal-help-q').css({'top' : '-80px', 'width' : '650px', 'left' : '-480px'  });
        }
        if ( $(this).hasClass('q11') ){ 
            $('.modal-help-q').html( $('#text-help-11').html() );
            $('.swap-modal-help-q').css({'top' : '-80px', 'width' : '550px', 'left' : '-480px'  });
        }
        if ( $(this).hasClass('q12') ){ 
            $('.modal-help-q').html( $('#text-help-12').html() );
            $('.swap-modal-help-q').css({'top' : '-80px' });
        }
        if ( $(this).hasClass('q13') ){ 
            $('.modal-help-q').html( $('#text-help-13').html() );
            $('.swap-modal-help-q').css({'top' : '-80px' });
        }
        if ( $(this).hasClass('q14')  ){ 
            $('.modal-help-q').html( $('#text-help-14').html() );
            $('.swap-modal-help-q').css({'top' : '-80px' });
        }
        if ( $(this).hasClass('q15') ){ 
            $('.modal-help-q').html( $('#text-help-15').html() );
            $('.swap-modal-help-q').css({'top' : '-80px' });
        }

        
        
        $('.not-active-field').removeClass('not-active-field');
    }
});

//close window
$('.wrap-setting-qf-woo').on('click', '.close-help-q' , function(){
    $(this).closest('.swap-modal-help-q').remove();
}); 

//close window 2
$('.wrap-setting-qf-woo').on('click' , function(e){
    if ( $(this).find('.swap-modal-help-q').length > 0 ){
        if ( $(e.target).attr('class')!='swap-modal-help-q' && $(e.target).attr('class')!='modal-help-q' && $(e.target).parent().attr('class')!='modal-help-q' && !$(e.target).hasClass('help-q') && !$(e.target).hasClass('img-help-q')  ){ 
            $('.wrap-setting-qf-woo').find('.swap-modal-help-q').remove();
        }
    }
});

//show help message in attribute
function showHelpMessageInAttr(){
    let num = $('.wrap-use-attribute').find('.element-attr-use-q').length;
    if ( num > 0 && 5 > num ){
        let width = 0;
        $('.wrap-use-attribute').find('.element-attr-use-q').each(function(){
            width = width + Math.round( $(this).css('width').replace(/[^0-9\.]/g, '') );
        });
        if ( width < 220 ){
            $('.wrap-help-attr-2').css('display', 'flex');
        }
        else {
            $('.wrap-help-attr-2').css('display', 'none');
        }
    }
    else {
        $('.wrap-help-attr-2').css('display', 'none');
    }
}
showHelpMessageInAttr();


//update-localization
if ( $('#loc-add-cart').val() == ''){
    $('#loc-add-cart').val( $('#loc-add-cart').prev('span').html() );
}
if ( $('#loc-select-option').val() == ''){
    $('#loc-select-option').val( $('#loc-select-option').attr('placeholder') );
}
if ( $('#loc-option-not-available').val() == ''){
    $('#loc-option-not-available').val( $('#loc-option-not-available').prev('span').html() );
}
if ( $('#loc-choose-option').val() == ''){
    $('#loc-choose-option').val( $('#loc-choose-option').prev('span').html() );
}
if ( $('#loc-fill-option').val() == ''){
    $('#loc-fill-option').val( $('#loc-fill-option').prev('span').html() );
}


//copy sryle
$('.modalbox-admin-panel').on('click', '.copy-qs', function(){
    $('.paste-qs').addClass('active-style');
    
    let string_design = $('#style-attr').find('option:selected').attr('data-val') + ';'+ $('#font-size-c').val() + ';' + $('#font-color-c').val() + ';' + $('#font-color-a').val() + ';' + $('#background-color-c').val() + ';' + $('#background-color-a').val() + ';' + $('#font-border-width-c').val() + ';' + $('#font-border-color-c').val() + ';' + $('#border-color-a').val() + ';' + $('#font-border-radius-c').val() + ';' + $('#admpaddingleft').val() + ';' + $('#admpaddingright').val() + ';' + $('#admpaddingtop').val() + ';' + $('#admpaddingbottom').val() + ';' + $('#size-width-q').val() + ';' + $('#size-height-q').val() + ';' + $('#disable-design').find('option:selected').attr('data-val')  + ';' + $('#font-size-categoty').val() + ';' + $('#admpaddingleft-c').val() + ';' + $('#admpaddingright-c').val() + ';' + $('#admpaddingtop-c').val() + ';' + $('#admpaddingbottom-c').val() + ';' + $('#size-width-q-c').val() + ';' + $('#size-height-q-c').val();
    
    
    $('#copy-style-data').attr('data-style', string_design);
});


$('.modalbox-admin-panel').on('click', '.active-style', function(){
    let array_style_paste = $('#copy-style-data').attr('data-style').split(';');
    //design
    $('#style-attr').find('option').each(function(){
        if ( $(this).attr('data-val') == array_style_paste[0] ){
            $(this).attr('selected', 'selected');
        }
    });
    
    if (  array_style_paste[1] !='undefined' ){
        $('#font-size-c').val(array_style_paste[1]);
    }
    if ( array_style_paste[2] !='undefined' ){
        $('#font-color-c').val(array_style_paste[2]).trigger('change');
    }
    if ( array_style_paste[3] !='undefined' ){
        $('#font-color-a').val(array_style_paste[3]).trigger('change');
    }
    if ( array_style_paste[4] !='undefined' ){
        $('#background-color-c').val(array_style_paste[4]).trigger('change');
    }
    if ( array_style_paste[5] !='undefined' ){
        $('#background-color-a').val(array_style_paste[5]).trigger('change');
    }
    if ( array_style_paste[6] !='undefined' ){
        $('#font-border-width-c').val(array_style_paste[6]);
    }
    if ( array_style_paste[7] !='undefined' ){
        $('#font-border-color-c').val(array_style_paste[7]).trigger('change');
    }
    if ( array_style_paste[8] !='undefined' ){
        $('#border-color-a').val(array_style_paste[8]).trigger('change');
    }
    if ( array_style_paste[9] !='undefined' ){
        $('#font-border-radius-c').val(array_style_paste[9]);
    }
    if ( array_style_paste[10] !='undefined' ){
        $('#admpaddingleft').val(array_style_paste[10]);
    }
    if ( array_style_paste[11] !='undefined' ){
        $('#admpaddingright').val(array_style_paste[11]);
    }
    if ( array_style_paste[12] !='undefined' ){
        $('#admpaddingtop').val(array_style_paste[12]);
    }
    if ( array_style_paste[13] !='undefined' ){
        $('#admpaddingbottom').val(array_style_paste[13]);
    }
    if ( array_style_paste[14] !='undefined' ){
        $('#size-width-q').val(array_style_paste[14]);
    }
    if ( array_style_paste[15] !='undefined' ){
        $('#size-height-q').val(array_style_paste[15]);
    }
    $('#disable-design').find('option').each(function(){
        if ( $(this).attr('data-val') == array_style_paste[16] ){
            $(this).attr('selected', 'selected');
        }
    });
    if ( array_style_paste[17] !='undefined' ){
        $('#font-size-categoty').val(array_style_paste[17]);
    }
    if ( array_style_paste[18] !='undefined' ){
        $('#admpaddingleft-c').val(array_style_paste[18]);
    }
    if ( array_style_paste[19] !='undefined' ){
        $('#admpaddingright-c').val(array_style_paste[19]);
    }
    if ( array_style_paste[20] !='undefined' ){
        $('#admpaddingtop-c').val(array_style_paste[20]);
    }
    if ( array_style_paste[21] !='undefined' ){
        $('#admpaddingbottom-c').val(array_style_paste[21]);
    }
    if ( array_style_paste[22] !='undefined' ){
        $('#size-width-q-c').val(array_style_paste[22]);
    }
    if ( array_style_paste[23] !='undefined' ){
        $('#size-height-q-c').val(array_style_paste[23]);
    }
    
    $('#font-size-c').trigger('keyup');
    
    
   
    
    

    
    
    
});

  
});
})(jQuery);