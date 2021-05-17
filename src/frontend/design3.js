jQuery(document).ready(function(){
    let clicks = 0;
    jQuery(".ninja-floating-button").click(function(event) {
        event.preventDefault();
        if(clicks%2 === 0) {
            jQuery(".ninja-chat-box").removeClass("animated bounceOutRight");
            jQuery(".ninja-chat-box").addClass("animated bounceInRight");
            jQuery(".ninja-chat-box").show();
        }else {
            jQuery(".ninja-chat-box").removeClass("animated bounceInRight");               
            jQuery(".ninja-chat-box").addClass("animated bounceOutRight");
        }
        ++clicks;
    });
});