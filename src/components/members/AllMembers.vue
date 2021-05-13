<template>
    <div class="ninja_content_wrap">
        <div class="ninja_all_feeds">
            <el-row>
                <el-col>
                    <div class="ninja_feed_table" v-loading="loading">
                        <div class="ninja_table_actions">
                            <div class="nina_search_action">
                                <el-input type="text" size="medium" v-model="search_string"  @keyup.enter="getAllMembers">
                                    <template #suffix>
                                        <el-button  size="medium" icon="el-icon-search" @click="getAllMembers"></el-button>
                                    </template>
                                </el-input>
                            </div>
                            <div class="ninja_add_new_actions">
                                <el-button size="mini"  @click="showAddFormModal = true" type="primary" icon="el-icon-circle-plus">
                                    Add Member
                                </el-button>
                            </div>
                        </div>
                        <el-table
                            :data="members"
                            @selection-change="handleSelectionChange"
                            style="width: 100%"
                        >
                            <el-table-column
                            type="selection"
                            width="55">
                            </el-table-column>

                            <el-table-column type="expand">
                            <template #default="props">
                                <p>Name: {{ props.row.member_name }}</p>
                            </template>
                            </el-table-column>

                            <el-table-column
                            label="Name"
                            width="400"
                            >
                            <template #default="scope">
                                <strong>{{ scope.row.member_name }}</strong>
                                <div class="row-actions ninja_row_actions">
                                    <a @click.prevent="editMember(scope.row.id)">
                                        Edit
                                    </a>
                                    |
                                    <a @click.prevent="confirmDeleteFeed(scope.row)" class="delete_btn">Delete</a>
                                    |
                                    <a @click.prevent="duplicateMember(scope.row)">Duplicate</a>
                                </div>
                            </template>
                            </el-table-column>

                            <el-table-column
                            label="Image"
                            >
                            <template #default="scope">
                                <img v-if="scope.row.member_image_url" height="80" width="80" :src="scope.row.member_image_url">
                                <img v-else height="80" width="80" :src="assets_url+'/images/chat/placeholder.png'">
                            </template>
                            </el-table-column>

                            <el-table-column 
                            label="Number"
                            prop="member_number"
                            >
                            </el-table-column>

                            <el-table-column 
                            label="Designation"
                            prop="member_designation"
                            >
                            </el-table-column>

                            <el-table-column 
                            label="Status"
                            prop="member_status"
                            >
                            </el-table-column>
                        </el-table>
                    </div>

                    <div class="ninja_pagination">
                        <el-pagination
                            background
                            @size-change="handleSizeChange"
                            @current-change="handleCurrentChange"
                            :current-page="page_number"
                            :page-size="per_page"
                            :page-sizes="pageSizes"
                            layout="total, sizes, prev, pager, next"
                            :total="total">
                        </el-pagination>
                    </div>
                </el-col>
            </el-row>

            <!--Delete form Confimation Modal-->
            <el-dialog
                    title="Are You Sure, You want to delete this Feed?"
                    v-model="deleteDialogVisible"
                    :before-close="handleDeleteClose"
                    width="60%">
                <div class="modal_body">
                    <p>All the data assoscilate with this feed will be deleted</p>
                    <p>You are deleting feed id: <b>{{ deletingMember.id }}</b>. <br/>Member Name: <b>{{
                        deletingMember.member_name }}</b></p>
                </div>
                <template #footer>
                    <span class="dialog-footer">
                        <el-button @click="deleteDialogVisible = false">Cancel</el-button>
                        <el-button type="primary" @click="deleteMemberNow()">Confirm</el-button>
                    </span>
                </template>
            </el-dialog>

            <el-dialog
                title="Add New Member"
                v-model="showAddFormModal"
                :before-close="handleAddClose"
                width="60%"
            >
                <div class="modal_body">
                    <el-form :model="member">
                        <el-form-item label="Name" :label-width="formLabelWidth">
                            <el-input type="text" v-model="member.member_name" autocomplete="off" size="mini"></el-input>
                            <p class="error-msg" v-if="errors && errors.member_name"> {{ errors.member_name }} </p>
                        </el-form-item>
                        <el-form-item label="Designation" :label-width="formLabelWidth">
                            <el-input type="text" v-model="member.member_designation" autocomplete="off" size="mini"></el-input>
                            <p class="error-msg" v-if="errors && errors.member_designation"> {{ errors.member_designation }} </p>
                        </el-form-item>
                        <el-form-item label="Number" :label-width="formLabelWidth">
                            <el-input type="text" v-model="member.member_number" autocomplete="off" size="mini"></el-input>
                            <p class="error-msg" v-if="errors && errors.member_number"> {{ errors.member_number }} </p>
                        </el-form-item>
                        <el-form-item label="Image" :label-width="formLabelWidth">
                            <input type="file" class="form-control" id="file" @change="onInputChange($event)" />
                            <div class="form-img-area" v-if="member.member_image_url">
                                <img height="80" width="80" :src="member.member_image_url" />
                            </div>
                        </el-form-item>
                        <el-form-item label="Status" :label-width="formLabelWidth" size="mini">
                            <el-select v-model="member.member_status" placeholder="Select" size="mini">
                                <el-option
                                    v-for="item in member_statuses"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value">
                                </el-option>
                            </el-select>
                            <p class="error-msg" v-if="errors && errors.member_status"> {{ errors.member_status }} </p>
                        </el-form-item>
                    </el-form>
                </div>
                <template #footer>
                    <span class="dialog-footer">
                        <el-button @click="handleAddClose()">Cancel</el-button>
                        <el-button type="primary" @click="addMember()">Add</el-button>
                    </span>
                </template>
            </el-dialog>
            
            <el-dialog
                title="Update a Member"
                v-model="showEditFormModal"
                :before-close="handleEditClose"
                width="60%"
            >
                <div class="modal_body">
                    <el-form :model="member">
                        <el-form-item label="Name" :label-width="formLabelWidth">
                            <el-input type="text" v-model="member.member_name" autocomplete="off" size="mini"></el-input>
                            <p class="error-msg" v-if="errors && errors.member_name"> {{ errors.member_name }} </p>
                        </el-form-item>
                        <el-form-item label="Designation" :label-width="formLabelWidth">
                            <el-input type="text" v-model="member.member_designation" autocomplete="off" size="mini"></el-input>
                            <p class="error-msg" v-if="errors && errors.member_designation"> {{ errors.member_designation }} </p>
                        </el-form-item>
                        <el-form-item label="Number" :label-width="formLabelWidth">
                            <el-input type="text" v-model="member.member_number" autocomplete="off" size="mini"></el-input>
                            <p class="error-msg" v-if="errors && errors.member_number"> {{ errors.member_number }} </p>
                        </el-form-item>
                        <el-form-item label="Image" :label-width="formLabelWidth">
                            <input type="file" class="form-control" id="file" @change="onInputChange($event)" />
                            <div class="form-img-area" v-if="member.member_image_url">
                                <img height="80" width="80" :src="member.member_image_url" />
                            </div>
                        </el-form-item>
                        <el-form-item label="Status" :label-width="formLabelWidth" size="mini">
                            <el-select v-model="member.member_status" placeholder="Select" size="mini">
                                <el-option
                                    v-for="item in member_statuses"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value">
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-form>
                </div>
                <template #footer>
                    <span class="dialog-footer">
                        <el-button @click="showEditFormModal = false">Cancel</el-button>
                        <el-button type="primary" @click="updateMember()">Update</el-button>
                    </span>
                </template>
            </el-dialog>

        </div>
    </div>
