<template>
    <div>
        <h1 class="mt-3">{{ this.items.poname }}</h1>
        <b-table-simple bordered hover class="mt-5">
            <b-tbody>
                <b-tr>
                    <b-th class="center-text-in-cell">
                        <label>ID</label>
                    </b-th>
                    <b-th class="normal-font-weight-for-sell center-text-in-cell">
                        <label>{{ this.items.id }}</label>
                    </b-th>
                </b-tr>
                <b-tr>
                    <b-th class="center-text-in-cell">
                        <label>Наименование организации</label>
                    </b-th>
                    <b-th class="normal-font-weight-for-sell center-text-in-cell">
                        <label>{{ this.items.name }}</label>
                    </b-th>
                </b-tr>
                <b-tr>
                    <b-th class="center-text-in-cell">
                        <label>Наименование</label>
                    </b-th>
                    <b-th class="normal-font-weight-for-sell center-text-in-cell">
                        <label>{{ this.items.poname }}</label>
                    </b-th>
                </b-tr>
                <b-tr>
                    <b-th class="center-text-in-cell">
                        <label>Полный адрес объекта</label>
                    </b-th>
                    <b-th class="normal-font-weight-for-sell center-text-in-cell">
                        <label>{{ this.items.address }}</label>
                    </b-th>
                </b-tr>
                <b-tr>
                    <b-th class="center-text-in-cell">
                        <label>Назначение</label>
                    </b-th>
                    <b-th class="normal-font-weight-for-sell center-text-in-cell">
                        <label>{{ this.items.assignment }}</label>
                    </b-th>
                </b-tr>
                <b-tr>
                    <b-th class="center-text-in-cell">
                        <label>Общая площадь здания - всего, кв.м.</label>
                    </b-th>
                    <b-th class="normal-font-weight-for-sell center-text-in-cell">
                        <label>{{ this.items.square }}</label>
                    </b-th>
                </b-tr>
                <b-tr>
                    <b-th class="center-text-in-cell">
                        <label>Год постройки здания</label>
                    </b-th>
                    <b-th class="normal-font-weight-for-sell center-text-in-cell">
                        <label>{{ this.items.year }}</label>
                    </b-th>
                </b-tr>
                <b-tr>
                    <b-th class="center-text-in-cell">
                        <label>Износ</label>
                    </b-th>
                    <b-th class="normal-font-weight-for-sell center-text-in-cell">
                        <label>{{ getIznos(this.items.wear) }}</label>
                    </b-th>
                </b-tr>
                <b-tr>
                    <b-th class="center-text-in-cell">
                        <label>Примечание</label>
                    </b-th>
                    <b-th class="normal-font-weight-for-sell center-text-in-cell">
                        <label>{{ this.items.note }}</label>
                    </b-th>
                </b-tr>
            </b-tbody>
        </b-table-simple>

        <b-card no-body>
            <b-card-header header-tag="header" class="p-1" role="tab">
                <span> <b-icon icon="document-text" scale="1.5" class="mr-2 p2"></b-icon>Загруженные документы</span>
            </b-card-header>
            <b-card-body>
                <div v-if="docs.length">
                    <ul>
                        <li v-for="(doc, index) in docs" :key="index"><a :href="`/program/object/download-doc/1069?id=${doc.id}`">{{ `${doc.name}.pfd` }}</a></li>
                    </ul>
                </div>
                <div v-else>
                    <label>Документы отсутствуют</label>
                </div>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
import Axios from "axios";
export default {
    data() {
        return {
            csrf: document.getElementsByName("csrf-token")[0].content,
            items: [],
            obj_id: null,
            docs: []
        };
    },
    mounted() {
        this.obj_id = this.$route.params.id;
        this.getObject();
    },
    methods: {
        getObject() {
            Axios.post(`/api/object/${this.obj_id}`, null, {
                headers: {
                    "X-CSRF-Token": this.csrf
                }
            }).then(res => {
                console.log(res.data.docs);
                this.items = res.data.obj[0];
                this.docs = res.data.docs;
            });
        },
        getIznos(iznos) {
            let izn = parseInt(iznos);
            if (izn === 0) {
                return "Менее 20%";
            } else if (izn === 1) {
                return "От 20% до 50%";
            } else if (izn === 2) {
                return "От 50% до 70%";
            } else if (izn === 3) {
                return "От 70% до 90%";
            } else if (izn === 4) {
                return "Более 90%";
            }
        }
    }
};
</script>
