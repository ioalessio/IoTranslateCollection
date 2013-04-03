

$('body').on('click', '.translate_content .translate_add', function() {

    
    var el = $(this).closest('.translate_content');
    var div =  $("#"+$("#"+el.attr('data-prototype-div')).attr('id'));
   console.log(div);

    var prototype = div.attr('data-prototype');
    console.log(prototype);
    var locale = el.attr('data-locale');
    var newForm = prototype.replace(/__locale__label__/g, locale);    
    var newForm = newForm.replace(/__locale__/g, locale);    
    el.html(newForm);
    
    $("#"+$("#"+el.attr('data-prototype-div')).attr('id')+"_"+locale+"_locale").val(locale);
    
});


