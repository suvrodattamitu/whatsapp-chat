<template>
    <div>
        <el-row>
            <el-col :span="24">
                <div class="ninja_countdown_item">
                    <label class="ninja_countdown_label">Colors</label>
                    <div class="color-customization">
                        <div class="bgColorList">
                            <div class="block-container">
                                <div class="title">
                                    <p>{{ 'BUTTON COLOR' }}</p>
                                </div>
                                <div class="color-picker">
                                    <el-color-picker
                                        size="mini" 
                                        v-model="styles_configs.button_bg_color" 
                                        show-alpha>
                                    </el-color-picker>
                                </div>
                            </div>
                        </div>

                        <div class="bgColorList">
                            <div class="block-container">
                                <div class="title">
                                    <p>{{ 'BUTTON TEXT COLOR' }}</p>
                                </div>
                                <div class="color-picker">
                                    <el-color-picker
                                        size="mini" 
                                        v-model="styles_configs.button_text_color" 
                                        show-alpha>
                                    </el-color-picker>
                                </div>
                            </div>
                        </div>

                        <div class="bgColorList">
                            <div class="block-container">
                                <div class="title">
                                    <p>{{ 'HEADER COLOR' }}</p>
                                </div>
                                <div class="color-picker">
                                    <el-color-picker
                                        size="mini" 
                                        v-model="styles_configs.header_bg_color" 
                                        show-alpha>
                                    </el-color-picker>
                                </div>
                            </div>
                        </div>

                        <div class="bgColorList">
                            <div class="block-container">
                                <div class="title">
                                    <p>{{ 'HEADER TEXT COLOR' }}</p>
                                </div>
                                <div class="color-picker">
                                    <el-color-picker
                                        size="mini" 
                                        v-model="styles_configs.header_text_color" 
                                        show-alpha>
                                    </el-color-picker>
                                </div>
                            </div>
                        </div>

                        <div class="bgColorList">
                            <div class="block-container">
                                <div class="title">
                                    <p>{{ 'BODY COLOR' }}</p>
                                </div>
                                <div class="color-picker">
                                    <el-color-picker
                                        size="mini" 
                                        v-model="styles_configs.body_bg_color" 
                                        show-alpha>
                                    </el-color-picker>
                                </div>
                            </div>
                        </div>

                        <div class="bgColorList">
                            <div class="block-container">
                                <div class="title">
                                    <p>{{ 'BODY TEXT COLOR' }}</p>
                                </div>
                                <div class="color-picker">
                                    <el-color-picker
                                        size="mini" 
                                        v-model="styles_configs.body_text_color" 
                                        show-alpha>
                                    </el-color-picker>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </el-col>
        </el-row>
        <el-row v-if="layout === 'design2'">
            <el-col :span="24">
                <div class="ninja_countdown_item">
                    <label class="ninja_countdown_label">FLOATING BUTTON POSITION FROM TOP (in %)</label>
                    <el-input type="number" v-model="styles_configs.button_position" size="mini"></el-input>
                </div>
            </el-col>
        </el-row>
    </div>
</template>

<script type="text/babel">
export default {
    name: 'StylePanel',
    props:['styles_configs','layout'],
    watch: {
        styles_configs: {
            handler(val){
                window.mitt.emit('update_css')
            },
            deep: true
        }
    }
}
</script>