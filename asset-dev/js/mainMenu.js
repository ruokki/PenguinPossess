(jQuery)(function($){
    
    var currentMenu = $("#mainMenu .active").text();
    
    $("#currenttMenu").text(currentMenu);
    
    // Gestion des sous-menus
    $("#mainMenu .menu > a").on("click", function(e){
        if($(this).siblings(".submenu").length !== 0) {
            e.preventDefault();
        }

        var $parent = $(this).parent();

        if($parent.hasClass("open")) {
            $parent.removeClass("open");
        }
        else {
            $("#mainMenu .open").removeClass("open");
            $parent.addClass("open");
        }
    });
    
    // Mise en place des tooltips custom
    $(document).tooltip();
    
    
    // Fermeture de la liste des erreurs
    $("#closeError").on("click", function(){
        $(this).parent().fadeOut(350, function(){
            $(this).remove();
        });
    });
});