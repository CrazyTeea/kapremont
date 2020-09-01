<template>
  <div id="org-shit-table">


    <b-card no-body class="mb-1">
      <b-card-header header-tag="header" class="p-1" role="tab" v-b-toggle.filters>
        <span class="toggle_button"><b-icon icon="filter" scale="1.5" class="mr-2 ml-1"></b-icon>Фильтры</span>
      </b-card-header>
      <b-collapse id="filters" accordion="filters" role="tabpanel">
        <b-card-body>
          <b-input-group prepend="ID" class="mb-2">
            <b-form-input type="number" v-model="filters.id_org"></b-form-input>
            <b-input-group-append>
              <b-button variant="outline-secondary" @click="filters.id_org = null">
                <b-icon icon="backspace" variant="danger" scale="1.2"></b-icon>
              </b-button>
            </b-input-group-append>
          </b-input-group>
          <b-input-group prepend="Субъект" class="mb-2">
            <b-form-input v-model="filters.region"></b-form-input>
            <b-input-group-append>
              <b-button variant="outline-secondary" @click="filters.region = null">
                <b-icon icon="backspace" variant="danger" scale="1.2"></b-icon>
              </b-button>
            </b-input-group-append>
          </b-input-group>
          <b-input-group prepend="Вуз" class="mb-2">
            <b-form-input v-model="filters.org_name"></b-form-input>
            <b-input-group-append>
              <b-button variant="outline-secondary" @click="filters.org_name = null">
                <b-icon icon="backspace" variant="danger" scale="1.2"></b-icon>
              </b-button>
            </b-input-group-append>
          </b-input-group>

          <b-input-group prepend="Выгрузка PDF" class="mb-2">
            <b-form-select v-model="filters.file_exist" :options="
                        [
                            { value: 1, text: 'Выгружено' },
                            { value: 0, text: 'Не выгружено' }
                        ]"></b-form-select>
            <b-input-group-append>
              <b-button variant="outline-secondary" @click="filters.file_exist = null">
                <b-icon icon="backspace" variant="danger" scale="1.2"></b-icon>
              </b-button>
            </b-input-group-append>
          </b-input-group>

        </b-card-body>
      </b-collapse>
    </b-card>

    <div v-if="!items.length" class="text-center">
      Данные загружаются, подождите
      <b-spinner variant="primary"/>
    </div>

    <br>

    <b-table sticky-header
             selectable
             hover
             small
             bordered
             style="font-size: 10px; min-height: 550px"
             select-mode="single"
             :items="items"
             :fields="fields"
             @row-selected="toObjects">
      <template v-slot:cell(pdf_export)="data">
        <div id="icon">
          <a style="display: block" v-if="data.item.pdf_export" :href="`/program/download-doc/${data.item.id_org}`">
            <b-icon icon="file-earmark-arrow-down" scale="4" variant="success"/>
          </a>
        </div>
      </template>

      <template v-slot:cell(pred_zakl)="data">
        <span>{{ data.item.pred_zakl.toFixed(3) }}</span>
      </template>

      <!--<template v-slot:cell(abj_obr)="data">
          <span class="text-secondary">{{ data.item.abj_obr }}</span>
      </template>
      <template v-slot:cell(abj_prog)="data">
          <span class="text-warning">{{ data.item.abj_prog }}</span>
      </template>
      <template v-slot:cell(abj_nappr)="data">
          <span class="text-danger">{{ data.item.abj_nappr }}</span>
      </template>
      <template v-slot:cell(abj_appr)="data">
          <span class="text-success">{{ data.item.abj_appr }}</span>
      </template>-->
    </b-table>
  </div>
</template>

<script>
import {
  BTable, BCard, BCardBody, BCardHeader, BInputGroupAppend, BInputGroup, BFormSelect, BButton,
  BCollapse, VBToggle, BFormInput, BIcon, BTr, BTh, BSpinner
} from "bootstrap-vue";
import Axios from "axios";

