<template>
    <div class="ninja_countdown_settings_wrapper" v-loading="loading">

        <div class="ninja_settings_panel">
            <h2 class="ninja_header_text">Advance Settings</h2>

            <!--Save settings-->
            <el-row class="setting_header">
                <el-col :md="18">
                    <h2>
                        Show Countdown Timer
                        <el-tooltip class="item" effect="light" placement="bottom-start">
                            <template #content>
                                <h3>Where to place the timer?</h3>
                                <p>These Settings is for showing your Countdown timer in specific pages.<br/>You can customize settings for each page</p>
                            </template>
                            <i class="el-icon-info el-text-info"></i>
                        </el-tooltip>
                    </h2>
                </el-col>
            </el-row>

            <el-form ref="form-layout" label-position="left">
                <!--Label Placement-->
                <el-form-item>

                    <div>
                        <span>Pages :</span>
                    </div>

                    <div v-if="pages">
                        <el-checkbox :indeterminate="isIndeterminate" v-model="checkAll"  @change="handleCheckAllChange">Check all</el-checkbox>
                        <div style="margin: 15px 0;"></div>
                        <el-checkbox-group v-model="checkedPages" @change="handleCheckedCitiesChange">
                            <el-checkbox v-for="page in pages" :label="page.page_id" :key="page.page_title">{{page.page_title}}</el-checkbox>
                        </el-checkbox-group>
                    </div>

                </el-form-item>

            </el-form>

            <!--Save settings-->
            <el-row>
                <el-col class="action-buttons clearfix mb15">
                    <el-button size="medium" class="pull-right" type="success" icon="el-icon-success" @click="saveSettings()">Save Settings</el-button>
                </el-col>
            </el-row>
        </div>

    </div>
</template>

<script>
  export default {
    data() {
      return {
        checkAll: false,
        checkedPages: [],
        pages: false,
        isIndeterminate: false,
        loading: false
      };
    },
    methods: {
        getSettings() {
            this.loading = true
            this.$adminGet({
                route: 'get_settings'
            })
                .then(response => {
                    if( response.data ) {
                        this.pages = response.data.pages
                        this.checkedPages = response.data.checked_pages

                        let checkedCount = response.data.checked_pages.length;
                        this.checkAll = checkedCount === this.pages.length;
                        this.isIndeterminate = checkedCount > 0 && checkedCount < this.pages.length;
                    }
                })
                .fail(error => {
                })
                .always(() => {
                    this.loading = false
                });
        },
        saveSettings() {
            this.loading = true
            this.$adminPost({
                route: 'save_settings',
                checked_pages: JSON.stringify(this.checkedPages)
            })
                .then(response => {
                    if( response.data ) {
                        this.$message({
                            showClose: true,
                            message: response.data.message,
                            type: 'success'
                        });
                        this.getSettings();
                    }
                })
                .fail(error => {
                })
                .always(() => {
                    this.loading = false
                });
        },
        handleCheckAllChange(val) {
            this.checkedPages = val ? this.pages.map(value => value.page_id) : [];
            this.isIndeterminate = false;
        },
        handleCheckedCitiesChange(value) {
            let checkedCount = value.length;
            this.checkAll = checkedCount === this.pages.length;
            this.isIndeterminate = checkedCount > 0 && checkedCount < this.pages.length;
        }
    },
    mounted() {
        this.getSettings()
    }
  };
</script>