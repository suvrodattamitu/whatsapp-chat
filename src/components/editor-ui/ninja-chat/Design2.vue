<template>
	<div class="wc-design2">
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
			jQuery('.wc-button').click (function(event){
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
    }
}
</script>