export default {
  directives: {
    BToggle: VBToggle,
  },
  components: {
    BTable,
    BIcon,
    BSpinner,
    BTr,
    BTh,
    BFormInput,
    BCard,
    BCardBody,
    BCardHeader,
    BCollapse,
    BInputGroupAppend,
    BInputGroup,
    BFormSelect,
    BButton
  },
  async mounted() {
    await this.getObjects();
  },
  data() {
    return {
      fields: [
        {key: "id_org", label: "ID ВУЗа", sortable: true},
        {key: "region", label: "Субъект", sortable: true},
        {key: "org_name", label: "Наименование ВУЗа", sortable: true},
        {key: "pdf_export", label: "Выгрузка PDF", sortable: true},
        {key: "program_status", label: "Статус программы", sortable: true},
        {key: "obs_limits", label: "Общие лимиты", sortable: true},
        {
          key: "obs_reserv",
          label: "Общий резерв (рассчитывается, когда ДЭП и ДКУ присвоили статус рассмотрено)",
          sortable: true
        },
        {key: "pred_zakl", label: "Предварительное отклонение от лимитов", sortable: true},
        {key: "kap_rem", label: "Объем бюджетного финансирования кап.ремонт по программе", sortable: true},
        {key: "obj_all", label: "Объектов всего", sortable: true},
        {key: "abj_obr", label: "Объектов в обработке", sortable: true, variant: 'secondary'},
        {key: "abj_prog", label: "Объектов на доработке", sortable: true, variant: 'warning'},
        {key: "abj_nappr", label: "Объектов не рекомендовано к согласованию", sortable: true, variant: 'danger'},
        {key: "abj_appr", label: "Объектов рекомендовано к согласованию", sortable: true, variant: 'success'},
        {key: "abj_dep", label: "Объектов рассмотрено ДЭП", sortable: true},
        {
          key: "cost_pr",
          label: "Объем бюджетного финансирования по приоритетным объектам рекомендованным к согласованию",
          sortable: true
        },
        {
          key: "cost_res",
          label: "Объем бюджетного финансирования по резервным объектам рекомендованным к согласованию",
          sortable: true
        },
        {key: "cost_depPr", label: "Объем бюджетного финансирования по объектам рассмотренным ДЭП", sortable: true},
        {
          key: "cost_depRes",
          label: "Объем бюджетного финансирования по объектам рассмотренным ДЭП(резерв)",
          sortable: true
        },
        {key: "dep_status", label: "Статус программы (ДЭП)", sortable: true},
        {key: "atz_nb", label: "Объем бюджетного финансирования АТЗ, не более", sortable: true},
        {key: "atz", label: "Объем бюджетного финансирования АТЗ по программе", sortable: true},
        {key: "atz_bud_fin", label: "Согласованный объем бюджетного финансирования АТЗ", sortable: true},
        {key: "dku_status", label: "Статус программы (ДКУ)", sortable: true}

      ],
      items: [],
      filters: {
        id_org: null,
        region: null,
        org_name: null,
        file_exist: null,
      }
    };
  },
  methods: {
    getObjects() {
      Axios.get("/shit-table/data", {
        params: {
          filter: JSON.stringify(this.filters)
        }
      }).then(response => {
        let pred_zakl = 0;
        let atz_nb = 0;
        let atz = 0;
        let atz_bud_fin = 0;
        this.items = [];
        if (response.data.program) {
          response.data.program.forEach(item => {
            pred_zakl += parseFloat(item.pred_zakl);
            atz_nb += parseFloat(item.atz_nb);
            atz += parseFloat(item.atz);
            atz_bud_fin += parseFloat(item.atz_bud_fin);
          });
          this.items.push({
            obs_limits: 'ИТОГО',
            pred_zakl: pred_zakl,
            atz_nb: atz_nb.toFixed(3),
            atz: atz.toFixed(3),
            atz_bud_fin: atz_bud_fin.toFixed(3)
          })
          this.items.push(...response.data.program);
        } else this.items.push({pred_zakl: 0});
      });
    },
    toObjects(item) {
      window.location = `/organization/list/${item[0].id_org}`;
    }
  },
  watch: {
    filters: {
      handler() {
        this.getObjects();
      },
      deep: true
    }
  }
};
</script>

<style scoped>
#icon {
  margin: 15px auto !important;
  text-align: center;
}
</style>
