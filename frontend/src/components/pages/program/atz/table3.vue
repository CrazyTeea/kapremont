<template>
  <div>
    <div class="table-auto-overflow">
      <b-table-simple hover bordered>
        <b-thead>
          <b-tr>
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
          </b-tr>

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


              <b-form-input placeholder="Бюджет..." :disabled="isDku()" type="number" class="mt-1"
                            v-model="row.video_system_bud.dku"/>


              <b-form-input placeholder="Внебюджет..." :disabled="isDku()" type="number" class="mt-1"
                            v-model="row.video_system_nebud.dku"/>


            </b-td>
            <b-td class="mw-145">

              <b-form-input placeholder="Бюджет..." :disabled="isDku()" type="number" class="mt-1"
                            v-model="row.evacuation_system_bud.dku"/>

              <b-form-input placeholder="Внебюджет..." :disabled="isDku()" type="number" class="mt-1"
                            v-model="row.evacuation_system_nebud.dku"/>

            </b-td>
            <b-td class="mw-145">

              <b-form-input placeholder="Бюджет..." :disabled="isDku()" type="number" class="mt-1"
                            v-model="row.light_system_bud.dku"/>

              <b-form-input placeholder="Внебюджет..." :disabled="isDku()" type="number" class="mt-1"
                            v-model="row.light_system_nebud.dku"/>

            </b-td>
            <b-td class="mw-145">

              <b-form-input placeholder="Бюджет..." :disabled="isDku()" type="number" class="mt-1"
                            v-model="row.predator_system_bud.dku"/>

              <b-form-input placeholder="Внебюджет..." :disabled="isDku()" type="number" class="mt-1"
                            v-model="row.predator_system_nebud.dku"/>

            </b-td>
            <b-td class="mw-145">

              <b-form-input placeholder="Бюджет..." :disabled="isDku()" type="number" class="mt-1"
                            v-model="row.alarm_warning_system_bud.dku"/>

              <b-form-input placeholder="Внебюджет..." :disabled="isDku()" type="number" class="mt-1"
                            v-model="row.alarm_warning_system_nebud.dku"/>

            </b-td>
            <b-td class="mw-145">

              <b-form-input placeholder="Бюджет..." :disabled="isDku()" type="number" class="mt-1"
                            v-model="row.alarm_fire_system_bud.dku"/>

              <b-form-input placeholder="Внебюджет..." :disabled="isDku()" type="number" class="mt-1"
                            v-model="row.alarm_fire_system_nebud.dku"/>

            </b-td>
            <b-td class="mw-145">

              <b-form-input placeholder="Бюджет..." :disabled="isDku()" type="number" class="mt-1"
                            v-model="row.phone_system_bud.dku"/>

              <b-form-input placeholder="Внебюджет..." :disabled="isDku()" type="number" class="mt-1"
                            v-model="row.phone_system_nebud.dku"/>

            </b-td>
            <b-td class="mw-145">

              <b-form-input placeholder="Бюджет..." :disabled="isDku()" type="number" class="mt-1"
                            v-model="row.fence_bud.dku"/>

              <b-form-input placeholder="Внебюджет..." :disabled="isDku()" type="number" class="mt-1"
                            v-model="row.fence_nebud.dku"/>

            </b-td>
            <b-td class="mw-145">

              <b-form-input placeholder="Бюджет..." :disabled="isDku()" type="number" class="mt-1"
                            v-model="row.skud_bud.dku"/>

              <b-form-input placeholder="Внебюджет..." :disabled="isDku()" type="number" class="mt-1"
                            v-model="row.skud_nebud.dku"/>


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
    <div class=" mt-2">
      <div class="row">
        <div class="col">
          <div class="row">
            <div class="col pr-0">
              <div v-if="files.file0S" class="row float-left">
                <div class="col"><a @click="downloadFile(0)">{{ files.file0S }}</a></div>
                <div v-can:user,faiv_user class="text-danger">
                  <b-icon @click="files.file0S = null" icon="trash-fill"></b-icon>
                </div>

              </div>

              <b-form-file v-else v-model="files.file0" @input="saveFile(0)" v-can:user,faiv_user/>
            </div>
            <div class="col pr-0">
              <div v-if="files.file1S" class="row float-left">
                <div class="col"><a @click="downloadFile(0)">{{ files.file1S }}</a></div>
                <div v-can:user,faiv_user class="text-danger">
                  <b-icon @click="files.file1S = null" icon="trash-fill"></b-icon>
                </div>

              </div>
              <b-form-file v-else v-model="files.file1" @input="saveFile(1)" v-can:user,faiv_user/>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="float-right">
            <b-button size="sm" @click="addRow">Добавить строку</b-button>
            <b-button size="sm" variant="success" class="ml-2" @click="saveChanges">Сохранить</b-button>
          </div>

        </div>
      </div>


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
import {BButton, BFormFile, BFormInput, BTableSimple, BTbody, BTd, BTh, BThead, BTr} from "bootstrap-vue";
import Multiselect from "vue-multiselect";
import Axios from "axios";

