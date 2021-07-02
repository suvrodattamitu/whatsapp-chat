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
                                    <color-picker v-model="styles_configs.button_bg_color"></color-picker>
                                </div>
                            </div>
                        </div>

                        <div class="bgColorList">
                            <div class="block-container">
                                <div class="title">
                                    <p>{{ 'BUTTON TEXT COLOR' }}</p>
                                </div>
                                <div class="color-picker">
                                    <color-picker v-model="styles_configs.button_text_color"></color-picker>
                                </div>
                            </div>
                        </div>

                        <div class="bgColorList">
                            <div class="block-container">
                                <div class="title">
                                    <p>{{ 'HEADER COLOR' }}</p>
                                </div>
                                <div class="color-picker">
                                    <color-picker v-model="styles_configs.header_bg_color"></color-picker>
                                </div>
                            </div>
                        </div>

                        <div class="bgColorList">
                            <div class="block-container">
                                <div class="title">
                                    <p>{{ 'HEADER TEXT COLOR' }}</p>
                                </div>
                                <div class="color-picker">
                                    <color-picker v-model="styles_configs.header_text_color"></color-picker>
                                </div>
                            </div>
                        </div>

                        <div class="bgColorList">
                            <div class="block-container">
                                <div class="title">
                                    <p>{{ 'BODY COLOR' }}</p>
                                </div>
                                <div class="color-picker">
                                    <color-picker v-model="styles_configs.body_bg_color"></color-picker>
                                </div>
                            </div>
                        </div>

                        <div class="bgColorList">
                            <div class="block-container">
                                <div class="title">
                                    <p>{{ 'BODY TEXT COLOR' }}</p>
                                </div>
                                <div class="color-picker">
                                    <color-picker v-model="styles_configs.body_text_color"></color-picker>
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
                    <label class="ninja_countdown_label">FLOATING BUTTON POSITION FROM TOP, (in %)</label>
                    <el-slider v-model="styles_configs.button_position" size="mini" :min="0" :max="100"></el-slider>
                </div>
            </el-col>
        </el-row>
    </div>
</template>

<script type="text/babel">
import ColorPicker from '../pieces/ColorPicker.vue';

export default {
    name: 'StylePanel',
    props:['styles_configs','layout'],
    components: {
        ColorPicker
    },
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