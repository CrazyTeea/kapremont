<template>
    <div>
        <b-card no-body class="mb-1">
            <b-card-header header-tag="header" class="p-1" role="tab" v-b-toggle.accordion-3>
                <span class="toggle_button" >
                    <b-icon icon="filter" scale="1.5" class="mr-2 ml-1"></b-icon>
                    Фильтры</span
                >
            </b-card-header>
            <b-collapse id="accordion-3" accordion="my-accordion" role="tabpanel" visible>
                <b-card-body>
                    <div>
                        <b-input-group prepend="ID" class="mb-2">
                            <b-form-input type="number" aria-label="First name" v-model="filters.id"></b-form-input>
                            <b-input-group-append>
                                <b-button variant="outline-secondary" @click="filters.id = null"><b-icon icon="backspace" variant="danger" scale="1.2"></b-icon></b-button>
                            </b-input-group-append>
                        </b-input-group>
                        <b-input-group prepend="username" class="mb-2">
                            <b-form-input aria-label="First name" v-model="filters.username"></b-form-input>
                            <b-input-group-append>
                                <b-button variant="outline-secondary" @click="filters.username = null"><b-icon icon="backspace" variant="danger" scale="1.2"></b-icon></b-button>
                            </b-input-group-append>
                        </b-input-group>
                    </div>
                </b-card-body>
            </b-collapse>
        </b-card>

        <b-table-simple class="mt-3"
            bordered
            hover
            >
                <b-thead>
                <b-tr>
                    <b-th>ID</b-th>
                    <b-th>Username</b-th>
                    <b-th>Организация</b-th>
                </b-tr>
                </b-thead>
                <b-tbody>
                <b-tr v-for="(user, index) in users" :key="index">
                    <b-th><label>{{ user.id }}</label></b-th>
                    <b-th><label>{{ user.username}}</label></b-th>
                    <b-th><label>{{ user.org}}</label></b-th>
                </b-tr>
                </b-tbody>
                <b-tfoot>
                
                </b-tfoot>
        </b-table-simple>
    </div>
</template>

<script>
import Axios from 'axios';
import {
    BTableSimple,
    BCard,
    BCardHeader,
    BCollapse,
    BCardBody,
    BInputGroup,
    BFormInput,
    BInputGroupAppend,
    BButton,
    BTr,
    BTh,
    BTbody,
    BPagination,
    BThead,
    VBToggle
} from 'bootstrap-vue'
export default {
    directives:{
        'b-toggle':VBToggle  
    },
    components:{
        BButton,
        BInputGroupAppend,
        BFormInput,
        BInputGroup,
        BCardBody,
        BCollapse,
        BTableSimple,
        BTbody,BTr,
        BTh,
        BPagination,
        BThead,
        BCard,
        BCardHeader
    },
    data() {
        return {
            csrf: document.getElementsByName('csrf-token')[0].content,
            filters: {
                id: null,
                username: null
            },
            users: [],
        }
    },
    async mounted(){
        await this.getTable()
        console.log('FaivAdmin')
    },
    methods: {
        async getTable(offset = 0) {
            let form = new FormData()
            form.append('filters', JSON.stringify(this.filters))
            return Axios.post(`/faiv-admin/get/users/${offset}`, form,{
                headers:
                    {
                        'X-CSRF-Token':this.csrf,
                    },
            }).then( res => {
                this.users = res.data
                console.log(res)
            })
        }
    },
    watch: {
        filters: {
            handler() {
                this.getTable();
            },
            deep: true
        }
    }
}
</script>