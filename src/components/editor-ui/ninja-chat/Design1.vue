<template>
    <div class="wc-design1">
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
    }
}
</script>