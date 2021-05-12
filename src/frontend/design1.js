jQuery(document).ready(function(){
    let clicks = 0;
    jQuery(".wc-button").on('click', function(e){
        if (clicks%2 === 0) {
            jQuery(this).removeClass('rotateBackward').toggleClass('rotateForward');
            jQuery(".wc-panel").animate({opacity: "toggle",height: "toggle"}, 600);
        } else {
            jQuery(this).removeClass('rotateForward').toggleClass('rotateBackward');
            jQuery(".wc-panel").animate({opacity: "hide",height: "hide"}, 200);
        }
        clicks++;
    });
});