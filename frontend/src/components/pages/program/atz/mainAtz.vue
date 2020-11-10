<template>
  <div v-if="ready" class="main_wrapper">
    <div class="row">
      <div class="col-6">
        <h6>{{ orgInfo.name }}</h6>
        <p>
          <strong>Субъект РФ:</strong>
          {{ orgInfo.region }}
        </p>
        <b-table-simple bordered>
          <b-thead>
            <b-th>№</b-th>
            <b-th colspan="2">Показатель</b-th>
            <b-th>Значение</b-th>
          </b-thead>
          <b-tbody>
            <b-tr>
              <b-td>1</b-td>
              <b-td colspan="2"
              >Объем финансового обеспечения на реализацию мероприятий по модернизации инфраструктуры, включая
                капитальный ремонт объектов и проведение мероприятий по
                антитеррористической защищенности объектов
              </b-td
              >
              <b-td>{{ finanse_volume }}</b-td>
            </b-tr>
            <b-tr>
              <b-td rowspan="3">2</b-td>
              <b-td rowspan="4"
              >Утвержденная программа модернизации инфраструктуры, включая капитальный ремонт объектов и проведение
                мероприятий по антитеррористической защищенности объектов (Раздел 2. Антитеррористическая защищенность
                объектов)
              </b-td
              >
              <b-td>Сумма бюджетного финансирования (руб.)</b-td>
              <b-td>{{ sum.b }}</b-td>
            </b-tr>
            <b-tr>
              <b-td>Сумма внебюджетного финансирования (руб.)</b-td>
              <b-td>{{ sum.vb }}</b-td>
            </b-tr>
            <b-tr>
              <b-td>Общий объем финансирования (руб.)</b-td>
              <b-td>{{ sum.b + sum.vb }}</b-td>
            </b-tr>
          </b-tbody>
        </b-table-simple>
        <h4 class="mt-2">Статус:</h4>
      </div>
      <div class="col-5 offset-1">
        <v-userPanel v-can:!dku/>
        <br/>
        <user-info-view :id_org="id_org"/>
      </div>
    </div>

    <!--    Тут таблица 2!!!!!!!!!!!!!!!!!!-->
    <div class="row">
      <comments class="w-100"/>
    </div>
    <div class="row mt-5">
      <b-card no-body class="mb-1 w-100">
        <b-card-header header-tag="header" class="p-1" role="tab" v-b-toggle.TABLE2>
          <span class="toggle_button">Таблица 2. Сведения из утвержденной программы модернизации инфраструктуры
            (Раздел 2. Антитеррористическая защищенность объектов) /
            Письма из Минобрнауки "О мероприятиях по антитерроиристической зазщищенности"
            объектов (Департамент управления имуществом)
            <!----></span>
        </b-card-header>
        <b-collapse id="TABLE2" accordion="TABLE2" role="tabpanel">
          <b-card-body>
            <table3 :sum="sum" :passport="passport" :id_org="id_org"/>
          </b-card-body>
        </b-collapse>
      </b-card>
    </div>

    <!--    Тут таблица 3!!!!!!!!!!!!!!!!!-->
    <div class="row mt-5">
      <b-card no-body class="mb-1 w-100">
        <b-card-header header-tag="header" class="p-1" role="tab" v-b-toggle.TABLE3>
          <span class="toggle_button">Таблица 3. Процесс реализации программы</span>
        </b-card-header>
        <b-collapse id="TABLE3" accordion="TABLE3" role="tabpanel">
          <b-card-body>
            <atz-table :id_org="id_org" :data="sum" @getTable2AtzInfo="setTable2Atz"/>
          </b-card-body>
        </b-collapse>
      </b-card>
    </div>

    <div class="row mt-5">
      <b-card no-body class="mb-1 w-100">
        <b-card-header header-tag="header" class="p-1" role="tab" v-b-toggle.TABLE4>
          <span class="toggle_button">Таблица 4. Реестр договоров заключенных в рамках программы модернизации инфраструктуры (АТЗ) </span>
        </b-card-header>
        <b-collapse id="TABLE4" accordion="TABLE4" role="tabpanel" visible>
          <b-card-body>
            <table4 :passport="passport" :id_org="id_org"/>
          </b-card-body>
        </b-collapse>
      </b-card>
    </div>

    <div class="row mt-5">
      <b-card no-body class="mb-1 w-100">
        <b-card-header header-tag="header" class="p-1" role="tab" v-b-toggle.TABLE5>
          <span class="toggle_button">Таблица 3. Процесс реализации программы</span>
        </b-card-header>
        <b-collapse id="TABLE5" accordion="TABLE5" role="tabpanel">
          <b-card-body>
            <div v-if="files.length" v-for="(file,index) in files">
              <a :href="file.link">{{ fileName(file.name_file) }}</a>
            </div>
            <div v-else>
              файлов пока нет
            </div>
          </b-card-body>
        </b-collapse>
      </b-card>
    </div>

    <div class="row mt-5">
      <b-card no-body class="mb-1 w-100">
        <b-card-header header-tag="header" class="p-1" role="tab" v-b-toggle.TABLEDoc>
          <span class="toggle_button">Документы</span>
        </b-card-header>
        <b-collapse id="TABLEDoc" accordion="TABLEDoc" role="tabpanel">
          <b-card-body>
            <upload-file-atchive :id_card="id_card"/>
          </b-card-body>
        </b-collapse>
      </b-card>
    </div>
  </div>
