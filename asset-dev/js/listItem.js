(jQuery)(function($){
    $(".item .front").on("click", function(e){
        
        // On veut ajouter/enlever la possession d'un objet
        if($(e.target).hasClass("possess")) {
            var $possess = $(e.target)
                cmd = $possess.hasClass("icon-checkbox-checked") ? "del" : "add",
                id = $possess.data("id");
                
            $.ajax({
                type: "POST",
                url: siteUrl + "/home/managePossess",
                data: {
                    cmd: cmd,
                    item: id
                },
                success: function(data){
                    var text = "";
                    if(cmd === "del") {
                        text = "supprimé de";
                        $possess.removeClass("icon-checkbox-checked").addClass("icon-checkbox-unchecked");
                        $possess.prev(".edit").addClass("hidden");
                    }
                    else if (cmd === "add") {
                        text = "ajouté à";
                        $possess.removeClass("icon-checkbox-unchecked").addClass("icon-checkbox-checked");
                        $possess.prev(".edit").removeClass("hidden");
                    }
                    showAlertBox("Item " + text + " votre collection", "success");
                }
            });
        }
        // Si on clique ailleurs que sur un lien, on redirige vers les infos item
        else if(!$(e.target).is("a")) {
            window.location = siteUrl + "/" + $(this).data("href");
        }
        
    });
});