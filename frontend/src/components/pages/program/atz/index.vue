<template>
  <div class="overflow">
    <b-form id="atz_form" method="post">
      <input id="hidden" name="_csrf" v-model="csrf" type='hidden'/>
      <b-table-simple
          bordered
          hover
          style="font-size: 12px;"
      >
        <b-thead>
          <b-tr>
            <b-th class="vertical-align-for-table-cell">Направление расходов</b-th>
            <b-th class="vertical-align-for-table-cell">Сумма бюджетного финансирования (руб)</b-th>
            <b-th class="vertical-align-for-table-cell">Сумма внебюджетного финансирования (руб)</b-th>
            <b-th class="vertical-align-for-table-cell">Сумма общий объем финансирования (руб)</b-th>

            <!--            Данные из карточки-->
            <b-th class="vertical-align-for-table-cell">Сумма бюджетного финансирования (руб)</b-th>
            <b-th class="vertical-align-for-table-cell">Сумма внебюджетного финансирования (руб)</b-th>
            <!--            Данные из карточки-->
            <b-th class="vertical-align-for-table-cell">Сумма бюджетного финансирования (руб)</b-th>
            <b-th class="vertical-align-for-table-cell">Сумма внебюджетного финансирования (руб)</b-th>
            <!--            Данные из карточки-->
            <b-th class="vertical-align-for-table-cell">Сумма бюджетного финансирования (руб)</b-th>
            <b-th class="vertical-align-for-table-cell">Сумма внебюджетного финансирования (руб)</b-th>
            <!--            Остаток-->
            <b-th class="vertical-align-for-table-cell">Сумма бюджетного финансирования (руб)</b-th>
            <b-th class="vertical-align-for-table-cell">Сумма внебюджетного финансирования (руб)</b-th>0

          </b-tr>
        </b-thead>
        <b-tbody>
          <b-tr v-for="(item, index) in items" :key="index">
            <b-th class="vertical-align-for-table-cell normal-font-weight-for-cell">
              <label>{{ item.label }}</label>
            </b-th>
            <b-th class="vertical-align-for-table-cell normal-font-weight-for-cell">
              <b-form-input
                  :name="`${modelName}[${index}][cost_b]`"
                  v-model="item.cost_b"
                  placeholder="Цена"
                  min="0"
                  type="number"
                  disabled
              ></b-form-input>
            </b-th>
            <b-th class="vertical-align-for-table-cell normal-font-weight-for-cell">
              <b-form-input
                  :name="`${modelName}[${index}][cost_v]`"
                  v-model="item.cost_v"
                  placeholder="Цена"
                  min="0"
                  type="number"
                  disabled
              ></b-form-input>
            </b-th>
            <b-th class="vertical-align-for-table-cell normal-font-weight-for-cell">
              <label>{{ cost_o(index) }}</label>
            </b-th>
            <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
              --
            </b-th>
            <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
              --
            </b-th>
            <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
              --
            </b-th>
            <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
              --
            </b-th>
            <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
              --
            </b-th>


          </b-tr>
          <b-tr>
            <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
              --
            </b-th>
            <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
              --
            </b-th>
            <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
              --
            </b-th>
            <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
              --
            </b-th>
            <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
              --
            </b-th>
            <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
              --
            </b-th>
            <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
              --
            </b-th>
            <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
              --
            </b-th>
            <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
              --
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
    </b-form>
  </div>
</template>

<script>
import Axios from 'axios'
import {BButton, BForm, BFormInput, BTableSimple, BTbody, BTfoot, BTh, BThead, BTr, VBToggle} from "bootstrap-vue";

export default {
  directives: {
    'b-toggle': VBToggle
  },
  props:['data'],

  watch:{
    data:{
      handler(){
        this.items[0].cost_b = this.data.video_system_bud;
        this.items[0].cost_v = this.data.video_system_nebud;


        this.items[1].cost_b = this.data.evacuation_system_bud;
        this.items[1].cost_v = this.data.evacuation_system_nebud;


        this.items[2].cost_b = this.data.light_system_bud;
        this.items[2].cost_v = this.data.light_system_nebud;


        this.items[3].cost_b = this.data.predator_system_bud;
        this.items[3].cost_v = this.data.predator_system_nebud;

        this.items[4].cost_b = this.data.alarm_warning_system_bud;
        this.items[4].cost_v = this.data.alarm_warning_system_nebud;

        this.items[5].cost_b = this.data.alarm_fire_system_bud;
        this.items[5].cost_v = this.data.alarm_fire_system_nebud;

        this.items[6].cost_b = this.data.phone_system_bud;
        this.items[6].cost_v = this.data.phone_system_nebud;

        this.items[7].cost_b = this.data.fence_bud;
        this.items[7].cost_v = this.data.fence_nebud;

        this.items[8].cost_b = this.data.skud_bud;
        this.items[8].cost_v = this.data.skud_nebud;

      },
      deep:true
    }
  },

  components: {
    BButton,
    BForm,
    BFormInput,
    BTableSimple,
    BThead,
    BTr,
    BTh,
    BTbody,
    BTfoot,
  },

  async mounted() {

    /*Axios.get('/rest/system/get-page', {
      params: {
        pageName: 'atz',
        //id_org:document.getElementById('global_id_org').value
      }
    }).then(response => {
      response.data.forEach(item => {
        this.items[item.elem].cost_b = item.cost_b;
        this.items[item.elem].cost_v = item.cost_v;
      })

      this.$emit('getTable2AtzInfo', {
        cost_b_full: this.cost_b_full,
        cost_v_full: this.cost_v_full,
      });
    }).catch(err => {
      console.error(err);
    });*/
  },

  data() {
    return {
      csrf: document.getElementsByName('csrf-token')[0].content,
      modelName: 'Atz',
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
      return index => {
        let a = parseFloat(this.items[index].cost_b) || 0;
        let b = parseFloat(this.items[index].cost_v) || 0;
        this.items[index].cost_o = a + b;
        return a + b
      }
    },
    cost_b_full() {
      var sum = 0;
      for (let cost of this.items) {
        sum += parseFloat(cost.cost_b) || 0
      }

      return sum
    },
    cost_v_full() {
      var sum = 0;
      for (let cost of this.items) {
        sum += parseFloat(cost.cost_v) || 0
      }

      return sum
    },
    cost_o_full() {
      var sum = 0;
      for (let cost of this.items) {
        sum += parseFloat(cost.cost_o) || 0
      }

      return sum
    }
  },
  methods: {
    clearInputs() {
      for (let val of this.items) {
        val.cost_b = null;
        val.cost_v = null;
        val.cost_o = null
      }
    },
    sendInfo() {
      let formData = new FormData(document.getElementById('atz_form'));
      Axios.post('/program/atz', formData, {
        headers:
            {
              'X-CSRF-Token': this.csrf,
              'Content-Type': 'application/x-www-form-urlencoded'
            },
      }).then((res) => {
        if (res.data)
          location.reload();
      })
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