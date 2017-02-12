(jQuery)(function($){
    
    var $mainMenu = $("#mainMenu");
    
    // Affichage du menu principal
    $("#getMenu").on("click", function(e){
        e.stopImmediatePropagation();
        $mainMenu.toggleClass("show");
    });
    
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
    
    // Fermeture du menu au clic sur la fenêtre
    $(window).on("click", function(e) {
        if($(e.target).parents("#mainMenu").length === 0) {
            $mainMenu.removeClass("show").find(".open").removeClass("open");
        }
    });
});