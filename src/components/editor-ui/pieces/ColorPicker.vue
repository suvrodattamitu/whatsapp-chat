<template>
<div class="color-picker">
    <el-color-picker  
        v-model="modelValue"  
        @active-change="logColor" 
        @change="updateColor"
        :predefine="predefineColors"
        size="mini"
    >
    </el-color-picker>
</div>
</template>

<script type="text/babel">
export default {
    emits: ['update:modelValue'],
    props: ['modelValue'],

    data() {
        return {
            predefineColors: [
                '#ffffff',
                '#000000',
                '#ff4500',
                '#ff8c00',
                '#ffd700',
                '#90ee90',
                '#00ced1',
                '#1e90ff',
                '#c71585',
            ]
        }
    },

    methods: {
        updateColor() {
            this.$emit('update:modelValue', this.modelValue);
        },
        logColor(color) {
            this.$emit('update:modelValue', color);
        }
    }
}
</script>

<style lang="scss">
.color-picker {
    .el-icon-arrow-down {
        display: none;
    }
    .el-color-picker__color {
        border: none;
    }
    .el-color-picker__trigger {
        border: none;
    }
}
</style>