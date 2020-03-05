<template>
    <div>
        <b-table-simple
            bordered
            hover
            responsive
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
                            v-model="item.types" 
                        ></b-form-input>
                    </b-th>
                    <b-th>
                        <b-form-input 
                            type="text"
                            v-model="item.poison" 
                        ></b-form-input>
                    </b-th>
                    <b-th>
                        <b-form-input
                            type="text"
                            v-model="item.protect"
                        ></b-form-input>
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
import BootstrapVue from 'bootstrap-vue';

export default {
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
            console.log(this.items)

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
