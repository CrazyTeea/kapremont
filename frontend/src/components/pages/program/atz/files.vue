<template>
  <div class="main-wrapper-upload-files">
    <div class="table-wrapper">
      <div class="file-wrapper" v-for="(file, index) in files" :key="`file_input_atz_${index}`">
        <file-input v-model="file.value" :index="index"/>
      </div>
      <div v-can:user class="mt-4 d-flex justify-content-end">
        <b-button variant="info" @click="addDockRow">Добавить</b-button>
        <b-button class="ml-1" variant="danger" @click="deleteLastRow">Удалить последний</b-button>
        <b-button class="ml-1" variant="success" @click="saveFile">Сохранить</b-button>
      </div>
      <div v-if="!oldFiles || oldFiles.length === 0" v-can:dku>
        Файлов пока нет
      </div>
    </div>
    <div v-if="showArchive && oldFiles.length !== 0" class="arhivated-docs mt-4">
      <h3>Архив документов</h3>

      <b-table-simple>
        <b-thead>
          <b-th>
            Описание документа
          </b-th>
          <b-th>
            Название документа
          </b-th>
        </b-thead>
        <b-tbody>
          <b-tr v-for="(key, index) in Object.keys(oldFiles)" :key="`old_files_${index}`">
            <b-td>
              {{ key }}
            </b-td>
            <b-td>
              <div>
                <ul>
                  <li v-for="file_key in Object.keys(oldFiles[key])"><a
                      :href="`/api/files-upload/get-file?id=${file_key}`">{{ oldFiles[key][file_key] }}</a></li>
                </ul>
              </div>
            </b-td>
          </b-tr>
        </b-tbody>
      </b-table-simple>
    </div>
  </div>
</template>

<script>
import Axios from 'axios';
import {BButton, BTableSimple, BTbody, BTd, BTh, BThead, BTr} from "bootstrap-vue";
import FileInputComponent from "./FileInputComponent";

export default {
  props: ['id_card'],
  components: {
    "file-input": FileInputComponent,
    BButton,
    BTableSimple,
    BThead,
    BTbody,
    BTh,
    BTd,
    BTr
  },
  data() {
    return {
      csrf: document.getElementsByName("csrf-token")[0].content,
      files: [],
      oldFiles: [],
      showArchive: false,
    }
  },
  async mounted() {
    await this.getCurrentFiles();
    console.log('oldFiles', this.oldFiles);
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
      return Axios.post('/api/files-upload/get-info', data, {
        headers: {
          "X-CSRF-Token": this.csrf,
        },
      }).then(res => {
        if (res.data != null) this.showArchive = true;
        this.oldFiles = res.data;
      });
    },
    async saveFile() {
      const filesSended = this.files.map(async element => {
        let data = new FormData();
        data.append('file', element.value.file);
        data.append('id_atz', this.$route.params.id);
        data.append('id_card', this.id_card);
        data.append('description', element.value.descriptor);

        return await Axios.post('/api/files-upload/save-file', data, {
          headers: {
            "X-CSRF-Token": this.csrf,
            "Content-Type": "multipart/form-data;"
          },
        });
      });
      await Promise.all(filesSended);
      this.files = [];
      await this.getCurrentFiles()
    }
  }
}
</script>

<style scoped>

</style>
