(jQuery)(function($){
    
    // Chargement des sous-catégories
    document.querySelector("#categoryItem").addEventListener("change", function(){
        $.ajax({
            url: siteUrl + "/user/manageItem",
            type: "POST",
            data: {
                cmd: "getSub",
                category: this.value
            },
            dataType: "JSON",
            success: function(data) {
                $(".compl").remove();
                
                var html = "";
                for(var i in data) {
                    html += '<option value="' + data[i].category_id + '">' + data[i].category_name + '</option>';
                }
                
                $("#subcategoryItem option:not([value=''])").remove();
                $("#subcategoryItem").append(html).val("");
            }
        });
    });
    
    // Chargement du HTML spécifique à une sous-catégorie
    document.querySelector("#subcategoryItem").addEventListener("change", function(){
        var category = $(this).find(":selected").text();
        
        $.ajax({
            url: siteUrl + "/user/manageItem",
            type: "POST",
            data: {
                cmd: "getCompl",
                category: category
            },
            dataType: "JSON",
            success: function(data) {
                $(".compl").remove();
                $(data.html).insertBefore("#buttonWrapper");
                setFloatingLabel();
            }
        });
    });
    
    // Gestion de la prévisualisation de l'image
    var reader = new FileReader();
    
    reader.onload = function (e) {
        $('#imgContainer img').attr('src', e.target.result);
    }

    $("#imgItem").on("change", function(){
        var files = this.files;
        
        if(files && files[0]) {
            reader.readAsDataURL(files[0]);
        }
    });
    
    $("[type='reset']").on("click", function(e){
        e.preventDefault();
        $("input, select, textarea").val("").change();
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