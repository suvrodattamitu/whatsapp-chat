jQuery(document).ready(function(){
    let clicks = 0;
    jQuery(".wc-button").click(function() {
        if(clicks%2 === 0) {
            jQuery(".wc-panel").removeClass("animated bounceOutRight");
            jQuery(".wc-panel").addClass("animated bounceInRight");
            jQuery(".wc-panel").show();
        }else {
            jQuery(".wc-panel").removeClass("animated bounceInRight");               
            jQuery(".wc-panel").addClass("animated bounceOutRight");
        }
        ++clicks;
    });
});