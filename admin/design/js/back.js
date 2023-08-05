// add asterisk

$('input').each(function(){
    if($(this).attr('required')==='required'){
        $(this).after('<span class="star">*</span>')
    }
});

$('.confirm').click(function(){
    return confirm('Are You Sure');
});


$('.childlink').hover(function(){
$(this).find('.showdelete').fadeIn();
},function(){
    $(this).find('.showdelete').fadeOut();
});