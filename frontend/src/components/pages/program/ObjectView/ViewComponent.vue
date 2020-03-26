<template>
    <div class="mt-3">
        <v-comments :obj_id="obj_id"/>
    </div>
</template>

<script>
import { CommentComponent } from "../../../organisms";
import { mapActions, mapGetters } from "vuex";
export default {
    components: {
        "v-comments": CommentComponent
    },
    data() {
        return {
            obj_id: null,
            user_id: null,
        };
    },
    async mounted() {
        this.obj_id = this.$route.params.id;
        await this.requestUser();
        this.user_id = this.getUser.organization.id;
    },
    computed: {
        ...mapGetters(["getUser"])
    },
    methods: {
        ...mapActions(["requestUser"])
    }
};
</script>
