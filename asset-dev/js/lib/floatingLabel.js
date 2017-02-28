(jQuery)(function($){
    
    $(".floatingLabel input").on("change", function(){
        if($(this).val() === "") {
            $(this).removeClass("filled");
        }
        else {
            $(this).addClass("filled");
        }
    });
    
});