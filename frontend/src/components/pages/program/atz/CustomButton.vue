<template>
  <div class="mt-4 mb-2 d-flex justify-content-end">
    <b-button-group size="sm">
      <b-button @click="$emit('addRow1')">Добавить закупку у единственного поставщика</b-button>
      <b-button @click="$emit('addRow2')">Добавить закупку конкурентным способом</b-button>
    </b-button-group>
  </div>
</template>

<script>
import {BButton, BButtonGroup} from "bootstrap-vue";

export default {
  components: {BButton, BButtonGroup},
  name: "CustomButton"
}
</script>

<style scoped>

</style>
