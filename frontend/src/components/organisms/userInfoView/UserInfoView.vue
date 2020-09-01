<template>
  <div id="user-info-view">
    <b-card header="Контактная информация">
      <b-table id="user-ifo-table" stacked :fields="fields" :current-page="curPage" :items="items" :per-page="perPage"/>
      <b-pagination v-model="curPage" :total-rows="count" :per-page="perPage" aria-controls="user-ifo-table"/>
    </b-card>
  </div>
</template>

<script>
import Axios from 'axios'
import {BCard, BPagination, BTable} from 'bootstrap-vue'
import {mapActions, mapGetters} from 'vuex'

export default {
  components: {
    BTable,
    BCard,
    BPagination
  },
  props: ['id_org'],
  data() {
    return {
      curPage: 1,
      perPage: 1,
      fields: [
        {key: 'name', label: 'ФИО'},
        {key: 'role', label: 'Роль'},
        {key: 'position', label: 'Должность'},
        {key: 'phone', label: 'Телефон'},
        {key: 'email', label: 'email'},
      ],
      items: []
    }
  },
  computed: {
    ...mapGetters(['getUser']),
    count: function () {
      return this.items.length;
    }
  },
  watch: {
    getUser: function () {
      let org_id = this.id_org || this.getUser.organization.id;
      Axios.get(`/api/getUsersInfo/${org_id}`).then(res => {
        this.items = res.data
      })
    }
  },
  methods: {
    ...mapActions(['requestUser']),
  },
  async mounted() {
    await this.requestUser();
  }
}
</script>

<style scoped>

</style>