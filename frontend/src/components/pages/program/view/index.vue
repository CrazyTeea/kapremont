<template>

    <div id="dev_programme">
        <div class="row">
            <div class="col-6">
                <b-table
                        :fields="[{ key:'id',label:'№' },{ key:'label',label:'Показатель' },{ key:'value',label:'Значение' }]"
                        :items="
                        [
                        { id:'1',label:'Полное наименование организации',value:getUser && getUser.organization && getUser.organization.name },
                        { id:'2' ,label:'Сокращенное наименование организации',value:getUser && getUser.organization && getUser.organization.short_name},
                        ]"
                        small bordered
                />
                <b-button class="btn btn-sm" style="float: right" href="/organization/info">Подробнее</b-button>
            </div>

            <div class="col-4 offset-2">
                <v-user-panel />
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-6">
                <b-button variant="info" href="object/create">Добавить объект кап. ремонта</b-button>
                <b-button disabled>Добавить мероприятия по АТЗ</b-button>
            </div>
            <div class="col-6"></div>
        </div>
        <br>
        <div class="row" >
            <b-card no-body>
                <b-card-header header-tag="header" class="p-1" role="tab">
                       <span>
                           <b-icon-gear-wide-connected />
                           Объекты требующие капитального ремонта</span>
                </b-card-header>
                <b-card-body>
                    <b-card-text>Приоритетные объекты</b-card-text>
                    <b-table
                            class="text-center"
                            :items="priorityObjects && priorityObjects.items"
                            :fields="fieldsObjects && fieldsObjects.fields"
                            small bordered
                    />
                    <b-card-text>Резервные объекты</b-card-text>
                    <b-table
                            class="text-center"
                            :items="reservedObjects && reservedObjects.items"
                            :fields="fieldsObjects && fieldsObjects.fields"
                            small bordered
                    />
                </b-card-body>
            </b-card>

            <!--<div class="col-12">
                <b-card no-body class="mb-1">
                    <b-card-header header-tag="header" class="p-1" role="tab">
                   <span class="toggle_button" v-b-toggle.accordion-1>
                       <b-icon-gear-wide-connected />
                       Объекты</span>
                    </b-card-header>
                    <b-collapse id="accordion-1" visible accordion="my-accordion" role="tabpanel">
                        <b-card-body>
                            <b-table
                                    class="text-center"
                                    :items="objects && objects.items"
                                    :fields="objects && objects.fields"
                                    small bordered
                            />
                        </b-card-body>
                    </b-collapse>
                </b-card>
                <b-card no-body class="mb-1">
                    <b-card-header header-tag="header" class="p-1" role="tab">
                   <span class="toggle_button" v-b-toggle.accordion-2>
                       <b-icon-gear-wide-connected />
                       Цели и задачи реализации программы</span>
                    </b-card-header>
                    <b-collapse id="accordion-2" accordion="my-accordion" role="tabpanel">
                        <b-card-body>
                            <b-table
                                    class="text-center"
                                    :items="target && target.items"
                                    :fields="target && target.fields"
                                    small bordered
                            />
                        </b-card-body>
                    </b-collapse>
                </b-card>
                <b-card no-body class="mb-1">
                    <b-card-header header-tag="header" class="p-1" role="tab">
                   <span  class="toggle_button" v-b-toggle.accordion-3 >
                       <b-icon-gear-wide-connected />
                       Потребность в бюджетных ассигнованиях на проведение кап. ремонта приоритетных объектов</span>
                    </b-card-header>
                    <b-collapse id="accordion-3" accordion="my-accordion" role="tabpanel">
                        <b-card-body>
                            <b-card-text>Приоритетные объекты</b-card-text>
                            &lt;!&ndash;

                             <b-table
                                    class="text-center"
                                    :items="priorityObjects && priorityObjects.items"
                                    :fields="fieldsObjects && fieldsObjects.fields"
                                    small bordered
                            />
                            <b-card-text>Резервные объекты</b-card-text>
                            <b-table
                                    class="text-center"
                                    :items="reservedObjects && reservedObjects.items"
                                    :fields="fieldsObjects && fieldsObjects.fields"
                                    small bordered
                            />
                             &ndash;&gt;
                        </b-card-body>
                    </b-collapse>
                </b-card>
            </div>-->
        </div>
        <div class="row">
            <div class="col-6"></div>
            <div class="col-6 offset-7">
                <b-button disabled class="btn btn-sm">Выгрузить программу</b-button>
                <b-button disabled class="btn btn-sm">Загрузить PDF</b-button>
                <b-button disabled class="btn btn-sm">Отправить на согласование</b-button>
            </div>
        </div>
    </div>
</template>

<script>
    import {userPanel} from "../../../organisms";
    import {mapGetters,mapActions} from 'vuex'
    export default {
        name: "ProgramView",
        data(){
            return{
                text:'dfs',

            }
        },
        components:{
            "v-user-panel":userPanel
        },
        methods:{
            ...mapActions(['requestPageData'])
        },
        computed:{
            ...mapGetters(['getUser','getPageData']),
            objects(){
                return this.getPageData && this.getPageData.objects
            },
            fieldsObjects(){
                return this.getPageData && this.getPageData.fieldsObjects
            },
            priorityObjects(){
                return this.getPageData && this.getPageData.priorityObjects
            },
            reservedObjects(){
                return this.getPageData && this.getPageData.reservedObjects
            },
            target(){
                return this.getPageData && this.getPageData.target
            },
        },
        mounted() {
            this.requestPageData({pageName:"programView"});
        }
    }
</script>

<style scoped>
    .toggle_button{
        display: block;
        cursor: pointer;
    }
    .card-body{
        overflow-y: auto;
    }
</style>