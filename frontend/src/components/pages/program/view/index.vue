<template>
  <div id="dev_programme">
    <div v-can:root>
      <!-- <b-modal centered id="modal-1" title="Внимание">
          <p class="my-4">
              Уважаемые пользователи! В связи с техническими работами на сервере возможность загрузки программы модернизации инфраструктуры образовательных организаций высшего образования (далее
              - программа) в формате pdf и отправка на согласование в Минобрнауки России будет доступна с 13 марта 2020 года. Срок направления программы на согласование с Минобрнауки России
              будет продлён до 20 марта 2020 года. Официальное письмо о продлении срока представления программы в Минобрнауки России:
              <a href="/baner.pdf" target="_blank">MN-17_90</a> .
          </p>
      </b-modal> -->
    </div>

    <div class="row">
      <div class="col-12">
        <b-alert v-show="!user_status" show variant="danger">
          Уважаемые пользователи! Просим Вас <a class="btn btn-link" :href="`/organization/user-info/${id_org}`">заполнить
          форму</a>, предоставив контактные данные сотрудников организации.
        </b-alert>
      </div>
      <div class="col-12">
        <!-- <b-modal cancel-title="Отмена" centered :visible="ban">
            Уважаемые пользователи! Сбор данных завершён. Доступ в систему закрыт
        </b-modal>
        <b-modal cancel-title="Отмена" centered :visible="!programStatus && !ban">
            Уважаемые пользователи! В связи с техническими работами на сервере возможность загрузки программы модернизации инфраструктуры образовательных организаций высшего образования в
            формате pdf и её отправки на согласование в Минобрнауки России продлена до 23 марта 2020 года.
        </b-modal> -->
      </div>
      <div class="col-6">
        <b-table
            :fields="[
                        { key: 'id', label: '№' },
                        { key: 'label', label: 'Показатель' },
                        { key: 'value', label: 'Значение' }
                    ]"
            :items="[
                        {
                            id: '1',
                            label: 'Полное наименование организации',
                            value: getUser && getUser.organization && getUser.organization.name
                        },
                        {
                            id: '2',
                            label: 'Сокращенное наименование организации',
                            value: getUser && getUser.organization && getUser.organization.short_name
                        }
                    ]"
            small
            bordered
        />

        <b-button class="btn btn-sm" style="float: right" href="/organization/info">Подробнее</b-button>
      </div>

      <div class="col-4 offset-2">
        <v-user-panel/>

        <h5 style="margin-top: 5px">Текущий статус ДКУ: <label :class="`text-${dku_status.color}`">{{
            dku_status.label
          }}</label></h5>
        <h5 style="margin-top: 5px">Сумма к выделению для финансирования мероприятий по АТЗ (Рублей) <label
            :class="`text-${dku_status.color}`">{{ dku_status.atz }}</label></h5>

      </div>
    </div>
    <br/>
    <div class="row">
      <div class="col-6">
        <b-button v-can:root,faiv_user,user variant="info" href="object/create"
                  v-show="!programStatus && !ban && user_status">Добавить объект кап. ремонта
        </b-button>
        <b-button v-can:root,user variant="info" href="atz" v-show="!programStatus && !ban && user_status">Добавить
          мероприятия по АТЗ
        </b-button>
      </div>
      <div class="col-6"></div>
    </div>
    <br/>
    <div class="row">
      <b-card no-body>
        <b-card-header header-tag="header" class="p-1" role="tab">
          <span> <b-icon-gear-wide-connected/>Объекты требующие капитального ремонта </span>
        </b-card-header>
        <b-card-body>
          <b-card-text>Приоритетные объекты</b-card-text>
          <b-table
              class="text-center"
              :per-page="prevTable.perPage"
              :current-page="prevTable.curPage"
              @row-clicked="onRowClick"
              tbody-tr-class="hover"
              :items="priorityObjects && priorityObjects.items"
              :fields="fieldsObjects && fieldsObjects.fields"
              small
              bordered
              hover
          />
          <b-pagination v-show="rowCount('prevTable')" :per-page="prevTable.perPage" v-model="prevTable.curPage"
                        :total-rows="rowsPrev"/>
          <div v-can:user>
            <b-card-text>Резервные объекты</b-card-text>
            <b-table
                class="text-center"
                :per-page="resTable.perPage"
                :current-page="resTable.curPage"
                @row-clicked="onRowClick"
                tbody-tr-class="hover"
                :items="reservedObjects && reservedObjects.items"
                :fields="fieldsObjects && fieldsObjects.fields"
                small
                bordered
                hover
            />
            <b-pagination v-show="rowCount('resTable')" :per-page="resTable.perPage" v-model="resTable.curPage"
                          :total-rows="resPrev"/>
          </div>

        </b-card-body>
      </b-card>

      <!--<div class="col-12">
          <b-card no-body class="mb-1">
              <b-card-header header-tag="header" class="p-1" role="tab">
             <span class="toggle_button" v-b-toggle.accordion-1>
                 <b-icon-gear-wide-connected />
                 Объекты</span>
              </b-card-header>
              <b-collapse id="accordion-1" visible accordion="my-accordion" role="tabpanel">
                  <b-card-body>
                      <b-table
                              class="text-center"
                              :items="objects && objects.items"
                              :fields="objects && objects.fields"
                              small bordered
                      />
                  </b-card-body>
              </b-collapse>
          </b-card>
          <b-card no-body class="mb-1">
              <b-card-header header-tag="header" class="p-1" role="tab">
             <span class="toggle_button" v-b-toggle.accordion-2>
                 <b-icon-gear-wide-connected />
                 Цели и задачи реализации программы</span>
              </b-card-header>
              <b-collapse id="accordion-2" accordion="my-accordion" role="tabpanel">
                  <b-card-body>
                      <b-table
                              class="text-center"
                              :items="target && target.items"
                              :fields="target && target.fields"
                              small bordered
                      />
                  </b-card-body>
              </b-collapse>
          </b-card>
          <b-card no-body class="mb-1">
              <b-card-header header-tag="header" class="p-1" role="tab">
             <span  class="toggle_button" v-b-toggle.accordion-3 >
                 <b-icon-gear-wide-connected />
                 Потребность в бюджетных ассигнованиях на проведение кап. ремонта приоритетных объектов</span>
              </b-card-header>
              <b-collapse id="accordion-3" accordion="my-accordion" role="tabpanel">
                  <b-card-body>
                      <b-card-text>Приоритетные объекты</b-card-text>
                      &lt;!&ndash;

                       <b-table
                              class="text-center"
                              :items="priorityObjects && priorityObjects.items"
                              :fields="fieldsObjects && fieldsObjects.fields"
                              small bordered
                      />
                      <b-card-text>Резервные объекты</b-card-text>
                      <b-table
                              class="text-center"
                              :items="reservedObjects && reservedObjects.items"
                              :fields="fieldsObjects && fieldsObjects.fields"
                              small bordered
                      />
                       &ndash;&gt;
                  </b-card-body>
              </b-collapse>
          </b-card>
