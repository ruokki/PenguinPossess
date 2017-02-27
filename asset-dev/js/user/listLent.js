(jQuery)(function($){
    
    $("table caption").on("click", function(){
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
                    
                }
            },
            Annuler: function(){
                $(this).dialog("close");
            }
        }
    });
    
});