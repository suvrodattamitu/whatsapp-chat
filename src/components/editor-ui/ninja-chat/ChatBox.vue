<template>
	<div class="ninja-chat-box" v-if="all_configs">
		<div class="ninja-chat-header">
			<p>{{ all_configs.chat_contents.chat_header.title }}</p>
			<strong>{{ all_configs.chat_contents.chat_header.description }}</strong>
		</div>
		<div class="ninja-chat-body">
			<a class="ninja-member-area" :number="member.member_number" v-for="(member,index) in members" :key="index">
				<div class="ninja-avatar-container" :class="'ninja-member-status-'+member.member_status">
					<img v-if="member.member_image_url" class="ninja-member-avatar" :src="member.member_image_url"/>
					<img v-else class="ninja-member-avatar" :src="assets_url+'/images/chat/placeholder.png'"/>
				</div>
				<div class="ninja-member-details">
					<span>{{ member.member_name }}</span>
					<p>{{ member.member_designation }}</p>
				</div>
			</a>
		</div>
	</div>
	<div class="ninja-floating-button show_hide">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 58.18 43.64" width="32" height="32" class="ninja-svg-icon">
            <g id="Layer_2" data-name="Layer 2" style="fill:#095E54">
                <g id="Layer_1-2" data-name="Layer 1" style="fill:#095E54">
                    <path class="wpsr-fm-bubble-btn-svg-path-1" d="M52.73,0a5.26,5.26,0,0,1,3.86,1.59,5.26,5.26,0,0,1,1.59,3.86V38.18a5.43,5.43,0,0,1-5.45,5.46H5.45a5.26,5.26,0,0,1-3.86-1.59A5.27,5.27,0,0,1,0,38.18V5.45A5.26,5.26,0,0,1,1.59,1.59,5.26,5.26,0,0,1,5.45,0Zm0,5.45H5.45v4.66q4,3.2,15.35,12.05a9.64,9.64,0,0,0,1.59,1.42,29.18,29.18,0,0,0,2.38,1.82c.53.34,1.23.74,2.11,1.19a4.9,4.9,0,0,0,2.21.68,4.94,4.94,0,0,0,2.22-.68c.87-.45,1.57-.85,2.1-1.19s1.32-.95,2.39-1.82a10.22,10.22,0,0,0,1.59-1.42q11.36-8.86,15.34-12ZM5.45,38.18H52.73V17.05q-4,3.18-11.93,9.43a14.45,14.45,0,0,0-1.65,1.36c-.95.84-1.69,1.44-2.22,1.82s-1.29.85-2.27,1.42a13.26,13.26,0,0,1-2.84,1.25,9.55,9.55,0,0,1-2.73.4,10,10,0,0,1-2.78-.4A10.47,10.47,0,0,1,23.47,31q-1.42-.9-2.22-1.47T19,27.78a17,17,0,0,0-1.64-1.3q-8-6.26-11.94-9.43Z"/>
                </g>
            </g>
        </svg>
	</div>
</template>

<script type="text/babel">
export default {
	props:['all_configs','members'],
	data() {
		return {
			assets_url: window.NinjaLiveAdmin.assets_url
		}
	},
	mounted() {
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
	}
}
</script>