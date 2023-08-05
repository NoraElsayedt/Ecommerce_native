// add asterisk

$('input').each(function(){
    if($(this).attr('required')==='required'){
        $(this).after('<span class="star">*</span>')
    }
});

$('.confirm').click(function(){
    return confirm('Are You Sure');
});


$('.livename').keyup(function(){
    $('.livepre  .caption h3').text($(this).val());
})

$('.livedes').keyup(function(){
    $('.livepre  .caption p').text($(this).val());
})

$('.liveprice').keyup(function(){
    $('.livepre  .price').text('$'+$(this).val());
})



$('.loginf h5 span').click(function(){
    $(this).addClass('selected').siblings().removeClass('selected');
    $('.loginf form').hide();
    $('.'+$(this).data('class')).fadeIn(10);
})
