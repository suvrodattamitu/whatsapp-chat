<template>
    <div>
        <el-row>
            <el-col :span="24">
                <div class="ninja_countdown_item">
                    <label class="ninja_countdown_label">Layout</label>
                    <el-select v-model="layout_configs.layout" clearable placeholder="Select" size="mini">
                        <el-option
                        v-for="item in options"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value">
                        </el-option>
                    </el-select>
                </div>
            </el-col>
        </el-row>
    </div>
</template>

<script type="text/babel">
export default {
    name: 'LayoutPanel',
    props:['layout_configs'],
    data(){
        return {
            options: [
                {
                    label: 'Layout One',
                    value: 'design1',
                },
                {
                    label: 'Layout Two',
                    value: 'design2',
                },
                {
                    label: 'Layout Three',
                    value: 'design3',
                }
            ]
        }
    }
}
</script>