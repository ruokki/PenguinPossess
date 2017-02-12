(jQuery)(function($){
    
    document.querySelector("#categoryItem").addEventListener("change", function(){
        $.ajax({
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
    
    document.querySelector("#subcategoryItem").addEventListener("change", function(){
        var category = $(this).find(":selected").text();
        category = category.toLowerCase();
        category = category.replace(" ", "");
        category = category.replace("é", "e");
        
        $.ajax({
            type: "POST",
            data: {
                cmd: "getCompl",
                category: category
            },
            dataType: "JSON",
            success: function(data) {
                $(".compl").remove();
                $(data.html).addClass("compl").insertBefore("#submitWrapper");
            }
        });
    });
    
    if(alert !== null) {
        showAlertBox(alert, type);
    }
    
});