</template>

<style lang="scss">
    .ninja_all_feeds{
        .el-input__suffix{
            right: 0px !important;
        }
        .ninja_pagination{
            float:right;
            margin:15px 0px;
        }
        .ninja_feed_table{
            
            .ninja_table_actions{
                display: flex;
                margin:15px 0px;
                align-items: center;
                justify-content: space-between;
                .nina_search_action{
                    display:flex;
                    
                }
            }

        }
        .ninja_row_actions{
            a{
                text-decoration: none;
                cursor:pointer;
                &.delete_btn{
                   color:#ff0000; 
                }
            }
            
        }
    }
</style>

<script>
    export default {
        data() {
            return {
                errors:[],
                formLabelWidth: '120px',
                member: {
                    id: null,
                    member_name: '',
                    member_designation: '',
                    member_number: '',
                    member_status: 'online',
                    member_image_file: null,
                    member_image_url: null
                },
                member_statuses:[
                    {
                        label: 'Online',
                        value: 'online'
                    },
                    {
                        label: 'Offline',
                        value: 'offline'
                    }
                ],
                showEditFormModal: false,
                showAddFormModal: false,
                loading: false,
                allFeeds: [],
                multipleSelection: [],
                deletingMember: {},
                deleteDialogVisible: false,
                //pagination
                per_page: 5,
                page_number: 1,
                total: 0,
                pageSizes: [5,10, 20, 30, 40, 50],
                search_string: '',
                members: [],
                assets_url: window.NinjaWhatsappAdmin.assets_url
            }
        },
        methods: {
            //for image file
            onInputChange(event) {
                const file = event.target.files[0];
                this.member.member_image_file = file;
                let that = this;
                let reader = new FileReader();
                reader.onload = (event) => {
                    // The file's text will be printed here
                    that.member.member_image_url = event.target.result;
                };
                reader.readAsDataURL(file);
            },

            //multiple select
            handleSelectionChange(val) {
                this.multipleSelection = val;
            },
            //pagination
            handleSizeChange(val) {
                this.per_page = val;
                this.getAllMembers();
            },
            handleCurrentChange(val) {
                this.page_number = val;
                this.getAllMembers();
            },
            handleAddClose(){
                this.showAddFormModal = false;
                document.getElementById("file").value=""; 
                this.emptyMember();
            },
            handleEditClose() {
                console.log('hi')
                this.showEditFormModal = false;
                document.getElementById("file").value=""; 
                this.emptyMember();
            },
            confirmDeleteFeed(feed) {
                this.deletingMember = feed;
                this.deleteDialogVisible = true;
            },
            deleteMemberNow(){
                this.loading = true;
                this.$adminPost({
                    route: 'delete_member',
                    member_id: this.deletingMember.id
                })
                    .then(response => {
                        if( response.data ) {
                            this.$message({
                                showClose: true,
                                message: response.data.message,
                                type: 'success'
                            });
                            this.getAllMembers();
                        }
                    }).fail(error => {

                    }).always(() => {
                        this.deleteDialogVisible = false;
                        this.deletingMember = {}
                        this.loading = false;
                    });
            },
            handleDeleteClose(){
                this.deleteDialogVisible = false;
                this.deletingMember = {}
            },
            addMember() {
                const formData = new FormData();
                formData.append('member_name', this.member.member_name);
                formData.append('member_number', this.member.member_number);
                formData.append('member_designation', this.member.member_designation);
                formData.append('member_status', this.member.member_status);
                formData.append('file', this.member.member_image_file);
                formData.append('action', 'ninja_whatsappchat_admin_ajax');
                formData.append('route', 'add_member');
                this.loading = true;
                let that = this;
                jQuery.ajax({
                    type: "POST",
                    enctype: 'multipart/form-data',
                    url: window.NinjaWhatsappAdmin.ajaxurl,
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 800000,
                    success: function (response) {
                        that.showAddFormModal = false;
                        that.emptyMember();
                        that.getAllMembers();
                        that.$message({
                            showClose: true,
                            message: response.data.message,
                            type: 'success'
                        });
                    },
                    error: function (errors) {
                        that.errors = errors.responseJSON.data;
                    },
                    complete: function() {
                        that.loading = false;
                    }
                });
            },
            getAllMembers(){
                this.loading = true
                this.$adminGet({
                    route: 'all_members',
                    per_page: this.per_page,
                    page_number: this.page_number,
                    search_string: this.search_string
                })
                    .then(response => {
                        if( response.data ) {
                            this.members = response.data.all_members
                            //pagination
                            this.total = response.data.total
                        }
                    }).fail(error => {

                    }).always(() => {
                        this.loading = false
                    });
            },
            editMember(memberId) {
                this.showEditFormModal = true;
                this.loading = true
                this.$adminGet({
                    route: 'get_member',
                    member_id: memberId
                })
                    .then(response => {
                        if( response.data ) {
                            this.member = response.data.member
                        }
                    }).fail(error => {

                    }).always(() => {
                        this.loading = false
                    });
            },
            updateMember() {
                this.loading = true;
                const formData = new FormData();
                formData.append('id', this.member.id);
                formData.append('member_name', this.member.member_name);
                formData.append('member_number', this.member.member_number);
                formData.append('member_designation', this.member.member_designation);
                formData.append('member_status', this.member.member_status);
                formData.append('file', this.member.member_image_file);
                formData.append('action', 'ninja_whatsappchat_admin_ajax');
                formData.append('route', 'update_member');
                this.loading = true;
                let that = this;
                jQuery.ajax({
                    type: "POST",
                    enctype: 'multipart/form-data',
                    url: window.NinjaWhatsappAdmin.ajaxurl,
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 800000,
                    success: function (response) {
                        that.showEditFormModal = false;
                        that.emptyMember();
                        that.getAllMembers();
                        that.$message({
                            showClose: true,
                            message: response.data.message,
                            type: 'success'
                        });
                    },
                    error: function (errors) {
                        that.errors = errors.responseJSON.data;
                    },
                    complete: function() {
                        that.loading = false;
                    }
                });
            },
            emptyMember() {
                this.member = {
                    member_name: '',
                    member_designation: '',
                    member_number: '',
                    member_status: 'online',
                    member_image_file: null,
                    member_image_url: null
                };
                this.errors = [];
            },
            duplicateMember(member){
                this.loading = true;
                this.$adminPost({
                    route: 'duplicate_member',
                    member: JSON.stringify(member)
                })
                    .then(response => {
                        if( response.data ) {
                            this.$message({
                                showClose: true,
                                message: response.data.message,
                                type: 'success'
                            });
                            this.getAllMembers();
                        }
                    }).fail((error) => {

                    }).always(() => {
                        this.loading = false;
                    });
            }
        },
        mounted(){
            this.getAllMembers()
        }
    }
</script>