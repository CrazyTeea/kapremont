<template>
  <div>
    <div class="table-auto-overflow">
      <b-table-simple hover bordered>
        <b-thead>
          <b-th>Объект / Адрес</b-th>
          <b-th>Система видеонаблюдения</b-th>
          <b-th>Система оповещения и управления эвакуацией</b-th>
          <b-th>Система освещения</b-th>
          <b-th>Средства охранной сигнализации</b-th>
          <b-th>Средства тревожной сигнализации</b-th>
          <b-th>Средства пожарной сигнализации</b-th>
          <b-th>Средства телефонной связи и радиосвязи</b-th>
          <b-th>Ограждение (в т.ч. ворота, шлагбаумы)</b-th>
          <b-th>СКУД</b-th>
          <b-th>ИТОГО</b-th>
        </b-thead>
        <b-tbody>
          <b-tr v-for="(row, index) in rows" :key="`table3_${index}`">
            <b-td class="first-table-column">
              <multiselect
                  v-model="row.object"
                  label="passport_name"
                  track-by="id"
                  :options="passport"
                  placeholder="Выберите объект"
                  select-label="Добваить"
                  deselect-label="Удалить"
                  selectedLabel="Выбрано"
              ></multiselect>
              <b-icon @click="deleteRow(index)" variant="danger" icon="trash" class="trash-icon mt-2"></b-icon>
            </b-td>
            <b-td class="mw-145">
              <b-form-input :disabled="isDku()" type="number" v-model="row.video_system.podved"></b-form-input>
              <div class="row">
                <div class="col m-0 pr-0"><b-form-input :disabled="!isDku()" type="number" class="mt-1" v-model="row.video_system_bud.dku"></b-form-input></div>
                <div class="col m-0 pl-0"><b-form-input :disabled="!isDku()" type="number" class="mt-1" v-model="row.video_system_nebud.dku"></b-form-input></div>
              </div>
              <b-form-input disabled class="mt-1" v-model="row.docs"></b-form-input>
            </b-td>
            <b-td class="mw-145">
              <b-form-input :disabled="isDku()" type="number" v-model="row.evacuation_system.podved"></b-form-input>
              <div class="row">
                <div class="col m-0 pr-0"><b-form-input :disabled="!isDku()" type="number" class="mt-1" v-model="row.evacuation_system_bud.dku"></b-form-input></div>
                <div class="col m-0 pl-0"><b-form-input :disabled="!isDku()" type="number" class="mt-1" v-model="row.evacuation_system_nebud.dku"></b-form-input></div>
              </div>
              <b-form-input disabled class="mt-1" v-model="row.docs"></b-form-input>
            </b-td>
            <b-td class="mw-145">
              <b-form-input :disabled="isDku()" type="number" v-model="row.light_system.podved"></b-form-input>
              <div class="row">
                <div class="col m-0 pr-0"><b-form-input :disabled="!isDku()" type="number" class="mt-1" v-model="row.light_system_bud.dku"></b-form-input></div>
                <div class="col m-0 pl-0"><b-form-input :disabled="!isDku()" type="number" class="mt-1" v-model="row.light_system_nebud.dku"></b-form-input></div>
              </div>
              <b-form-input disabled class="mt-1" v-model="row.docs"></b-form-input>
            </b-td>
            <b-td class="mw-145">
              <b-form-input :disabled="isDku()" type="number" v-model="row.predator_system.podved"></b-form-input>
              <div class="row">
                <div class="col m-0 pr-0"><b-form-input :disabled="!isDku()" type="number" class="mt-1" v-model="row.predator_system_bud.dku"></b-form-input></div>
                <div class="col m-0 pl-0"><b-form-input :disabled="!isDku()" type="number" class="mt-1" v-model="row.predator_system_nebud.dku"></b-form-input></div>
              </div>
              <b-form-input disabled class="mt-1" v-model="row.docs"></b-form-input>
            </b-td>
            <b-td class="mw-145">
              <b-form-input :disabled="isDku()" type="number" v-model="row.alarm_warning_system.podved"></b-form-input>
              <div class="row">
                <div class="col m-0 pr-0"><b-form-input :disabled="!isDku()" type="number" class="mt-1" v-model="row.alarm_warning_system_bud.dku"></b-form-input></div>
                <div class="col m-0 pl-0"><b-form-input :disabled="!isDku()" type="number" class="mt-1" v-model="row.alarm_warning_system_nebud.dku"></b-form-input></div>
              </div>
              <b-form-input disabled class="mt-1" v-model="row.docs"></b-form-input>
            </b-td>
            <b-td class="mw-145">
              <b-form-input :disabled="isDku()" type="number" v-model="row.alarm_fire_system.podved"></b-form-input>
              <div class="row">
                <div class="col m-0 pr-0"><b-form-input :disabled="!isDku()" type="number" class="mt-1" v-model="row.alarm_fire_system_bud.dku"></b-form-input></div>
                <div class="col m-0 pl-0"><b-form-input :disabled="!isDku()" type="number" class="mt-1" v-model="row.alarm_fire_system_nebud.dku"></b-form-input></div>
              </div>
              <b-form-input disabled class="mt-1" v-model="row.docs"></b-form-input>
            </b-td>
            <b-td class="mw-145">
              <b-form-input :disabled="isDku()" type="number" v-model="row.phone_system.podved"></b-form-input>
              <div class="row">
                <div class="col m-0 pr-0"><b-form-input :disabled="!isDku()" type="number" class="mt-1" v-model="row.phone_system_bud.dku"></b-form-input></div>
                <div class="col m-0 pl-0"><b-form-input :disabled="!isDku()" type="number" class="mt-1" v-model="row.phone_system_nebud.dku"></b-form-input></div>
              </div>
              <b-form-input disabled class="mt-1" v-model="row.docs"></b-form-input>
            </b-td>
            <b-td class="mw-145">
              <b-form-input :disabled="isDku()" type="number" v-model="row.fence.podved"></b-form-input>
              <div class="row">
                <div class="col m-0 pr-0"><b-form-input :disabled="!isDku()" type="number" class="mt-1" v-model="row.fence_bud.dku"></b-form-input></div>
                <div class="col m-0 pl-0"><b-form-input :disabled="!isDku()" type="number" class="mt-1" v-model="row.fence_nebud.dku"></b-form-input></div>
              </div>

              <b-form-input disabled class="mt-1" v-model="row.docs"></b-form-input>
            </b-td>
            <b-td class="mw-145">
              <b-form-input :disabled="isDku()" type="number" v-model="row.skud.podved"></b-form-input>
              <div class="row">
                <div class="col m-0 pr-0"><b-form-input :disabled="!isDku()" type="number" class="mt-1" v-model="row.skud_bud.dku"></b-form-input></div>
                <div class="col m-0 pl-0"><b-form-input :disabled="!isDku()" type="number" class="mt-1" v-model="row.skud_nebud.dku"></b-form-input></div>
              </div>
              <b-form-input disabled class="mt-1" v-model="row.docs"></b-form-input>
            </b-td>
            <b-td class="mw-145">
              ---
              <!--<b-form-input type="number" v-model="row.docs"></b-form-input>
              <b-form-input type="number" class="mt-1" v-model="row.docs"></b-form-input>
              <b-form-input disabled class="mt-1" v-model="row.docs"></b-form-input> -->
            </b-td>
          </b-tr>
        </b-tbody>
      </b-table-simple>
    </div>
    <div class="d-flex justify-content-end mt-2">
      <b-button size="sm" @click="addRow">Добавить строку</b-button>
      <b-button size="sm" variant="success" class="ml-2" @click="saveChanges">Сохранить</b-button>
    </div>
    <div class="mt-5">
      <!-- <multiselect
          v-model="sel2"
          label="passport_name"
          track-by="id"
          :options="passport"
          placeholder="Выберите объект"
          select-label="Добваить"
          deselect-label="Удалить"
          selectedLabel="Выбрано"
      ></multiselect>

      <multiselect
          class="mt-5"
          v-model="sel"
          label="passport_name"
          track-by="id"
          :multiple="true"
          :taggable="true"
          :options="passport"
          placeholder="Выберите объект"
          select-label="Добваить"
          deselect-label="Удалить"
          selectedLabel="Выбрано"
      ></multiselect> -->
    </div>
  </div>
