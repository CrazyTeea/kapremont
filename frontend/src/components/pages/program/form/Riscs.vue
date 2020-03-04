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
                            v-model="dataItems.types[index]" 
                        ></b-form-input>
                    </b-th>
                    <b-th>
                        <b-form-input 
                            type="text"
                            v-model="dataItems.poison[index]" 
                        ></b-form-input>
                    </b-th>
                    <b-th>
                        <b-form-input 
                            type="text"
                            v-model="dataItems.protect[index]" 
                        ></b-form-input>
                    </b-th>
                </b-tr>
                </b-tbody>
                <b-tfoot>
                <b-tr>
                    <b-td
                        @click="deleteLastRow()"
                        v-if="items.length"
                        colspan="2"
                        variant="secondary"
                        class="text-right text-danger">
                        Удалить строку
                    </b-td>
                    <b-td
                        colspan="3"
                        @click="addNewRow()"
                        variant="secondary"
                        class="text-right">
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
            items: [],
            dataItems: {
                types: [],
                poison: [],
                protect: []
            },
        }
    },
    methods: {
        addNewRow: function() {
            let returd = this.items.length
            this.items.push(returd)
        },
        deleteLastRow: function() {
            this.items.pop()
            this.dataItems.types.pop()
            this.dataItems.poison.pop()
            this.dataItems.protect.pop()
        }
    }

}
</script>
