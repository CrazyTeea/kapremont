<template>
  <div>
    <div class="table-overflow">
      <b-table-simple hover bordered>
        <b-thead>
          <b-tr>
            <b-th rowspan="2">Этап</b-th>
            <b-th rowspan="2">Вид мероприятия</b-th>
            <b-th rowspan="2">Адрес проведения мероприятия</b-th>
            <b-th rowspan="2">Вид статьи мероприятия по АТЗ</b-th>

            <b-th rowspan="2">Способ определения поставщика (подрядчика, исполнителя)</b-th>
            <b-th rowspan="2">Вид документа</b-th>
            <b-th rowspan="2">Наименование объекта закупки (лота / договора/контракта)</b-th>

            <b-th colspan="3">Начальная (максимальная) цена закупки лота /договора, контракта, руб.</b-th>

            <b-th rowspan="2">Номер извещения /номер Номер реестровой записи договора/контракта на сайте https://zakupki.gov.ru/ (в случаи публикации)</b-th>
            <b-th rowspan="2">Дата заключения контракта/договора</b-th>
            <b-th rowspan="2">Номер договора /контракта</b-th>
            <b-th rowspan="2">Наименование поставщика по договору /контракту</b-th>
            <b-th rowspan="2">ИНН поставщика по договору /контракту</b-th>

            <b-th colspan="2">Срок выполнений мероприятий по договору /контракту</b-th>

            <b-th rowspan="2">Подтверждающие документы</b-th>
            <b-th rowspan="2">Комментарий (текстовое поле Заполняет ВУЗ)</b-th>
            <b-th rowspan="2">ЭкспертМОН +/-</b-th>
            <b-th rowspan="2">Комментарий эксперта МОН )</b-th>
          </b-tr>
          <b-tr>
            <b-th>Общая стоимость (руб.)</b-th>
            <b-th>Бюджетного финансирования (руб.)</b-th>
            <b-th>Внебюджетного финансирования (руб.)</b-th>
            <b-th>Дата начала</b-th>
            <b-th>Дата окончания</b-th>
          </b-tr>
        </b-thead>
        <b-tbody v-for="(body, indexBody) in rows" :key="`b-body-${indexBody}`">
          <b-tr v-for="(row, index) in body.row.row_stages" :key="`b-tr-${index}`">
            <b-td>
              {{ indexBody + 1 + row.stage_number }}
              <b-icon v-if="!index" @click="deleteRow(indexBody)" variant="danger" icon="trash" class="trash-icon mt-2 col-1"></b-icon>
            </b-td>
            <b-td>{{ row.stage_name }}</b-td>
            <b-td class="min-width-for-multiselect">
              <multiselect class="mt-5" v-model="row.address" label="passport_name" track-by="id" :multiple="true" :taggable="true" :options="passport" placeholder="Выберите объект" select-label="Добваить" deselect-label="Удалить" selectedLabel="Выбрано" :close-on-select="false"></multiselect>
            </b-td>
            <b-td class="min-width-for-multiselect">
                <multiselect 
                    class="mt-5"
                    v-model="row.type_event"
                    label="name"
                    track-by="value"
                    :multiple="true"
                    :taggable="true"
                    :options="ONinput(indexBody, index)" 
                    group-values="variants"
                    group-label="state"
                    placeholder="Выберите системы"
                    select-label="Добваить" 
                    deselect-label="Удалить"
                    selectedLabel="Выбрано" 
                    :close-on-select="false"
                ></multiselect>
            </b-td>

            <b-td>
              <b-form-input v-model="row.method"></b-form-input>
            </b-td>
            <b-td>
              <b-form-input v-model="row.type_document"></b-form-input>
            </b-td>
            <b-td>
              <b-form-input v-model="row.name_object"></b-form-input>
            </b-td>
            <b-td>
              <b-form-input type="number" v-model="row.cost_full"></b-form-input>
            </b-td>
            <b-td>
              <b-form-input type="number" v-model="row.cost_budjet"></b-form-input>
            </b-td>
            <b-td>
              <b-form-input type="number" v-model="row.cost_vb"></b-form-input>
            </b-td>
            <b-td>
              <b-form-input v-model="row.number_contract"></b-form-input>
            </b-td>
            <b-td>
              <b-form-input v-model="row.date_doc"></b-form-input>
            </b-td>
            <b-td>
              <b-form-input v-model="row.number_deal"></b-form-input>
            </b-td>
            <b-td>
              <b-form-input v-model="row.name_deller_by_doc"></b-form-input>
            </b-td>
            <b-td>
              <b-form-input v-model="row.inn_deller_by_doc"></b-form-input>
            </b-td>
            <b-td>
              <b-form-input v-model="row.date_start"></b-form-input>
            </b-td>
            <b-td>
              <b-form-input v-model="row.date_end"></b-form-input>
            </b-td>
            <b-td>
              <b-form-input v-model="row.docs"></b-form-input>
            </b-td>
            <b-td>
              <b-form-input v-model="row.comment_vuz"></b-form-input>
            </b-td>
            <b-td>
              <b-form-input v-model="row.mon_expert"></b-form-input>
            </b-td>
            <b-td>
              <b-form-input v-model="row.comment_mon"></b-form-input>
            </b-td>
          </b-tr>
        </b-tbody>
      </b-table-simple>
    </div>
    <div class="d-flex justify-content-end mt-2">
      <!-- <b-button class="mr-2" @click="debug">Debug</b-button> -->

      <b-button size="sm" @click="addRow1">Добавить строку 1</b-button>
      <b-button size="sm" class="ml-2" @click="addRow2">Добавить строку 2</b-button>

      <b-button disabled variant="success" size="sm" class="ml-2">Сохранить</b-button>
    </div>
  </div>
