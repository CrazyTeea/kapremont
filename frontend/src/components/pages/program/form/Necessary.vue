<template>
    <div>
        <b-table
            bordered
            :fields="fields"
            :items="items"
        >
            <template v-slot:cell(nalichie)="row">
                <input type="checkbox" :value="'check' + row.index" v-model="nalichie[row.index]">
                <label @click="returnData(row)" :for="'check' + row.index">{{ row.index }}</label>
            </template>
            <template v-slot:cell(material)="row">
                <b-form-input
                    v-if="nalichie[row.index]"
                    v-model="material[row.index]" 
                    placeholder="Материалы"
                    type="text"
                ></b-form-input>
            </template>
            <template v-slot:cell(srok_eks)="row">
                <b-form-datepicker
                    reset-button
                    label-reset-button="сбросить"
                    size="sm"
                    placeholder="дата"
                    v-if="nalichie[row.index]"
                    v-model="srok_eks[row.index]"></b-form-datepicker>
            </template>
            <template v-slot:cell(kap_remont)="row">
                <input 
                type="checkbox"
                v-if="nalichie[row.index]"
                :value="'rem' + row.index"
                v-model="kap_remont[row.index]" 
                >
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
            nalichie: [],
            material: [],
            srok_eks: [],
            kap_remont: [],
            obosnovanie: [],
            fields: [
                {key: 'stroi_konstr', label: 'Строительные конструкции замена и (или) восстановление которых планируются при капитальном ремонте'},
                {key: 'nalichie', label: 'Наличие на объекте'},
                {key: 'material', label: 'Материал конструкции'},
                {key: 'srok_eks', label: 'Срок эксплуатации с момента строительства или предыдущего капитального ремонта'},
                {key: 'kap_remont', label: 'Требуется капитальный ремонт'},
                {key: 'obosnovanie', label: 'Обоснование необходим'},
            ],
            items: [
                {stroi_konstr: 'Фундаменты', label: 'Фундаменты'},
                {stroi_konstr: 'Отмостка', label: 'Необходимость выполнения'},
                {stroi_konstr: 'Стены', label: 'Дата начала', tdClass: 'date'},
                {stroi_konstr: 'Колонны', label: 'Дата окончания', tdClass: 'date'},
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
        nalichie: function() {
            this.nalichie.forEach((element, index) => {
                console.log(element, index)
            });
        }
    },
    methods: {
        returnData(data) {
            console.log(data)
            console.log(this.material)
        }
    }
}
</script>