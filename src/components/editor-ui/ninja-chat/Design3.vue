<template>
	<div class="ninja-chat-design3">
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
            jQuery(".ninja-floating-button").click(function() {
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
    }
}
</script>

