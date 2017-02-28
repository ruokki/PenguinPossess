(jQuery)(function($){
    
    $("table caption").on("click", function(){
        $modalRuleBorrow.dialog("option", "title", $(this).find(".title").text());
        $modalRuleBorrow.dialog("open");
    });
    
    // On accepte la demande de prêt
    $(".accept").on("click", function(){
        $.ajax({
            url: siteUrl + "/user/lent",
            type: "POST",
            data: {
                cmd: "accept",
                idBorrow: $(this).parents("tr").data("id")
            },
            success: function(data) {
                if(data === "ERROR") {
                    showAlertBox("Erreur lors de la validation de l'emprunt", "error");
                }
                else {
                    window.location.reload();
                }
            }
        });
    });
    
    // On refuse la demande de prêt
    $(".deny").on("click", function(){
        $("#idDemandeDeny").val($(this).parents("tr").data("id"));
        $modalJustifDeny.dialog("open");
    });
    
    // L'item a été transmis au demandeur
    $(".given").on("click", function(){
        $("#idBorrowBegin").val($(this).parents("tr").data("id"));
        $modalBorrowBegin.dialog("open");
    });
    
    // Affichage de la date prévisuonnelle de rendu
    $("#nbJourLend").on("change", function(){
        var value = $(this).val();
        
        if($.trim(value) === "" || parseInt(value) === 0) {
            value = 15;
            $(this).val(value);
        }
        
        var today = new Date(),
            endBorrow = new Date(today.getTime() + value * 24 * 60 * 60 * 1000);
        
        var day = endBorrow.getDate(),
            month = endBorrow.getMonth() + 1,
            year = endBorrow.getFullYear();
        $("#modalBorrowBegin p > span").text((day < 10 ? "0" + day : day) + "/" + (month < 10 ? "0" + month : month) + "/" + year);
    });
    $("#nbJourLend").change();
    
    // L'item a été rendu à son propriétaire
    $(".stop").on("click", function(){
        $("#idBorrowEnd").val($(this).parents("tr").data("id"));
        $modalConfirmEnd.dialog("open");
    });
    
    // Modification de la date de fin du prêt
    $(".renew").on("click", function(){
        $("#idBorrowRenew").val($(this).parents("tr").data("id"));
        $modalRenewBorrow.find("p > span").text($(this).data("old"));
        $modalRenewBorrow.dialog("open");
    });
    
    // Demande de rallonge
    $(".askRenew").on("click", function(){
        $("#idBorrowRenew").val($(this).parents("tr").data("id"));
        $modalRenewBorrow.find("p > span").text($(this).data("old"));
        $modalRenewBorrow.dialog("open");
    });
    
    // Une rallonge a été demandée par l'emprunteur
    $(".seeRenew").on("click", function(){
        $("#idBorrowRenewAsked").val($(this).parents("tr").data("id"));
        $modalSeeRenew.find(".old").text($(this).data("old"));
        $modalSeeRenew.find(".new").text($(this).data("new"));
        $modalSeeRenew.dialog("open");
    });
    
    // Ajout d'un datepicker
    $("#newEndDate").datepicker({
        minDate: 0,
        dateFormat: "dd/mm/yy"
    });
    
    // Modal d'information concernant le fdonctionnement des prêts
    var $modalRuleBorrow = $("#modalRuleBorrow");
    $modalRuleBorrow.dialog({
        title: "Fonctionnement des prêts",
        autoOpen: false,
        modal: true,
        minWidth: 700,
        buttons: {
            OK: function() {
                $(this).dialog("close");
            }
        }
    });
    
    // Modal de justification du refus
    var $modalJustifDeny = $("#modalJustifDeny");
    $modalJustifDeny.dialog({
        title: "Refus d'un prêt",
        modal: true,
        autoOpen: false,
        buttons: {
            Valider: function() {
                var id = $("#idDemandeDeny").val(),
                    textDeny = $("#textDeny").val();
                    
                $.ajax({
                    url: siteUrl + "/user/lent",
                    type: "POST",
                    data: {
                        cmd: "deny",
                        idBorrow: id,
                        motive: textDeny
                    },
                    success: function(data) {
                        if(data === "ERROR") {
                            showAlertBox("Erreur lors de l'enregistrement du refus", "error");
                        }
                        else {
                            window.location.reload();
                        }
                    }
                });
            },
            Annuler: function() {
                $(this).dialog("close");
            }
        }
    });
    
    // Modal de début effectif du prêt
    var $modalBorrowBegin = $("#modalBorrowBegin");
    $modalBorrowBegin.dialog({
        title: "Prêt effectif",
        modal: true,
        autoOpen: false,
        buttons: {
            Valider: function() {
                var nbJour = $("#nbJourLend").val();
                if($.trim(nbJour) !== "" && parseInt(nbJour) === 0) {
                    showAlertBox("Impossible de faire un prêt de 0 jours", "error");
                }
                else {
                    $.ajax({
                        url: siteUrl + "/user/lent",
                        type: "POST",
                        data: {
                            cmd: "given",
                            idBorrow: $("#idBorrowBegin").val(),
                            length: nbJour
                        },
                        success: function (data) {
                            if (data === "ERROR") {
                                showAlertBox("Erreur lors de la validation de l'emprunt", "error");
                            } else {
                                window.location.reload();
                            }
                        }
                    });
                }
            },
            Annuler: function(){
                $(this).dialog("close");
            }
        }
    });
    
    // Modal de confirmation de rendu
    var $modalConfirmEnd = $("#modalConfirmEnd");
    $modalConfirmEnd.dialog({
        title: "Confirmation de fin",
        modal: true,
        autoOpen: false,
        buttons: {
            Oui: function() {
                $.ajax({
                    url: siteUrl + "/user/lent",
                    type: "POST",
                    data: {
                        cmd: "stop",
                        idBorrow: $("#idBorrowEnd").val()
                    },
                    success: function(data) {
                        if(data === "ERROR") {
                            showAlertBox("Erreur lors de l'arrêt du prêt", "error");
                        }
                        else {
                            window.location.reload();
                        }
                    }
                });
            },
            Non: function() {
                $(this).dialog("close");
            }
        }
    });
    
    // Modal de modification de la date de fin
    var $modalRenewBorrow = $("#modalRenewBorrow");
    $modalRenewBorrow.dialog({
        title: "Modification de la date de fin",
        modal: true,
        autoOpen: false,
        buttons: {
            Valider: function() {
                var newDate = $("#newEndDate").val();
                
                if(newDate.match(/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/) === null) {
                    showAlertBox("Le format de la date est jj/mm/aaaa");
                }
                else {
                    $.ajax({
                        url: siteUrl + "/user/lent",
                        type: "POST",
                        data: {
                            cmd: $("#cmdRenew").val(),
                            idBorrow: $("#idBorrowRenew").val(),
                            newDate: $("#newEndDate").val()
                        },
                        success: function (data) {
                            if (data === "ERROR") {
                                showAlertBox("Erreur lors de la modification du prêt", "error");
                            }
                            else {
                                window.location.reload();
                            }
                        }
                    });
                }
            },
            Annuler: function() {
                $(this).dialog("close");
            }
        }
    });
    
    // Modal de modification de la date de fin
    var $modalSeeRenew = $("#modalSeeRenew");
    $modalSeeRenew.dialog({
        title: "Demande de rallonge",
        modal: true,
        autoOpen: false,
        buttons: {
            Accepter: function() {
                $.ajax({
                    url: siteUrl + "/user/lent",
                    type: "POST",
                    data: {
                        cmd: "acceptRenew",
                        idBorrow: $("#idBorrowRenewAsked").val()
                    },
                    success: function(data) {
                        if(data === "ERROR") {
                            showAlertBox("Erreur lors de la modification du prêt", "error");
                        }
                        else {
                            window.location.reload();
                        }
                    }
                });
            },
            Refuser: function() {
                $.ajax({
                    url: siteUrl + "/user/lent",
                    type: "POST",
                    data: {
                        cmd: "denyRenew",
                        idBorrow: $("#idBorrowRenewAsked").val()
                    },
                    success: function(data) {
                        if(data === "ERROR") {
                            showAlertBox("Erreur lors de la modification du prêt", "error");
                        }
                        else {
                            window.location.reload();
                        }
                    }
                });
            },
            Annuler: function() {
                $(this).dialog("close");
            }
        }
    });
    
});