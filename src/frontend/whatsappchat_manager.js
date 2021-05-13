jQuery(document).ready(function(){
    jQuery('.ninja-member-area').on("click",function(){
        var number =  jQuery(this).attr("number");
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            window.open('https://wa.me/'+number, '-blank');  
        }
        else{
            window.open('https://web.WhatsApp.com/send?phone='+number, '-blank'); 
        }
    })
});