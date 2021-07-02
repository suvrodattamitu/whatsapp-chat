<template>
    <div class="fizzy-upload-photo-element" v-if="app_ready">
        <div class="fizzy-upload-container">
            <div class="upload-items">
                <div class="fizzy_popup_photo_holder_element" :class="[modelValue ? 'fizzy_upload_photo_container' : '']">
                    <img v-if="modelValue" :src="modelValue"/>
                </div>
                <i class="el-icon-upload fizzy-upload-icon"></i>
                <p>Browse for a file to upload</p>
                <el-button size="small" @click="initUploader" :type="btn_type">{{btn_text}}</el-button>
            </div>
        </div>
    </div>
</template>

<style lang="scss">
    .fizzy-upload-photo-element{
        .fizzy-upload-container{
            display: flex;
            .upload-items{
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                .fizzy_upload_photo_container{
                    margin-bottom:15px;
                }
                .fizzy-upload-icon{
                    font-size: 35px;
                }
                .fizzy_popup_photo_holder_element{
                    img{
                        display: block;
                        max-height: 100px;
                        height: 80px;
                        width:80px;
                    }
                }
            }
        }
    }
</style>

<script type="text/babel">
    export default {
        name: 'photo_widget',
        emits: ['input','changed','update:modelValue'],
        props: {
            modelValue: {
                required: false,
                type: String
            },
            btn_mode: {
                type: Boolean,
                default() {
                    return false
                }
            },
            btn_text: {
                required: false,
                default() {
                    return '+ Upload';
                }
            },
            btn_type: {
                required: false,
                default() {
                    return 'default';
                }
            }
        },
        data() {
            return {
                app_ready: false,
                image_url: this.modelValue
            }
        },
        methods: {
            initUploader(event) {
                const that = this;
                const sendAttachmentBkp = wp.media.editor.send.attachment;
                wp.media.editor.send.attachment = function (props, attachment) {
                    that.$emit('input', attachment.url);
                    that.$emit('changed', attachment.url);
                    that.$emit('update:modelValue', attachment.url);
                    that.image_url = attachment.url;
                    wp.media.editor.send.attachment = sendAttachmentBkp;
                }
                wp.media.editor.open(jQuery(event.target));
                return false;
            },
            getThumb(attachment) {
                return attachment.url;
            }
        },
        mounted() {
            if (!window.wpActiveEditor) {
                window.wpActiveEditor = null;
            }
            this.app_ready = true;
        }
    };
</script>