<template>
    <b-card no-body class="mt-3">
        <b-card-header header-tag="header" class="p-1 toggle_button" role="tab" v-b-toggle.accordion1>
            <span>
                <b-icon icon="chat" scale="1.5" class="mr-2 ml-1"></b-icon>
                Комментарии
            </span>
        </b-card-header>
        <b-collapse id="accordion1" accordion="my-accordion" role="tabpanel" visible>
            <b-card-body>
                <div>
                    <b-list-group v-if="allComments.length">
                        <b-list-group-item v-for="(comment, index) in allComments" :key="index" class="flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1 font-weight-light">{{ comment.username }}</h5>
                                <small>{{ comment.created_at }}</small>
                            </div>

                            <p class="mb-1">{{ comment.message }}</p>

                            <small></small>
                            <div class="d-flex justify-content-end" v-if="user_id === comment.id_user">
                                <b-button variant="outline-danger" size="sm" @click="deleteComment(comment.id)">Удалить</b-button>
                            </div>
                        </b-list-group-item>
                    </b-list-group>
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
                        <b-button variant="outline-primary" @click="addNewComment()">Добавить</b-button>
                    </div>
                </div>
            </b-card-body>
        </b-collapse>
    </b-card>
</template>

<script>
import Axios from "axios";
import {
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
    data() {
        return {
            newComment: "",
            allComments: []
        };
    },
    computed: {
        restWords() {
            return 255 - (parseInt(this.newComment.length) || 0);
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
            let data = new FormData();
            data.append("id_obj", parseInt(this.obj_id));
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
        }
    }
};
</script>

<style></style>
