jQuery(document).ready(function ($) {

    $("#hmis-metabox li.hmis-add-slide").click(function (e) {
        $("#hmis-lightbox-data").lightbox_me({
            centered: true,
            closeSelector : '.hmis-action-cancel',
            zIndex: '10000',
            onLoad: function () {
                $(".hmis-action-insert").attr('value', hmis_data.insert_text);
                $("#hmis-current-slide").val(0);
                $("#hmis-lightbox-data img").attr('src', hmis_data.default_image_url);
                $("#hmis-select-caption").val('');
                $("#hmis-select-url").val('');
            }
        });
        e.preventDefault();
    });
    
    $(document).on('click', '#hmis-metabox li:not(.hmis-add-slide)',function(){
        
        var slideId     = $(this).data('slide');
        var elements    = $(this).find('*');
        var imgUrl      = $(elements).eq(1).val();
        var caption     = $(elements).eq(2).val();
        var url         = $(elements).eq(3).val();
        
        $("#hmis-lightbox-data").lightbox_me({
            centered: true,
            closeSelector : '.hmis-action-cancel',
            zIndex: '10000',
            onLoad: function () {
                $(".hmis-action-insert").attr('value', hmis_data.edit_text);
                $("#hmis-current-slide").val(slideId);
                $("#hmis-lightbox-data img").attr('src', imgUrl);
                $("#hmis-select-caption").val(caption);
                $("#hmis-select-url").val(url);
            }
        });
        
    });
    
    var sortabelItem = $("#hmis-metabox ul");
    $("#hmis-metabox ul").sortable({
        items: "li:not(.hmis-add-slide)",
        update : function(e, ui){
            console.log(ui);
        }
    });
    
    $("#hmis-lightbox-data img").click(function(){
        var target = $(this);
        tb_show('', 'media-upload.php?type=image&TB_iframe=true');
        window.send_to_editor = function(html){
            var imgUrl = $('img', html).attr('src');
            $(target).attr('src', imgUrl);
            tb_remove();
        }
        return false;
    });
    
    $("input.hmis-action-insert").click(function(){
        
        var imgUrl          = $("#hmis-lightbox-data img").attr('src');
        var caption         = $("#hmis-select-caption").val(); 
        var url             = $("#hmis-select-url").val();
        var currentSlide    = $("#hmis-current-slide").val();
        
        if( imgUrl == hmis_data.default_image_url ){
            alert(hmis_data.no_image_select);
        }else{
            if( currentSlide == 0 ){
                //Add new slide
                var lastSlideId = $("li.hmis-add-slide").prev().data('slide');
                lastSlideId++;
                var newElementHtml = '<li class="slide" data-slide="' + lastSlideId + '"><img src="' + imgUrl + '" /><input type="hidden" name="hmis_slide_images[]" value="' + imgUrl + '"/><input type="hidden" name="hmis_slide_captions[]" value="' + caption + '"/><input type="hidden" name="hmis_slide_urls[]" value="' + url + '"/></li>';
                $(newElementHtml).insertBefore('li.hmis-add-slide');
            }else{
                //Edit exists slide
                var slideForEdit = $("li[data-slide='" + currentSlide + "'] *");
                console.log( 'editing' );
                $(slideForEdit).eq(0).attr('src', imgUrl);
                $(slideForEdit).eq(1).val(imgUrl);
                $(slideForEdit).eq(2).val(caption);
                $(slideForEdit).eq(3).val(url);
                
            }
            $("#hmis-lightbox-data").trigger('close');
        }
        
    });
    
    //Functions
    

});