</template>

<script>
import {BButton, BFormInput, BTableSimple, BTbody, BTd, BTh, BThead, BTr} from "bootstrap-vue";
import Multiselect from "vue-multiselect";
import Axios from "axios";

export default {
  props: ["passport", "id_org"],
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
      csrf: document.getElementsByName("csrf-token")[0].content,
      rows: [],
      sel: null,
      sel2: null,
    };
  },
  async mounted() {
    await this.id_org;
    await this.getInfoTable3();
  },
  methods: {
    deleteRow(index) {
      if (this.rows[index].id) {
        this.deleteRowFromServer(this.rows[index].id);
        return;
      }
      this.rows.splice(index, 1);
    },
    deleteRowFromServer(id) {
      let data = new FormData();
      data.append("id", id);
      return Axios.post("/app/atz/delete-table3", data, {
        headers: {
          "X-CSRF-Token": this.csrf,
        },
      }).then(() => {
        this.getInfoTable3();
      });
    },
    isDku() {
      return window.Permission === "dku";
    },
    async getInfoTable3() {
      let data = new FormData();
      data.append("id_org", this.id_org);
      return Axios.post("/app/atz/get-table3", data, {
        headers: {
          "X-CSRF-Token": this.csrf,
        },
      }).then((res) => {
        if (res.data) this.rows = res.data;
      });
    },
    saveChanges() {
      let data = new FormData();
      data.append("data", JSON.stringify(this.rows));
      data.append("id_org", this.id_org);

      return Axios.post("/app/atz/save-table3", data, {
        headers: {
          "X-CSRF-Token": this.csrf,
        },
      })
          .then((res) => {
            console.log(res);
          })
          .catch(() => {
            console.log("error!");
          });
    },
    debug() {
      console.log(this.rows);
    },
    addRow() {
      this.rows.push({
        object: null,
        video_system: {
          podved: null,
          dku: null,
          dku_choice: null,
        },
        evacuation_system: {
          podved: null,
          dku: null,
          dku_choice: null,
        },
        light_system: {
          podved: null,
          dku: null,
          dku_choice: null,
        },
        predator_system: {
          podved: null,
          dku: null,
          dku_choice: null,
        },
        alarm_warning_system: {
          podved: null,
          dku: null,
          dku_choice: null,
        },
        alarm_fire_system: {
          podved: null,
          dku: null,
          dku_choice: null,
        },
        phone_system: {
          podved: null,
          dku: null,
          dku_choice: null,
        },
        fence: {
          podved: null,
          dku: null,
          dku_choice: null,
        },
        skud: {
          podved: null,
          dku: null,
          dku_choice: null,
        },
      });
    },
  },
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style scoped>
.table-auto-overflow {
  height: 380px;
  overflow-x: scroll;
  overflow-y: unset;
}

.first-table-column {
  min-width: 390px;
}

.mw-145 {
  min-width: 145px;
}

.trash-icon {
  transform: scale(1);
  transition: all .3s ease;
}

.trash-icon:hover {
  transform: scale(1.3);
  transition: all .3s ease;
}
</style>