</div>-->
    </div>
    <div class="mt-3">
      <div class="row">
        <div class="col-12">
          <b-alert v-for="(banner, index) in bannerInfo" :key="index" :show="banner.show" :variant="banner.variant"
                   dismissible fade>{{ banner.message }}
          </b-alert>
        </div>
      </div>
    </div>
    <div class="row justify-content-end">
      <div>
        <a href="/program/export" @click="setSpinner()" class="btn btn-secondary btn-sm"
           v-show="!programStatus && !ban">Выгрузить программу</a>
        <label v-show="!programStatus && !ban && user_status" for="file_input_pdf_main" v-if="buttons.upload"
               class="btn btn-info btn-sm mt-2">Загрузить PDF</label>
        <input v-show="!programStatus && !ban && user_status" type="file" id="file_input_pdf_main"
               class="hidden-file-input" @input="fileInput()"/>
        <!-- <b-button class="btn btn-sm btn-info" for="file_input_pdf_main">Загрузить PDF</b-button> -->
        <b-button v-show="!programStatus" v-if="buttons.delete && user_status" class="btn btn-sm btn-danger"
                  @click="deleteFileFromYii()">Удалить PDF
        </b-button>

        <a :href="'/program/download-doc/' + id_org" v-if="buttons.save" class="btn btn-success btn-sm">Скачать PDF</a>
        <b-button class="btn btn-sm" @click="approveModal" v-show="!programStatus && !ban && user_status">Отправить на
          согласование
        </b-button>
      </div>
    </div>
  </div>
