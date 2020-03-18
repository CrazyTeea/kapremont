<template>
    <div>работает</div>
</template>

<script>
export default {
    data() {
        return {
            org_id: null
        };
    },
    mounted() {
        this.org_id = this.$route.params.id;
    },
    methods: {
        getCurentOrg() {
            Axios.post("/rest/organizations/by-id", {
                id: this.org_id
            })
                .then(response => {
                    ctx.commit("updateOrg", response.data);
                })
                .catch(error => {
                    console.error(error);
                });
        }
    }
};
</script>

<style></style>template
