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
                    <b-form-group
                        class="mb-0"
                        label-for="textarea-lazy"
                        :description="`Слов осталось: ${restWords}`"
                    >
                        <b-form-textarea
                            v-model="newComment"
                            placeholder="Новый комментарий..."
                            rows="2"
                            max-rows="6"
                            maxlength="255"
                        ></b-form-textarea>
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
import Axios from 'axios';
export default {
    name: "CommentComponent",
    props: ["obj_id", "user_id"],
    data() {
        return {
            newComment: ''
        };
    },
    computed: {
        restWords() {
            return 255 - (parseInt(this.newComment.length) || 0)
        }
    },
    mounted() {},
    methods: {
        addNewComment() {
            let data = new FormData();
            data.append('id_obj', parseInt(this.obj_id));
            data.append('message', this.newComment);
            data.append('id_user', this.user_id)
            Axios.post('/api/comment', data, {
                headers: {
                    "X-CSRF-Token": this.csrf
                }
            }).then((res) => {
                console.log(res)
            })
        }
    }
};
</script>

<style></style>