</template>

<script>
import { BButton, BTableSimple, BThead, BTbody, BTh, BTd, BTr, BFormInput } from "bootstrap-vue";
import Multiselect from "vue-multiselect";

export default {
  props: ["passport"],
  components: {
    BButton,
    BTableSimple,
    BThead,
    BTbody,
    BTh,
    BTd,
    BTr,
    BFormInput,
    Multiselect,
  },
  data() {
    return {
      rows: [],
    };
  },
  methods: {
    ONinput(index1, index2) {
      if(!this.rows[index1].row.row_stages[index2].address) return [];
      let options = [];
      this.rows[index1].row.row_stages[index2].address.forEach((element) => {
        options.push({
          state: element.passport_name,
          variants: [
            { name: "Система видеонаблюдения", value: "video_system" },
            { name: "Система оповещения и управления эвакуацией", value: "evacuation_system" },
            { name: "Система освещения", value: "light_system" },
            { name: "Средства охранной сигнализации", value: "predator_system" },
            { name: "Средства тревожной сигнализации", value: "alarm_warning_system" },
            { name: "Средства пожарной сигнализации", value: "alarm_fire_system" },
            { name: "Средства телефонной связи и радиосвязи", value: "phone_system" },
            { name: "Ограждения", value: "fence" },
            { name: "СКУД", value: "skud" },
          ],
        });
      });

      return options;
    },
    getOptions(index1, index2) {
      let array = this.rows[index1].row.row_stages[index2].address;

      return [
        {
          id_podved: 12,
          passport_name: "lol",
        },
      ];
    },
    debug() {
      console.log(this.rows);
    },
    deleteRow(index) {
      this.rows.splice(index, 1);
      console.log(index);
    },
    addRow1() {
      this.rows.push({
        row: {
          stage: this.rows.length + 1,
          row_stages: [
            {
              address: null,
              stage_number: null,
              stage_name: "Закупка не конкурентный способом /Заключение договора /контракта ",
              type_event: null,
              address: null,
              method: null,
              type_document: null,
              name_object: null,
              cost_full: null,
              cost_budjet: null,
              cost_vb: null,
              number_contract: null,
              date_doc: null,
              number_deal: null,
              name_deller_by_doc: null,
              inn_deller_by_doc: null,
              date_start: null,
              date_end: null,
              docs: null,
              comment_vuz: null,
              mon_expert: null,
              comment_mon: null,
            },
            {
              address: null,
              stage_number: ".1",
              stage_name: "Исполнение договора /контракта",
              type_event: null,
              address: null,
              method: null,
              type_document: null,
              name_object: null,
              cost_full: null,
              cost_budjet: null,
              cost_vb: null,
              number_contract: null,
              date_doc: null,
              number_deal: null,
              name_deller_by_doc: null,
              inn_deller_by_doc: null,
              date_start: null,
              date_end: null,
              docs: null,
              comment_vuz: null,
              mon_expert: null,
              comment_mon: null,
            },
          ],
        },
      });
    },
    addRow2() {
      this.rows.push({
        row: {
          stage: this.rows.length + 1,
          row_stages: [
            {
              address: null,
              stage_number: ".2",
              stage_name: "Закупка конкурентный способом",
              type_event: null,
              address: null,
              method: null,
              type_document: null,
              name_object: null,
              cost_full: null,
              cost_budjet: null,
              cost_vb: null,
              number_contract: null,
              date_doc: null,
              number_deal: null,
              name_deller_by_doc: null,
              inn_deller_by_doc: null,
              date_start: null,
              date_end: null,
              docs: null,
              comment_vuz: null,
              mon_expert: null,
              comment_mon: null,
            },
            {
              address: null,
              stage_number: ".21",
              stage_name: "Подведение итогов по закупке",
              type_event: null,
              address: null,
              method: null,
              type_document: null,
              name_object: null,
              cost_full: null,
              cost_budjet: null,
              cost_vb: null,
              number_contract: null,
              date_doc: null,
              number_deal: null,
              name_deller_by_doc: null,
              inn_deller_by_doc: null,
              date_start: null,
              date_end: null,
              docs: null,
              comment_vuz: null,
              mon_expert: null,
              comment_mon: null,
            },
            {
              address: null,
              stage_number: ".23",
              stage_name: "Заключение договора /контракта",
              type_event: null,
              address: null,
              method: null,
              type_document: null,
              name_object: null,
              cost_full: null,
              cost_budjet: null,
              cost_vb: null,
              number_contract: null,
              date_doc: null,
              number_deal: null,
              name_deller_by_doc: null,
              inn_deller_by_doc: null,
              date_start: null,
              date_end: null,
              docs: null,
              comment_vuz: null,
              mon_expert: null,
              comment_mon: null,
            },
            {
              address: null,
              stage_number: ".24",
              stage_name: "Исполнение договора /контракта",
              type_event: null,
              address: null,
              method: null,
              type_document: null,
              name_object: null,
              cost_full: null,
              cost_budjet: null,
              cost_vb: null,
              number_contract: null,
              date_doc: null,
              number_deal: null,
              name_deller_by_doc: null,
              inn_deller_by_doc: null,
              date_start: null,
              date_end: null,
              docs: null,
              comment_vuz: null,
              mon_expert: null,
              comment_mon: null,
            },
          ],
        },
      });
    },
  },
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style scoped>
.table-overflow {
  overflow-x: scroll;
  height: auto;
}
.min-width-for-multiselect {
  min-width: 450px;
}
.trash-icon {
  transform: scale(1);
  transition: all 0.3s ease;
}
.trash-icon:hover {
  transform: scale(1.3);
  transition: all 0.3s ease;
}
</style>
