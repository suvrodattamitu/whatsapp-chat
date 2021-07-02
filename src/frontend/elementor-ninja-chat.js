jQuery(document).ready(function($){
    let layout = jQuery('.ninja-live-chat').data("layout");
    let clicks = 0;
    jQuery(".ninja-floating-button").on('click', function(event){
        event.preventDefault();
        if( layout === 'design1' ) {
            if (clicks%2 === 0) {
                jQuery(this).removeClass('rotateBackward').toggleClass('rotateForward');
                jQuery(".ninja-chat-box").animate({opacity: "toggle",height: "toggle"}, 600);
            } else {
                jQuery(this).removeClass('rotateForward').toggleClass('rotateBackward');
                jQuery(".ninja-chat-box").animate({opacity: "hide",height: "hide"}, 200);
            }
        } else if( layout === 'design2' ) {
            if( jQuery (this).hasClass('show_hide') ){
                jQuery('.ninja-chat-design2').stop().animate({right:'-280px'},500 );
            }else{
                jQuery('.ninja-chat-design2').stop().animate({right:'0px'},500 );
            } 
            jQuery(this).toggleClass('show_hide');
        } else if( layout === 'design3' ) {
            if(clicks%2 === 0) {
                jQuery(".ninja-chat-box").removeClass("animated bounceOutRight");
                jQuery(".ninja-chat-box").addClass("animated bounceInRight");
                jQuery(".ninja-chat-box").show();
            }else {
                jQuery(".ninja-chat-box").removeClass("animated bounceInRight");               
                jQuery(".ninja-chat-box").addClass("animated bounceOutRight");
            }
        }
        clicks++;
    });
});