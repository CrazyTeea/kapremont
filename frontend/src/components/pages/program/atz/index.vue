<template>
  <div class="overflow">
    <b-form id="atz_form" method="post">
      <input id="hidden" name="_csrf" v-model="csrf" type='hidden'/>
      <b-table-simple
          responsive
          bordered
          hover
          style="font-size: 12px;"
      >
        <b-thead>
          <b-tr>
            <b-td></b-td>
            <b-td class="text-center" colspan="3">Согласовано</b-td>
            <b-td class="text-center" colspan="2">Законтрактовано</b-td>
            <b-td class="text-center" colspan="2">На исполнении</b-td>
            <b-td class="text-center" colspan="2">Исполнено</b-td>
            <b-td class="text-center" colspan="2">Остаток</b-td>

          </b-tr>
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
            <b-th class="vertical-align-for-table-cell">Сумма внебюджетного финансирования (руб)</b-th>

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
              {{ item.cost_o }}
            </b-th>
            <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
              {{ item.zakontraktovano_bud }}
            </b-th>
            <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
              {{ item.zakontraktovano_nebud }}
            </b-th>
            <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
              {{ item.zakontraktovano_bud - item.soglasovano_bud }}
            </b-th>
            <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
              {{ item.zakontraktovano_nebud - item.soglasovano_nebud }}
            </b-th>
            <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
              {{ item.soglasovano_bud }}
            </b-th>
            <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
              {{ item.soglasovano_nebud }}
            </b-th>
            <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
              {{ item.cost_b - item.zakontraktovano_bud }}
            </b-th>
            <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
              {{ item.cost_v - item.zakontraktovano_nebud }}
            </b-th>
          </b-tr>
        </b-tbody>
        <b-tfoot>
          <b-tr>
            <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
              <label>ИТОГО:</label>
            </b-th>
            <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
              <label>{{ cost_sb_full }}</label>
            </b-th>
            <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
              <label>{{ cost_sv_full }}</label>
            </b-th>
            <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
              <label>{{ cost_so_full }}</label>
            </b-th>

            <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
              <label>{{ cost_zb_full }}</label>
            </b-th>
            <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
              <label>{{ cost_zv_full }}</label>
            </b-th>
            <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
              <label>{{ cost_nb_full }}</label>
            </b-th>

            <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
              <label>{{ cost_nv_full }}</label>
            </b-th>
            <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
              <label>{{ cost_ib_full }}</label>
            </b-th>
            <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
              <label>{{ cost_iv_full }}</label>
            </b-th>
            <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
              <label>{{ cost_ob_full }}</label>
            </b-th>
            <b-th class="vertical-align-for-table-cell text-align-end-for-cell">
              <label>{{ cost_ov_full }}</label>
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
import {BButton, BForm, BFormInput, BTableSimple, BTbody, BTd, BTfoot, BTh, BThead, BTr, VBToggle} from "bootstrap-vue";

