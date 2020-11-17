<template>
  <div>
    <div class="wrapper">
      <transition-group
          name="list-complete"
          tag="div"
          class="row justify-content-md-center justify-content-lg-start justify-content-xl-start"
      >
        <div
            v-for="(body, indexBody) in rows"
            class="passport-card mt-2 col-12 list-complete-item"
            @click="showModal(indexBody)"
            :key="`card-item-${indexBody}`"
        >
          <div class="row-stages-wrapper">
            <h5 v-for="header in computedHeader(body)">{{ header }}</h5>
          </div>
        </div>
      </transition-group>
    </div>
    <c-button v-if="check('user')" @addRow1="addRow1" @addRow2="addRow2"/>


    <b-modal scrollable id="modalPassport" v-model="showModalDialog" size="xl">
      <template v-slot:modal-header="{ close }">
        <div>Карточка</div>
      </template>

      <template v-slot:modal-footer="{ close }">
        <b-button variant="danger" @click="deleteStageRow">Удалить</b-button>
        <b-button variant="success" @click="saveContent">Сохранить</b-button>
        <b-button variant="info" @click="$bvModal.hide('modalPassport')">Отмена</b-button>
      </template>

      <div class="row mt-3">
        <div class="col m-auto">
          Название
        </div>
        <div class="col m-auto">
          Законтрактовано (сведения о заключении договора/контракта)
        </div>
        <div class="col m-auto">
          Исполнено (сведения об исполнении)
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-4 m-auto">
          Вид документа
        </div>
        <div class="col m-auto" v-for="(row, index) in modalContent" :key="`modalContent${index}`">
          <b-form-select :disabled="!check('user')" v-model="row.type_document" :options="index === 1 ? [
              {value: 'Акт', text: 'Акт'},
              {value: 'Товарная накладная', text: 'Товарная накладная'}
          ] :[
              {value: 'Договор', text: 'Договор'},
              {value: 'Контракт', text: 'Контракт'}
          ]"></b-form-select>
          <!--<b-form-input :disabled="!check('user')" v-model="row.method"></b-form-input>-->
        </div>

        <!--<div class="col-8 m-auto">

        </div>-->
      </div>
      <div class="row mt-3">
        <div class="col-4 m-auto">
          Адрес проведения мероприятия
        </div>
        <div class="col-8 m-auto">
          <multiselect
              :disabled="!check('user')"
              v-model="address"
              label="passport_name"
              track-by="id"
              :multiple="true"
              :taggable="true"
              :options="passport"
              placeholder="Выберите объект"
              select-label="Добваить"
              deselect-label="Удалить"
              selectedLabel="Выбрано"
              :close-on-select="false"
          ></multiselect>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-4 m-auto">
          Вид статьи мероприятия по АТЗ
        </div>
        <div class="col-8 m-auto">
          <multiselect
              :disabled="!check('user')"
              v-model="type_event"
              label="name"
              track-by="value"
              :multiple="true"
              :taggable="true"
              :options="ONinput(0)"
              group-values="variants"
              group-label="state"
              placeholder="Выберите системы"
              select-label="Добваить"
              deselect-label="Удалить"
              selectedLabel="Выбрано"
              :close-on-select="false"
          ></multiselect>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col m-auto">
          Способ определения поставщика (подрядчика, исполнителя)
        </div>
        <div class="col m-auto" v-for="(row, index) in modalContent" :key="`modalContent${index}`">
          <b-form-input :disabled="!check('user') || (index === 1)" v-model="row.method"></b-form-input>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col m-auto">
          Наименование объекта закупки (договора/контракта)
        </div>
        <div class="col m-auto" v-for="(row, index) in modalContent" :key="`modalContent${index}`">
          <b-form-input :disabled="!check('user') || (index === 1)" v-model="row.name_object"></b-form-input>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col m-auto">
          Общая стоимость (руб.)
        </div>
        <div class="col m-auto" v-for="(row, index) in modalContent" :key="`modalContent${index}`">
          <b-form-input disabled v-model="row.cost_full"></b-form-input>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col m-auto">
          Общая стоимость бюд (руб.)
        </div>
        <div class="col m-auto" v-for="(row, index) in modalContent" :key="`modalContent${index}`">
          <b-form-input disabled v-model="row.cost_full_b"></b-form-input>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col m-auto">
          Общая стоимость вне бюд (руб.)
        </div>
        <div class="col m-auto" v-for="(row, index) in modalContent" :key="`modalContent${index}`">
          <b-form-input disabled v-model="row.cost_full_vb"></b-form-input>
        </div>
      </div>
      <b-tabs class="mt-3" fill>

        <b-tab :key="`tab_${index}`" v-for="(typeEvent, index) in [...modalContent][0]['type_event']"
               :title="typeEvent.name"
               :title-item-class="modalContent.reduce((a,b)=>a + toNum(b.cost_budjet[typeEvent.value]) + toNum(b.cost_vb[typeEvent.value]),0) ? 'text-success' : ''">

          <div class="row mt-3">
            <div class="col m-auto">
              Бюджетного финансирования (руб.)
            </div>
            <div class="col m-auto" v-for="(row, index) in modalContent" :key="`modalContent${index}`">
              <b-form-input @input="sumShit(row,row.cost_budjet)" :disabled="!check('user')"
                            v-model="row.cost_budjet[typeEvent.value]"/>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col m-auto">
              Внебюджетного финансирования (руб.)
            </div>
            <div class="col m-auto" v-for="(row, index) in modalContent" :key="`modalContent${index}`">
              <b-form-input @input="sumShit(row,row.cost_vb)" :disabled="!check('user')"
                            v-model="row.cost_vb[typeEvent.value]"/>
            </div>
          </div>

        </b-tab>


        <div class="w-100 mt-3 back-strip"></div>
      </b-tabs>
      <div class="row mt-3">
        <div class="col m-auto">
          Адрес ссылки https://zakupki.gov.ru/ (из реестра договоров/контрактов)
        </div>
        <div class="col m-auto" v-for="(row, index) in modalContent" :key="`modalContent${index}`">
          <b-form-input :disabled="!check('user') || (index === 1)" v-model="row.number_contract"></b-form-input>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col m-auto">
          Дата заключения
        </div>
        <div class="col m-auto" v-for="(row, index) in modalContent" :key="`modalContent${index}`">
          <b-form-input type="date" :disabled="!check('user')" v-model="row.date_doc"></b-form-input>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col m-auto">
          Номер
        </div>
        <div class="col m-auto" v-for="(row, index) in modalContent" :key="`modalContent${index}`">
          <b-form-input :disabled="!check('user')" v-model="row.number_deal"></b-form-input>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col m-auto">
          Наименование поставщика
        </div>
        <div class="col m-auto" v-for="(row, index) in modalContent" :key="`modalContent${index}`">
          <b-form-input :disabled="!check('user') || (index === 1)" v-model="row.name_deller_by_doc"></b-form-input>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col m-auto">
          ИНН поставщика
        </div>
        <div class="col m-auto" v-for="(row, index) in modalContent" :key="`modalContent${index}`">
          <b-form-input :disabled="!check('user') || (index === 1)" v-model="row.inn_deller_by_doc"></b-form-input>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col m-auto">
          Дата начала исполнения
        </div>
        <div class="col m-auto" v-for="(row, index) in modalContent" :key="`modalContent${index}`">
          <b-form-input type="date" :disabled="!check('user')" v-model="row.date_start"></b-form-input>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col m-auto">
          Дата окончания исполнения
        </div>
        <div class="col m-auto" v-for="(row, index) in modalContent" :key="`modalContent${index}`">
          <b-form-input type="date" :disabled="!check('user')" v-model="row.date_end"></b-form-input>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col m-auto">
          Прикрепленный файлы(PDF)
        </div>
        <div class="col m-auto" v-for="(row, index) in modalContent" :key="`modalContent${index}`">
          <b-form-file v-if="!row.file"
                       browse-text="Файл"
                       :placeholder="index ? 'Исполнено' : 'Законтрактовано'"
                       @input="saveFile(row,index,$event)"
                       :disabled="!check('user')"/>
          <div v-else>
            <a :href="`/app/atz/file4?id_tab4=${row.id}&id_org=${row.id_org}`">{{ row.file }}</a>
            <b-icon @click="row.file = null" style="cursor: pointer" class="text-danger" icon="trash"/>
          </div>

        </div>
      </div>
      <div class="row mt-3">
        <div class="col m-auto">
          Комментарий (текстовое поле Заполняет ВУЗ)
        </div>
        <div class="col m-auto" v-for="(row, index) in modalContent" :key="`modalContent${index}`">
          <b-form-input :disabled="!check('user')" v-model="row.comment_vuz"></b-form-input>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col m-auto">
          ЭкспертМОН
        </div>
        <div class="col m-auto" v-for="(row, index) in modalContent" :key="`modalContent${index}`">
          <b-form-select :disabled="!check('dku')" v-model="row.mon_expert" :options="[
              {value: 1, text: '+'},
              {value: 2, text: '-'}
          ]"></b-form-select>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col m-auto">
          Комментарий эксперта МОН
        </div>
        <div class="col m-auto" v-for="(row, index) in modalContent" :key="`modalContent${index}`">
          <b-form-input :disabled="!check('dku')" v-model="row.comment_mon"></b-form-input>
        </div>
      </div>

    </b-modal>
  </div>
