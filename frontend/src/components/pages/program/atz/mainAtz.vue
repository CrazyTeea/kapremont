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
        <b-card-header header-tag="header" class="p-1" role="tab" v-b-toggle.TABLEDoc>
          <span class="toggle_button">Таблица 3. Процесс реализации программы</span>
        </b-card-header>
        <b-collapse id="TABLEDoc" accordion="TABLEDoc" role="tabpanel">
          <b-card-body>
            <upload-file-atchive :id_card="id_card"/>
          </b-card-body>
        </b-collapse>
      </b-card>
    </div>

    <div class="row mt-5">
      <b-card no-body class="mb-1 w-100">
        <b-card-header header-tag="header" class="p-1" role="tab" v-b-toggle.TABLE5>
          <span class="toggle_button">Документы</span>
        </b-card-header>
        <b-collapse id="TABLE5" accordion="TABLE5" role="tabpanel">
          <b-card-body>
            <div v-for="(file,index) in files">
              <a :href="file.link">{{ fileName(file.name_file) }}</a>
            </div>
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
      await Axios.get(`https://api.xn--80apneeq.xn--p1ai/api.php?option=free_api&action=get_files_report&token=Mirea@2020&id_report=768&id_org=${this.id_org}`).then(resp => {
        this.files = resp.data;
      }).catch(resp => {
        //console.error(resp)
        this.files = [
          {
            "name_file": "data/vo/1/2020/rep768/2020-18-05_11-49-1014-05-2020_16-07-20.zip",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=355078"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_15-08-29biznes-inkubator_agu.xls",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=357835"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_15-08-29glav_uch.korpus.xls",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=357836"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_15-08-29gornaya_legenda.xls",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=357837"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_15-08-29kolledgh_ul.solnechnaya_60.xls",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=357838"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_15-08-29nauchnaya_bibleoteka_agu_chasty_a.xls",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=357839"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_15-08-29obscheghitie_-_№1_ghukovskogo_18.xlsx.xls",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=357840"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_15-08-29obscheghitie_-_№3_yunatov_1.xls",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=357841"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_15-08-30obscheghitie_№2_pervomayskaya_212.xls",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=357842"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_15-08-30uchebno-laboratornyy_korpus__ul._2-ya_veteranov_1.xls",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=357843"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_15-08-30uchebnyy_korpus_№_3_ul._ghukovskogo,_15.xls",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=357844"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_15-08-30uchebnyy_korpus_izo-dizayn.xls",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=357845"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_15-09-26tehnicheskoe_zadanie_videonablyudenie.docx",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=357848"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_15-09-26tehnicheskoe_zadanie_pogharka.docx",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=357849"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_15-09-26tz_skud_RG.doc",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=357850"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_15-11-13smeta_svn_telekomport_video.pdf",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=357853"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_15-11-13smeta_svn_telekomport.xlsx",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=357854"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_15-11-13smeta_skud_telekomport.xlsx",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=357855"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_15-11-13smeta_skud.pdf",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=357856"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_15-11-50aps_soue__glavnyy_korpus.xlsx",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=357857"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_15-11-50aps_soue_glavnyy_korpus.PDF",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=357858"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_15-11-50aps_soue_ifk_i_dzyudo.PDF",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=357859"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_15-11-50aps_soue_ifk_i_dzyudo.xlsx",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=357860"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_15-48-14tz_skud.pdf",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=358107"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_15-49-03tz_pogharka.pdf",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=358108"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_15-51-47tz_videonablyudenie.pdf",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=358114"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_16-16-10biznes-inkubator_agu_-_pushkina_260.pdf",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=358191"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_16-16-10glavnyy_uchebnyy_korpus_-_pervomayskaya_208.pdf",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=358192"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_16-16-10gornaya_legenda_-_st._dahovskaya.pdf",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=358193"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_16-16-10kafedra_izo_i_dizayna_-_pervomayskaya_183.pdf",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=358194"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_16-16-10kolledgh_-_solnechnaya_60.pdf",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=358195"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_16-16-10nauchnaya_biblioteka_agu_-_pionerskaya_260.pdf",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=358196"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_16-16-10obscheghitie_№_1-_ghukoskogo_18.pdf",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=358197"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_16-16-10obscheghitie_№_2_-_permovayskaya_212.pdf",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=358198"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_16-16-10obscheghitie_№_3_-_yunatov_1.pdf",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=358199"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_16-16-10soprovoditelynoe_pisymo.pdf",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=358200"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_16-16-10uchebno-laboratornyy_korpus_-_2-ya_veteranov_1.pdf",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=358201"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_16-16-10uchebnyy_korpus_№_3_-_ghukosvkogo_15.pdf",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=358202"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_16-37-09lokalynaya_smeta_-_na_remont_vorot.pdf",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=358256"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_16-37-10lokalynaya_smeta_-_na_remont_vorot.xlsx",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=358257"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-20-05_16-45-38aps_soue_ifk_i_dzyudo_(vernaya_versiya).PDF",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=358280"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-27-05_08-31-12tablica_3.pdf",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=360995"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-27-05_08-31-12tablica_3.xls",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=360996"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-03-06_17-15-43tablicy_aktualynye.rar",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=363423"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-19-06_16-38-10pisymo_i.a._hrabrovoy_zaregistrirovannoe.jpg",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=365461"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-22-06_17-35-02da_postavka_skud_i_sistemy_videonablyud.pdf",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=365604"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-22-06_17-35-02kontrakt_1.pdf",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=365605"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-22-06_17-35-02kontrakt_2.pdf",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=365606"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-22-06_17-35-02pisymo_ot_22.06.2020.jpg",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=365607"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-22-06_17-35-02pogh._sign._gl.ucheb.korp.rar",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=365608"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-22-06_17-35-02pogh.sign._ifk.rar",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=365609"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-23-06_10-12-51kontrakt_1_aktualynaya_versiya.pdf",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=365659"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-23-06_10-12-51kontrakt_2_aktualynaya_versiya.pdf",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=365660"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-27-08_18-08-42rechevoe_opoveschenie.rar",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=374836"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-27-08_18-08-42svn.rar",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=374837"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-27-08_18-08-42skud.rar",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=374838"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-27-08_21-38-42pisymo_atz_ot_20.08.2020.pdf",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=374839"
          },
          {
            "name_file": "data/vo/1/2020/rep768/2020-18-09_10-50-00informaciya_po_planirovaniyu_zakupok_2020_v_ramkah_programmy_modernizacii_infrastruktury_(meropriyatiya_po_antiterroristicheskoy_zaschischennosti).jpg",
            "link": "https://xn--80apneeq.xn--p1ai/index.php?plg=plagin_downloadFile&link_doc=376692"
          }
        ];
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