export default {
  directives: {
    'b-toggle': VBToggle
  },
  props: ['data', 'id_org'],

  watch: {
    data: {
      async handler() {

        await this.getTableFourInfo()

        this.items.forEach(i => {
          Object.keys(i).forEach(key => {
            i[key] = 0;
          })
        })


        if (this.table4) {

          this.table4.forEach(item => {
            this.items[0].cost_b = this.data.video_system_bud;
            this.items[0].cost_v = this.data.video_system_nebud;
            this.items[0].cost_o = this.toNum(this.data.video_system_nebud) + this.toNum(this.data.video_system_bud);
            this.items[0].zakontraktovano_bud += this.toNum(item.row_stages[0]?.cost_budjet['video_system-0']); //this.toNum(this.table4[0].cost_budjet['video_system-0'])
            this.items[0].zakontraktovano_nebud += this.toNum(item.row_stages[0]?.cost_vb['video_system-0']);// this.toNum(this.table4[0].cost_vb['video_system-0'])
            this.items[0].soglasovano_bud += this.toNum(item.row_stages[1]?.cost_budjet['video_system-0']);
            this.items[0].soglasovano_nebud += this.toNum(item.row_stages[1]?.cost_vb['video_system-0']);

            this.items[1].cost_b = this.data.evacuation_system_bud;
            this.items[1].cost_v = this.data.evacuation_system_nebud;
            this.items[1].cost_o = this.toNum(this.data.evacuation_system_nebud) + this.toNum(this.data.evacuation_system_bud);
            this.items[1].zakontraktovano_bud += this.toNum(item.row_stages[0]?.cost_budjet['evacuation_system-0']);
            this.items[1].zakontraktovano_nebud += this.toNum(item.row_stages[0]?.cost_vb['evacuation_system-0']);
            this.items[1].soglasovano_bud += this.toNum(item.row_stages[1]?.cost_budjet['evacuation_system-0']);
            this.items[1].soglasovano_nebud += this.toNum(item.row_stages[1]?.cost_vb['evacuation_system-0']);

            this.items[2].cost_b = this.data.light_system_bud;
            this.items[2].cost_v = this.data.light_system_nebud;
            this.items[2].cost_o = this.toNum(this.data.light_system_nebud) + this.toNum(this.data.light_system_bud);
            this.items[2].zakontraktovano_bud += this.toNum(item.row_stages[0]?.cost_budjet['light_system-0']);
            this.items[2].zakontraktovano_nebud += this.toNum(item.row_stages[0]?.cost_vb['light_system-0']);
            this.items[2].soglasovano_bud += this.toNum(item.row_stages[1]?.cost_budjet['light_system-0']);
            this.items[2].soglasovano_nebud += this.toNum(item.row_stages[1]?.cost_vb['light_system-0']);

            this.items[3].cost_b = this.data.predator_system_bud;
            this.items[3].cost_v = this.data.predator_system_nebud;
            this.items[3].cost_o = this.toNum(this.data.predator_system_nebud) + this.toNum(this.data.predator_system_bud);
            this.items[3].zakontraktovano_bud += this.toNum(item.row_stages[0]?.cost_budjet['predator_system-0']);
            this.items[3].zakontraktovano_nebud += this.toNum(item.row_stages[0]?.cost_vb['predator_system-0']);
            this.items[3].soglasovano_bud += this.toNum(item.row_stages[1]?.cost_budjet['predator_system-0']);
            this.items[3].soglasovano_nebud += this.toNum(item.row_stages[1]?.cost_vb['predator_system-0']);

            this.items[4].cost_b = this.data.alarm_warning_system_bud;
            this.items[4].cost_v = this.data.alarm_warning_system_nebud;
            this.items[4].cost_o = this.toNum(this.data.alarm_warning_system_nebud) + this.toNum(this.data.alarm_warning_system_bud);
            this.items[4].zakontraktovano_bud += this.toNum(item.row_stages[0]?.cost_budjet['alarm_warning_system-0']);
            this.items[4].zakontraktovano_nebud += this.toNum(item.row_stages[0]?.cost_vb['alarm_warning_system-0']);
            this.items[4].soglasovano_bud += this.toNum(item.row_stages[1]?.cost_budjet['alarm_warning_system-0']);
            this.items[4].soglasovano_nebud += this.toNum(item.row_stages[1]?.cost_vb['alarm_warning_system-0']);

            this.items[5].cost_b = this.data.alarm_fire_system_bud;
            this.items[5].cost_v = this.data.alarm_fire_system_nebud;
            this.items[5].cost_o = this.toNum(this.data.alarm_fire_system_nebud) + this.toNum(this.data.alarm_fire_system_bud);
            this.items[5].zakontraktovano_bud += this.toNum(item.row_stages[0]?.cost_budjet['alarm_fire_system-0']);
            this.items[5].zakontraktovano_nebud += this.toNum(item.row_stages[0]?.cost_vb['alarm_fire_system-0']);
            this.items[5].soglasovano_bud += this.toNum(item.row_stages[1]?.cost_budjet['alarm_fire_system-0']);
            this.items[5].soglasovano_nebud += this.toNum(item.row_stages[1]?.cost_vb['alarm_fire_system-0']);

            this.items[6].cost_b = this.data.phone_system_bud;
            this.items[6].cost_v = this.data.phone_system_nebud;
            this.items[6].cost_o = this.toNum(this.data.phone_system_nebud) + this.toNum(this.data.phone_system_bud);
            this.items[6].zakontraktovano_bud += this.toNum(item.row_stages[0]?.cost_budjet['phone_system-0']);
            this.items[6].zakontraktovano_nebud += this.toNum(item.row_stages[0]?.cost_vb['phone_system-0']);
            this.items[6].soglasovano_bud += this.toNum(item.row_stages[1]?.cost_budjet['phone_system-0']);
            this.items[6].soglasovano_nebud += this.toNum(item.row_stages[1]?.cost_vb['phone_system-0']);

            this.items[7].cost_b = this.data.fence_bud;
            this.items[7].cost_v = this.data.fence_nebud;
            this.items[7].cost_o = this.toNum(this.data.fence_nebud) + this.toNum(this.data.fence_bud);
            this.items[7].zakontraktovano_bud += this.toNum(item.row_stages[0]?.cost_budjet['fence-0']);
            this.items[7].zakontraktovano_nebud += this.toNum(item.row_stages[0]?.cost_vb['fence-0']);
            this.items[7].soglasovano_bud += this.toNum(item.row_stages[1]?.cost_budjet['fence-0']);
            this.items[7].soglasovano_nebud += this.toNum(item.row_stages[1]?.cost_vb['fence-0']);

            this.items[8].cost_b = this.data.skud_bud;
            this.items[8].cost_v = this.data.skud_nebud;
            this.items[8].cost_o = this.toNum(this.data.skud_nebud) + this.toNum(this.data.skud_bud);
            this.items[8].zakontraktovano_bud += this.toNum(item.row_stages[0]?.cost_budjet['skud-0']);
            this.items[8].zakontraktovano_nebud += this.toNum(item.row_stages[0]?.cost_vb['skud-0']);
            this.items[8].soglasovano_bud += this.toNum(item.row_stages[1]?.cost_budjet['skud-0']);
            this.items[8].soglasovano_nebud += this.toNum(item.row_stages[1]?.cost_vb['skud-0']);
          })


        }


      },
      deep: true
    }
  },

  components: {
    BTd,
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
    await this.getTableFourInfo()
  },

  data() {
    return {
      csrf: document.getElementsByName('csrf-token')[0].content,
      modelName: 'Atz',
      table4: [],
      items: [
        {
          zakontraktovano_bud: 0, soglasovano_bud: 0, zakontraktovano_nebud: 0, soglasovano_nebud: 0,
          cost_b: null, cost_v: null, cost_o: null, label: 'Система видеонаблюдения'
        },
        {
          zakontraktovano_bud: 0,
          soglasovano_bud: 0,
          zakontraktovano_nebud: 0,
          soglasovano_nebud: 0,
          cost_b: null,
          cost_v: null,
          cost_o: null,
          label: 'Система оповещения и управления эвакуацией'
        },
        {
          zakontraktovano_bud: 0,
          soglasovano_bud: 0,
          zakontraktovano_nebud: 0,
          soglasovano_nebud: 0,
          cost_b: null,
          cost_v: null,
          cost_o: null,
          label: 'Система освещения'
        },
        {
          zakontraktovano_bud: 0,
          soglasovano_bud: 0,
          zakontraktovano_nebud: 0,
          soglasovano_nebud: 0,
          cost_b: null,
          cost_v: null,
          cost_o: null,
          label: 'Средства охранной сигнализации'
        },
        {
          zakontraktovano_bud: 0,
          soglasovano_bud: 0,
          zakontraktovano_nebud: 0,
          soglasovano_nebud: 0,
          cost_b: null,
          cost_v: null,
          cost_o: null,
          label: 'Средства тревожной сигнализации'
        },
        {
          zakontraktovano_bud: 0,
          soglasovano_bud: 0,
          zakontraktovano_nebud: 0,
          soglasovano_nebud: 0,
          cost_b: null,
          cost_v: null,
          cost_o: null,
          label: 'Средства пожарной сигнализации'
        },
        {
          zakontraktovano_bud: 0,
          soglasovano_bud: 0,
          zakontraktovano_nebud: 0,
          soglasovano_nebud: 0,
          cost_b: null,
          cost_v: null,
          cost_o: null,
          label: 'Средства телефонной связи и радиосвязи'
        },
        {
          zakontraktovano_bud: 0,
          soglasovano_bud: 0,
          zakontraktovano_nebud: 0,
          soglasovano_nebud: 0,
          cost_b: null,
          cost_v: null,
          cost_o: null,
          label: 'Ограждение (в т.ч. ворота, шлагбаумы)'
        },
        {
          zakontraktovano_bud: 0,
          soglasovano_bud: 0,
          zakontraktovano_nebud: 0,
          soglasovano_nebud: 0,
          cost_b: null,
          cost_v: null,
          cost_o: null,
          label: 'СКУД'
        },
      ],
    }
  },
  computed: {
    cost_sb_full() {
      return this.items.reduce((a, b) => a + this.toNum(b.cost_b), 0)
    },
    cost_sv_full() {
      return this.items.reduce((a, b) => a + this.toNum(b.cost_v), 0)
    },
    cost_so_full() {
      return this.items.reduce((a, b) => a + this.toNum(b.cost_o), 0)
    },
    cost_zb_full() {
      return this.items.reduce((a, b) => a + this.toNum(b.zakontraktovano_bud), 0)
    },
    cost_zv_full() {
      return this.items.reduce((a, b) => a + this.toNum(b.zakontraktovano_nebud), 0)
    },
    cost_nb_full() {
      return this.items.reduce((a, b) => a + (this.toNum(b.zakontraktovano_bud) - this.toNum(b.soglasovano_bud)), 0)
    },
    cost_nv_full() {
      return this.items.reduce((a, b) => a + (this.toNum(b.zakontraktovano_nebud) - this.toNum(b.soglasovano_nebud)), 0)
    },
    cost_ib_full() {
      return this.items.reduce((a, b) => a + this.toNum(b.soglasovano_bud), 0)
    },
    cost_iv_full() {
      return this.items.reduce((a, b) => a + this.toNum(b.soglasovano_nebud), 0)
    },
    cost_ob_full() {
      return this.items.reduce((a, b) => a + (this.toNum(b.cost_b) - this.toNum(b.soglasovano_bud)), 0)
    },
    cost_ov_full() {
      return this.items.reduce((a, b) => a + (this.toNum(b.cost_v) - this.toNum(b.soglasovano_nebud)), 0)
    }

  },
  methods: {

    async getTableFourInfo() {
      let data = new FormData();
      data.append('id_org', this.id_org);
      await Axios.post("/app/atz/get-table4", data, {
        headers: {
          "X-CSRF-Token": this.csrf,
        },
      }).then((res) => {
        this.table4 = res.data;
        console.log('coming from server: ', this.table4);
      });
    },

    toNum: num => typeof num === 'string' ? num.toNumber() : (num || 0),
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