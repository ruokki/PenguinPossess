(jQuery)(function($){
    var $gotVolume;
    
    // Gestion de l'étape 1 (Choix de la catégorie)
    $("#step1 .category").on("click", function(){
        var id = $(this).data("id");
        $("#categoryId").val(id);
        $.ajax({
            url: siteUrl + "/user/manageItem",
            type: "POST",
            data: {
                cmd: "getSub",
                category: id
            },
            dataType: "JSON",
            success: function(data) {
                var html = "",
                    item = {};
                
                for(var i in data) {
                    item = data[i];
                    html += 
                        '<div class="category text-center" data-id="' + item.category_id + '">' +
                            '<span class="icon icon-' + item.category_icon + '"></span>' +
                            '<p>' + item.category_name + '</p>' +
                        '</div>';
                }
                $("#step2 > div").html(html);
                changeStep("next");
            }
        });
    });

    // Gestion de l'étape 2 (Choix de la sous catégorie)
    $("#step2").on("click", function(e) {
        var $target = $(e.target);
        
        if($target.hasClass("category") || $target.parents(".category").length > 0) {
            if($target.parents(".category").length > 0) {
                $target = $target.parents(".category");
                $("#subCategoryId").val($target.data("id"));
                $("#subCategoryName").val($target.find("p").text());
                $.ajax({
                    url: siteUrl + "/user/" + (isCollec === true ? "manageCollection" : "manageItem"),
                    type: "POST",
                    data: {
                        cmd: "getCompl",
                        category: $target.find("p").text().toLowerCase()
                    },
                    dataType: "JSON",
                    success: function(data) {
                        changeStep("next");
                        $("#step3 > div > *:not(.dontRemove)").remove();
                        $("#step3 > div").append(data.html);
                        setFloatingLabel();

                        if(typeItem === "wish") {
                            $("#gotVolume").remove();
                        }
                        else {
                            $gotVolume = $("#gotVolume");
                        }
                    }
                });
            }
        }
    });
    
    /**
     * Gestion des diverses étapes du formulaire
     * @param String cmd
     */
    var step = 1;
    function changeStep(cmd, myStep = false) {
        if(cmd === "next") {
            step++;
        }
        else if(cmd === "prev") {
            step--;
        }
        if(cmd === "first") {
            step = 1;
        }
        else if(cmd === "goTo") {
            $("#step" + step).css("left", "-150%");
            step = myStep;
        }

        $("#step" + step).css("left", "0");
        
        if(step > 1) {
            $("#step" + (step - 1)).css("left", "-150%");
        }
        
        manageBreadcrumb();
    }
    
    /**
     * Gestion du fil d'arianne
     */
    function manageBreadcrumb() {
        var labelStep = [
                "Catégorie",
                "Sous catégorie",
                "Informations"
            ],
            html = "";
        for(var i = 0; i < step; i++) {
            html += '<span data-step="' + (i + 1) + '">' + labelStep[i] + "</span>";
        }
        
        $("#breadcrumb").html(html);
    }
    
    $("#breadcrumb").on("click", function(e){
        var $target = $(e.target),
            toStep = $target.data("step");
            
        if(toStep !== undefined && toStep !== step) {
            changeStep("goTo", toStep);
        }
        
    });
    
    // Gestion du champ des volumes d'une collection
    $("body").on("change", function(e){
        var $target = $(e.target);
        if($target.is("#totalCollection") && $gotVolume !== undefined) {
            var nbTome = parseInt($target.val()),
                html = '<label for="allTomes"><input type="checkbox" checked="checked" id="allTomes" /> Tous les tomes</label><br />';
            
            if(nbTome > 0) {
                for(var i = 1; i <= nbTome; i++) {
                    html += '<label for="tome' + i + '"><input type="checkbox" id="tome' + i + '" name="collection[got_tome][' + i + ']" checked="checked" /> Tome ' + i + '</label>';
                }
                $gotVolume.find("div").html(html);
                $gotVolume.show();
                
            }
            else {
                $gotVolume.hide();
            }
        }
    })
    // Gestion du clic sur "Tous les tomes"
    .on("click", function(e){
        var $target = $(e.target);
        if($target.is("#allTomes")) {
            if($target.is(":checked")) {
                $gotVolume.find("[id*='tome']").attr("checked", "checked");
            }
            else {
                $gotVolume.find("[id*='tome']").removeAttr("checked");
            }
        }
    });
    
    // Si on a eu une erreur lors de la création, on va directement à l'étape 3, sinon on va à l'étape 1
    if(entry === false) {
        changeStep("first");
    }
    else {
        changeStep("goTo", 3);
    }
    
    // Gestion de la prévisualisation de l'image
    var reader = new FileReader();
    
    reader.onload = function (e) {
        $('#imgContainer img').attr('src', e.target.result);
    };

    $("#imgItem").on("change", function(){
        var files = this.files;
        
        if(files && files[0]) {
            reader.readAsDataURL(files[0]);
        }
    });
    
    // Gestion de l'ajout/suppression des pistes d'un album
    var trackTemplate = $(
        '<div class="floatingLabel track">' + 
            '<input type="text" name="track[]" value="" />' +
        '</div>'
    );
    
    document.querySelector("body").addEventListener("click", function(e){
        var $target = $(e.target);
        if($target.is("#addTrack")) {
            $target.parents("#manageTrack").before(trackTemplate.clone());
        }
        else if ($target.is("#delTrack")) {
            var allTrack = $target.parents(".compl").find("[name*='track']");
            if(allTrack.length === 1) {
                showAlertBox("Impossible de supprimer la dernière piste", "error");
            }
            else {
                allTrack.last().parent().remove();
            }
        }
    });
   
    if(alert !== null) {
        showAlertBox(alert, type);
    }
});