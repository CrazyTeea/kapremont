<template>
    <div class="overflow">
        <b-table-simple
            bordered
            hover
            >
                <b-thead>
                <b-tr>
                    <b-th>Документы</b-th>
                    <b-th>Загрузка</b-th>
                    <b-th>Удалить</b-th>
                </b-tr>
                </b-thead>
                <b-tbody>
                <b-tr v-for="(item, index) in items" :key="index">
                    <b-th class="cell-center-for-table normal-font-weight-for-table">
                        <label v-if="!item.other">{{ item.label }}</label>
                        <b-form-input
                            v-else
                            v-model="item.label" 
                            placeholder="Название документа..."
                            type="text"
                        ></b-form-input>
                    </b-th>
                    <b-th class="no-cell-border vertical-align-centre-extra-table normal-font-weight-for-table">

                        <input type="file" :name="`${modelName}[${item.descriptor}]file`" :ref="'file' + index" :id="'file_input_' + index" class="hidden-file-input" @input="fileInput(index)">

                        <div class="cell-center-for-items" v-if="!item.fileName">
                            <div class="arrow">
                                <label :for="`file_input_${index}`" class="label">
                                    <span class="title">
                                        <span class="scope-to-animate"></span>
                                        <span class="scope-to-animate"></span>
                                        <span class="scope-to-animate"></span>
                                        <span class="scope-to-animate"></span>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <label v-else class="normal-font-size-for-cell-file-name">{{ item.fileName }}</label>
                    </b-th>
                    <b-th class="no-cell-border vertical-align-centre-extra-table">
                        <div class="cell-center-for-items">
                            <div class="cross">
                                <label class="label" @click="fileRemove(index, item.descriptor)">
                                    <span class="title">
                                        <span class="cross-to-animate"></span>
                                        <span class="cross-to-animate"></span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </b-th>
                </b-tr>
                </b-tbody>
                <b-tfoot>
              <!--  <b-tr>
                    <b-td
                        @click="deleteLastRow()"
                        v-if="items.length > 10"
                        colspan="1"
                        variant="secondary"
                        class="text-right text-danger">
                        Удалить документ
                    </b-td>
                    <b-td
                        colspan="3"
                        @click="addNewRow()"
                        variant="secondary"
                        class="text-right text-info">
                        Добавить документ
                    </b-td>
                </b-tr>-->
                </b-tfoot>
        </b-table-simple>


            <label v-if="loadProgress">Файл {{ loadingFileName }} загружен на {{ loadProgress }}%</label>

    </div>
</template>

<script>
import Axios from 'axios';

