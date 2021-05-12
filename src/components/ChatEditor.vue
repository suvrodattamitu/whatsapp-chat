<template>
    <div class="ninja_countdown_wrapper" v-loading="loading">
        <div class="header">
            <remove @on-confirm="clearConfigs"></remove>
            <el-button type="primary" size="mini" @click="updateConfigs">
                Update
            </el-button>
        </div>
        <div class="ninja_countdown_editor">
            <div class="ninja_countdown_preview">
                <chat-panel :all_configs="configs" :members="members"></chat-panel>
            </div>
            <div class="ninja_countdown_settings" v-if="configs">
                <div class="settings_panel">
                    <el-tabs type="border-card">
                        <el-tab-pane>
                            <template #label>
                                <span class="icon-style"><i class="el-icon-date"></i> Contents</span>
                            </template>
                            <timer-panel :chat_contents="configs.chat_contents"></timer-panel>
                        </el-tab-pane>

                        <el-tab-pane>
                            <template #label>
                                <span class="icon-style"><i class="el-icon-video-play"></i>Chat Bubble</span>
                            </template>
                            <button-panel :button_configs="configs.chat_bubble"></button-panel>
                        </el-tab-pane> 

                        <el-tab-pane>
                            <template #label>
                                <span class="icon-style"><i class="el-icon-edit"></i>Style</span>
                            </template>
                            <style-panel :styles_configs="configs.styles"></style-panel>
                        </el-tab-pane>
                    </el-tabs>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import StylePanel from '../components/editor-ui/settings-elements/StylePanel'
import ButtonPanel from '../components/editor-ui/settings-elements/ButtonPanel'
import TimerPanel from '../components/editor-ui/settings-elements/TimerPanel'
import Remove from '../components/editor-ui/pieces/Remove'
import ChatPanel from './editor-ui/ninja-chat/ChatPanel'

export default {
    components:{
        StylePanel,
        TimerPanel,
        ButtonPanel,
        Remove,
        ChatPanel
    },

    data() {
        return {
            members:[],
            val:'',
            val1:'',
            activeName: "1",
            configs: false,
            loading: false
        }
    },

    methods: {
        clearConfigs() {
            this.loading = true
            this.$adminPost({
                route: 'clear_configs',
            })
                .then(response => {
                    if( response.data ) {
                        this.$message({
                            showClose: true,
                            message: response.data.message,
                            type: 'success'
                        });
                        this.getConfigs();
                    }
                })
                .fail(error => {

                })
                .always(() => {
                    this.loading = false
                });
        },
        updateConfigs() {
            this.loading = true
            this.$adminPost({
                route: 'save_configs',
                configs: JSON.stringify(this.configs)
            })
                .then(response => {
                    if( response.data ) {
                        this.$message({
                            showClose: true,
                            message: response.data.message,
                            type: 'success'
                        });
                        this.getConfigs();
                    }
                })
                .fail(error => {

                })
                .always(() => {
                    this.loading = false
                });
        },
        getConfigs() {
            this.loading = true
            this.$adminGet({
                route: 'get_chat_configs'
            })
                .then(response => {
                    if( response.data ) {
                        this.configs = response.data.configs;
                        this.members = response.data.members;
                    }
                })
                .fail(error => {

                })
                .always(() => {
                    this.loading = false
                });
        },

        //css generate start 
        generateCSS(prefix) {
            let configs = this.configs;
            return `
                /* Header Color Styling */
                    ${prefix} {
                    background-color: ${configs.styles.background_color};
                    ${configs.styles.position}:0;
                }
                ${prefix} .ninja-countdown-timer-header-title-text{
                    color: ${configs.styles.message_color};
                }
                ${prefix} .ninja-countdown-timer-button{
                    background-color: ${configs.styles.button_color};
                    color: ${configs.styles.button_text_color}
                }
                ${prefix} .ninja-countdown-timer-item{
                    color: ${configs.styles.timer_color}
                }
             `
        },

        reloadCss() {
            let countdownCss = this.generateCSS('.ninja-countdown-timer-1');
            jQuery('#ninja_countdown_dynamic_style').html(countdownCss);  
        }
        //css generate end
    },

    watch:{
        'configs': {
            handler() {
                window.mitt.emit('update_css')
            },
            deep: true
        }
    },

    mounted() {
        this.getConfigs();
        window.mitt.on('update_css', () => {
            if (this.configs) {
                this.reloadCss();
            }
        });
    }
}
</script>