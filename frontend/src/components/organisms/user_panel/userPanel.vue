<template>
    <div class="user_panel">
        <div class="card squash">
            <h3 class="card-header" id="user_card_title">
                Информация по учетной записи пользователя
            </h3>
            <div class="card-body">
                <div class="text-center card-text">
                    <span>{{getUser.organization ? getUser.organization.name : ''}}</span>
                </div>
                <div class="text-center card-text  font-weight-bold">
                    <span>{{getUser.fio}}</span>
                </div>
                <div class="text-center card-text">
                    <span>{{getUser.position}}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
export default {
    name: "userPanel",
    data(){
        return {
            user:{}
        }
    },
    computed: {
        ...mapGetters(['getUser']),
    },
    methods:{
        ...mapActions(['requestUser']),
    },
    mounted() {
        this.requestUser();
        // this.user = this.getUser;
    }
}
</script>

<style scoped>


    #user_card_title{
        font-size: 85%;

    }

</style>