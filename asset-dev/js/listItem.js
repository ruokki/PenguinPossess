(jQuery)(function($){
    $(".item .front").on("click", function(e){
        
        // On veut ajouter/enlever la possession d'un objet
        if($(e.target).hasClass("possess")) {
            var $possess = $(e.target),
                cmd = $possess.hasClass("icon-checkbox-checked") ? "delPossess" : "addPossess",
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
                    if(cmd === "delPossess") {
                        text = "supprimé de";
                        $possess.removeClass("icon-checkbox-checked")
                            .addClass("icon-checkbox-unchecked")
                            .attr("title", "Ajouter à ma collection");
                        $possess.prev(".edit").addClass("hidden");
                    }
                    else if (cmd === "addPossess") {
                        text = "ajouté à";
                        $possess.removeClass("icon-checkbox-unchecked")
                            .addClass("icon-checkbox-checked")
                            .attr("title", "Supprimer de ma collection");
                        $possess.prev(".edit").removeClass("hidden");
                    }
                    showAlertBox("Item " + text + " votre collection", "success");
                }
            });
        }
        // On souhaite emprunter l'item
        else if($(e.target).hasClass("borrow")) {
            var $possess = $(e.target),
                id = $possess.data("id");
                
            if($possess.hasClass("disabled")) {
                showAlertBox("Une demande est déjà en cours pour ce produit", "alert");
            }
            else {
                $.ajax({
                    type: "POST",
                    url: siteUrl + "/home/managePossess",
                    data: {
                        cmd: cmd,
                        item: id
                    },
                    success: function(data){
                        $possess.addClass("disabled");
                        showAlertBox("Demande d'emprunt effectuée", "success");
                    }
                });
            }
        }
        // Si on clique ailleurs que sur un lien, on redirige vers les infos item
        else if(!$(e.target).is("a")) {
            window.location = siteUrl + "/" + $(this).data("href");
        }
        
    });
});