export default {
    data() {
        return {
            csrf: document.getElementsByName('csrf-token')[0].content,
            items: [
                {descriptor:'inv_card', fileName: null, label: 'Инвентарные карточки учета основных средств на объект недвижимого имущества и на земельный участок под указанным объектом'},
                {descriptor:'reestr_vip', fileName: null, label: 'Выписка из реестра федерального имущества на объект федерального имущества и на земельный участок под указанным объектом'},
                {descriptor:'pravust', fileName: null, label: 'Правоустанавливающие и (или) правоудостоверяющие документы на объект недвижимого имущества и на земельный участок под указанным объектом'},
                {descriptor:'tex_kad_docs', fileName: null, label: 'Документы технического и кадастрового учета на объект недвижимого имущества'},
                {descriptor:'sit_plan', fileName: null, label: 'Ситуационный план с указанием границ земельного участка, объекта недвижимого имущества и иных объектов (включая незавершенные строительные объекты), принадлежащих третьим лицам, расположенных на указанном земельном участке'},
                {descriptor:'tex_acts', fileName: null, label: 'Акт технического осмотра объекта капитального строительства (документ, содержащий сведения о результатах обследования объекта капитального строительства, техническом состоянии строительных конструкций и инженерного оборудования такого объекта и количественной оценке фактических показателей качества строительных конструкций и инженерного оборудования по состоянию на дату обследования, для определения состава, объёмов и сроков работ по капитальному ремонту объекта капитального строительства)'},
                {descriptor:'def_ved', fileName: null, label: 'Дефектная ведомость (первичный учётный документ, подготовленный в соответствии с требованиями законодательства Российской Федерации о бухгалтерском учёте по результатам обследования технического состояния объекта капитального строительства и содержащий перечень дефектов строительных конструкций и инженерного оборудования объекта капитального строительства с указанием качественных и количественных характеристик таких дефектов)'},
                {descriptor:'obj_photos', fileName: null, label: 'Фотографии объекта, предполагаемого к проведению капитального ремонта (подписанные по 2 шт. на листе А4, но не более 10 шт. на объект недвижимости)'},
                {descriptor:'predpis', fileName: null, label: 'Предписания надзорных органов (при наличии)'},
                {descriptor:'proekti', fileName: null, label: 'Задание на проектирование (корректировку проектной документации), составленное в соответствии с рекомендациями Минстроя РФ (в случае разработки/корректировки проектной документации и/или направления данной документации на экспертизу)'},
            ],
            allDescriptors: ['inv_card', 'reestr_vip', 'pravust', 'tex_kad_docs', 'sit_plan', 'tex_acts', 'tex_acts', 'def_ved', 'obj_photos', 'predpis', 'proekti'],
            loadProgress: null,
            loadingFileName: null,
            loadedFilesOnServer: [],
            selectedFiles: [],
            uploadSuccess: true,
            update: false,
            objectId: null
        }
    },
    mounted() {
        if(this.$route.path.indexOf('/program/object/update') !== -1) {
            this.update = true;
            this.objectId = this.$route.params.id;
            this.getLoadedFiles(this.objectId)
        }
    },
    methods: {
        async getLoadedFiles(id) {
            await Axios.get(`/program/object/files/${id}`).then((res) => {
                if (res.data?.length) {
                    res.data.forEach(element => {
                        this.loadedFilesOnServer.push(element);
                        this.setFileName(element)
                    });
                }
            });
        },
        setFileName(element){
            this.items.map((elem, index) => {
                if(elem.descriptor === element.descriptor)
                {
                    this.items[index].fileName = element.name + '.pdf';

                }
            })
        },
        addNewRow() {
            this.items.push({
                descriptor:  null,
                fileName: null,
                label: null,
                other: true
            })
        },
        deleteLastRow() {
            this.items.pop();
            let index = this.items.length - 1;
            if(this.selectedFiles.length)
                this.fileRemove(index) 
        },
        fileInput(index) {
            // let file = Array.from(event.target.files)[0]; Это тоже рабочая версия
            let file = document.querySelector('#file_input_' + index).files[0];
            if(!this.checkFileExt(file.type) || !this.checkFileSize(file.size) || this.checkFileName(file.name)) {
                file.innerHeight = document.getElementById(`file_input_${index}`);
                return false;
            }
            this.selectedFiles.push({
                id: index,
                descriptor: this.items[index].descriptor,
                name: this.items[index].label,
                file: file
            });
            console.log(this.selectedFiles);
            this.items[index].fileName = file.name
        },
        fileRemove(index, descriptor) {
            let key = this.getSelectedFileKey(index);
            if(this.items[index].fileName != null && key == null) {
                console.log('удалить с сервера');
                this.removeFileFromYii(this.objectId, descriptor, index)
            } else if(this.items[index].fileName == null && key == null) {
                this.errorMessage('Сначала выберите файлы!')
            } else if(this.items[index].fileName != null && key != null) {
                console.log('удалить локально');
                console.log(this.selectedFiles);
                this.selectedFiles.splice(key, 1);
                this.items[index].fileName = null
            }
        },
        checkFileExt(type) {
            if(type !== 'application/pdf') {
                this.errorMessage('Файл не является документом pdf!');
                return false
            }
            return true
        },
        checkFileSize(size) {
            let _size = 20971520; //20 Мб
            if(parseInt(size) > _size) {
                this.errorMessage('Файл больше 20МБ!');
                return false
            }
            return true
        },
        checkFileName(fileName){
            if (this.items.find(f => f.fileName == fileName)){
                this.errorMessage('Файл c таким именем уже загружен!');
                return true;
            }
            return false;

        },
        getSelectedFileKey(index) {
            let element = this.selectedFiles.map((elem, id) => {
                if(elem.id === index) {
                    return id
                } else {
                    return null
                }
            }).filter((elem) => {
                return elem !== null
            })[0];
            if(element != null) {
                return element 
            } else {
                return null
            }
        },
        getSavedDocuments() {
            return this.selectedFiles;
        },
        async sendFile({id}) {
            if(this.selectedFiles.length) {
                //  this.errorMessage('Сначала выберите файлы!')
                for (let file of this.selectedFiles) {
                    await this.uploadFile(file, id)
                }
            }
            if (this.uploadSuccess)
                window.location.href = `/program/object/view/${id}`;
        },
        async removeFileFromYii(id, descriptor, index) {
            await Axios.get(`/program/object/delete-docs/${id}`, { params: { descriptor: descriptor } }).then((res) => {
                this.items[index].fileName = null;
                console.log(res.data)
            }).catch(error => console.log(error))
        },
        async uploadFile(file,id) {
            let form = new FormData();
            form.append(`${file.descriptor}`, file.file);
            this.loadingFileName = file.file.name;
            await Axios.post(`/program/object/add-docs/${id}`, form, {
                headers:
                    {
                        'X-CSRF-Token': this.csrf,
                        'Content-Type':'multipart/form-data;'
                    },
                onUploadProgress: (itemUpload) => {
                    this.loadProgress = Math.round( (itemUpload.loaded / itemUpload.total) * 100 )
                }
            }).then((res) => {
                 this.uploadSuccess &= !!res.data;
            }).catch(error => console.log(error))
        },
        // loadMessage: function(file) {
        //     message = `Файл ${this.loadingFileName} загружен на ${this.loadProgress}%`
        //     this.$bvModal.msgBoxOk(message, {
        //         title: 'Загрузка!',
        //         size: 'sm',
        //         buttonSize: 'sm',
        //         okVariant: 'outline-success',
        //         headerClass: 'p-2 border-bottom-0',
        //         footerClass: 'p-2 border-top-0',
        //         centered: true
        //     })
        // },
        errorMessage: function(message) {
            this.$bvModal.msgBoxOk(message, {
                title: 'Ошибка!',
                size: 'sm',
                buttonSize: 'sm',
                okVariant: 'outline-success',
                headerClass: 'p-2 border-bottom-0',
                footerClass: 'p-2 border-top-0',
                centered: true
            })
        }
    },
    props: {
        modelName:String
    }
}
</script>

