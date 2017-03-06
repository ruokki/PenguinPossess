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

                    if(data.error && data.error === true) {
                        showAlertBox(data.text, "error");
                    }
                    else {
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
                                    '<div class="user" data-id="' + tmp[0] + '" data-item="' + id + '">' +
                                        '<img src="' + baseUrl + 'asset/default-user.png' + '" />' +
                                        '<p class="text-center">' + tmp[1] + '</p>' +
                                    '</div>';
                            }

                            $modalBorrow.find(".listUser .user").remove();
                            $modalBorrow.find(".listUser").prepend(html);
                            $modalBorrow.find(".listUser .user").first().find(":first-child").click();
                            $modalBorrow.dialog("open");
                        }
                    }
                }
            });
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
                    names = [],
                    selected = $(this).find(".user.active"),
                    item = selected.first().data("item");
                $(this).find(".user.active").each(function(idx, elem){
                    users.push($(elem).data("id"));
                    names.push($(elem).find("p").text());
                });

                if(users.length === 0) {
                    showAlertBox("Veuillez sélectionner l'utilisateur aurpès duquel faire la demande", "error");
                }
                else {
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
                            showAlertBox("Demande d'emprunt effectuée auprès " + (names.length === 1 ? "de " + names.join(", ") : "des utilisateurs concernés"), "success");
                        }
                    });
                }
            },
            Annuler: function() {
                $(this).dialog("close");
            }
        }
    }).on("click", function(e){
        if($(e.target).parents(".user").length > 0) {
            $modalBorrow.find(".user").removeClass("active");
            $(e.target).parents(".user").addClass("active");
        }
    });
});