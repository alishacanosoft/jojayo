function convertToSlug(Text)
{
    return Text
        .replace(/^\s+|\s+$/gm, '')
        .toLowerCase()
        .replace(/ /g,'-')
        .replace(/[^\w-]+/g,'')
        ;
}
$(document).ready(function() {
    $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
        e.preventDefault();
        $(this).siblings('a.active').removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });
});
function initSelect(id){
    $("#"+id).select2();
}
$(document).ready(function() {
    if (window.File && window.FileList && window.FileReader) {
        // $(".files").on("change", function(e) {
            $(document).on("change", ".files", function (e) {
                var files = e.target.files,
                        filesLength = files.length;
                //this reffer's to <input type="file" class="files" .. so you need to get closest parent .file-upload
                let div = $(this).closest(".file-upload");
                $(div).find('.pip').remove();
                for (var i = 0; i < filesLength; i++) {
                    var f = files[i]
                    var fileReader = new FileReader();
                    fileReader.onload = (function (e) {
                        var file = e.target;
                        $("<span class=\"pip\">" +
                                "<img class=\"imageThumb\" src=\"" + e.target.result + "\">" +
                                //"<br/><span class=\"remove\"><i class='fa fa-times-circle'></i></span>" +
                                "</span>").insertAfter($(div));
                    });
                    fileReader.readAsDataURL(f);
                }
                $(div).find(".remove").click(function () {
                    $(div).remove();
                });
            });
    } else {
        alert("Your browser doesn't support to File API")
    }
});

function openDialog(title, text){
    $( "#dialog" ).attr('title', title);
    $( "#dialog" ).html('<p>'+text+'</p>');
    $( "#dialog" ).dialog({modal: true});
    $('.ui-dialog-titlebar-close').html('<span>X</span>');
}