export default {
  props: {
    passport: null,
    id_org: null,
    sum: {
      video_system_bud: 0,
      evacuation_system_bud: 0,
      light_system_bud: 0,
      predator_system_bud: 0,
      alarm_warning_system_bud: 0,
      alarm_fire_system_bud: 0,
      phone_system_bud: 0,
      fence_bud: 0,
      skud_bud: 0,


      video_system_nebud: 0,
      evacuation_system_nebud: 0,
      light_system_nebud: 0,
      predator_system_nebud: 0,
      alarm_warning_system_nebud: 0,
      alarm_fire_system_nebud: 0,
      phone_system_nebud: 0,
      fence_nebud: 0,
      skud_nebud: 0

    }
  },
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
    BFormFile
  },
  watch: {
    rows: {
      handler() {

        let toNum = (val) => typeof val === 'string' ? val.toNumber() : Number(val)

        this.sum.video_system_bud = this.rows.reduce((a, b) => {
          return a + toNum(b.video_system_bud.dku)
        }, 0);
        this.sum.evacuation_system_bud = this.rows.reduce((a, b) => {
          return a + toNum(b.evacuation_system_bud.dku)
        }, 0);
        this.sum.light_system_bud = this.rows.reduce((a, b) => {
          return a + toNum(b.light_system_bud.dku)
        }, 0);
        this.sum.predator_system_bud = this.rows.reduce((a, b) => {
          return a + toNum(b.predator_system_bud.dku)
        }, 0);
        this.sum.alarm_warning_system_bud = this.rows.reduce((a, b) => {
          return a + toNum(b.alarm_warning_system_bud.dku)
        }, 0);
        this.sum.alarm_fire_system_bud = this.rows.reduce((a, b) => {
          return a + toNum(b.alarm_fire_system_bud.dku)
        }, 0);
        this.sum.phone_system_bud = this.rows.reduce((a, b) => {
          return a + toNum(b.phone_system_bud.dku)
        }, 0);
        this.sum.fence_bud = this.rows.reduce((a, b) => {
          return a + toNum(b.fence_bud.dku)
        }, 0);
        this.sum.skud_bud = this.rows.reduce((a, b) => {
          return a + toNum(b.skud_bud.dku)
        }, 0);


        this.sum.video_system_nebud = this.rows.reduce((a, b) => {
          return a + toNum(b.video_system_nebud.dku)
        }, 0);
        this.sum.evacuation_system_nebud = this.rows.reduce((a, b) => {
          return a + toNum(b.evacuation_system_nebud.dku)
        }, 0);
        this.sum.light_system_nebud = this.rows.reduce((a, b) => {
          return a + toNum(b.light_system_nebud.dku)
        }, 0);
        this.sum.predator_system_nebud = this.rows.reduce((a, b) => {
          return a + toNum(b.predator_system_nebud.dku)
        }, 0);
        this.sum.alarm_warning_system_nebud = this.rows.reduce((a, b) => {
          return a + toNum(b.alarm_warning_system_nebud.dku)
        }, 0);
        this.sum.alarm_fire_system_nebud = this.rows.reduce((a, b) => {
          return a + toNum(b.alarm_fire_system_nebud.dku)
        }, 0);
        this.sum.phone_system_nebud = this.rows.reduce((a, b) => {
          return a + toNum(b.phone_system_nebud.dku)
        }, 0);
        this.sum.fence_nebud = this.rows.reduce((a, b) => {
          return a + toNum(b.fence_nebud.dku)
        }, 0);
        this.sum.skud_nebud = this.rows.reduce((a, b) => {
          return a + toNum(b.skud_nebud.dku)
        }, 0);

      },
      deep: true
    }
  },
  data() {
    return {
      csrf: document.getElementsByName("csrf-token")[0].content,
      rows: [],
      sel: null,
      sel2: null,
      files: {
        file0: null,
        file1: null,
        file0S: null,
        file1S: null
      },
    };
  },
  async mounted() {
    await this.id_org;
    await this.getInfoTable3();
    await this.getFiles()
  },
  methods: {
    downloadFile(type) {
      window.open(`/app/atz/download-files?id_org=${this.id_org}&type=${type}`)
    },
    async getFiles() {
      await Axios.get('/app/atz/get-files', {
        params: {
          id_org: this.id_org
        }
      }).then(res => {
        if (res.data.length) {
          res.data.forEach(item => {
            if (item.type === 0)
              this.files.file0S = item.file
            if (item.type === 1)
              this.files.file1S = item.file
          })
        }
      })
    },
    async saveFile(type) {
      let data = new FormData();
      data.append('file', this.files[`file${type}`]);
      data.append('id_org', this.id_org);
      data.append('type', type);
      await Axios.post('/app/atz/save-file', data, {
        headers: {
          "X-CSRF-Token": this.csrf
        }
      }).then(res => {
        if (res.data.success)
          this.getFiles();
      })
    },
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
    },
    debug() {
      //console.log(this.rows);
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

        video_system_bud: {
          podved: null,
          dku: null,
          dku_choice: null,
        },
        evacuation_system_bud: {
          podved: null,
          dku: null,
          dku_choice: null,
        },
        light_system_bud: {
          podved: null,
          dku: null,
          dku_choice: null,
        },
        predator_system_bud: {
          podved: null,
          dku: null,
          dku_choice: null,
        },
        alarm_warning_system_bud: {
          podved: null,
          dku: null,
          dku_choice: null,
        },
        alarm_fire_system_bud: {
          podved: null,
          dku: null,
          dku_choice: null,
        },
        phone_system_bud: {
          podved: null,
          dku: null,
          dku_choice: null,
        },
        fence_bud: {
          podved: null,
          dku: null,
          dku_choice: null,
        },
        skud_bud: {
          podved: null,
          dku: null,
          dku_choice: null,
        },


        video_system_nebud: {
          podved: null,
          dku: null,
          dku_choice: null,
        },
        evacuation_system_nebud: {
          podved: null,
          dku: null,
          dku_choice: null,
        },
        light_system_nebud: {
          podved: null,
          dku: null,
          dku_choice: null,
        },
        predator_system_nebud: {
          podved: null,
          dku: null,
          dku_choice: null,
        },
        alarm_warning_system_nebud: {
          podved: null,
          dku: null,
          dku_choice: null,
        },
        alarm_fire_system_nebud: {
          podved: null,
          dku: null,
          dku_choice: null,
        },
        phone_system_nebud: {
          podved: null,
          dku: null,
          dku_choice: null,
        },
        fence_nebud: {
          podved: null,
          dku: null,
          dku_choice: null,
        },
        skud_nebud: {
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
a {
  cursor: pointer;
}

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
