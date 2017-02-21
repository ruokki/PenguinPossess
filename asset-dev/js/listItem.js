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
                cmd = "addBorrow",
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
                    dataType: "JSON",
                    success: function(data){
                        var possessors = data.possessors;
                        
                        if(data.created === true) {
                            $possess.addClass("disabled");
                            showAlertBox("Demande d'emprunt effectuée auprès de " + possessors[0].split("|")[1], "success");
                        }
                        else {
                            var html = "";
                            var tmp = [];
                            for(var i in possessors) {
                                tmp = possessors[i].split("|");
                                html += 
                                    '<div class="user active" data-id="' + tmp[0] + '" data-item="' + id + '">' +
                                        '<img src="' + baseUrl + 'asset/default-user.png' + '" />' +
                                        '<p class="text-center">' + tmp[1] + '</p>' +
                                    '</div>';
                            }

                            $modalBorrow.find(".listUser .user").remove();
                            $modalBorrow.find(".listUser").prepend(html);
                            $modalBorrow.dialog("open");
                        }
                    }
                });
            }
        }
        // Si on clique ailleurs que sur un lien, on redirige vers les infos item
        else if(!$(e.target).is("a")) {
            window.location = siteUrl + "/" + $(this).data("href");
        }
    });
    
    var $modalBorrow = $("#modalBorrow");
    $modalBorrow.dialog({
        title: "Demande d'emprunt",
        modal: true,
        width: 626,
        autoOpen: false,
        buttons: {
            Valider: function() {
                var users = [],
                    selected = $(this).find(".user.active"),
                    item = selected.first().data("item");
                $(this).find(".user.active").each(function(idx, elem){
                    users.push($(elem).data("id"));
                });
                $(this).dialog("close");
                
                $.ajax({
                    type: "POST",
                    url: siteUrl + "/home/managePossess",
                    data: {
                        cmd: "createBorrow",
                        item: item,
                        users: users
                    },
                    success: function(data){
                        showAlertBox("Demande d'emprunt effectuée auprès des utilisateurs sélectionnés", "success");
                    }
                });
            },
            Annuler: function() {
                $(this).dialog("close");
            }
        }
    }).on("click", function(e){
        if($(e.target).parents(".user").length > 0) {
            $(e.target).parents(".user").toggleClass("active");
        }
    });
});