<style>
.extra-table-class {
    vertical-align: middle !important;
    text-align: center;
}
.vertical-align-centre-extra-table {
    vertical-align: middle !important;
}
.overflow {
    overflow: hidden;
}
.normal-font-weight-for-table {
    font-weight: normal !important;
}
.normal-font-size-for-cell-file-name {
    font-size: 13px !important;
}
.cell-center-for-table {
    vertical-align: middle !important;
    text-align: center !important;
}
.cell-center-for-items {
    display: flex;
    align-items: center;
    justify-content: center;
}
.scope-to-animate {
    z-index: 999;
    height: 2px;
    width: 8px;
    background: grey;
    transition: 0.4s ease;
}
.scope-to-animate:first-child {
    display: block;
    position: absolute;
    transform: rotate(45deg);
    left: 25%;
    bottom: 35%;
}
.scope-to-animate:nth-child(2) {
    display: block;
    position: absolute;
    transform: rotate(-45deg);
    left: 45%;
    bottom: 35%;
}
.scope-to-animate:nth-child(3) {
    display: block;
    position: absolute;
    transform: rotate(45deg);
    left: 25%;
    bottom: 54%;
}
.scope-to-animate:nth-child(4) {
    display: block;
    position: absolute;
    transform: rotate(-45deg);
    left: 45%;
    bottom: 54%;
}
.label:hover .scope-to-animate:nth-child(1) {
    transform: rotate(-135deg);
    background: #5bc0de;
}
.label:hover .scope-to-animate:nth-child(2) {
    transform: rotate(135deg);
    background: #5bc0de;
}
.label:hover .scope-to-animate:nth-child(3) {
    transform: rotate(225deg);
    background: #5bc0de;
}
.label:hover .scope-to-animate:nth-child(4) {
    transform: rotate(-225deg);
    background: #5bc0de;
}
.hidden-file-input {
    display: none;
}
.label {
    position: relative;
    width: 28px;
}
.arrow {
    display: flex;
    align-items: center;
}
.arrow input[type=file] {
    outline:0;
    opacity:0;
    pointer-events:none;
    user-select:none
}
.arrow .label  {
    height: 28px;
    border:1px solid grey;
    border-radius:5px;
    display:block;
    transition:border 300ms ease;
    cursor:pointer;
    text-align:center
}
.arrow .label i {
    display:block;
    font-size:42px;
}
.arrow .label i,.example-1 .label .title {
    color:grey;
    transition:200ms color
}
.arrow .label:hover {
    border:2px solid #5bc0de
}
.arrow .label:hover i,.example-1 .label:hover .title {
    color:#5bc0de
}
.cross-to-animate {
    z-index: 999;
    height: 2px;
    width: 15px;
    background: #d9534f;
    transition: 0.4s ease;
}
.cross-to-animate:first-child {
    display: block;
    position: absolute;
    transform: rotate(45deg);
    left: 20%;
    bottom: 45%;
}
.cross-to-animate:nth-child(2) {
    display: block;
    position: absolute;
    transform: rotate(-45deg);
    left: 22%;
    bottom: 45%;
}
.label:hover .cross-to-animate:nth-child(1) {
    transform: rotate(-135deg);
}
.label:hover .cross-to-animate:nth-child(2) {
    transform: rotate(135deg);
}
.cross {
    display: flex;
    align-items: center;
}
.cross .label  {
    height: 28px;
    border:1px solid grey;
    border-radius:5px;
    display:block;
    transition:border 300ms ease;
    cursor:pointer;
    text-align:center
}
.cross .label i {
    display:block;
    font-size:42px;
}
.cross .label i,.cross .label .title {
    color:grey;
    transition:200ms color
}
.cross .label:hover {
    border:2px solid #d9534f
}
</style>