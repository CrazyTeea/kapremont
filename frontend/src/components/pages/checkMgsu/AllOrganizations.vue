<template>
  <div>
    <b-card no-body class="mb-1">
      <b-card-header header-tag="header" class="p-1" role="tab" v-b-toggle.accordion-3>
                <span class="toggle_button">
                    <b-icon icon="filter" scale="1.5" class="mr-2 ml-1"></b-icon>
                    Фильтры</span
                >
      </b-card-header>
      <b-collapse id="accordion-3" accordion="my-accordion" role="tabpanel">
        <b-card-body>
          <div>
            <b-input-group prepend="ID" class="mb-2">
              <b-form-input type="number" aria-label="First name" v-model="filters.id"></b-form-input>
              <b-input-group-append>
                <b-button variant="outline-secondary" @click="filters.id = null">
                  <b-icon icon="backspace" variant="danger" scale="1.2"></b-icon>
                </b-button>
              </b-input-group-append>
            </b-input-group>
            <b-input-group prepend="Субъект" class="mb-2">
              <b-form-input aria-label="First name" v-model="filters.region"></b-form-input>
              <b-input-group-append>
                <b-button variant="outline-secondary" @click="filters.region = null">
                  <b-icon icon="backspace" variant="danger" scale="1.2"></b-icon>
                </b-button>
              </b-input-group-append>
            </b-input-group>
            <b-input-group prepend="Организация" class="mb-2">
              <b-form-input aria-label="First name" v-model="filters.name"></b-form-input>
              <b-input-group-append>
                <b-button variant="outline-secondary" @click="filters.name = null">
                  <b-icon icon="backspace" variant="danger" scale="1.2"></b-icon>
                </b-button>
              </b-input-group-append>
            </b-input-group>
            <b-input-group prepend="Колличество объектов" class="mb-2">
              <b-form-select v-model="filters.quantity" :options="options.quantity"></b-form-select>
              <b-input-group-append>
                <b-button variant="outline-secondary" @click="filters.quantity = null">
                  <b-icon icon="backspace" variant="danger" scale="1.2"></b-icon>
                </b-button>
              </b-input-group-append>
            </b-input-group>
            <b-input-group prepend="Выгрузка PDF" class="mb-2">
              <b-form-select v-model="filters.file_exist" :options="options.file_exist"></b-form-select>
              <b-input-group-append>
                <b-button variant="outline-secondary" @click="filters.file_exist = null">
                  <b-icon icon="backspace" variant="danger" scale="1.2"></b-icon>
                </b-button>
              </b-input-group-append>
            </b-input-group>
            <b-input-group prepend="Выгрузка отправлена" class="mb-2">
              <b-form-select v-model="filters.p_status" :options="options.p_status"></b-form-select>
              <b-input-group-append>
                <b-button variant="outline-secondary" @click="filters.p_status = null">
                  <b-icon icon="backspace" variant="danger" scale="1.2"></b-icon>
                </b-button>
              </b-input-group-append>
            </b-input-group>

            <b-button @click="getPlanExport" variant="outline-success">Выгрузить план график</b-button>

          </div>
        </b-card-body>
      </b-collapse>
    </b-card>

    <div class="row mt-3">
      <div class="col-12">
        <b-alert v-for="(banner, index) in bannerInfo" :key="index" :show="banner.show"
                 :variant="banner.variant"
                 dismissible fade>{{ banner.message }}
        </b-alert>
      </div>
    </div>
    <div class="pre-table-wrapper" :style="preTableWrapperHeight">
      <div class="table-wrapper">
        <div :class=" 'table-overflow-hidden mt-1 transform' +  (isUserDku() ? ' transform ' : '')">
          <b-pagination v-model="currentPage" :total-rows="totalRows" :per-page="perPage"></b-pagination>

          <b-table-simple
              class="table-calculated"
              bordered hover>
            <b-thead>
              <b-tr>
                <b-th v-if="filters.id">№</b-th>
                <b-th>ID</b-th>
                <b-th>Субъект</b-th>
                <b-th>Образовательная организация высшего образования</b-th>
                <b-th>Объектов добавлено</b-th>
                <b-th>Выгрузка PDF</b-th>
                <b-th>Выгрузка отправлена</b-th>
                <b-th v-can:dku,dku_user style="min-width: 150px !important;">Статус программы (ДКУ)</b-th>
                <b-th v-can:dep,dku,dku_user style="min-width: 125px !important;">Статус программы (ДЭП)</b-th>
                <b-th v-can:dku,dku_user style="min-width: 150px !important;">Сумма к выделению для
                  финансирования
                  мероприятий по АТЗ (Рублей)
                </b-th>
                <b-th v-can:dku,dku_user>Дополнительная информация</b-th>
                <b-th>Инн</b-th>
                <b-th v-can:dku,dku_user>Документ</b-th>
              </b-tr>
            </b-thead>
            <b-tbody>
              <b-tr v-for="(item, index) in items" :key="index">
                <b-th v-if="filters.id">{{ index + perPage * (currentPage - 1) + 1 }}</b-th>
                <b-th class="normal-font-weight-for-sell center-text-in-cell">
                  <label>{{ item.id }}</label>
                </b-th>
                <b-th class="normal-font-weight-for-sell center-text-in-cell">
                  <label>{{ item.region }}</label>
                </b-th>
                <b-th
                    class="normal-font-weight-for-sell cursor-pointer center-text-in-cell popover-action">

                  <!--                  popover-->
                  <div class="custom-popover-wrapper">
                    <div class="popover-styling d-flex justify-content-center">
                      <h6 class="atz" @click="goToRef(item.id, '/program/main-atz/')">АТЗ</h6>
                      <h6 class="dep" @click="goToRef(item.id, '/organization/list/')">ДЭП</h6>
                    </div>
                  </div>

                  <!--                  content-->
                  <label class="cursor-pointer label-item-name">
                    {{ item.name }}
                    <div v-can:mgsu,root v-if="item.id_founder !== '1' && item.is_new==='1'">
                      <b-badge variant="danger">новый пользователь</b-badge>
                    </div>
                  </label>

                </b-th>
                <b-th class="normal-font-weight-for-sell center-text-in-cell">
                  <label>{{ item.quantity }}</label>
                </b-th>
                <b-th class="normal-font-weight-for-sell center-text-in-cell">
                  <a v-if="item.file_exist === '1'" :href="`/program/download-doc/${item.id}`" class="a-decorating">
                    <b-icon icon="file-earmark-arrow-down" scale="2" vriant="success"></b-icon>
                  </a>
                  <b-icon v-else icon="alert-circle" scale="2"></b-icon>
                </b-th>
                <b-th class="normal-font-weight-for-sell center-text-in-cell">
                  <b-icon v-if="item.p_status === '1'" icon="check" variant="success" scale="2"></b-icon>
                  <b-icon v-else icon="x-octagon" variant="danger" scale="2"></b-icon>
                </b-th>
                <b-th v-can:dku,dku_user class="normal-font-weight-for-sell center-text-in-cell">
                  <b-form-select
                      v-can:dku
                      size="sm"
                      @change="setDkuStatus(item)"

                      v-model="item.dku_status"
                      :options="[
                                    {value: 'not', text: 'В обработке'},
                                    {value: 'approved', text: 'Рассмотрено ДКУ'},
                                    {value: 'rejected', text: 'Резерв'}
                                ]"
                  ></b-form-select>
                  <span v-can:dku_user>{{ getDkuStatus(item.dku_status) }}</span>
                </b-th>
                <b-th v-can:dep,dku,dku_user class="normal-font-weight-for-sell center-text-in-cell">
                  <b-form-select
                      v-can:dep
                      size="sm"
                      @change="setDepStatus(item)"
                      v-model="item.dep_status"
                      :options="[
                                    {value: 'not', text: 'В обработке'},
                                    {value: 'approved', text: 'Согласовано ДЭП'},
                                    {value: 'rejected', text: 'Резерв'}
                                ]"/>
                  <span v-can:dku,dku_user>{{ getDepStatus(item.dep_status) }}</span>
                </b-th>
                <b-th v-can:dku,dku_user style="max-width: 100px"
                      class="normal-font-weight-for-sell center-text-in-cell">
                  <b-form-input v-can:dku
                                size="sm"
                                @change="setDkuAtz(item)"
                                v-model="item.dku_atz"
                  ></b-form-input>
                  <span v-can:dku_user>{{ item.dku_atz }}</span>
                </b-th>
                <b-th v-can:dku,dku_user class="normal-font-weight-for-sell center-text-in-cell">
                  <b-form-textarea
                      size="sm"
                      @change="setDkuComment(item)"
                      v-model="item.dku_comment"
                  ></b-form-textarea>
                </b-th>
                <b-th>
                  {{ item.inn }}
                </b-th>
                <b-th v-can:dku,dku_user class="normal-font-weight-for-sell center-text-in-cell">
                  <div class="fileInput">
                    <div class="cell-center-for-items">
                      <input
                          type="file"
                          :id="'file_input_' + index"
                          class="hidden-file-input"
                          @change="setDkuDoc(item,index)"
                      />
                      <div
                          class="arrow">
                        <label :for="`file_input_${index}`" class="label">
                      <span class="title">
                        <span class="scope-to-animate"></span>
                        <span class="scope-to-animate"></span>
                        <span class="scope-to-animate"></span>
                        <span class="scope-to-animate"></span>
                      </span>
                        </label>
                      </div>
                    </div>

                  </div>
                  <div v-if="item.dku_doc">
                    <a :href="`/uploads/dku_docs/${item.id}/${item.dku_doc}`">{{ item.dku_doc }}</a>
                  </div>
                </b-th>
              </b-tr>
            </b-tbody>
          </b-table-simple>

          <!--<b-button @click="debug">debug</b-button>-->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Axios from "axios";
