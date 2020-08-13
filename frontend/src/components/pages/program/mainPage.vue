<template>
  <div id="program_mi_body">
    <b-modal scrollable id="extraBaner" v-model="extraBaner" cancel-disabled>
      <div class="text-center">Уважаемые коллеги!</div>
      <p>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Департамент экономической политики
        Минобрнауки России рассмотрел представленные подведомственными
        образовательными организациями высшего образования программы
        модернизации инфраструктуры в части осуществления мероприятий по
        капитальному ремонту объектов недвижимого имущества (далее –
        организации) и сообщает, что организации могут начинать осуществление
        закупочных процедур по приоритетным и резервным объектам со статусом
        «Рассмотрено ДЭП».
      </p>
      <p>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;По вопросам работы в
        информационно-аналитической системе «Мониторинг» организации могут
        связаться со службой технической поддержки по телефону: 8-495-989-84-47
        доб. 1 (многоканальный) или по адресу электронной почты: ias@mirea.ru.
      </p>
      <p>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;В части проведения мероприятий по
        антитеррористической защищенности объектов необходимо обращаться в
        Департамент корпоративного управления Минобрнауки России: Бочарова Елена
        Владимировна, консультант отдела оформления имущественных прав и ведения
        реестра федерального имущества, 8-926-623-99-10,
        bocharovaev@minobrnauki.gov.ru
      </p>
      <template v-slot:modal-footer>
        <b-button variant="success" @click="extraBaner = false">ОК!</b-button>
      </template>
    </b-modal>

    <b-modal size="lg" id="extraBaner2" v-model="extraBaner2" cancel-disabled>
      <p>Уважаемые коллеги!</p>
      <p>
        Программа модернизации инфраструктуры рассмотрена Департаментом
        корпоративного управления.
      </p>
      <p>
        С суммой к выделению для финансирования мероприятий по АТЗ Вы можете
        ознакомиться на стартовой странице модуля.
      </p>
      <p>
        Она расположена над кнопками "Заполнить программу модернизации" и
        "Приступить к реализации программы модернизации"
      </p>
      <div>
        &nbsp;&nbsp;&nbsp;После размещения информации на официальном сайте
        <a
          class="bnt btn-link"
          href="www.zakupki.gov.ru"
        >www.zakupki.gov.ru</a>
        о закупке в рамках проведения мероприятий по антитеррористической
        защищённости объектов подведомственному образовательному учреждению
        необходимо,
        <span
          class="font-weight-bold"
        >в день размещения информации о закупке</span>направить уведомление на электронную почту
        <a
          class="bnt btn-link"
          href="zakupki_atz@mirea.ru"
        >zakupki_atz@mirea.ru</a>.
      </div>
      <p>Пример направляемого уведомления о закупки:</p>
      <p>
        <i>Тема письма:</i>
      </p>
      <p>
        Уведомление о размещении закупки:
        <span
          class="text-danger"
        >ФГБОУ ВО «Адыгейский государственный университет»</span>
      </p>
      <p class="font-weight-bold mt-2">
        В случае размещения конкурентным способом (запрос котировок, аукцион в
        электронной форме и т.д)
      </p>
      <p>
        <i>Текст письма:</i>
      </p>
      <p>
        Извещение о проведении:
        <span
          class="text-danger"
        >электронного аукциона от 19.06.2020 №0130200002420001879</span>
      </p>
      <p class="font-weight-bold mt-2">В случае размещения у поставщика</p>
      <p>
        <i>Текст письма:</i>
      </p>
      <p>
        Наименование, ИНН единственного поставщика:
        <span
          class="text-danger"
        >ООО «ПРОЕКАПС», ИНН 3305795967</span>
      </p>
      <p>
        Предмет контракта/договора:
        <span class="text-danger">
          Выполнение работ по проектированию системы автоматической пожарной
          сигнализации
        </span>
      </p>
      <p>
        Цена контракта/договора:
        <span class="text-danger">10 000,00 руб.</span>
      </p>
      <p>
        Номер контракта/договора:
        <span class="text-danger">25/А</span>
      </p>
      <p>
        Дата заключения контракта/договора:
        <span class="text-danger">22.06.2020</span>
      </p>

      <p>
        &nbsp;&nbsp;&nbsp;Напоминаем, что размещение закупок подведомственными образовательными
        учреждениями в рамках проведения мероприятий по антитеррористической
        защищённости объектов
        <span
          class="font-weight-bold"
        >осуществляется строго после получения согласования</span>
        от Департамента корпоративного управления.
      </p>

      <template v-slot:modal-footer>
        <b-button variant="success" @click="extraBaner2 = false">ОК!</b-button>
      </template>
    </b-modal>

    <div class="row">
      <div class="col-6">
        <h4 v-show="getOrg">{{ getOrg && getOrg.name }}</h4>
        <p v-show="getRegion">
          Субъект РФ:
          <span class="text-success">{{ getRegion && getRegion.region }}</span>
        </p>
        <div v-if="getPageData">
          <b-table
            id="program_table"
            :fields="fields"
            :items="items"
            :per-page="perPage"
            :current-page="currentPage"
            small
            bordered
          >
            <template v-slot:cell(value)="data">
              <b-form-input
                @change="setProgramValue('finance_volume', data.item.value)"
                style="min-width: 120px"
                v-model="data.item.value"
                type="number"
                v-can:faiv_user
              ></b-form-input>
              <span v-can:user>{{ data.item.value }}</span>
            </template>
            <template v-slot:cell(value)="data">
              <b-form-input
                @change="setProgramValue('finance_events', data.item.value)"
                style="min-width: 120px"
                v-model="data.item.value"
                type="number"
                v-can:faiv_user
              ></b-form-input>
              <span v-can:user>{{ data.item.value }}</span>
            </template>
            <template v-slot:cell(value)="data">
              <b-form-input
                @change="setProgramValue('cost', data.item.value)"
                style="min-width: 120px"
                v-model="data.item.value"
                type="number"
                v-can:faiv_user
              ></b-form-input>
              <span v-can:user>{{ data.item.value }}</span>
            </template>
          </b-table>
          <h5 style="margin-top: 5px">
            Текущий статус ДКУ:
            <label :class="`text-${dku_status.color}`">
              {{
              dku_status.label
              }}
            </label>
          </h5>
          <h5 style="margin-top: 5px">
            Сумма к выделению для финансирования мероприятий по АТЗ (Рублей)
            <label
              :class="`text-${dku_status.color}`"
            >
              {{
              dku_status.atz
              }}
            </label>
          </h5>
          <h5 style="margin-top: 5px">
            Комментарий
            <label :class="`text-${dku_status.color}`">
              {{
              dku_status.comment
              }}
            </label>
          </h5>
          <div class="row">
            <div class="col-6">
              <h5 style="margin-top: 5px">Приложение</h5>
            </div>
            <div class="col-6">
              <a
                v-if="dku_status.doc"
                style="display: block"
                :href="
                  `/uploads/dku_docs/${getUser.organization.id}/${dku_status.doc.file_name}`
                "
              >
                <b-icon icon="file-earmark-arrow-down" scale="2" vriant="success"></b-icon>
              </a>
            </div>
          </div>
        </div>

        <h3 v-else>
          <span class="text-danger">Данные о вашей организации отсутствуют в системе</span>
        </h3>
        <b-pagination
          v-show="rows > perPage"
          v-model="currentPage"
          :total-rows="rows"
          :per-page="perPage"
          aria-controls="my-table"
        ></b-pagination>
        <div style="float: right" v-show="getUser.isAdmin && getPageData">
          <b-button href="/program/view">Заполнить программу модернизации</b-button>
          <b-button
            class="btn-info mt-2"
            href="/program/org"
          >Приступить к реализации программы модернизации</b-button>
          <!--<b-button @click="goAtz()" class="btn-info mt-2">Мероприятия по АТЗ</b-button> -->
        </div>
      </div>
      <div class="col-2"></div>

      <div class="col-4">
        <v-userPanel />
        <br />
        <user-info-view />
      </div>

      <div class="col-12 mt-4">
        <b-table-simple>
          <b-thead>
            <b-th>
              Скачать выгрузку
            </b-th>
            <b-th>
              Загрузить xlsx
            </b-th>
            <b-th>
              Загрузить pdf
            </b-th>
          </b-thead>
          <b-tbody>
            <b-td>
              <a href="/api/file-main-page/get-file" target="_blank">Скачать</a>
            </b-td>
            <b-td>
              <label class="file_atz_label" for="file_atz_xls">Загрузить</label>
              <input @input="fileInput($event, 'xlsx')" id="file_atz_xls" hidden type="file">
            </b-td>
            <b-td>
              <label class="file_atz_label" for="file_atz_pdf">Загрузить</label>
              <input @input="fileInput($event,'pdf')" id="file_atz_pdf" hidden type="file">
            </b-td>
          </b-tbody>
        </b-table-simple>
      </div>
    </div>
  </div>
