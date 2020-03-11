<template>
    <div class="overflow">
        <b-table-simple
            bordered
            hover
            >
                <b-thead>
                <b-tr>
                    <b-th class="vertical-align-for-table-cell">Направление расходов</b-th>
                    <b-th class="vertical-align-for-table-cell">Сумма бюджетного финансирования (руб)</b-th>
                    <b-th class="vertical-align-for-table-cell">Сумма внебюджетного финансирования (руб)</b-th>
                    <b-th class="vertical-align-for-table-cell">Сумма общий объем финансирования (руб)</b-th>
                </b-tr>
                </b-thead>
                <b-tbody>
                <b-tr v-for="(item, index) in items" :key="index">
                    <b-th class="vertical-align-for-table-cell normal-font-weight-for-cell">
                        <label>{{ item.label }}</label>
                    </b-th>
                    <b-th class="vertical-align-for-table-cell normal-font-weight-for-cell">
                        <b-form-input
                            v-model="item.cost_b" 
                            placeholder="Цена"
                            min="0"
                            type="number"
                        ></b-form-input>
                    </b-th>
                    <b-th class="vertical-align-for-table-cell normal-font-weight-for-cell">
                        <b-form-input
                            v-model="item.cost_v" 
                            placeholder="Цена"
                            min="0"
                            type="number"
                        ></b-form-input>
                    </b-th>
                    <b-th class="vertical-align-for-table-cell normal-font-weight-for-cell">
                        <label>{{ cost_o(index) }}</label>
                        <!-- <b-form-input
                            v-model="item.cost_o" 
                            placeholder="Цена"
                            min="0"
                            type="number"
                        ></b-form-input> -->
                    </b-th>
                </b-tr>
                </b-tbody>
                <b-tfoot>
                    <b-tr>
                     <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
                        <label>ИТОГО:</label>
                    </b-th>
                    <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
                        <label>{{ cost_b_full }}</label>
                    </b-th>
                    <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
                        <label>{{ cost_v_full }}</label>
                    </b-th>
                    <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
                        <label>{{ cost_o_full }}</label>
                    </b-th>
                    </b-tr>
                </b-tfoot>
        </b-table-simple>
        <div class="align-element-right">
            <b-button size="sm" variant="info" @click="sendInfo()">Сохранить</b-button>
            <b-button size="sm" variant="danger" @click="clearInputs()">Сброс</b-button>
        </div>
    </div>
</template>

<script>
import Axios from 'axios'

export default {

    mounted() {
        Axios.post()
    },

    data() {
        return {
            items: [
                {cost_b: null, cost_v: null, cost_o: null, label: 'Система видеонаблюдения'},
                {cost_b: null, cost_v: null, cost_o: null, label: 'Система оповещения и управления эвакуацией'},
                {cost_b: null, cost_v: null, cost_o: null, label: 'Система освещения'},
                {cost_b: null, cost_v: null, cost_o: null, label: 'Средства охранной сигнализации'},
                {cost_b: null, cost_v: null, cost_o: null, label: 'Средства тревожной сигнализации'},
                {cost_b: null, cost_v: null, cost_o: null, label: 'Средства пожарной сигнализации'},
                {cost_b: null, cost_v: null, cost_o: null, label: 'Средства телефонной связи и радиосвязи'},
                {cost_b: null, cost_v: null, cost_o: null, label: 'Ограждение (в т.ч. ворота, шлагбаумы)'},
                {cost_b: null, cost_v: null, cost_o: null, label: 'СКУД'},
            ],
        }
    },
    computed: {
        cost_o() {
            return index =>{ 
                let a = parseFloat(this.items[index].cost_b) || 0 ;
                let b = parseFloat(this.items[index].cost_v) || 0 ;
                this.items[index].cost_o = a + b;
                return a + b
                }
        },
        cost_b_full() {
            var sum = 0;
            for(let cost of this.items) {
                sum += parseInt(cost.cost_b) || 0
            }

            return sum
        },
        cost_v_full() {
            var sum = 0;
            for(let cost of this.items) {
                sum += parseInt(cost.cost_v) || 0
            }

            return sum
        },
        cost_o_full() {
            var sum = 0;
            for(let cost of this.items) {
                sum += parseInt(cost.cost_o) || 0
            }

            return sum
        }
    },
    methods: {
        clearInputs() {
            for(let val of this.items) {
                val.cost_b = null;
                val.cost_v = null;
                val.cost_o =null
            }
        },
        sendInfo() {
            console.log(this.items)
            // Axios.post('/куда-то там').then((res) => {
                
            // })
        }

    },
}
</script>

<style>
.normal-font-weight-for-cell {
    font-weight: normal !important;
}
.vertical-align-for-table-cell {
    vertical-align: middle !important;
    text-align: center !important;
}
.text-align-end-for-cell {
    text-align: end !important;
}
.align-element-right {
    float: right;
}
</style>