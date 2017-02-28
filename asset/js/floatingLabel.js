(jQuery)(function($){
    
    $(".floatingLabel").each(function(){
        var $parent = $(this);
        $(this).find("input").on("change", function(){
            if($(this).val() === "") {
                $parent.removeClass("filled");
            }
            else {
                $parent.addClass("filled");
            }
        });
    });
    
});