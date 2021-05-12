<template>
	<div class="wc-design3">
		<chat-box :all_configs="all_configs" :members="members"></chat-box>
	</div>
</template>

<script>
import ChatBox from './ChatBox'

export default {
    props:['all_configs','members'],
    components:{
		ChatBox
	},
    mounted(){
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
    }
}
</script>

