<div class="wc-<?php echo $configs['layouts']['layout'];?>">
    <div class="wc-panel" v-if="all_configs">
		<div class="wc-header">
			<p><?php echo $configs['chat_contents']['chat_header']['title']; ?></p>
			<strong><?php echo $configs['chat_contents']['chat_header']['description']; ?></strong>
		</div>
		<div class="wc-body">	

            <?php foreach($members as $member): ?>
                <a class="wc-list" :number="member.member_number">
                    <div class="wc-img-cont wc-<?php echo esc_html($member['member_status']); ?>">
                        <?php if( !empty($member['member_image_url']) ): ?>
                            <img class="wc-user-img" src="<?php echo esc_url($member['member_image_url']); ?>"/>
                        <?php else: ?>
                            <img class="wc-user-img" src="<?php echo NINJAWHATSAPPCHAT_URL.'public/images/chat/placeholder.png' ?>" />
                        <?php endif; ?>
                    </div>
                    
                    <div class="wc-user-info">
                        <span><?php echo esc_html($member['member_name']); ?></span>
                        <p><?php echo esc_html($member['member_designation']); ?></p>
                    </div>
                </a>
            <?php endforeach; ?>

		</div>
	</div>
	<div class="wc-button">
		
	</div>
</div>