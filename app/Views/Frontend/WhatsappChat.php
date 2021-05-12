<?php 
    // echo '<pre>';
    //     var_dump($members);
    //     die();
    // echo '</pre>';
?>

<div class="wc-<?php echo $configs['layout'];?>">
    <div class="wc-panel" v-if="all_configs">
		<div class="wc-header">
			<p><?php echo $configs['chat_contents']['chat_header']['title']; ?></p>
			<strong><?php echo $configs['chat_contents']['chat_header']['description']; ?></strong>
		</div>
		<div class="wc-body">	

            <?php foreach($members as $member): ?>
                <a class="wc-list" :number="member.member_number">
                    <div class="wc-img-cont" class="wc-<?php echo esc_html($member['member_status']); ?>">
                        <img class="wc-user-img" src="assets_url+'/images/chat/profile_01.jpg'"/>
                    </div>
                    <div class="wc-user-info">
                        <span><?php echo esc_html($member['member_name']); ?></span>
                        <p><?php echo esc_html($member['member_designation']); ?></p>
                    </div>
                </a>
            <?php endforeach; ?>

		</div>
	</div>
	<div class="wc-button wc-right-bottom">
		
	</div>
</div>