<template>
  <div class="file-input-component">
    <div class="row">
    <b-input-group class="mt-3">
        <b-form-input
            class="col-lg-6"
            v-model="label"
            placeholder="Название документа..."
            type="text"
        ></b-form-input>
      <b-form-file
          placeholder="Выберите файл"
          ref="formFile"
          browse-text="Файл"
          @input="change"
      ></b-form-file>
    </b-input-group>
    </div>
    <div v-show="message.show" class="row justify-content-start message-danger text-danger">{{ message.text }}</div>
  </div>
</template>

<script>
import { BFormInput, BFormGroup, BInputGroupAppend, BInputGroup, BFormFile, BButton } from 'bootstrap-vue';
export default {
  name: "FileInputComponent",
  components: {
    BFormInput, BFormGroup, BInputGroupAppend , BInputGroup, BFormFile, BButton
  },
  props: {
    index: {
      required: true,
    }
  },
  data() {
    return {
      label: null,
      message: {
        show: false,
        text: 'Сначала заполните название документа'
      }
    }
  },

  mounted() {},
  methods: {
    change(file) {
      if(!this.label) {
        this.message.show = true;
        this.$refs['formFile'].reset();
        return;
      }
      this.$emit('input', {file: file, descriptor: this.label}, 'file');
    },
  },
  watch: {
    label() {
      this.message.show = (this.label.length > 3) ? false : true;
    }
  }
}
</script>

<style scoped>
.message-danger {
  font-size: 14px;
}
</style>