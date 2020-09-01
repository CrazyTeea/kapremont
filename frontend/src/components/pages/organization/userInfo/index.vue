<template>
  <div id="user-info-form">
    <b-form id="user_form">
      <b-card style="margin-top: 10px;" v-for="(item,index) in items" :key="index">
        <b-form-group
            id="role-input-group"
            label="Роль (поля обязательные к заполнению)"
            label-for="role-input-select"
        >
          <b-form-input hidden v-model="item.role" id="role-input" :name="`${model}[${index}][role]`"/>
          <b-select :disabled="!item.canSelect" v-model="item.role" id="role-input-select" :options="roles"/>
        </b-form-group>
        <b-form-group
            id="name-input-group"
            label="ФИО"
            label-for="name-input"
        >
          <b-form-input v-model="item.name" id="name-input" :name="`${model}[${index}][name]`"/>
        </b-form-group>

        <b-form-group
            id="position-input-group"
            label="Должность"
            label-for="position-input"
        >
          <b-form-input v-model="item.position" id="position-input" :name="`${model}[${index}][position]`"/>
        </b-form-group>
        <b-form-group
            id="phone-input-group"
            label="Контактный мобильный телефон"
            label-for="phone-input"
        >
          <b-form-input v-model="item.phone" id="phone-input" :name="`${model}[${index}][phone]`"/>
        </b-form-group>
        <b-form-group
            id="email-input-group"
            label="Почта"
            label-for="email-input"
        >
          <b-form-input v-model="item.email" id="email-input" :name="`${model}[${index}][email]`"/>
        </b-form-group>
      </b-card>
      <br>
      <b-alert show variant="success" v-show="showSuccess">
        Данные сохранены успешно
      </b-alert>
      <b-alert show variant="danger" v-show="showError">
        Что то пошло не так
      </b-alert>
      <b-button variant="success" @click="submit">Сохранить</b-button>
      <b-button variant="success" @click="add">Добавить эдемент</b-button>
      <b-button variant="danger" @click="deleteItem">Удалить элемент</b-button>

      <b-button variant="primary" v-b-modal.modal-approve>Отправить данные</b-button>

      <b-modal cancel-title="Отмена" ok-title="Отправить" @ok="submitAll" id="modal-approve" title="Отправить данные">
        <p class="my-4">После этого действия вы больше не сможете изменять эти данные</p>
      </b-modal>

    </b-form>
  </div>
</template>

<script>
import Axios from 'axios';
import {BAlert, BButton, BCard, BForm, BFormGroup, BFormInput, BFormSelect, BModal, VBModal,} from 'bootstrap-vue'

export default {
  directives: {
    'b-modal': VBModal
  },
  components: {
    BModal,
    BAlert,
    BForm,
    BCard,
    BFormGroup,
    BFormInput,
    BButton,
    'b-select': BFormSelect
  },
  async mounted() {
    await this.getModels();
    await this.getRoles();
  },
  methods: {
    getModels() {
      if (window.users_info.length) {
        window.users_info.forEach((item, index) => {
          if (index < 4) {
            this.items[index].role = item.role;
            this.items[index].name = item.name;
            this.items[index].position = item.position;
            this.items[index].phone = item.phone;
            this.items[index].email = item.email;
          } else {
            this.items.push({
              role: item.role,
              name: item.name,
              position: item.position,
              phone: item.phone,
              email: item.email,
              canSelect: true
            })
          }
        })
      }
    },
    getRoles() {
      Axios.get('/api/user-info/roles').then(response => {
        response.data.forEach(item => {
          this.roles.push({
            value: item.id,
            text: item.role
          })
        })
      });
    },
    submit(el, changeStatus = false) {
      let formData = new FormData(document.getElementById('user_form'));

      if (changeStatus)
        formData.append('user_status', '1');

      Axios.post(this.$route.path, formData, {
        headers: {
          "X-CSRF-Token": this.csrf
        }
      }).then(response => {
        if (response.data.success) {
          this.showSuccess = true;
          this.showError = false;
        } else {
          this.showSuccess = false;
          this.showError = true;
        }
      })
    },
    async submitAll() {
      await this.submit(null, true);
      window.location.href = '/program/view';

    },
    add() {
      this.items.push(
          {
            name: '',
            position: '',
            phone: '',
            email: '',
            role: 1,
            canSelect: true,
          },
      )
    },
    deleteItem() {
      if (this.items.length > 4)
        this.items.pop()
    }
  },
  data() {
    return {
      users_info: window.users_info || [],
      model: 'UserInfo',
      roles: [],
      csrf: document.getElementsByName("csrf-token")[0].content,
      showSuccess: false,
      showError: false,
      items: [
        {
          name: '',
          position: '',
          phone: '',
          email: '',
          role: 1,
          canSelect: false,
        },
        {
          name: '',
          position: '',
          phone: '',
          email: '',
          canSelect: false,
          role: 2
        },
        {
          name: '',
          position: '',
          phone: '',
          email: '',
          canSelect: false,
          role: 3
        },
        {
          name: '',
          position: '',
          phone: '',
          email: '',
          canSelect: false,
          role: 4
        },
      ],
      formData: []
    }
  }
}
</script>

<style scoped>

</style>