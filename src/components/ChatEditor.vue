<template>
    <div class="ninja_countdown_wrapper" v-loading="loading">
        <div class="header">
            <remove @on-confirm="clearConfigs"></remove>
            <el-button type="primary" size="mini" @click="updateConfigs">
                Update
            </el-button>
        </div>
        <div class="ninja_countdown_editor">
            <div class="ninja_countdown_preview" v-if="configs">
                <component :is="component" :all_configs="configs" :members="members" />
            </div>
            <div class="ninja_countdown_settings" v-if="configs">
                <div class="settings_panel">
                    <el-tabs type="border-card">
                        <el-tab-pane>
                            <template #label>
                                <span class="icon-style"><i class="el-icon-date"></i> Layouts</span>
                            </template>
                            <layout-panel :layout_configs="configs.layouts"></layout-panel>
                        </el-tab-pane>

                        <el-tab-pane>
                            <template #label>
                                <span class="icon-style"><i class="el-icon-date"></i> Contents</span>
                            </template>
                            <contents-panel :chat_contents="configs.chat_contents"></contents-panel>
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
import LayoutPanel from '../components/editor-ui/settings-elements/LayoutPanel'
import ContentsPanel from '../components/editor-ui/settings-elements/ContentsPanel'
import Remove from '../components/editor-ui/pieces/Remove'

import Design1 from '../components/editor-ui/ninja-chat/Design1'
import Design2 from '../components/editor-ui/ninja-chat/Design2'
import Design3 from '../components/editor-ui/ninja-chat/Design3'

export default {
    components:{
        StylePanel,
        ContentsPanel,
        LayoutPanel,
        Remove,
        Design1,
		Design2,
		Design3
    },

    data() {
        return {
            members:[],
            val:'',
            val1:'',
            activeName: "1",
            configs: false,
            loading: false,
            component:Design1,
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
                route: 'save_chat_configs',
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
                        this.component = response.data.configs.layouts.layout;
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
                .wc-panel .wc-header {
                    background: ${configs.styles.header_bg_color} !important;
                    color: ${configs.styles.header_text_color} !important;
                }
                .wc-button {
                    background: ${configs.styles.button_bg_color} !important;
                    color: ${configs.styles.button_text_color} !important;
                }
                .wc-panel .wc-body{
                    background: ${configs.styles.body_bg_color} !important;
                }
                .wc-panel .wc-body .wc-user-info{
                    color: ${configs.styles.body_text_color} !important;
                }
            `
        },

        reloadCss() {
            let whatsappChatCss = this.generateCSS();
            jQuery('#ninja_whatsapp_chat_dynamic_style').html(whatsappChatCss);  
        }
        //css generate end
    },

    watch:{
        'configs': {
            handler(configs) {
                window.mitt.emit('update_css')
                if( configs && configs.layouts ) {
                    this.component = configs.layouts.layout
                }
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