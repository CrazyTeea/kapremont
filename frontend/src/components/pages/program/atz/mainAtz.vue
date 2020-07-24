<template>
  <div class="main_wrapper">
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
              <b-td colspan="2">Объем финансового обеспечения на реализацию мероприятий по модернизации инфраструктуры, включая капитальный ремонт объектов и проведение мероприятий по антитеррористической защищенности объектов</b-td>
              <b-td>Данные</b-td>
            </b-tr>
            <b-tr>
              <b-td rowspan="3">2</b-td>
              <b-td rowspan="4">Утвержденная программа модернизации инфраструктуры, включая капитальный ремонт объектов и проведение мероприятий по антитеррористической защищенности объектов</b-td>
              <b-td>Сумма бюджетного финансирования (руб.)</b-td>
              <b-td>Данные</b-td>
            </b-tr>
            <b-tr>
              <b-td>Сумма внебюджетного финансирования (руб.)</b-td>
              <b-td>Данные</b-td>
            </b-tr>
            <b-tr>
              <b-td>Общий объем финансирования (руб.)</b-td>
              <b-td>Данные</b-td>
            </b-tr>
          </b-tbody>
        </b-table-simple>
        <h4 class="mt-2">Статус:</h4>
      </div>
      <div class="col-5 offset-1">
        <v-userPanel v-can:!dku />
        <br />
        <user-info-view :id_org="id_org" />
      </div>
    </div>
    <div class="row">Тут будут комментарии... когда-нибудь</div>
    <div class="row mt-5">
      <b-card no-body class="mb-1">
        <b-card-header header-tag="header" class="p-1" role="tab" v-b-toggle.TABLE2>
          <span class="toggle_button">Таблица 2</span>
        </b-card-header>
        <b-collapse id="TABLE2" accordion="TABLE2" role="tabpanel">
          <b-card-body>
            <atz-table />
          </b-card-body>
        </b-collapse>
      </b-card>
    </div>
    <div class="row mt-5">
      <b-card no-body class="mb-1">
        <b-card-header header-tag="header" class="p-1" role="tab" v-b-toggle.TABLE2>
          <span class="toggle_button">Таблица 3</span>
        </b-card-header>
        <b-collapse id="TABLE2" accordion="TABLE2" role="tabpanel">
          <b-card-body>
            Тут пока хз что)
          </b-card-body>
        </b-collapse>
      </b-card>
    </div>
  </div>
</template>

<script>
import { userPanel, UserInfoView } from "../../../organisms";
import AtzTable from "./index";
import {
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
  VBToggle
} from "bootstrap-vue";
export default {
  directives: {
    BToggle: VBToggle
  },
  components: {
    "v-userPanel": userPanel,
    "atz-table": AtzTable,
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
    BCardBody
  },
  data() {
    return {
      orgInfo: {},
      id_org: null,
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      if (window._Organization) this.orgInfo = window._Organization;

      if (window._Region) this.orgInfo.region = window._Region;

      if(this.$route.params.id) this.id_org = this.$route.params.id

      console.log(this.id_org)
    }
  }
};
</script>

<style>
</style>