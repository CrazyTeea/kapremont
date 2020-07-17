<template>
    <div>
        <b-table-simple
                bordered
                hover
        >
            <b-thead>
                <b-tr>
                    <b-th>Виды рисков</b-th>
                    <b-th>Отрицательные влияния</b-th>
                    <b-th>Способы защиты</b-th>
                </b-tr>
            </b-thead>
            <b-tbody>
                <b-tr v-for="(item, index) in items" :key="index">
                    <b-th>
                        <b-form-input
                                type="text"
                                :name="`${modelName}[${index}][types]`"
                                v-model="item.types"
                        />
                    </b-th>
                    <b-th>
                        <b-form-input
                                type="text"
                                :name="`${modelName}[${index}][poison]`"
                                v-model="item.poison"
                        />
                    </b-th>
                    <b-th>
                        <b-form-input
                                type="text"
                                :name="`${modelName}[${index}][protect]`"
                                v-model="item.protect"
                        />
                    </b-th>
                </b-tr>
            </b-tbody>
            <b-tfoot>
                <b-tr>
                    <b-td
                            @click="deleteLastRow()"
                            v-if="items.length > 1"
                            colspan="2"
                            variant="secondary"
                            class="text-right text-danger">
                        Удалить строку
                    </b-td>
                    <b-td
                            colspan="3"
                            @click="addNewRow()"
                            variant="secondary"
                            class="text-right text-info">
                        Добавить строку
                    </b-td>
                </b-tr>
            </b-tfoot>
        </b-table-simple>
    </div>
</template>

<script>
    import {
        BFormInput,
        BTableSimple,
        BTbody,
        BTd,
        BTfoot,
        BTh,
        BThead,
        BTr,
        VBToggle
    } from "bootstrap-vue";

    export default {
        directives:{
            'b-toggle':VBToggle
        },
        components:{
            BFormInput,
            BTableSimple,
            BThead,
            BTr,
            BTh,
            BTd,
            BTbody,
            BTfoot,
        },
        props:{
            modelName:String
        },
        mounted() {
            if(window.MODEL.riscs[0]) {
                this.items.pop()
            }
            window.MODEL.riscs.forEach((item,index)=> {
                if (!index)
                    this.items[0] = {
                        types: item.types,
                        poison: item.poison,
                        protect: item.protect
                    };
                else this.items.push({
                    types: item.types,
                    poison: item.poison,
                    protect: item.protect
                });
            });
        },
        data(){
            return {
                items: [
                    {
                        types: null,
                        poison: null,
                        protect: null
                    }
                ]
            }
        },
        methods: {
            addNewRow: function() {
                this.items.push({
                    types: null,
                    poison: null,
                    protect: null
                })
            },
            deleteLastRow: function() {
                this.items.pop()
            }
        }
    }
</script>
