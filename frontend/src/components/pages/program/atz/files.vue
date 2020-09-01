<template>
  <div class="main-wrapper-upload-files">
    <div class="table-wrapper">
      <div class="file-wrapper" v-for="(file, index) in files" :key="`file_input_atz_${index}`">
        <file-input v-model="file.value" :index="index"/>
      </div>

      <b-button variant="info" @click="addDockRow">Добавить</b-button>
      <b-button variant="danger" @click="deleteLastRow">Удалить последний</b-button>

      <b-button variant="success" @click="saveFile">Сохранить</b-button>


      <!--      <b-button @click="debug">debug</b-button>-->
    </div>
    <div class="arhivated-docs">

    </div>
  </div>
</template>

<script>
import Axios from 'axios';
import {BButton} from "bootstrap-vue";
import FileInputComponent from "./FileInputComponent";

export default {
  props: ['id_card'],
  components: {
    "file-input": FileInputComponent,
    BButton
  },
  data() {
    return {
      csrf: document.getElementsByName("csrf-token")[0].content,
      files: [],
      oldFiles: []
    }
  },
  async mounted() {
    // await this.getCurrentFiles();
  },
  methods: {
    deleteLastRow() {
      this.files.pop();
    },
    addDockRow() {
      this.files.push({value: {}})
    },
    save() {

    },
    debug() {
      console.log(this.files)
    },
    async getCurrentFiles() {
      let data = new FormData();
      data.append('id_atz', this.$route.params.id);
      data.append('id_card', this.id_card);
      return Axios.post('', data);
    },
    async saveFile() {
      const filesSended = this.files.map(async element => {
        let data = new FormData();
        data.append('file', element.value.file);
        data.append('id_atz', this.$route.params.id);
        data.append('id_card', this.id_card);
        data.append('description', element.value.description);

        return await Axios.post('/api/files-upload/save-file', data, {
          headers: {
            "X-CSRF-Token": this.csrf,
            "Content-Type": "multipart/form-data;"
          },
        });
      });
      await Promise.all(filesSended)
    }
  }
}
</script>

<style scoped>

</style>