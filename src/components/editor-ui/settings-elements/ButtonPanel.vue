<template>
    <div>
        <el-row>
            <el-col :span="24">
                <div class="ninja_countdown_item">
                    <label class="ninja_countdown_label">BUTTON TEXT</label>
                    <el-input type="text" v-model="button_configs.button_text" size="mini"></el-input>
                </div>
            </el-col>
        </el-row>
    </div>
</template>

<script>
export default {
    props:['button_configs']
}
</script>