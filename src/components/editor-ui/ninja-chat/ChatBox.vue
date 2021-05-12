<template>
	<div class="wc-panel" v-if="all_configs">
		<div class="wc-header">
			<p>{{ all_configs.chat_contents.chat_header.title }}</p>
			<strong>{{ all_configs.chat_contents.chat_header.description }}</strong>
		</div>
		<div class="wc-body">	

			<a class="wc-list" :number="member.member_number" v-for="(member,index) in members" :key="index">
				<div class="wc-img-cont" :class="'wc-'+member.member_status">
					<img class="wc-user-img" :src="assets_url+'/images/chat/profile_01.jpg'"/>
				</div>
				<div class="wc-user-info">
					<span>{{ member.member_name }}</span>
					<p>{{ member.member_designation }}</p>
				</div>
			</a>
			
		</div>
	</div>
	<div class="wc-button wc-right-bottom">
		<div id="ninja-whatsapp" class="whatsapp fa fa-whatsapp"></div>
	</div>
</template>

<script type="text/babel">
export default {
	props:['all_configs','members'],
	data() {
		return {
			assets_url: window.NinjaWhatsappAdmin.assets_url
		}
	},
	mounted() {
		jQuery(document).ready(function(){
			jQuery('.wc-list').on("click",function(){
				var number =  jQuery(this).attr("number");
				var message =  jQuery(this).attr("message");
				if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
					window.open('https://wa.me/'+number, '-blank');  
				}
				else{
					window.open('https://web.WhatsApp.com/send?phone='+number, '-blank'); 
				}
			})
		});
	}
}
</script>