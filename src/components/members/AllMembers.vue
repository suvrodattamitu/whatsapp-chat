<template>
    <div class="ninja_content_wrap">
        <div class="ninja_all_feeds">
            <el-row>
                <el-col>
                    <div class="ninja_feed_table" v-loading="loading" element-loading-text="Loading..Please wait...">
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
                                <div class="ninja-member-avatar-container">
                                    <img class="ninja-member-avatar" v-if="scope.row.member_image_url" :src="scope.row.member_image_url">
                                    <img class="ninja-member-avatar" v-else :src="assets_url+'/images/chat/placeholder.png'">
                                </div>
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
                    title="Are You Sure, You want to delete this member?"
                    v-model="deleteDialogVisible"
                    :before-close="handleDeleteClose"
                    width="60%">
                <div class="modal_body">
                    <p>All the data assoscilate with this member will be deleted</p>
                    <p>You are deleting member id: <b>{{ deletingMember.id }}</b>. <br/>Member Name: <b>{{
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
                            <photo-widget
                                btn_type="primary"
                                :btn_text="'Select File'"
                                :btn_mode="true"
                                @changed="updateAvatar"
                                v-model="member.member_image_url"
                            />
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
                        <el-button type="primary" :loading="adding" @click="addMember()">
                            <span v-if="adding">Creating Member...</span>
                            <span v-else>Add Member</span>
                        </el-button>
                    </span>
                </template>
            </el-dialog>
            
            <el-dialog
                title="Update a Member"
                v-model="showEditFormModal"
                :before-close="handleEditClose"
                width="60%"
            >
                <div class="modal_body" v-loading="fetching" element-loading-text="Loading Members...">
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
                            <photo-widget
                                btn_type="primary"
                                :btn_text="'Select File'"
                                :btn_mode="true"
                                @changed="updateAvatar"
                                v-model="member.member_image_url"
                            />
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
                        <el-button type="primary" @click="updateMember()" :loading="updating">
                            <span v-if="updating">Updating Member...</span>
                            <span v-else>Update Member</span>
                        </el-button>
                    </span>
                </template>
            </el-dialog>
        </div>
    </div>
</template>

<style lang="scss">
    .ninja_all_feeds{
        .ninja-member-avatar-container{
            height: 60px;
            width: 60px;
            border-radius: 50%;
            .ninja-member-avatar{
                display: block;
                margin: 0 auto;
                max-width: 100%;
                height: 100%;
            }
        }
        .el-dialog__header {
            text-align: center;
            font-weight: 700;
        }
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

<script type="text/babel">
    import PhotoWidget from '../editor-ui/pieces/PhotoWidget.vue';

    export default {
        components: {
            PhotoWidget
        },
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
                fetching: false,
                updating: false,
                adding: false,
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
                assets_url: window.NinjaLiveAdmin.assets_url
            }
        },
        methods: {
            updateAvatar(url) {
            
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
                this.emptyMember();
            },
            handleEditClose() {
                this.showEditFormModal = false;
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
                this.adding = true;
                this.$adminPost({
                    route: 'add_member',
                    member: JSON.stringify(this.member)
                }).then(response => {
                        if( response.data ) {
                            this.showAddFormModal = false;
                            this.emptyMember();
                            this.getAllMembers();
                            this.$message({
                                showClose: true,
                                message: response.data.message,
                                type: 'success'
                            });
                        }
                    }).fail(errors => {
                        this.errors = errors.responseJSON.data;
                    }).always(() => {
                        this.adding = false;
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
                this.fetching = true
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
                        this.fetching = false
                    });
            },
            updateMember() {
                this.updating = true;
                this.$adminPost({
                    route: 'update_member',
                    member: JSON.stringify(this.member)
                }).then(response => {
                        if( response.data ) {
                            this.showEditFormModal = false;
                            this.emptyMember();
                            this.getAllMembers();
                            this.$message({
                                showClose: true,
                                message: response.data.message,
                                type: 'success'
                            });
                        }
                    }).fail(errors => {
                        this.errors = errors.responseJSON.data;
                    }).always(() => {
                        this.updating = false;
                    });
            },
            emptyMember() {
                this.member = {
                    member_name: '',
                    member_designation: '',
                    member_number: '',
                    member_status: 'online',
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