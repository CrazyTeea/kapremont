<template>
  <div>
    <b-table-simple bordered hover>
      <b-thead>
        <b-tr>
          <b-th>Цели и задачи</b-th>
          <b-th>Планируемый показатель</b-th>
          <b-th>Единица измерения</b-th>
        </b-tr>
      </b-thead>
      <b-tbody>
        <b-tr v-for="(item, index) in dataFirst" :key="index">
          <b-th class="font-normal-first-colomn">
            <label v-if="index < 5">{{ item.aim }}</label>
            <b-form-input
                v-else
                type="text"
                :name="`${modelName}[${index}][aim]`"
                v-model="item.aim"
            ></b-form-input>
          </b-th>
          <b-th>
            <div v-if="item.var">
              <b-form-input style="display: none" v-model="item.plan" :name="`${modelName}[${index}][plan]`"/>
              <b-select
                  v-if="item.var"
                  v-model="item.plan"
                  :options="[
                                { value: 0, text: 'нет' },
                                { value: 1, text: 'да' }
                            ]"
              />
            </div>

            <b-form-input
                v-else
                type="text"
                :name="`${modelName}[${index}][plan]`"
                v-model="item.plan"
            ></b-form-input>

          </b-th>
          <b-th class="font-normal-first-colomn">
            <label v-if="index < 5">{{ item.changes }}</label>
            <b-form-input
                v-else
                type="text"
                :name="`${modelName}[${index}][changes]`"
                v-model="item.changes"
            ></b-form-input>
          </b-th>
        </b-tr>
      </b-tbody>
      <b-tfoot>
        <b-tr>
          <b-td
              @click="deleteLastRow()"
              v-if="dataFirst.length > 6"
              colspan="2"
              variant="secondary"
              class="text-right text-danger"
          >
            Удалить строку
          </b-td>
          <b-td
              @click="addNewRow()"
              colspan="3"
              variant="secondary"
              class="text-right text-info"
          >
            Добавить строку
          </b-td>
        </b-tr>
      </b-tfoot>
    </b-table-simple>
  </div>
</template>

<script>
import {BFormInput, BFormSelect, BTableSimple, BTbody, BTd, BTfoot, BTh, BThead, BTr, VBToggle} from "bootstrap-vue";

export default {
  directives: {
    'b-toggle': VBToggle
  },
  components: {
    BFormInput,
    BTableSimple,
    BThead,
    BTr,
    BTh,
    BTd,
    BTbody,
    BTfoot,
    'b-select': BFormSelect
  },
  props: {
    modelName: String
  },
  data() {
    return {
      dataFirst: [
        {
          aim: "Проведение капитального ремонта, общая площадь",
          plan: null,
          changes: "кв.м"
        },
        {
          aim:
              "Вовлечение в хозяйственную деятельность за счет проведенного капитального ремонта, общая площадь",
          plan: null,
          changes: "кв.м"
        },
        {
          aim: "Снижение затрат на эксплуатацию",
          plan: 0,
          changes: "",
          var: true
        },
        {
          aim: "Повышение энергоэффективности",
          plan: 0,
          changes: "",
          var: true
        },
        {
          aim:
              "Восстановление (ремонт, реставрация, за исключением реконструкции) объектов культурного наследия",
          plan: 0,
          changes: "",
          var: true
        },
        {aim: null, plan: null, changes: null}
      ]
    };
  },
  mounted() {
    if (window.MODEL.waited?.length) {
      window.MODEL.waited.forEach((item, index) => {
        if (index < 5) {
          if (this.dataFirst[item.element]) {
            this.dataFirst[item.element].plan = item.plan;
          }
        } else {
          if (this.dataFirst[item.element]) {
            this.dataFirst[item.element] = {
              aim: item.aim,
              plan: item.plan,
              changes: item.changes
            };
          } else {
            this.dataFirst.push({
              aim: item.aim,
              plan: item.plan,
              changes: item.changes
            });
          }
        }
      });
    }
  },
  methods: {
    addNewRow: function () {
      this.dataFirst.push({
        aim: null,
        plan: null,
        changes: null
      });
    },
    deleteLastRow: function () {
      this.dataFirst.pop();
    }
  }
};
</script>

<style>
.font-normal-first-colomn {
  font-weight: normal !important;
}
</style>
