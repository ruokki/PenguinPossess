(jQuery)(function($){
    
    setFloatingLabel();
    
});

function setFloatingLabel() {
    $(".floatingLabel :input").off(".floatingLabel").on("change.floatingLabel", function() {
        var value = $(this).val();
        console.log(value);
        if(value === "" || value === null) {
            $(this).removeClass("filled");
        }
        else {
            $(this).addClass("filled");
        }
    }).change();
}