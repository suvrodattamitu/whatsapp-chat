<?php 

namespace NinjaLive\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use \Elementor\Scheme_Typography as Scheme_Typography;
use Elementor\Group_Control_Background;
use \Elementor\Scheme_Color;
use \Elementor\Utils;

if (!defined('ABSPATH')) {
    exit;
}

class ChatWidget extends Widget_Base {
    public function get_name() 
    {
        return 'ninja-live-chat';
    }

    public function get_title() 
    {
        return __( 'Live Chat', 'ninjawhatsappchat' );
    }

    public function get_icon() 
    {
        return 'eicon-form-horizontal';
    }
	
	public function get_categories() {
        return ['general'];
    }

    public function get_keywords() 
    {
        return [
            'livechat',
            'live chat',
            'chat',
            'message',
        ];
    }

    public function get_style_depends() {
        return ['ninjalivechat'];
    }

    public function get_script_depends() {
        return ['ninjalivechat', 'ninjalivechat_manager'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_fizzy_popup',
            [
                'label' => __('Live Chat', 'fizzypopups'),
            ]
        );

        $this->add_control(
            'nlc_layout',
            [
                'label' => esc_html__('Ninja Chats', 'fizzypopups'),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'options' => ElementorHelper::getChats(),
                'default' => 'design2',
            ]
        );

        $this->add_control(
			'nlc_header_title',
			[
				'label'			=> __('HEADER TITLE', 'ninjalivechat'),
				'type'			=> Controls_Manager::TEXTAREA,
				'default'		=> __('Need Help?','ninjalivechat'),
			]
		);

        $this->add_control(
			'nlc_header_description',
			[
				'label'			=> __('HEADER DESCRIPTION', 'ninjalivechat'),
				'type'			=> Controls_Manager::TEXTAREA,
				'default'		=> __('Ask us anything!','ninjalivechat'),
			]
		);

        $this->end_controls_section();

        //members
        $this->start_controls_section(
			'live_chat_member_section',
			[
				'label' => __( 'Members', 'ninjalivechat' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'nlc_member_number', [
                'label' => __( 'Member Number', 'ninjalivechat' ),
                'type' => Controls_Manager::TEXT,
                'default' => '0991122334',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'nlc_member_image', [
                'label' => __( 'Choose Image', 'ninjalivechat' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
            ]
        );

        $repeater->add_control(
            'nlc_member_name', [
                'label' => __( 'Name', 'ninjalivechat' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'John Doe' , 'ninjalivechat' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'nlc_member_designation', [
                'label' => __( 'Designation', 'ninjalivechat' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'CEO' , 'ninjalivechat' ),
                'label_block' => true,
            ]
        );

  
        $this->add_control(
            'nlc_member_lists',
            [
                'label' => __( 'Member Lists', 'ninjalivechat' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'nlc_member_number' => '12345',
                        'nlc_member_name' => __( 'John Doe', 'ninjalivechat' ),
                        'nlc_member_designation'    => __('Sales Executive', 'ninjalivechat' )
                    ],
                    [
                        'nlc_member_number' => '34567',
                        'nlc_member_name' => __( 'Michael Jackson', 'ninjalivechat' ),
                        'nlc_member_designation'    => __('Technical Support', 'ninjalivechat' )             
                    ],
                    [
                        'nlc_member_number' => '345678',
                        'nlc_member_name' => __( 'Jackson', 'ninjalivechat' ),
                        'nlc_member_designation'    => __('Marketing Executive', 'ninjalivechat' )              
                    ],
                ],
                'title_field' => '{{{ nlc_member_name }}}',
            ]
        );

        $this->end_controls_section();

        //styles
		$this->start_controls_section(
			'live_chat_style_section',
			[
				'label' => __( 'Live Chat' , 'ninjalivechat' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);
        $this->add_control(
			'nlc_button_color',
			[
				'label' => __( 'BUTTON COLOR', 'ninjalivechat' ),
				'type' => Controls_Manager::COLOR,
                'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ninja-floating-button' => 'background-color: {{VALUE}};',
				],
			]
		);
        $this->add_control(
			'nlc_button_text_color',
			[
				'label' => __( 'BUTTON TEXT COLOR', 'ninjalivechat' ),
				'type' => Controls_Manager::COLOR,
                'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ninja-floating-button' => 'color: {{VALUE}};',
				],
			]
		);
        $this->add_control(
			'nlc_header_color',
			[
				'label' => __( 'HEADER COLOR', 'ninjalivechat' ),
				'type' => Controls_Manager::COLOR,
                'default'   => '#095E54',
				'selectors' => [
					'{{WRAPPER}} .ninja-chat-box .ninja-chat-header' => 'background-color: {{VALUE}};',
				],
			]
		);
        $this->add_control(
			'nlc_header_text_color',
			[
				'label' => __( 'HEADER TEXT COLOR', 'ninjalivechat' ),
				'type' => Controls_Manager::COLOR,
                'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ninja-chat-box .ninja-chat-header' => 'color: {{VALUE}};',
				],
			]
		);
        $this->add_control(
			'nlc_body_color',
			[
				'label' => __( 'BODY COLOR', 'ninjalivechat' ),
				'type' => Controls_Manager::COLOR,
                'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ninja-chat-box .ninja-chat-body' => 'background-color: {{VALUE}};',
				],
			]
		);
        $this->add_control(
			'nlc_body_text_color',
			[
				'label' => __( 'BODY TEXT COLOR', 'ninjalivechat' ),
				'type' => Controls_Manager::COLOR,
                'default'   => '#3FB122',
				'selectors' => [
					'{{WRAPPER}} .ninja-chat-box .ninja-chat-body .ninja-member-details' => 'color: {{VALUE}};',
				],
			]
		);
        $this->add_control(
			'nlc_floating_button_position',
			[
				'label' => __( 'FLOATING BUTTON POSITION FROM TOP, (in %)', 'ninjalivechat' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['%'],
				'range' => [
					'%' => [
						'min' => 0,
                        'max' => 100,
					],
				],
                'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors' => [
                    '{{WRAPPER}} .ninja-chat-design2 .ninja-floating-button' => 'top: {{SIZE}}{{UNIT}};',
                ]
			]
		);
		$this->end_controls_section();
    }

    public function is_reload_preview_required() {
		return true;
	}

    protected function render() 
    {
        $configs = $this->get_settings_for_display();
        if( $configs['nlc_layout'] === 0 ) return;
        $members = $configs['nlc_member_lists'];
    ?>
        <div  class="ninja-live-chat ninja-chat-<?php echo esc_html($configs['nlc_layout']);?>" data-layout="<?php echo esc_attr($configs['nlc_layout']); ?>">
            <div class="ninja-chat-box">
                <div class="ninja-chat-header">
                    <p><?php echo esc_html($configs['nlc_header_title']); ?></p>
                    <strong><?php echo esc_html($configs['nlc_header_description']); ?></strong> 
                </div>
                <div class="ninja-chat-body">	
                    <?php foreach($members as $member): ?>
                    <a class="ninja-member-area" number="<?php echo esc_html($member['nlc_member_number']); ?>">
                        <div class="ninja-avatar-container ninja-member-status-<?php echo esc_html($member['nlc_member_status']); ?>">
                            <?php if( !empty($member['nlc_member_image']) ): ?>
                                <img class="ninja-member-avatar" src="<?php echo esc_url($member['nlc_member_image']['url']); ?>"/>
                            <?php else: ?>
                                <img class="ninja-member-avatar" src="<?php echo NINJALIVECHAT_URL.'public/images/chat/placeholder.png' ?>" />
                            <?php endif; ?>
                        </div>
                        <div class="ninja-member-details">
                            <span><?php echo esc_html($member['nlc_member_name']); ?></span>
                            <p><?php echo esc_html($member['nlc_member_designation']); ?></p>
                        </div>
                    </a>
                    <?php endforeach; ?>
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
        </div>
    <?php
    }

	protected function content_template() {}
}