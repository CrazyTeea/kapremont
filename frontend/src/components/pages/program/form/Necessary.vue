<template>
    <div class="overflow">
        <b-table-simple
            bordered
            hover
            responsive
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
                    <b-th class="normal-font-weight-for-table cell-center-for-table">
                        <label>{{ item.label}}</label>
                    </b-th>
                    <b-th class="cell-center-for-table">
                        <b-form-checkbox type="checkbox" :value="'check' + index" v-model="item.nalichie" :name="'waited[check1_nalichie_' + index + ']'"></b-form-checkbox>
                    </b-th>
                    <b-th class="cell-center-for-table">
                        <b-form-input
                            :name="'waited[input1_material_' + index + ']'"
                            v-if="item.nalichie"
                            v-model="item.material" 
                            placeholder="Материалы"
                            type="text"
                        ></b-form-input>
                    </b-th>
                    <b-th class="cell-center-for-table">
                        <b-form-input
                            :name="'waited[input1_srok_eks_' + index + ']'"
                            type="text"
                            v-if="item.nalichie"
                            v-model="item.srok_eks" 
                            placeholder="Срок"
                        ></b-form-input>
                    </b-th>
                    <b-th class="cell-center-for-table">
                        <b-form-checkbox 
                            :name="'waited[input1_kap_remont_' + index + ']'"
                            type="checkbox"
                            v-if="item.nalichie"
                            :value="'rem' + index"
                            v-model="item.kap_remont" 
                        ></b-form-checkbox>
                    </b-th>
                    <b-th class="cell-center-for-table">
                        <b-form-input
                            :name="'waited[input1_obosnovanie_' + index + ']'"
                            type="text"
                            v-if="item.nalichie"
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
            responsive
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
                    <b-th class="normal-font-weight-for-table cell-center-for-table">
                        <label>{{ item.label}}</label>
                    </b-th>
                    <b-th class="cell-center-for-table">
                        <b-form-checkbox type="checkbox" :value="'check2' + index" v-model="item.nalichie" :name="'waited[check2_nalichie_' + index + ']'"></b-form-checkbox>
                    </b-th>
                    <b-th class="cell-center-for-table">
                        <b-form-input
                            :name="'waited[input2_srok_eks' + index + ']'"
                            type="text"
                            v-if="item.nalichie"
                            v-model="item.srok_eks" 
                            placeholder="Срок"
                        ></b-form-input>
                    </b-th>
                    <b-th class="cell-center-for-table">
                        <b-form-checkbox
                            :name="'waited[input2_kap_remont' + index + ']'"
                            type="checkbox"
                            v-if="item.nalichie"
                            :value="'rem2' + index"
                            v-model="item.kap_remont" 
                        ></b-form-checkbox>
                    </b-th>
                    <b-th class="cell-center-for-table">
                        <b-form-input
                            :name="'waited[input2_obosnovanie' + index + ']'"
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
import BootstrapVue from 'bootstrap-vue';

export default {
    data() {
        return{
            items: [
                {label: 'Фундаменты', nalichie: null, material: null, srok_eks: null, kap_remont: null, obosnovanie: null},
                {label: 'Отмостка', nalichie: null, material: null, srok_eks: null, kap_remont: null, obosnovanie: null},
                {label: 'Стены', nalichie: null, material: null, srok_eks: null, kap_remont: null, obosnovanie: null},
                {label: 'Колонны', nalichie: null, material: null, srok_eks: null, kap_remont: null, obosnovanie: null},
                {label: 'Перегородки', nalichie: null, material: null, srok_eks: null, kap_remont: null, obosnovanie: null},
                {label: 'Крыша', nalichie: null, material: null, srok_eks: null, kap_remont: null, obosnovanie: null},
                {label: 'Кровля', nalichie: null, material: null, srok_eks: null, kap_remont: null, obosnovanie: null},
                {label: 'Перекрытия', nalichie: null, material: null, srok_eks: null, kap_remont: null, obosnovanie: null},
                {label: 'Полы', nalichie: null, material: null, srok_eks: null, kap_remont: null, obosnovanie: null},
                {label: 'Окна', nalichie: null, material: null, srok_eks: null, kap_remont: null, obosnovanie: null},
                {label: 'Двери', nalichie: null, material: null, srok_eks: null, kap_remont: null, obosnovanie: null},
                {label: 'Ворота', nalichie: null, material: null, srok_eks: null, kap_remont: null, obosnovanie: null},
                {label: 'Лестницы', nalichie: null, material: null, srok_eks: null, kap_remont: null, obosnovanie: null},
                {label: 'Крыльца', nalichie: null, material: null, srok_eks: null, kap_remont: null, obosnovanie: null},
                {label: 'Балконы/Лоджии', nalichie: null, material: null, srok_eks: null, kap_remont: null, obosnovanie: null},
                {label: 'Внутренняя отделка', nalichie: null, material: null, srok_eks: null, kap_remont: null, obosnovanie: null},
                {label: 'Наружняя отделка', nalichie: null, material: null, srok_eks: null, kap_remont: null, obosnovanie: null},
            ],
            itemsTwo: [
                {label: 'Система электроснабжения', nalichie: null, srok_eks: null, kap_remont: null, obosnovanie: null},
                {label: 'Система водоснабжения', nalichie: null, srok_eks: null, kap_remont: null, obosnovanie: null},
                {label: 'Система водоотведения', nalichie: null, srok_eks: null, kap_remont: null, obosnovanie: null},
                {label: 'Система газоснабжения', nalichie: null, srok_eks: null, kap_remont: null, obosnovanie: null},
                {label: 'Система кондиционирования воздуха', nalichie: null, srok_eks: null, kap_remont: null, obosnovanie: null},
                {label: 'Система вентиляции', nalichie: null, srok_eks: null, kap_remont: null, obosnovanie: null},
                {label: 'Система отопления', nalichie: null, srok_eks: null, kap_remont: null, obosnovanie: null},
                {label: 'Система диспетчеризации', nalichie: null, srok_eks: null, kap_remont: null, obosnovanie: null},
                {label: 'Радиофикация', nalichie: null, srok_eks: null, kap_remont: null, obosnovanie: null},
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