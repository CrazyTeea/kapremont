<template>
  <div class="main-wrapper-upload-files">
    <div class="table-wrapper">

    </div>
    <div class="arhivated-docs">

    </div>
  </div>
</template>

<script>
import Axios from 'axios';
export default {
  props: ['id_card'],
  data() {
    return {
      csrf: document.getElementsByName("csrf-token")[0].content,
      files: [],
      oldFiles: []
    }
  },
  async mounted() {
    // await this.getCurrentFiles();
    this.saveFile();
  },
  methods: {
    async getCurrentFiles() {
      let data = new FormData();
      data.append('id_atz', this.$route.params.id);
      data.append('id_card', this.id_card);
      return Axios.post('', data);
    },
    async saveFile() {
      const filesSended = this.files.map(async element => {
        let data = new FormData();
        data.append('bla', 'fiks');
        return await Axios.post();
      });
      await Promise.all(filesSended)
    }
  }
}
</script>

<style scoped>

</style>