</template>

<script>
import {userPanel} from "../../../organisms";
import {mapActions, mapGetters} from "vuex";
import Axios from "axios";
import {BAlert, BButton, BCard, BCardBody, BCardHeader, BCardText, BPagination, BTable, VBToggle,} from "bootstrap-vue";

export default {
  directives: {
    'b-toggle': VBToggle
  },
  components: {
    BAlert,
    BCard,
    BCardHeader,
    BCardBody,
    BButton,
    BPagination,
    BTable,
    BCardText,
    "v-user-panel": userPanel,
  },
  data() {
    return {
      canAxios: false,
      ban: false,
      user_status: false,
      programStatus: null,
      bannerInfo: [],
      loadProgress: null,
      buttons: {
        upload: false,
        save: false,
        delete: false
      },
      id_org: null,
      csrf: document.getElementsByName("csrf-token")[0].content,
      text: "dfs",
      prevTable: {
        curPage: 1,
        perPage: 5
      },
      resTable: {
        curPage: 1,
        perPage: 5
      },
      dku_status: {
        color: 'secondary',
        label: '',
        atz: 0
      }
    };
  },
  methods: {
    ...mapActions(["requestPageData", "requestUser"]),
    getApprove() {
      Axios.get("/program/is-approve").then(response => {
        this.programStatus = response.data.p_status !== 0;
        this.ban = response.data.ban !== 0;
        this.user_status = response.data.user_status !== 0;
      });
    },
    approveModal() {
      this.canAxios = false;
      this.$bvModal
          .msgBoxConfirm("Редактирование программы модернизации ифраструктуры будет временно заблокировано", {
            title: "Подтверждение действий.",
            okTitle: "Да",
            okVariant: "danger",
            cancelTitle: "Нет",
            centered: true
          })
          .then(value => {
            this.canAxios = value;
            this.setApprove();
          });
    },
    setApprove() {
      if (this.canAxios) {
        Axios.post("/program/approve", null, {
          headers: {
            "X-CSRF-Token": this.csrf
          }
        }).then(response => {
          this.programStatus = response.data.programStatus;
          if (!response.data.status) {
            this.errorReport(response.data.msg);
          }
        });
      }
    },
    onRowClick(item) {
      if (item.id) {
        window.location.href = `/program/object/view/${item.id}`;
      }
    },
    rowCount(attr) {
      if (attr === "resTable" && this.reservedObjects?.items) {
        return this.reservedObjects.items.length > this.resTable.perPage;
      } else if (attr === "prevTable" && this.priorityObjects?.items) return this.priorityObjects.items.length > this.prevTable.perPage;
      else return false;
    },
    fileInput() {
      let selector = document.querySelector("#file_input_pdf_main");
      let file = selector.files[0];
      if (!this.checkExt(file.type)) {
        selector.value = null;
        return;
      }

      // let message = `Файл ${file.name} загружается ${this.loadProgress}%`;
      this.setBanner("primary", `Файл ${file.name} загружается ${this.loadProgress}%`);
      this.uploadFileToYii(file);
      selector.value = null;
    },
    async uploadFileToYii(file) {
      let form = new FormData();
      form.append("progFile", file);
      await Axios.post(`/program/add-doc/${this.id_org}`, form, {
        headers: {
          "X-CSRF-Token": this.csrf,
          "Content-Type": "multipart/form-data;"
        },
        onUploadProgress: itemUpload => {
          this.loadProgress = Math.round((itemUpload.loaded / itemUpload.total) * 100);
        }
      }).then(res => {
        if (res.data) {
          this.setBanner("success", "Файл загружен успешно");

          this.buttons.save = true;
          this.buttons.delete = true;
          this.buttons.upload = false;
        } else {
          this.setBanner("danger", "При загрузке файла произошла ошибка, напишите в службу поддержки");
        }
      });
    },
    checkExt(ext) {
      if (ext === "application/pdf") {
        return true;
      }
      this.setBanner("danger", "Файл не является документом pdf!");
      return false;
    },
    setBanner(variant, message) {
      this.bannerInfo.unshift({
        show: true,
        variant: variant,
        message: message
      });
      setTimeout(() => {
        this.resetBanners();
      }, 1400);
    },
    resetBanners() {
      this.bannerInfo.pop();
    },
    deleteFileFromYii() {
      Axios.post(`/program/delete-doc/${this.id_org}`, null, {
        headers: {
          "X-CSRF-Token": this.csrf
        }
      }).then(res => {
        if (res.data) {
          this.setBanner("success", "Файл удален успешно");

          this.buttons.save = false;
          this.buttons.delete = false;
          this.buttons.upload = true;
        } else {
          this.setBanner("danger", "При удалении файла произошла ошибка, напишите в службу поддержки");
        }
      });
    },
    getFileStatus() {
      Axios.post(`/program/check-doc/${this.id_org}`, null, {
        headers: {
          "X-CSRF-Token": this.csrf
        }
      }).then(res => {
        if (!res.data) {
          this.buttons.upload = true;
        } else {
          this.buttons.save = true;
          this.buttons.delete = true;
        }
      });
    },
    errorReport(message) {
      this.$bvModal.msgBoxOk(message, {
        title: "Ошибка!",
        size: "sm",
        buttonSize: "sm",
        okVariant: "outline-success",
        headerClass: "p-2 border-bottom-0",
        footerClass: "p-2 border-top-0",
        centered: true
      });
    }
  },
  async mounted() {
    this.requestPageData({pageName: "programView"});
    await this.getApprove();
    await this.requestUser();

    let dku = this.getUser.organization.dku_status;
    if (dku == 'not') {
      this.dku_status.label = 'В обработке';
      this.dku_status.color = 'secondary'
    } else if (dku == 'approved') {
      this.dku_status.label = 'Рассмотрено ДКУ';
      this.dku_status.color = 'success'
    } else if (dku == 'rejected') {
      this.dku_status.label = 'Резерв';
      this.dku_status.color = 'warning'
    }
    this.dku_status.atz = this.getUser.program.dku_atz;

    this.id_org = this.getUser.organization.id;
    this.getFileStatus();
    //  this.$bvModal.show('modal-1')
  },
  computed: {
    ...mapGetters(["getUser", "getPageData"]),
    objects() {
      return this.getPageData && this.getPageData.objects;
    },
    fieldsObjects() {
      return this.getPageData && this.getPageData.fieldsObjects;
    },
    priorityObjects() {
      return this.getPageData && this.getPageData.priorityObjects;
    },
    reservedObjects() {
      return this.getPageData && this.getPageData.reservedObjects;
    },
    target() {
      return this.getPageData && this.getPageData.target;
    },
    rowsPrev() {
      return this.getPageData.priorityObjects && this.getPageData.priorityObjects.items.length;
    },
    resPrev() {
      return this.getPageData.reservedObjects && this.getPageData.reservedObjects.items.length;
    }
  }
};
</script>
<style>
.hover {
  cursor: pointer;
}
</style>
<style scoped>
.toggle_button {
  display: block;
  cursor: pointer;
}

.card-body {
  overflow-y: auto;
}
</style>
