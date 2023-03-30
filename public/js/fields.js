$(document).ready(function(){

    $('[name*="ar"]').css({'text-align':'end'});
    //change language

    $('body').on('click','.change_lang',function(){

        $lable = $(this);

        $($lable).addClass('active');
        $old_lable = $($lable).siblings('label')[0];
        $($old_lable).removeClass('active');

        $lang = $(this).attr('lang');
        $oldLang = $($old_lable).attr('lang');

        $(`.${$lang}`).removeClass('display_none');

        $(`.${$oldLang}`).addClass('display_none');

        $('.lang').html($lang);

    });

    $('.newImage').on('click',function(){
        $(".newImageButton").click();
    });

    $('body').on('click','.removeGalleryImage',function(){
        span = $(this).closest('span');
        var url = span.data('url');
        if(url){
            $.ajax({
                type : 'post',
                url : url,
                headers: {'X-CSRF-Token': $('input[name="_token"]').val()},    
                data : {_method : 'delete'},
                success : function(data){
                    if(data == 1){
                        alert("Image Removed Successflly!");
                        $(span).remove();
                    }else{
                    alert("Image Cannot be Removed!");
                    }

                },
                error: function(data){
                    alert("Image Cannot be Removed!");
                }
            })
        }
    });

    $('.newImageButton').on('change',function(){
        $('.galleryImages').find('.newImage').remove();
        var fileList = this.files;
        if (fileList && fileList[0]) {
            for (var i = 0; i < fileList.length; i++) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $newImage = $('#galleryImage').clone().attr('id','');
                    $newImage.find('img').attr('src', e.target.result);
                    $newImage.css({'display':'block'});
                    $('.galleryImages').append($newImage);
                }
                reader.readAsDataURL(fileList[i]);
            }
        }
    });

    $('.slugable_ar').on('keyup',function(){
        $val = $(this).val().replace(/ /g,'-');
        $('#slug_ar').val($val);
    });

    $('.slugable_en').on('keyup',function(){
        $val = convertToSlug($(this).val());
        $('#slug_en').val($val);
    });

    function convertToSlug(Text)
    {
        return Text
            .toLowerCase()
            .replace(/ /g,'-')
            .replace(/[^\w-]+/g,'')
            ;
    }


    $('.clinics').on('change',function(){
        $ids = $(this).val();
        $.ajax({
            type : 'get',
            data : {ids:$ids},
            url : '/admin/clinic/related',
            success : function(data){
                doctors = data['doctors'];
                services = data['services'];
                $doctors= $('.doctors').empty();
                $services= $('.services').empty();
                $.each(doctors,function(k,d){
                    console.log(d.title);
                    $doctors.append($('<option>').val(d.id).text(d.title_ar))
                });
                $.each(services,function(k,s){
                    $services.append($('<option>').val(s.id).text(s.name_ar))
                });
            }
        }) 
    });

    $('.active ').closest('ul').css({'display':'block'});
    $('.active ').closest('ul').closest('li').addClass('menu-open');

    $('[name="is_visitor"]').on('change', function(){
        if(!$(this).is(':checked')){
            $('.visitor-field').addClass('display_none');
        }else{
            $('.visitor-field').removeClass('display_none');
        }
    });
    toggleVideo($('input[name=is_video]').is(':checked'))
            
    $('.toggle-group').on('click', function(){
        toggleVideo(!$('input[name=is_video]').is(':checked'))
    });

    function toggleVideo(condition){
        if(condition){
            $('.videos').slideDown();
            $('.photos').slideUp();
        }else{
            $('.videos').slideUp();
            $('.photos').slideDown();
        }
    }

    $("input[type=submit]").parent('div').after(`<label class="disabled-input display_none" style="color:red">*Large images uploaded<label/>`);
    $("body").on("change", "input[type=file]", function () {
       let image = this;
       let submit = $("input[type=submit]"); 
       
       if( this.files[0].size / 1000000 > 5 ){
            $(image).after(`<label class="v-error" style="color:red">*Maximum image size is 5 MB<label/>`);
        }else{
            $(image).siblings(".v-error").remove();
        }

        if($('.v-error').length){
            $(submit).attr('disabled', true);
            $('.disabled-input').removeClass("display_none");
        }else{
            $(submit).attr('disabled', false);
            $('.disabled-input').addClass("display_none");
        }
    });
 });
