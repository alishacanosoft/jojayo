function convertToSlug(Text)
{
    return Text
        .replace(/^\s+|\s+$/gm, '')
        .toLowerCase()
        .replace(/ /g,'-')
        .replace(/[^\w-]+/g,'')
        ;
}

function callFancyBox(){
    $('.iframe-btn').fancybox({
        'width'		: 900,
        'height'	: 600,
        'type'		: 'iframe',
        'autoScale'    	: false
    });
}

function multipleSelect(selector, placeholder){
    $('#'+selector).select2({
        placeholder: placeholder
    });
}

function MarketColors(id){
    $.ajax({
        method: "GET",
        url: "/colors", //{{ route('colors') }}
        dataType: 'json',
        success: function(response) {
            $.each(response, function(key, value) {
                $('#'+id).append('<option value="'+response[key]['id']+'">'+response[key]['name']+'</option>');
            });
        },
    });
};

function javaAlert(response){
    var type=  response.alert_type;
    switch(type){
        case 'info':
        toastr.info(response.message);
        break;
    case 'success':
        toastr.success(response.message);
        break;
    case 'warning':
        toastr.warning(response.message);
        break;
    case 'error':
    toastr.error(response.message);
    break;
    }
}

function initSelect(id){
    $("#"+id).select2();
}

function multiSelect(id){
    $("#"+id).select2({
        tags: true,
        allowClear: true,
        multiple: true,
        placeholder: 'Select Multiple',
        tokenSeparators: [',', ' ']
    });
}