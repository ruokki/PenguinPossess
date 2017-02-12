/**
 * Affichage d'une petite fenêtre d'alert qui s'estompe après un certain temps
 * @param {String} text
 * @param {String} type
 */
function showAlertBox(text, type) {
    var $alert = $('<div id="alertBox" class="' + type + '">' + text + '</div>'),
        duration = 2000;
    
    $alert.hide();
    $("body").append($alert);
    $alert.fadeIn(400, function(){
        setTimeout(function(){
            $alert.fadeOut(400, function(){
                $alert.remove();
            });
        }, duration);
    });
    
}