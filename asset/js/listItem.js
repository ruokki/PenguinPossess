(jQuery)(function($){
    
    $(".item .front, #item .category").on("click", function(e){
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
                dataType: "JSON",
                success: function(data){
                    $(e.target).parents(".actionItem").html(data.html);
                    showAlertBox("Item " + (cmd === "delPossess" ? "supprimé de" : "ajouté à") + " votre collection", "success");
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
                            showAlertBox("Demande d'emprunt effectuée auprès de " + possessors, "success");
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
        // On souhaite rendre l'item empruntable/non-empruntable
        else if($(e.target).hasClass("letBorrow")) {
            var $letBorrow = $(e.target),
                cmd = $letBorrow.hasClass("icon-unlocked") ? "stopBorrow" : "letBorrow",
                id = $letBorrow.data("id");
                
            $.ajax({
                type: "POST",
                url: siteUrl + "/home/managePossess",
                data: {
                    cmd: cmd,
                    item: id
                },
                success: function(data){
                    var text = "";
                    if(cmd === "letBorrow") {
                        text = "disponible pour un prêt";
                        $letBorrow.removeClass("icon-lock")
                            .addClass("icon-unlocked")
                            .attr("title", "Prêt possible");
                    }
                    else if (cmd === "stopBorrow") {
                        text = "indisponible pour un prêt";
                        $letBorrow.removeClass("icon-unlocked")
                            .addClass("icon-lock")
                            .attr("title", "Prêt interdit");
                    }
                    showAlertBox("Item " + text, "success");
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
                var $selected = $(this).find(".user.active"),
                    item = $selected.first().data("item"),
                    user = $selected.data("id"),
                    name = $selected.find("p").text();

                if($selected.length === 0) {
                    showAlertBox("Veuillez sélectionner l'utilisateur auprès duquel faire la demande", "error");
                }
                else {
                    $(this).dialog("close");
                    $.ajax({
                        type: "POST",
                        url: siteUrl + "/home/managePossess",
                        dataType: "JSON",
                        data: {
                            cmd: "createBorrow",
                            item: item,
                            user: user
                        },
                        success: function(data){
                            if(data.error === true) {
                                showAlertBox("Une demande est déjà en cours auprès de " + name, "error");
                            }
                            else {
                                showAlertBox("Demande d'emprunt effectuée auprès de " + name, "success");
                            }
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