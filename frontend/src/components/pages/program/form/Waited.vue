<template>
    <div>
        <b-table-simple
            bordered
            hover
            responsive
            >
                <b-thead>
                <b-tr>
                    <b-th>Цели и задачи</b-th>
                    <b-th>Планируемый показатель</b-th>
                    <b-th>Единица измерения</b-th>
                </b-tr>
                </b-thead>
                <b-tbody>
                <b-tr v-for="(item, index) in items" :key="index">
                    <b-th class="font-normal-first-colomn">
                        <label>{{ item.label }}</label>
                    </b-th>
                    <b-th>
                        <b-form-input 
                            type="text"
                            v-model="dataItems.plan[index]" 
                        ></b-form-input>
                    </b-th>
                    <b-th class="font-normal-first-colomn">
                        <label>{{ item.izm }}</label>
                    </b-th>
                </b-tr>
                <b-tr v-for="(item, index) in newElems" :key="index + 5">
                    <b-th>
                        <b-form-input 
                            type="text"
                            v-model="dataItems.aims[second_index(index)]" 
                        ></b-form-input>
                    </b-th>
                    <b-th>
                        <b-form-input 
                            type="text"
                            v-model="dataItems.plan[second_index(index)]" 
                        ></b-form-input>
                    </b-th>
                    <b-th>
                        <b-form-input 
                            type="text"
                            v-model="dataItems.izm[second_index(index)]" 
                        ></b-form-input>
                    </b-th>
                </b-tr>
                </b-tbody>
                <b-tfoot>
                <b-tr>
                    <!-- <b-td
                        @click="deleteLastRow()"
                        v-if="this.lastIndex!=5"
                        colspan="2"
                        variant="secondary"
                        class="text-right text-danger">
                        Удалить строку
                    </b-td> -->
                    <b-td
                        colspan="3"
                        variant="secondary"
                        class="text-right">
                        Скоро здесь можно будет добавить строку
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
                {label: 'Проведение капитального ремонта, общая площадь', izm: 'кв.м'},
                {label: 'Вовлечение в хозяйственную деятельность за счет проведенного капитального ремонта, общая площадь', izm: 'кв.м'},
                {label: 'Снижение затрат на эксплуатацию', izm: 'да/нет'},
                {label: 'Повышение энергоэффективности', izm: 'да/нет'},
                {label: 'Восстановление (ремонт, реставрация, за исключением реконструкции) объектов культурного наследия ', izm: 'да/нет'}
            ],
            newElems: [],
            dataItems: {
                aims: [],
                plan: [],
                izm: []
            },
            lastIndex: 5
        }
    },
    computed: {
        second_index() {
            return index => index + 5 && this.setLastIndex(index)
        }
    },
    methods: {
        addNewRow: function() {
            let returd = this.newElems.length
            this.newElems.push(returd)
            // console.log(this.newElems)
        },
        deleteLastRow: function() {
            this.newElems.pop()
            this.dataItems.aims.pop()
            this.dataItems.plan.pop()
            this.dataItems.izm.pop()
        },
        setLastIndex: function(index) {
            
            this.lastIndex = index
        }
    }

}
</script>

<style>
.font-normal-first-colomn {
    font-weight: normal !important;
}
</style>