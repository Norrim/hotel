$(document).ready(function(){
    //on cache les listes category et content
    $("#menu_category").parents(".form-group").hide();
    $("#menu_content").parents(".form-group").hide();

    $('body').on('click','#menu_type_0',function(e){
        showCategory();
    });

    $('body').on('click','#menu_type_1',function(e){
        showContent();
    });

    if($('#menu_type_0').is(":checked")){
        showCategory();
    }

    if($('#menu_type_1').is(":checked")){
        showContent();
    }

});

function showCategory() {
    $("#menu_category").parents(".form-group").show();
    $("#menu_content").parents(".form-group").hide();
}

function showContent() {
    $("#menu_category").parents(".form-group").hide();
    $("#menu_content").parents(".form-group").show();
}