<template>
	<el-popover
        placement="top"
        width="180"
        v-model:visible="visible"
    >
		<p>Are you sure you want to clear this?</p>
		<div style="text-align: right; margin: 0">
			<el-button size="mini" type="text"
                       @click="visible = false"
            >cancel</el-button>

			<el-button type="primary" size="mini"
                       @click="confirmAction"
            >confirm</el-button>
		</div>
        <template #reference>
            <el-button size="mini" type="danger">
                Reset
            </el-button>
        </template>
	</el-popover>
</template>

<script>
    export default {
        name: 'confirmRemove',
        props: {
            plain: {
                type: Boolean,
                default: false
            }
        },
        emits: ['on-confirm'],
        data() {
            return {
                visible: false
            };
        },
        methods: {
            confirmAction() {
                this.visible = false;
                this.$emit('on-confirm');
            }
        }
    }
</script>