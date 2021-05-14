<template>
    <div class="ninja-chat-design1">
        <chat-box :all_configs="all_configs" :members="members"></chat-box>
    </div>
</template>

<script type="text/babel">
import ChatBox from './ChatBox'

export default {
    props:['all_configs','members'],
    components:{
		ChatBox
	},
    mounted() {
        jQuery(document).ready(function(){
            let clicks = 0;
            jQuery(".ninja-floating-button").on('click', function(e){
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
    }
}
</script>