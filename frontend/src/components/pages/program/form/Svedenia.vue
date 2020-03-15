<template>
    <div class="hidden-val-for-table">
        <b-table
            bordered
            foot-clone
            hover
            caption-top
            :fields="fields"
            :items="stages"
            >
                <template v-slot:cell(is_nessesary)="row">
                    <input type="hidden" v-model="sved.is_nessesary[row.index]" :name="`${modelName}[${row.index}][is_nessesary]`">
                    <v-select
                        class="mt-5"
                        v-model="sved.is_nessesary[row.index]"
                        label="type"
                        :options="[
                            {id:1,type:'Да'},
                            {id:0,type:'Нет'}
                        ]"
                        :reduce = "type => type.id"
                    />
                </template>
                <template v-slot:cell(begin_date)="row">
                    <b-form-input type="date" v-model="sved.begin_date[row.index]" :name="`${modelName}[${row.index}][date_event_start]`" />
                    <!--<b-form-datepicker
                        today-button
                        label-today-button="сегодня"
                        reset-button
                        label-reset-button="сбросить"
                        placeholder="дата"
                        size="sm"
                        :name="`${modelName}[${row.index}][date_event_start]`"
                        v-model="sved.begin_date[row.index]">
                    </b-form-datepicker>-->
                </template>
                <template v-slot:cell(final_date)="row">
                    <b-form-input type="date" v-model="sved.final_date[row.index]" :name="`${modelName}[${row.index}][date_event_end]`" />
                    <!--<b-form-datepicker
                        today-button
                        label-today-button="сегодня"
                        reset-button
                        label-reset-button="сбросить"
                        size="sm"
                        placeholder="дата"
                        :name="`${modelName}[${row.index}][date_event_end]`"
                        v-model="sved.final_date[row.index]"></b-form-datepicker>-->
                </template>
                <template v-slot:cell(rc)="row">
                    <b-form-input
                        v-if="row.value" 
                        v-model="sved.realization_cost[row.index]" 
                        placeholder="Цена"
                        step="0.001"
                        type="number"
                        @change="val => setFloat(val,row.index,'realization_cost')"
                        :name="`${modelName}[${row.index}][cost_real]`"
                        ></b-form-input>
                        <label v-else>-</label>
                </template>
                <template v-slot:cell(kap_cost)="row">
                    <b-form-input
                        v-if="row.value" 
                        v-model="sved.kap_cost[row.index]" 
                        placeholder="Цена"
                        step="0.001"
                        type="number"
                        @change="val => setFloat(val,row.index,'kap_cost')"
                        :name="`${modelName}[${row.index}][sum_bud_fin]`"
                        ></b-form-input>
                        <label v-else>-</label>
                </template>
                <template v-slot:cell(finanse)="row">
                    <b-form-input
                        v-if="row.value"
                        v-model="sved.finanse[row.index]"
                        placeholder="Цена"
                        step="0.001"
                        type="number"
                        @change="val => setFloat(val,row.index,'finanse')"
                        :name="`${modelName}[${row.index}][fin_vnebud_ist]`"
                        ></b-form-input>
                        <label v-else>-</label>
                </template>
                <template v-slot:foot(stage)>
                    <span class="font-weight-bold">ИТОГО:</span>
                </template>
                <template v-slot:foot(is_nessesary)>
                    <span class="font-weight-bold"></span>
                </template>
                <template v-slot:foot(begin_date)>
                    <span class="font-weight-bold"></span>
                </template>
                <template v-slot:foot(final_date)>
                    <span class="font-weight-bold"></span>
                </template>
                <template v-slot:foot(rc)>
                    <span class="font-weight-bold">{{ rc_full }}</span>
                </template>
                <template v-slot:foot(kap_cost)>
                    <span class="font-weight-bold">{{ kap_full }}</span>
                </template>
                <template v-slot:foot(finanse)>
                    <span class="font-weight-bold">{{ finanse_sum }}</span>
                </template>
        </b-table>
    </div>
</template>

