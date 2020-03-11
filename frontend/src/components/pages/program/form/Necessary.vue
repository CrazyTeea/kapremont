<template>
    <div class="overflow">
        <b-table-simple
                bordered
                hover
        >
            <b-thead>
                <b-tr>
                    <b-th>Строительные конструкции замена и (или) восстановление которых планируются при капитальном ремонте</b-th>
                    <b-th>Наличие на объекте</b-th>
                    <b-th>Материал конструкции</b-th>
                    <b-th>Срок эксплуатации с момента строительства или предыдущего капитального ремонта</b-th>
                    <b-th>Требуется капитальный ремонт</b-th>
                    <b-th>Обоснование необходимости</b-th>
                </b-tr>
            </b-thead>
            <b-tbody>
                <b-tr v-for="(item, index) in items" :key="index">
                    <input v-if="item.nalichie" type="hidden" v-model="item.element" :name="`${modelName}[${index}][element]`">
                    <b-th class="normal-font-weight-for-table cell-center-for-table">
                        <label>{{ item.label}}</label>
                    </b-th>
                    <b-th class="cell-center-for-table">
                        <b-form-checkbox value="1" type="checkbox" v-model="item.nalichie" :name="`${modelName}[${index}][nalichie]`"></b-form-checkbox>
                    </b-th>
                    <b-th class="cell-center-for-table">
                        <b-form-input
                                :name="`${modelName}[${index}][material]`"
                                v-if="item.nalichie"
                                v-model="item.material"
                                placeholder="Материалы"
                                type="text"
                        ></b-form-input>
                    </b-th>
                    <b-th class="cell-center-for-table">
                        <b-form-input
                                :name="`${modelName}[${index}][srok_eks]`"
                                type="text"
                                v-if="item.nalichie"
                                v-model="item.srok_eks"
                                placeholder="Срок"
                        ></b-form-input>
                    </b-th>
                    <b-th class="cell-center-for-table">
                        <b-form-checkbox
                                value="1"
                                :name="`${modelName}[${index}][kap_remont]`"
                                type="checkbox"
                                v-if="item.nalichie"
                                v-model="item.kap_remont"
                        ></b-form-checkbox>
                    </b-th>
                    <b-th class="cell-center-for-table">
                        <b-form-input
                                :name="`${modelName}[${index}][obosnovanie]`"
                                type="text"
                                v-if="item.nalichie && item.kap_remont"
                                v-model="item.obosnovanie"
                                placeholder="Обоснование"
                        ></b-form-input>
                    </b-th>
                </b-tr>
            </b-tbody>
        </b-table-simple>

        <b-table-simple
                bordered
                hover
        >
            <b-thead>
                <b-tr>
                    <b-th>Системы инженерно-технического обеспечения замена и (или) восстановление которых планируются при капитальном ремонте</b-th>
                    <b-th>Наличие на объекте</b-th>
                    <b-th>Срок эксплуатации с момента строительства или предыдущего капитального ремонта</b-th>
                    <b-th>Требуется капитальный ремонт</b-th>
                    <b-th>Обоснование необходимости</b-th>
                </b-tr>
            </b-thead>
            <b-tbody>
                <b-tr v-for="(item, index) in itemsTwo" :key="index">
                    <input v-if="item.nalichie" type="hidden" v-model="item.element" :name="`${modelName}[${index}][element]`">
                    <b-th class="normal-font-weight-for-table cell-center-for-table">
                        <label>{{ item.label}}</label>
                    </b-th>
                    <b-th class="cell-center-for-table">
                        <b-form-checkbox type="checkbox" value="1" v-model="item.nalichie" :name="`${modelName}[${index+17}][obosnovanie]`"></b-form-checkbox>
                    </b-th>
                    <b-th class="cell-center-for-table">
                        <b-form-input
                                :name="`${modelName}[${index+17}][srok_eks]`"
                                type="text"
                                v-if="item.nalichie"
                                v-model="item.srok_eks"
                                placeholder="Срок"
                        ></b-form-input>
                    </b-th>
                    <b-th class="cell-center-for-table">
                        <b-form-checkbox
                                value="1"
                                :name="`${modelName}[${index+17}][kap_remont]`"
                                type="checkbox"
                                v-if="item.nalichie"
                                v-model="item.kap_remont"
                        ></b-form-checkbox>
                    </b-th>
                    <b-th class="cell-center-for-table">
                        <b-form-input
                                :name="`${modelName}[${index+17}][obosnovanie]`"
                                type="text"
                                v-if="item.nalichie"
                                v-model="item.obosnovanie"
                                placeholder="Обоснование"
                        ></b-form-input>
                    </b-th>
                </b-tr>
            </b-tbody>
        </b-table-simple>
    </div>
</template>