</template>

<script>
import {UserInfoView, userPanel} from "../../../organisms";
import {AtzCommentComponent} from "../../../organisms/comments/";
import UploadFileArchive from './files';
import AtzTable from "./index";
import Table3 from "./table3";
import Table4 from "./table4";
import {
  BButton,
  BCard,
  BCardBody,
  BCardHeader,
  BCollapse,
  BTableSimple,
  BTbody,
  BTd,
  BTh,
  BThead,
  BTr,
  VBToggle
} from "bootstrap-vue";
import Axios from "axios";

export default {
  directives: {
    BToggle: VBToggle,
  },
  components: {
    "v-userPanel": userPanel,
    "atz-table": AtzTable,
    comments: AtzCommentComponent,
    table3: Table3,
    table4: Table4,
    "upload-file-atchive": UploadFileArchive,
    UserInfoView,
    BButton,
    BTableSimple,
    BThead,
    BTbody,
    BTh,
    BTd,
    BTr,
    BCollapse,
    BCard,
    BCardHeader,
    BCardBody,
  },
  data() {
    return {
      csrf: document.getElementsByName("csrf-token")[0].content,
      orgInfo: {},
      id_org: null,
      table2Info: {},
      sums3: {},
      passport: [],
      finanse_volume: null,
      id_card: 1,
      files: [],
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
        skud_nebud: 0,

        b: 0,
        vb: 0,

        row: []

      },
      ready: false
    };
  },
  async mounted() {
    await this.init();
    await this.getPassportInfo();
    await this.getCurentOrg();
    await this.getIasFiles();
    console.log('dsfsdfsd')
    this.ready = true
  },
  computed: {
    fileName() {
      return name => {
        if (name) {
          let arr = name.split('/');
          return arr[arr.length - 1];
        }

      }
    }
  },
  watch: {
    sum: {
      handler(nw) {
        //console.log(nw)
      },
      deep: true
    }

  },
  methods: {

    async getIasFiles() {
      await Axios.get(`/app/atz/get-ias-files?id_org=${this.id_org}`).then(resp => {
        this.files = resp.data;
      }).catch(resp => {
        //console.error(resp)
        this.files = [];
      })

    },

    setTable2Atz(event) {
      this.table2Info = event;
    },
    init() {
      if (window._Organization) this.orgInfo = window._Organization;

      if (window._Region) this.orgInfo.region = window._Region;

      if (this.$route.params.id) this.id_org = this.$route.params.id;


    },
    async getPassportInfo() {
      let data = new FormData();
      data.append("id_org", this.id_org);
      return Axios.post("/app/atz/get-info", data, {
        headers: {
          "X-CSRF-Token": this.csrf,
        },
      }).then(res => {
        this.passport = res.data;
      });
    },
    async getCurentOrg() {
      return Axios.post(`/api/org-table/${this.$route.params.id}`, null, {
        headers: {
          "X-CSRF-Token": this.csrf
        }
      }).then(res => {
        this.finanse_volume = res.data.programm.finance_volume;
      });
    },
  },
};
</script>

<style></style>
