(jQuery)(function($){
    
    var $mainMenu = $("#mainMenu"),
        currentMenu = $("#mainMenu .active").text();
    
    $("#currenttMenu").text(currentMenu);
    
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
    
    // Gestion du champ de recherche
    var cache = {};
    $("#searchItem").autocomplete({
        source: function(request, response) {
            var term = request.term;
            if(term in cache) {
                response(cache[term]);
                return;
            }
            
            $.ajax({
                url: siteUrl + "/home/search",
                type: "POST",
                data: {
                    "item_name": term
                },
                dataType: "JSON",
                beforeSend: function() {
                    
                },
                complete: function() {
                    
                },
                success: function(data) {
                    console.log(data);
                    cache[term] = data.result;
                    response(data.result);
                },
                error: function() {
                    
                }
            });
        },
        select: function(event, ui) {
            window.location = siteUrl + "/home/item/" + ui.item.item_id;
        },
        position: {
            my: "right top",
            at: "right bottom"
        }
    }).autocomplete("instance")._renderItem = function(ul, item) {
        return $("<li>").append(
            '<div>' + 
                '<div class="img float-left">' + 
                    '<img src="' + baseUrl+ 'asset/userfile/img/' + item.category_id + '/' + item.subcategory_id + '/' + item.item_img + '">' +
                '</div>' +
                '<div class="info float-left">' +
                    '<p>' + item.item_name + '</p>' +
                    '<p>' + item.main_category + '</p>' +
                    '<p>' + item.sub_category + '</p>' +
                    '<p>' + item.item_creator + '</p>' +
                '</div>' +
                '<div class="clearfix"></div>' +
            '</div>'
        ).appendTo(ul);
    };
});