<script>
    export default {
        props:{
            modelName:String
        },
        mounted() {

            function getKeyByValue(object,attr, value) {
                let f;
                object.forEach(obj => {
                    if (obj[attr] == value)
                        f= obj;
                });
                return f;
            }

            this.items.forEach((item,index)=>{
                let it = getKeyByValue(window.MODEL.necessary,'element',index);
                item.nalichie = it?.nalichie;
                item.material = it?.material;
                item.srok_eks = it?.srok_eks;
                item.kap_remont = it?.kap_remont;
                item.obosnovanie = it?.obosnovanie;
            });
            this.itemsTwo.forEach((item,index)=>{
                let it = getKeyByValue(window.MODEL.necessary,'element',index);
                item.nalichie = it?.nalichie;
                item.srok_eks = it?.srok_eks;
                item.kap_remont = it?.kap_remont;
                item.obosnovanie = it?.obosnovanie;
            })

        },
        data() {
            return{
                items: [
                    {label: 'Фундаменты', nalichie: null, material: null, srok_eks: null, kap_remont: null, obosnovanie: null ,element:0},
                    {label: 'Отмостка', nalichie: null, material: null, srok_eks: null, kap_remont: null, obosnovanie: null,element:1},
                    {label: 'Стены', nalichie: null, material: null, srok_eks: null, kap_remont: null, obosnovanie: null,element:2},
                    {label: 'Колонны', nalichie: null, material: null, srok_eks: null, kap_remont: null, obosnovanie: null,element:3},
                    {label: 'Перегородки', nalichie: null, material: null, srok_eks: null, kap_remont: null, obosnovanie: null,element:4},
                    {label: 'Крыша', nalichie: null, material: null, srok_eks: null, kap_remont: null, obosnovanie: null,element:5},
                    {label: 'Кровля', nalichie: null, material: null, srok_eks: null, kap_remont: null, obosnovanie: null,element:6},
                    {label: 'Перекрытия', nalichie: null, material: null, srok_eks: null, kap_remont: null, obosnovanie: null,element:7},
                    {label: 'Полы', nalichie: null, material: null, srok_eks: null, kap_remont: null, obosnovanie: null,element:8},
                    {label: 'Окна', nalichie: null, material: null, srok_eks: null, kap_remont: null, obosnovanie: null,element:9},
                    {label: 'Двери', nalichie: null, material: null, srok_eks: null, kap_remont: null, obosnovanie: null,element:10},
                    {label: 'Ворота', nalichie: null, material: null, srok_eks: null, kap_remont: null, obosnovanie: null,element:11},
                    {label: 'Лестницы', nalichie: null, material: null, srok_eks: null, kap_remont: null, obosnovanie: null,element:12},
                    {label: 'Крыльца', nalichie: null, material: null, srok_eks: null, kap_remont: null, obosnovanie: null,element:13},
                    {label: 'Балконы/Лоджии', nalichie: null, material: null, srok_eks: null, kap_remont: null, obosnovanie: null,element:14},
                    {label: 'Внутренняя отделка', nalichie: null, material: null, srok_eks: null, kap_remont: null, obosnovanie: null,element:15},
                    {label: 'Наружняя отделка', nalichie: null, material: null, srok_eks: null, kap_remont: null, obosnovanie: null,element:16},
                ],
                itemsTwo: [
                    {label: 'Система электроснабжения', nalichie: null, srok_eks: null, kap_remont: null, obosnovanie: null,element:17},
                    {label: 'Система водоснабжения', nalichie: null, srok_eks: null, kap_remont: null, obosnovanie: null,element:18},
                    {label: 'Система водоотведения', nalichie: null, srok_eks: null, kap_remont: null, obosnovanie: null,element:19},
                    {label: 'Система газоснабжения', nalichie: null, srok_eks: null, kap_remont: null, obosnovanie: null,element:20},
                    {label: 'Система кондиционирования воздуха', nalichie: null, srok_eks: null, kap_remont: null, obosnovanie: null,element:21},
                    {label: 'Система вентиляции', nalichie: null, srok_eks: null, kap_remont: null, obosnovanie: null,element:22},
                    {label: 'Система отопления', nalichie: null, srok_eks: null, kap_remont: null, obosnovanie: null,elementt:23},
                    {label: 'Система диспетчеризации', nalichie: null, srok_eks: null, kap_remont: null, obosnovanie: null,element:24},
                    {label: 'Радиофикация', nalichie: null, srok_eks: null, kap_remont: null, obosnovanie: null,element:25},
                    {label: 'Телевидение эфирное', nalichie: null, srok_eks: null, kap_remont: null, obosnovanie: null,element:26},
                    {label: 'Система видеонаблюдения', nalichie: null, srok_eks: null, kap_remont: null, obosnovanie: null,element:27},
                    {label: 'Система интернет и телефонии', nalichie: null, srok_eks: null, kap_remont: null, obosnovanie: null,element:28},
                    {label: 'Система контроля управления доступом', nalichie: null, srok_eks: null, kap_remont: null, obosnovanie: null,element:29},
                    {label: 'Пожарная сигнализация', nalichie: null, srok_eks: null, kap_remont: null, obosnovanie: null,element:30},
                    {label: 'Охранная сигнализация', nalichie: null, srok_eks: null, kap_remont: null, obosnovanie: null,element:31},
                    {label: 'Мусоропроводы', nalichie: null, srok_eks: null, kap_remont: null, obosnovanie: null,element:32},
                    {label: 'Лифты', nalichie: null, srok_eks: null, kap_remont: null, obosnovanie: null,element:33},
                ],
            }
        },
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
    .normal-font-weight-for-table {
        font-weight: normal !important;
    }
    .cell-center-for-table {
        vertical-align: middle !important;
        text-align: center !important;
    }
</style>