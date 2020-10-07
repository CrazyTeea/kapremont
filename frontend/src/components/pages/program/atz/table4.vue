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
            class="passport-card mt-2 ml-xl-2 ml-lg-2 ml-md-2 col-xl-4 col-lg-6 col-12 list-complete-item"
            @click="showModal(indexBody)"
            :key="`card-item-${indexBody}`"
        >
          <div class="row-stages-wrapper">
            <div v-for="(row, index) in body.row_stages" class="info-card-passport">
              {{ computedHeader(row.address) }}
            </div>
          </div>

          <b-icon
              @click.prevent="deleteRow(indexBody)"
              variant="danger"
              icon="trash"
              class="trash-icon mt-2 col-1"
          ></b-icon>

        </div>
      </transition-group>
    </div>
    <c-button @addRow1="addRow1" @addRow2="addRow2"/>


    <b-modal v-model="showModalDialog" size="xl">
      <template v-slot:modal-header="{ close }">
        <div>Карточка</div>
      </template>

      <template v-slot:modal-footer="{ close }">
        <b-button variant="danger">Удалить</b-button>
        <b-button variant="success">Сохранить</b-button>
      </template>

      <div v-for="(modalRow, index) in modalContent" :key="`modalContent${index}`">
        <multiselect
            class="mt-5"
            v-model="modalRow.address"
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

      <p class="my-4">Hello from modal!</p>
    </b-modal>
  </div>
</template>

<script>
import Axios from "axios";
import CButton from "./CustomButton";
import Multiselect from "vue-multiselect";
import {BButton} from "bootstrap-vue";

export default {
  components: {Multiselect, BButton, CButton},
  props: ['passport', 'id_org'],
  name: "table4Remake",
  data() {
    return {
      csrf: document.getElementsByName("csrf-token")[0].content,
      showModalDialog: false,
      modalContent: {},
      rows: [],
    }
  },
  mounted() {
    this.getTableFourInfo();
  },
  methods: {
    showModal(rowIndex) {
      this.modalContent = this.rows[rowIndex].row_stages;

      console.log(rowIndex);
      console.log(this.rows[rowIndex]);

      this.showModalDialog = true;
    },
    getTableFourInfo() {
      console.log(this.rows);
      return Axios.post("/app/atz/get-table4", null, {
        headers: {
          "X-CSRF-Token": this.csrf,
        },
      }).then((res) => {
        this.rows = [...res.data];
        console.log(this.rows);
      });
    },
    deleteRow(index) {
      if (this.rows[index]) {
        let ids = [];
        this.rows[index].row_stages.forEach(element => {
          ids.push(element.id);
        });
        console.log(ids);
        // this.deleteRowFromServer(ids);
        return;
      }

      this.rows.splice(index, 1);
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
            address: [],
            stage_number: ".1",
            stage_name: "Исполнение договора /контракта",
            type_event: [],
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
            address: [],
            stage_number: ".21",
            stage_name: "Подведение итогов по закупке",
            type_event: [],
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
            address: [],
            stage_number: ".23",
            stage_name: "Заключение договора /контракта",
            type_event: [],
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
            address: [],
            stage_number: ".24",
            stage_name: "Исполнение договора /контракта",
            type_event: [],
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
      });
    }
  },
  computed: {
    computedHeader() {
      return array => {
        return array.map(el => el.passport_name).join(' ') ? array.map(el => el.passport_name).join(' ') : 'Пустой документ';
      }
    }
  }
}
</script>

<style scoped lang="scss">
.row-stages-wrapper {
  height: 185px;
  overflow-y: scroll;

}

::-webkit-scrollbar {
  width: 0px;
  background: rgba(255, 255, 255, 0.0);
}

.passport-card {
  height: 255px;
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
    max-width: 32.333333%;
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