import {
  BAlert,
  BBadge,
  BButton,
  BCard,
  BCardBody,
  BCardHeader,
  BCollapse,
  BFormFile,
  BFormInput,
  BFormSelect,
  BFormTextarea,
  BInputGroup,
  BInputGroupAppend,
  BPagination,
  BTableSimple,
  BTbody,
  BTh,
  BThead,
  BTooltip,
  BTr,
  VBToggle,
  VBTooltip
} from "bootstrap-vue";

export default {
  props: ['state'],
  directives: {
    "b-toggle": VBToggle,
    "b-tooltip": VBTooltip
  },
  components: {
    BTooltip,
    BFormTextarea,
    BAlert,
    BBadge,
    BCollapse,
    BCard,
    BCardHeader,
    BCardBody,
    BInputGroup,
    BFormInput,
    BInputGroupAppend,
    BButton,
    BFormSelect,
    BTableSimple,
    BThead,
    BTr,
    BTh,
    BFormFile,
    BTbody,
    BPagination,
  },
  data() {
    return {
      preTableWrapperHeight: "height: 0px",
      bannerInfo: [],
      selected: null,
      offset: 0,
      filters: {
        state: null,
        id: null,
        region: null,
        name: null,
        quantity: null,
        file_exist: null,
        p_status: null,
      },
      options: {
        dku_status: [
          {value: 'not', text: 'В обработке'},
          {value: 'approved', text: 'Рассмотрено ДКУ'},
          {value: 'rejected', text: 'Резерв'}
        ],
        dep_status: [
          {value: 'not', text: 'В обработке'},
          {value: 'approved', text: 'Согласовано ДЭП'},
          {value: 'rejected', text: 'Резерв'}
        ],
        quantity: [
          {value: "up", text: "По возрастанию"},
          {value: "down", text: "По убыванию"}
        ],
        file_exist: [
          {value: "1", text: "Выгружено"},
          {value: "0", text: "Не выгружено"}
        ],
        p_status: [
          {value: "1", text: "Отправлена"},
          {value: "0", text: "Не отправлена"}
        ],
        status: [
          {value: "1", text: "В обработке"},
          {value: "2", text: "Рекомендуется к согласованию"},
          {value: "3", text: "Не рекомендуется к согласованию"},
          {value: "4", text: "Возвращено на доработку"}
        ]
      },
      csrf: document.getElementsByName("csrf-token")[0].content,
      items: [],
      currentPage: 1,
      perPage: 10,
      totalRows: 1
    };
  },
  async mounted() {
    await this.init();
    this.filters.state = this.state;
    this.getTable();

    window.addEventListener('resize', () => {
      this.$forceUpdate()
    });
    // document.querySelector()
  },
  methods: {
    mousePopoverOver() {
      //console.log("here is this shit");
      // let element = document.querySelector()
    },
    goToDev() {
      window.location = '/app/atz/in-dev';
    },
    debug() {
      //console.log(this.isUserDku());
    },
    async init() {
      // if(window)
    },
    getToolTip(id) {
      return `
                    <div class="d-flex">
                        <a href="/organization/list/${id}">АТЗ</a>
                        <a class="ml-2" href="/organization/list/${id}">ДКУ</a>
                    </div>
                `;
    },
    getDkuStatus(s) {
      return this.options.dku_status.find(item => item.value == s).text;
    },
    getDepStatus(s) {
      return this.options.dep_status.find(item => item.value == s).text;
    },
    setBanner(variant, message, timeout = 2500) {
      this.bannerInfo.unshift({
        show: true,
        variant: variant,
        message: message
      });
      setTimeout(() => {
        this.bannerInfo.pop();
      }, timeout);
    },
    async goToRef(id, url) {
      await Axios.post(`/organization/set-old/${id}`, null, {
        headers: {
          "X-CSRF-Token": this.csrf
        }
      }).finally(() => {
      //  alert(`${url}${id}`)
        window.location = `${url}${id}`;
      })

    },
    async goToRefNotDku(id, url) {
      if (this.isUserDku()) return;
      await Axios.post(`/organization/set-old/${id}`, null, {
        headers: {
          "X-CSRF-Token": this.csrf
        }
      }).finally(() => {
        window.location = `${url}${id}`;
      })

    },
    getPlanExport() {
      let data = new URLSearchParams(this.filters).toString();
      window.open(`/app/program/export-plan?${data}`);
      // win.close();

    },
    setDkuDoc(item, index) {
      let graph = document.querySelector(`#file_input_${index}`);
      graph = graph.files[0];
      let form = new FormData();
      form.append('dku_doc', graph)
      Axios.post(`/org/dku-doc/${item.id}`, form, {
        headers: {
          "X-CSRF-Token": this.csrf
        }
      }).then(res => {
        if (res.data.success) {
          this.getTable()
          this.setBanner('success', `Данные внесены успешно: ${item.name}`, 3200)
        }

      }).catch(() => {
        this.setBanner("danger", "Что-то пошло не так! Обратитесь в служюу поддержки.")
      })
    },
    isUserDku() {
      return window.Permission === "dku";
    },
    getTable() {
      let form = new FormData();
      form.append("form", JSON.stringify(this.filters));
      Axios.post(`/api/mgsu/main-table/${this.offset}`, form, {
        headers: {
          "X-CSRF-Token": this.csrf
        }
      }).then(res => {
        this.items = res.data.rows;
        this.items.forEach(item => {
          item.dku_atz = item.dku_atz ? Number(item.dku_atz).toLocaleString() : null;
        })
        this.totalRows = res.data.count.quantity;
      });
    },
    setDkuAtz: async function (item) {
      let ask = confirm('Вы уверены?');
      if (!ask) {
        await this.getTable();
        return false;
      }

      let form = new FormData();
      // item.dku_atz = Number(item.dku_atz).toLocaleString();
      form.append('dku_atz', item.dku_atz.replace(/\s/g, '').replace(',', '.'))
      await Axios.post(`/api/set-status/dku/${item.id}`, form, {
        headers: {
          "X-CSRF-Token": this.csrf
        }
      }).then(res => {
        this.getTable()
        this.setBanner('success', `Данные внесены успешно: ${item.name}`, 3200)
      }).catch(() => {
        this.setBanner("danger", "Что-то пошло не так! Обратитесь в служюу поддержки.")
      })

    },
    setDkuComment(item) {
      let form = new FormData();
      form.append('dku_comment', item.dku_comment)
      Axios.post(`/api/set-comment/dku/${item.id}`, form, {
        headers: {
          "X-CSRF-Token": this.csrf
        }
      }).then(res => {
        this.getTable()
        this.setBanner('success', `Данные внесены успешно: ${item.name}`, 3200)
      }).catch(() => {
        this.setBanner("danger", "Что-то пошло не так! Обратитесь в служюу поддержки.")
      })

    },
    setDkuStatus(item) {
      let form = new FormData();
      form.append('dku_status', item.dku_status)
      Axios.post(`/api/set-status/dku/${item.id}`, form, {
        headers: {
          "X-CSRF-Token": this.csrf
        }
      }).then(res => {
        this.getTable()
        this.setBanner('success', `Статус успешно изменен: ${item.name}`, 3200)
      }).catch(() => {
        this.setBanner("danger", "Что-то пошло не так! Обратитесь в служюу поддержки.")
      })
    },
    setDepStatus(item) {
      let form = new FormData();
      form.append('dep_status', item.dep_status)
      Axios.post(`/api/set-status/dep/${item.id}`, form, {
        headers: {
          "X-CSRF-Token": this.csrf
        }
      }).then(res => {
        this.getTable()
        this.setBanner('success', `Статус успешно изменен: ${item.name}`, 3200)
      }).catch(() => {
        this.setBanner("danger", "Что-то пошло не так! Обратитесь в служюу поддержки.")
      })
    }
  },
  updated() {
    let elementHeight = parseInt(document.querySelector(".transform")?.offsetHeight) + 15;
    this.preTableWrapperHeight = elementHeight ? `height: ${elementHeight}px;` : "height: 1500px";
  },
  watch: {
    currentPage() {
      this.offset = (parseInt(this.currentPage) - 1) * 10;
      this.getTable();
    },
    filters: {
      handler() {
        this.getTable();
      },
      deep: true
    }
  }
};
</script>

