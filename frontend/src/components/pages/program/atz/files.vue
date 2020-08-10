<template>
  <div class="main-wrapper-upload-files">
    <div class="table-wrapper">
      <div class="file-wrapper" v-for="(file, index) in files" :key="`file_input_atz_${index}`">
        <file-input v-model="filesSelected" :index="index" @deleteRow="deleteRow(index)"/>
      </div>

      <b-button @click="addDockRow">Добавить</b-button>
      <b-button @click="save">Сохранить</b-button>


      <b-button @click="debug">debug</b-button>
    </div>
    <div class="arhivated-docs">

    </div>
  </div>
</template>

<script>
import Axios from 'axios';
import { BButton } from "bootstrap-vue";
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
      filesSelected: [],
      oldFiles: []
    }
  },
  async mounted() {
    // await this.getCurrentFiles();
    this.saveFile();
  },
  methods: {
    deleteRow(index) {
      this.files.splice(index, 1);
    },
    addDockRow() {
      this.files.push(1)
    },
    save() {

    },
    debug() {
      console.log(this.filesSelected)
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
        data.append('bla', 'fiks');
        return await Axios.post('/');
      });
      await Promise.all(filesSended)
    }
  }
}
</script>

<style scoped>

</style>