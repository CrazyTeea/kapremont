<template>
    <div class="overflow">
        <b-table
            bordered
            :fields="fields"
            :items="items"
        >
            <template v-slot:cell(nalichie)="row">
                <input type="checkbox" :value="'check' + row.index" v-model="dataToSend.nalichie[row.index]">
                <!-- <label @click="returnData(row)" :for="'check' + row.index">{{ row.index }}</label> -->
            </template>
            <template v-slot:cell(material)="row">
                <b-form-input
                    v-if="dataToSend.nalichie[row.index]"
                    v-model="dataToSend.material[row.index]" 
                    placeholder="Материалы"
                    type="text"
                ></b-form-input>
            </template>
            <template v-slot:cell(srok_eks)="row">
                <b-form-input 
                    type="text"
                    v-if="dataToSend.nalichie[row.index]"
                    v-model="dataToSend.srok_eks[row.index]" 
                ></b-form-input>
            </template>
            <template v-slot:cell(kap_remont)="row">
                <input 
                type="checkbox"
                v-if="dataToSend.nalichie[row.index]"
                :value="'rem' + row.index"
                v-model="dataToSend.kap_remont[row.index]" 
                >
            </template>
            <template v-slot:cell(obosnovanie)="row">
                <b-form-input 
                placeholder="Обоснование"
                type="text"
                v-if="dataToSend.nalichie[row.index]"
                v-model="dataToSend.obosnovanie[row.index]" 
                ></b-form-input>
            </template>
        </b-table>
    </div>
</template>

<script>
import BootstrapVue from 'bootstrap-vue';

export default {
    data() {
        return{
            dataSend: [],
            dataToSend: {
                nalichie: [],
                material: [],
                srok_eks: [],
                kap_remont: [],
                obosnovanie: [],
            },
            nalichie: [],
            material: [],
            srok_eks: [],
            kap_remont: [],
            obosnovanie: [],
            fields: [
                {key: 'stroi_konstr', label: 'Строительные конструкции замена и (или) восстановление которых планируются при капитальном ремонте'},
                {key: 'nalichie', label: 'Наличие на объекте', tdClass: 'extra-table-class'},
                {key: 'material', label: 'Материал конструкции', tdClass: 'vertical-align-centre-extra-table'},
                {key: 'srok_eks', label: 'Срок эксплуатации с момента строительства или предыдущего капитального ремонта', tdClass: 'vertical-align-centre-extra-table'},
                {key: 'kap_remont', label: 'Требуется капитальный ремонт', tdClass: 'extra-table-class'},
                {key: 'obosnovanie', label: 'Обоснование необходимости', tdClass: 'vertical-align-centre-extra-table'},
            ],
            items: [
                {stroi_konstr: 'Фундаменты', label: 'Фундаменты'},
                {stroi_konstr: 'Отмостка', label: 'Необходимость выполнения'},
                {stroi_konstr: 'Стены', label: 'Дата начала'},
                {stroi_konstr: 'Колонны', label: 'Дата окончания'},
                {stroi_konstr: 'Перегородки', label: 'Стоимость реализации (тыс.руб)'},
                {stroi_konstr: 'Крыша', label: 'Сумма бюджетного финансирования на проведение кап.ремонта (тыс.руб)'},
                {stroi_konstr: 'Кровля', label: 'Софинансирование из внебюджетных источников (тыс.руб)'},
                {stroi_konstr: 'Перекрытия', label: 'Софинансирование из внебюджетных источников (тыс.руб)'},
                {stroi_konstr: 'Полы', label: 'Софинансирование из внебюджетных источников (тыс.руб)'},
                {stroi_konstr: 'Окна', label: 'Софинансирование из внебюджетных источников (тыс.руб)'},
                {stroi_konstr: 'Двери', label: 'Софинансирование из внебюджетных источников (тыс.руб)'},
                {stroi_konstr: 'Ворота', label: 'Софинансирование из внебюджетных источников (тыс.руб)'},
                {stroi_konstr: 'Лестницы', label: 'Софинансирование из внебюджетных источников (тыс.руб)'},
                {stroi_konstr: 'Крыльца', label: 'Софинансирование из внебюджетных источников (тыс.руб)'},
                {stroi_konstr: 'Балконы/Лоджии', label: 'Софинансирование из внебюджетных источников (тыс.руб)'},
                {stroi_konstr: 'Внутренняя отделка', label: 'Софинансирование из внебюджетных источников (тыс.руб)'},
                {stroi_konstr: 'Наружняя отделка', label: 'Софинансирование из внебюджетных источников (тыс.руб)'},
            ],
        }
    },
    watch:{
        dataToSend: function () {
            // console.log('датаТуСенд')
            // console.log(this.dataToSend)
        },
        nalichie: function() {
            this.nalichie.forEach((element, index) => {
            // console.log(this.nalichie)

                if(this.nalichie[index] && this.nalichie[index].length) {
                    this.dataSend[index].push(this.material[index], this.srok_eks[index], this.kap_remont[index], this.obosnovanie[index])
                }
                // console.log(this.dataSend)
            }); 
        }
    },
    methods: {
        getData(){
          return this.dataToSend;
        },
        returnData(data) {
            // console.log(data)
            // console.log(this.material)
        }
    }
}
</script>

<style>
.extra-table-class {
    vertical-align: middle !important;
    text-align: center;
}
.vertical-align-centre-extra-table {
    vertical-align: middle !important;
}
.overflow {
    overflow: hidden;
}
</style>