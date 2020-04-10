<template>
    <div id="user-info-view">

    </div>
</template>

<script>
    import Axios from 'axios'
    import {mapActions,mapGetters} from 'vuex'
    export default {
        data(){
          return {
              id_org: 0
          }
        },
        computed:{
            ...mapGetters(['getUser']),
        },
        watch:{
            getUser:function () {
                Axios.get(`/api/getUsersInfo/${this.getUser.organization.id}`).then(res=>{
                    console.log(res.data);
                })
            }
        },
        methods:{
            ...mapActions(['requestUser']),
        },
        async mounted() {
            await this.requestUser();
        }
    }
</script>

<style scoped>

</style>