jQuery(document).ready(function(){
    let clicks = 0;
    jQuery(".ninja-floating-button").on('click', function(event){
        event.preventDefault();
        if (clicks%2 === 0) {
            jQuery(this).removeClass('rotateBackward').toggleClass('rotateForward');
            jQuery(".ninja-chat-box").animate({opacity: "toggle",height: "toggle"}, 600);
        } else {
            jQuery(this).removeClass('rotateForward').toggleClass('rotateBackward');
            jQuery(".ninja-chat-box").animate({opacity: "hide",height: "hide"}, 200);
        }
        clicks++;
    });
});