<script>
import Multiselect from 'vue-select';

    export default {
        name: "Svedenia",
        mounted() {
            if (Array.isArray(window.MODEL.svedenia)){
                window.MODEL.svedenia.forEach((item,index)=>{
                    this.sved.is_nessesary[index]=item.is_nessesary;
                    this.sved.begin_date[index]=item.date_event_start;
                    this.sved.final_date[index]=item.date_event_end;
                    this.sved.realization_cost[index]=item.cost_real;
                    this.sved.kap_cost[index]=item.sum_bud_fin;
                    this.sved.finanse[index]=item.fin_vnebud_ist;
                });
            }
        },
        components: {
            "v-select": Multiselect,    
        },
        methods:{
            setFloat(val,index, attr) {
                if (val.search('.') !=-1)
                    val.replace('.',',');
                this.sved[attr][index] = parseFloat(val).toFixed(3);
            },
            getSved(){
                return this.sved;
            }
        },
        props:{
          modelName:String
        },
        computed: {
            test(){
                return index => this.masObj[index]?.finance // ? this.masObj[index].finanse : this.masObj[index]
            },
            rc_full() {
                var sum = 0;
                for(let key in this.sved.realization_cost){
                    sum += (parseFloat(this.sved.realization_cost[key]).toFixed(3)*1 || 0);
                }
                return sum.toFixed(3);
            },
            kap_full() {
                var sum = 0;
                for(let key in this.sved.kap_cost){
                    sum += (parseFloat(this.sved.kap_cost[key]).toFixed(3)*1 || 0);
                }
                return sum.toFixed(3);
            },
            finanse_sum() {
                var sum = 0;
                for(let key in this.sved.finanse){
                    sum += (parseFloat(this.sved.finanse[key]).toFixed(3)*1 || 0);
                }
                return sum.toFixed(3);

            }
        },
        data() {
            return {
                fields: [
                    {key: 'stage', label: 'Этап'},
                    {key: 'is_nessesary', label: 'Необходимость выполнения'},
                    {key: 'begin_date', label: 'Дата начала', tdClass: 'date vertical-align-extra-table'},
                    {key: 'final_date', label: 'Дата окончания', tdClass: 'date vertical-align-extra-table'},
                    {key: 'rc', label: 'Стоимость реализации (тыс.руб)', tdClass: 'vertical-align-extra-table'},
                    {key: 'kap_cost', label: 'Сумма бюджетного финансирования на проведение кап.ремонта (тыс.руб)', tdClass: 'vertical-align-extra-table'},
                    {key: 'finanse', label: 'Софинансирование из внебюджетных источников (тыс.руб)', tdClass: 'vertical-align-extra-table'},
                ],
                stages: [
                    {
                        'stage': 'Проведение тендера и заключение договора на выполнение обследования', 
                        'rc': false,
                        'kap_cost': false,
                        'finanse':  false
                    },
                    {
                        'stage': 'Выполнение обследования, подготовка и утверждение дефектного акта', 
                        'rc': true,
                        'kap_cost': false,
                        'finanse':  true
                    },
                    {
                        'stage': 'Утверждение задания на проектирование',
                        'rc': false,
                        'kap_cost': false,
                        'finanse':  false
                    },
                    {
                        'stage': 'Проведение тендера и заключение договора на подготовку проектно-сметной документации',
                        'rc': false,
                        'kap_cost': false,
                        'finanse':  false
                    },
                    {
                        'stage': 'Подготовка проектно-сметной документации',
                        'rc': true,
                        'kap_cost': true,
                        'finanse':  true
                    },
                    {
                        'stage': 'Прохождение экспертизы проектно-сметной документации',
                        'rc': true,
                        'kap_cost': true,
                        'finanse':  true
                    },
                    {
                        'stage': 'Проведение тендера и заключение договора на выполнение строительно-монтажных работ',
                        'rc': false,
                        'kap_cost': false,
                        'finanse':  false
                    },
                    {
                        'stage': 'Выполнение строительно-монтажных работ',
                        'rc': true,
                        'kap_cost': true,
                        'finanse':  true
                    },
                ],
                sved: {
                    is_nessesary: [],
                    begin_date: [],
                    final_date: [],
                    realization_cost: [],
                    kap_cost: [],
                    finanse:[]
                }, 
                masObj: [
                    {
                        is_nessesary: true,
                        begin_date: undefined,
                        final_date: undefined,
                        realization_cost: undefined,
                        kap_cost: undefined,
                        finanse: undefined
                    }
                ]
            }
        },
    }
</script>

<style>
    .date {
        min-width: 111px !important;
    }
</style>

<style>
.hidden-val-for-table {
    overflow: hidden !important;
    overflow-x: scroll !important;
}
.vertical-align-extra-table {
    vertical-align: middle !important;
}
</style>
