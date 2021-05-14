<template>
	<div class="ninja-chat-design2">
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
			jQuery('.ninja-floating-button').click (function(event){
				event.preventDefault();
				if( jQuery (this).hasClass('show_hide') ){
					jQuery('.ninja-chat-design2').stop().animate({right:'-280px'},500 );
				}else{
					jQuery('.ninja-chat-design2').stop().animate({right:'0px'},500 );
				} 
				jQuery(this).toggleClass('show_hide');
			});
		});
    }
}
</script>