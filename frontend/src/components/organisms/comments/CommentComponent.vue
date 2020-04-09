<template>
    <b-card no-body class="mt-3">
        <b-card-header header-tag="header" class="p-1 toggle_button" role="tab" v-b-toggle.accordion1>
            <span>
                <b-icon icon="chat" scale="1.5" class="mr-2 ml-1"></b-icon>
                Комментарии
            </span>
        </b-card-header>
        <b-collapse id="accordion1" accordion="my-accordion" role="tabpanel">
            <b-card-body>
                <div>
                    <div v-if="allComments.length">
                    <b-list-group  v-for="(comment, index) in allComments" :key="index">
                        <b-list-group-item v-if="comment.user_role == 'mgsu'" class="flex-column align-items-start bg-light mt-2">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 :id="`user_${comment.id_user}`" class="mb-1 font-weight-bold text-warning">Минобрнауки России (эксперт)</h5>
                                    <small>{{ comment.created_at }}</small>
                                </div>

                                <p class="mb-1 font-italic">{{ comment.message }}</p>

                                <small></small>
                                <div class="d-flex justify-content-end" v-if="user_id === comment.id_user">
                                    <b-button variant="outline-danger" size="sm" @click="deleteComment(comment.id)">Удалить</b-button>
                                </div>
                        </b-list-group-item>
                        <b-list-group-item v-else class="flex-column align-items-start mt-2">
                            <div>
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 :id="`user_${comment.id_user}`" class="mb-1 font-weight-light">{{ comment.username }}</h5>
                                    <small>{{ comment.created_at }}</small>
                                </div>

                                <p class="mb-1">{{ comment.message }}</p>

                                <small></small>
                                <div class="d-flex justify-content-end" v-if="user_id === comment.id_user">
                                    <b-button variant="outline-danger" size="sm" @click="deleteComment(comment.id)">Удалить</b-button>
                                </div>
                            </div>
                        </b-list-group-item>
                    </b-list-group>
                    </div>
                    <b-list-group v-else>
                        <b-list-group-item class="flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1 font-weight-light">Комментариев к этому объекту пока нет</h5>
                            </div>

                            <small>Но вы можете их добавить</small>
                        </b-list-group-item>
                    </b-list-group>
                </div>
                <div class="mt-3">
                    <b-form-group class="mb-0" label-for="textarea-lazy" :description="`Слов осталось: ${restWords}`">
                        <b-form-textarea v-model="newComment" placeholder="Новый комментарий..." rows="2" max-rows="6" maxlength="255"></b-form-textarea>
                    </b-form-group>
                    <div class="d-flex justify-content-end">
                            <b-form-file
                                multiple
                                class="col-6 mr-3"
                                v-model="files"
                                placeholder="Файл..."
                                browse-text="Выбрать"
                                accept=".jpg, .jpeg, .doc, .doch, .xls, .pdf, .png"
                            ></b-form-file>
                        <b-button size="sm" variant="outline-primary" @click="sendFile(56)">Добавить</b-button>
                    </div>
                </div>
            </b-card-body>
        </b-collapse>
    </b-card>
</template>

<script>
import Axios from "axios";
import {
    BFormFile,
    BButton,
    BCard,
    BCardBody,
    BCardHeader,
    BCollapse,
    BListGroup,
    BListGroupItem,
    BFormGroup,
    BFormTextarea,
    VBToggle
} from "bootstrap-vue";
export default {
    name: "CommentComponent",
    props: ["obj_id"],
    directives:{
        'b-toggle':VBToggle
    },
    components:{
        BFormFile,
        BCollapse,
        BCard,
        BCardHeader,
        BCardBody,
        BButton,
        BListGroup,
        BListGroupItem,
        BFormGroup,
        BFormTextarea,
    },
    watch: {
        files(){
            if(this.files) {
                for(let file of this.files) {
                    if(!this.types.includes(file.type)) {
                        this.files = null
                    }
                }
            }
        }
    },
    data() {
        return {
            csrf: document.getElementsByName("csrf-token")[0].content,
            types: ['application/pdf', 'application/doc', 'application/doch', 'image/jpeg', 'image/jpg', 'image/png'],
            files: null,
            newComment: "",
            allComments: []
        };
    },
    computed: {
        restWords() {
            return 255 - (this.newComment.length || 0);
        }
    },
    async mounted() {
        await this.obj_id;
        await this.getUser();
        await this.refreshComments();
    },
    methods: {
        async getUser() {
            return Axios.get('/api/comment/user').then((res) => {
                this.user_id = res.data
            })
        },
        async refreshComments() {
            return Axios.get(`/api/comment/obj/${this.obj_id}`).then(res => {
                this.allComments = res.data;
            });
        },
        async deleteComment(id) {
            return Axios.delete(`/api/comment/${id}`).then(() => {
                this.refreshComments();
            });
        },
        addNewComment() {
            this.refreshComments();
            let data = new FormData()
            data.append("id_obj", this.obj_id);
            data.append("message", this.newComment);
            data.append("id_user", this.user_id);
            Axios.post("/api/comment", data, {
                headers: {
                    "X-CSRF-Token": this.csrf
                }
            }).then(() => {
                this.refreshComments();
                this.newComment = "";
            });
        },
        async sendFile(id_comment) {
            console.log(this.files[0])
            let form = new FormData();
            form.append('file', this.files[0])
            await Axios.post(`/api/fileUpload/${this.obj_id}/${id_comment}`, form, {
                headers: {
                    "X-CSRF-Token": this.csrf,
                    "Content-Type": "multipart/form-data;"
                },
            })
        }
    }
};
</script>

<style></style>