</template>

<script>
import { userPanel, UserInfoView } from "../../organisms";
import { mapActions, mapGetters } from "vuex";
import {
  BButton,
  BTable,
  BPagination,
  VBToggle,
  BFormInput,
  BTableSimple,
  BThead,
  BTh,
  BTbody,
  BTd
} from "bootstrap-vue";
import Axios from "axios";
// import b_vue from 'bootstrap-vue';
export default {
  directives: {
    "b-toggle": VBToggle
  },
  components: {
    "v-userPanel": userPanel,
    BFormInput,
    BButton,
    BPagination,
    BTable,
    UserInfoView,
    BTableSimple,
    BThead,
    BTh,
    BTbody,
    BTd
  },
  data() {
    return {
      csrf: document.getElementsByName("csrf-token")[0].content,
      extraBaner: window.Permission === "user",
      extraBaner2: false,
      perPage: 5,
      currentPage: 1,
      id_org: null,
      dku_status: {
        color: "secondary",
        label: "",
        atz: 0,
        comment: "",
        doc: null
      }
    };
  },
  computed: {
    ...mapGetters(["getUser", "getOrg", "getRegion", "getPageData"]),
    rows() {
      if (this.getPageData && this.getPageData.items)
        return this.getPageData.items.length;
      return 0;
    },
    items() {
      if (this.getPageData && this.getPageData.items)
        return this.getPageData.items;
      return [];
    },
    fields() {
      if (this.getPageData && this.getPageData.fields)
        return this.getPageData.fields;
      return [];
    }
  },
  watch: {
    getUser: function() {
      this.requestOrg({ id: this.getUser.organization.id });
      this.id_org = this.getUser.organization.id;

      let dku = this.getUser.organization.dku_status;
      if (dku == "not") {
        this.dku_status.label = "В обработке";

        this.dku_status.color = "secondary";
      } else if (dku == "approved") {
        this.dku_status.label = "Рассмотрено ДКУ";
        this.extraBaner2 = true;
        this.dku_status.color = "success";
      } else if (dku == "rejected") {
        this.dku_status.label = "Резерв";
        this.dku_status.color = "warning";
      }
      this.dku_status.atz = this.getUser.program.dku_atz;
      this.dku_status.comment = this.getUser.organization.dku_comment;
      this.dku_status.doc = this.getUser.dku_doc;
    }
  },
  methods: {
    fileInput(e, type) {
      let file = e.target.files[0];
      let splitFileName = file.name.split('.');
      if(splitFileName[splitFileName.length - 1] != type) return;

      let data = new FormData();
      data.append('file', file);
      data.append('type', type);
      Axios.post('/api/file-main-page/save-file', data, {
        headers: {
          "X-CSRF-Token": this.csrf,
          "Content-Type": "multipart/form-data;"
        },
      }).then(res => {
        console.log('sended');
      });
    },
    goAtz() {
      if(window.currentUser === 2535) {
        window.location = `/program/main-atz/${this.id_org}`;
      }
      else {
        window.location = '/app/atz/in-dev';
      }
    },
    ...mapActions([
      "requestProgram",
      "requestOrg",
      "requestPageData",
      "requestUser"
    ]),
    setProgramValue(atr, value) {
      if (this.id_org) {
        let data = new FormData();
        data.append("value", atr);
        data.append(atr, value);
        Axios.post(`/program/set-value/${this.id_org}`, data, {
          headers: {
            "X-CSRF-Token": this.csrf
          }
        }).then(response => {
          if (!response.data.success)
            response.data.errors.forEach(item => {
              this.setBanner("danger", item);
            });
        });
      }
    }
  },
  async mounted() {
    await this.requestUser();
    await this.requestPageData({ pageName: "main" });

    //this.id_org = this.getUser.organization.id;

    //this.requestProgram();
  }
};
</script>

<style scoped>
.file_atz_label:hover {
  border-bottom: 1px solid #1b1e21;
}
</style>