</template>

<script>
import Axios from "axios";
import CButton from "./CustomButton";
import Multiselect from "vue-multiselect";
import {BButton, BFormFile, BFormInput, BFormSelect, BTab, BTabs} from "bootstrap-vue";

export default {
  components: {
    Multiselect, BButton, BFormFile,
    CButton, BFormInput, BFormSelect, BTabs, BTab
  },
  props: ['passport', 'id_org'],
  name: "table4Remake",
  data() {
    return {
      csrf: document.getElementsByName("csrf-token")[0].content,
      showModalDialog: false,
      modalContent: {},
      modalContentIndex: null,
      rows: [],
      card: 1,
    }
  },
  async mounted() {
    await this.id_org;
    await window.Permission;
    await this.getTableFourInfo();
  },
  methods: {
    toNum: num => typeof num === 'string' ? num.toNumber() : (num || 0),
    debug() {
      //console.log(this.modalContent)
    },
    check(role) {
      return window.Permission === role;
    },
    saveContent() {

      let address = this.modalContent[0].address.slice();
      //console.log('address: ', address);
      let type_event = this.modalContent[0].type_event.slice();

      this.modalContent[1].address = address;
      this.modalContent[1].type_event = type_event;

      this.rows[this.modalContentIndex].row_stages = this.modalContent;
      //console.log(this.modalContent);
      this.saveInfo();
    },
    async saveInfo() {

      let data = new FormData();
      data.append("data", JSON.stringify(this.rows));
      data.append("id_org", this.id_org);
      data.append("card_number", this.card);

      await Axios.post("/app/atz/save-table4", data, {
        headers: {
          "X-CSRF-Token": this.csrf,
        },
      }).then(res => {
        if (res.data.success) {
          location.reload();
          this.getTableFourInfo();
        }
      }).finally(()=>{
        this.$bvModal.hide('modalPassport');
      });
    },

    deleteStageRow() {
      if (this.rows[this.modalContentIndex].row_stages[0].id) {
        let ids = this.rows[this.modalContentIndex].row_stages.map(el => {
          return el.id;
        });
        this.deleteRowsFromServer(ids);
      }

      this.rows.splice(this.modalContentIndex, 1);
      this.$bvModal.hide('modalPassport');
    },
    deleteRowsFromServer(ids) {
      let data = new FormData();
      data.append('ids', JSON.stringify(ids));
      return Axios.post('/app/atz/destroy-atz-table-four-row', data, {
        headers: {
          "X-CSRF-Token": this.csrf,
        },
      }).then(res => {
        this.getTableFourInfo();
      })
    },
    ONinput(index2) {
      let index1 = this.modalContentIndex;
      if (!this.rows[index1]?.row_stages[index2].address || typeof this.rows[index1]?.row_stages[index2].address !== 'object') return [];
      let options = [];
      this.rows[index1].row_stages[index2].address.forEach(
          (element, indexArray) => {
            options.push({
              state: element.passport_name,
              variants: [
                {
                  name: "Система видеонаблюдения",
                  value: `video_system-${indexArray}`,
                },
                {
                  name: "Система оповещения и управления эвакуацией",
                  value: `evacuation_system-${indexArray}`,
                },
                {
                  name: "Система освещения",
                  value: `light_system-${indexArray}`,
                },
                {
                  name: "Средства охранной сигнализации",
                  value: `predator_system-${indexArray}`,
                },
                {
                  name: "Средства тревожной сигнализации",
                  value: `alarm_warning_system-${indexArray}`,
                },
                {
                  name: "Средства пожарной сигнализации",
                  value: `alarm_fire_system-${indexArray}`,
                },
                {
                  name: "Средства телефонной связи и радиосвязи",
                  value: `phone_system-${indexArray}`,
                },
                {name: "Ограждения", value: `fence-${indexArray}`},
                {name: "СКУД", value: `skud-${indexArray}`},
              ],
            });
          }
      );

      return options;
    },
    sumShit(row, valArr) {
      row.cost_full_b = Object.keys(row.cost_budjet).reduce((a, b) => a + this.toNum(row.cost_budjet[b]), 0);
      row.cost_full_vb = Object.keys(row.cost_vb).reduce((a, b) => a + this.toNum(row.cost_vb[b]), 0);
      row.cost_full = row.cost_full_b + row.cost_full_vb;

    },
    showModal(rowIndex) {
      //console.log('showModal before: ', this.rows[rowIndex].row_stages[1]);
      this.modalContent = this.rows[rowIndex].row_stages;


      this.modalContent.forEach(elem => {
        if (Array.isArray(elem.cost_budjet)) elem.cost_budjet = {};
        if (Array.isArray(elem.cost_vb)) elem.cost_vb = {};
      });

      // console.log('showModal after: ', this.modalContent);

      this.modalContentIndex = rowIndex;

      this.showModalDialog = true;
    },
    async getTableFourInfo() {
      let data = new FormData();
      data.append('id_org', this.id_org);
      await Axios.post("/app/atz/get-table4", data, {
        headers: {
          "X-CSRF-Token": this.csrf,
        },
      }).then((res) => {
        this.rows = [...res.data];
        //console.log('coming from server: ', this.rows);
      });
    },
    async saveFile(row, index, event) {
      let data = new FormData();
      data.append('id_org', row.id_org);
      data.append('file_index', index);
      data.append('file', event)
      data.append('id', row.id)
      await Axios.post(`/app/atz/save-file4?id_org=${row.id_org}`, data, {
        headers: {
          "X-CSRF-Token": this.csrf,
        }
      }).then(res => console.log(res.data))
    },
    addRow1() {
      this.rows.push({
        row_stages: [
          {
            address: [],
            stage_number: null,
            stage_name:
                "Закупка не конкурентный способом /Заключение договора /контракта ",
            type_event: [],
            method: null,
            type_document: null,
            name_object: null,
            cost_full: null,
            cost_full_b: null,
            cost_full_vb: null,
            cost_budjet: {},
            cost_vb: {},
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
            address: [],
            stage_number: ".1",
            stage_name: "Исполнение договора /контракта",
            type_event: [],
            method: null,
            type_document: null,
            name_object: null,
            cost_full: null,
            cost_full_b: null,
            cost_full_vb: null,
            cost_budjet: {},
            cost_vb: {},
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
      });
    },
    addRow2() {
      this.rows.push({
        row_stages: [
          {
            address: [],
            stage_number: ".2",
            stage_name: "Закупка конкурентный способом",
            type_event: [],
            method: null,
            type_document: null,
            name_object: null,
            cost_full: null,
            cost_full_b: null,
            cost_full_vb: null,
            cost_budjet: {},
            cost_vb: {},
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
            address: [],
            stage_number: ".21",
            stage_name: "Подведение итогов по закупке",
            type_event: [],
            method: null,
            type_document: null,
            name_object: null,
            cost_full: null,
            cost_full_b: null,
            cost_full_vb: null,
            cost_budjet: {},
            cost_vb: {},
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
            address: [],
            stage_number: ".23",
            stage_name: "Заключение договора /контракта",
            type_event: [],
            method: null,
            type_document: null,
            name_object: null,
            cost_full: null,
            cost_full_b: null,
            cost_full_vb: null,
            cost_budjet: {},
            cost_vb: {},
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
            address: [],
            stage_number: ".24",
            stage_name: "Исполнение договора /контракта",
            type_event: [],
            method: null,
            type_document: null,
            name_object: null,
            cost_full: null,
            cost_full_b: null,
            cost_full_vb: null,
            cost_budjet: {},
            cost_vb: {},
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
      });
    }
  },
  computed: {
    disableDeleteButton() {
      if (this.check('dku')) return false;
    },
    address: {
      get() {
        return this.modalContent[0]?.address;
      },
      set(val) {
        this.modalContent[0].address = val;
        this.modalContent[1].address = val;
      }
    },
    type_event: {
      get() {
        return this.modalContent[0]?.type_event;
      },
      set(val) {
        this.modalContent[0].type_event = val;
        this.modalContent[1].type_event = val;
      }
    },
    typeDocument: {
      get() {
        return this.modalContent[0]?.type_document;
      },
      set(val) {
        this.modalContent[0].type_document = val;
        this.modalContent[1].type_document = val;
      }
    },
    computedHeader() {
      return array => array.row_stages.map(elem => `${elem.type_document || '--'} №${elem.number_deal || '--'} на выполнение работ ${elem.name_object || '--'} на сумму ${Number(elem.cost_full) || '--'}`);
    }
  }
}
</script>

<style scoped lang="scss">
.back-strip {
  border-bottom: 1px solid #dee2e6;
}

.passport-card {
  height: auto;
  border: 1px solid #dee2e6;
  padding: 20px;
  border-radius: 2px;
  transition: box-shadow .2s ease;

  &:hover {
    transition: box-shadow .2s ease;
    box-shadow: 0 3px 5px -1px rgba(0, 0, 0, 0.2), 0 6px 10px 0 rgba(0, 0, 0, 0.14), 0 1px 18px 0 rgba(0, 0, 0, 0.12);
  }
}

@media screen and (min-width: 992px) {
  .passport-card {
    //max-width: 32.333333%;
  }
}

@media screen and (min-width: 768px) and (max-width: 992px) {
  .passport-card {
    max-width: 49%;
  }
}

.info-card-passport {
}

.list-complete-enter, .list-complete-leave-to
  /* .list-complete-leave-active до версии 2.1.8 */
{
  opacity: 0;
  transform: translateY(30px);
}

.list-complete-leave-active {
  position: absolute;
}

.list-complete-item {
  transition: all .3s;
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