<style>
.atz:hover {
  color: red;
  transition: .2s ease;
}

.dep:hover {
  color: green;
}

.dep, .atz {
  transition: .2s ease;
}

.dep {
  margin-left: 8px;
  transition: .2s ease;
}

.popover-styling > h6 {
  font-weight: normal;
}

.popover-styling > h6:hover {
  transform: scale(1.3);
}

.popover-styling > h6 > a {
  text-decoration: none;
}

.popover-action {
  position: relative;
}

.custom-popover-wrapper {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -10%);
  z-index: 200;
  opacity: 0;
  transition: all .3s ease;
}

.pop {
  padding: 8px;
  background-color: #fff;
  border: 1px solid rgba(0, 0, 0, .2);
  border-radius: .3rem;
  opacity: 10;
}

.label-item-name {
  transition: all .3s ease;
}

.popover-action:hover .custom-popover-wrapper {
  transform: translate(-50%, -50%);
  opacity: 1;
  transition-delay: .2s;
  transition-property: all;
}

.popover-action:hover .label-item-name {
  opacity: 10%;
  transition: all .3s ease;
  transform: translateY(10px);
}

.pop > h6 {
  margin-bottom: 0px !important;
}

.table-overflow-hidden {
  overflow: hidden !important;
  overflow-x: scroll !important;
}

.pre-table-wrapper {
  height: 1500px;
}

.table-wrapper {
  position: absolute;
  left: 0;
  padding: 20px;
  width: 100%;
  height: 80%;
}

.transform {
  position: relative;
  width: 1148px;
  /*width: 100%;*/
  transition: all .5s ease;
  margin: 0px auto;
}

.table-calculated {
  width: calc(100vw - 55px);
}

.transform:hover, .popover-styling:hover .transform {
  width: calc(100vw - 55px);
  transition: all .5s ease;
}

.normal-font-weight-for-sell {
  font-weight: normal !important;
}

.center-text-in-cell {
  vertical-align: middle !important;
  text-align: center !important;
}

.cursor-pointer {
  cursor: pointer !important;
}

.a-decorating {
  text-decoration: none !important;
  color: darkgreen !important;
}
</style>
