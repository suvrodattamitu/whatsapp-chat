<template>
    <div>
        <el-row>
            <el-col :span="24">
                <div class="ninja_countdown_item">
                    <label class="ninja_countdown_label">Header Title</label>
                    <el-input type="text" v-model="chat_contents.chat_header.title" size="mini"></el-input>
                </div>
            </el-col>
        </el-row>

        <el-row>
            <el-col :span="24">
                <div class="ninja_countdown_item">
                    <label class="ninja_countdown_label">Header Description</label>
                    <el-input type="text" v-model="chat_contents.chat_header.description" size="mini"></el-input>
                </div>
            </el-col>
        </el-row>

        <el-row>
            <el-col :span="24">
                <div class="ninja_countdown_item">
                    <label class="ninja_countdown_label">BUTTON TEXT</label>
                    <el-input type="text" v-model="chat_contents.chat_bubble.button_text" size="mini"></el-input>
                </div>
            </el-col>
        </el-row>
    </div>
</template>

<script type="text/babel">
export default {
    name: 'ContentsPanel',
    props: ['chat_contents']
}
</script>