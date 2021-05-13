jQuery(document).ready(function(){
    jQuery('.ninja-floating-button').click (function(event){
        event.preventDefault();
        if( jQuery (this).hasClass('inOut') ){
            jQuery('.wc-design2').stop().animate({right:'-280px'},500 );
        }else{
            jQuery('.wc-design2').stop().animate({right:'0px'},500 );
        } 
        jQuery(this).toggleClass('inOut');
        return false;
    });
});