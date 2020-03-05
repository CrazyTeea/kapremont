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
                        <label>{{ item.label }}</label>
                    </b-th>
                    <b-th class="no-cell-border">
                        <div class="cell-center-for-items">
                        <div class="example-1">
                            <label class="label">
                                <span class="title">
                                    <div class="round-to-animate">
                                        <span class="scope-to-animate"></span>
                                        <span class="scope-to-animate"></span>
                                        <span class="scope-to-animate"></span>
                                        <span class="scope-to-animate"></span>
                                    </div>
                                </span>
                                <form :id="'file_form_' + index">
                                    <input type="file" :id="'file_input_' + index" class="hidden-file-input" @input="fileInput(index)">
                                </form>
                            </label>
                        </div>
                        </div>
                    </b-th>
                    <b-th>
                        <label>
                            <b-button @click="fileRemove(index)">X</b-button>
                        </label>
                    </b-th>
                </b-tr>
                </b-tbody>
        </b-table-simple>
    </div>
</template>

<script>
export default {
    data() {
        return {
            items: [
                {name: null, label: 'Инвентарные карточки учета основных средств на объект недвижимого имущества и на земельный участок под указанным объектом'},
                {name: null, label: 'Выписка из реестра федерального имущества на объект федерального имущества и на земельный участок под указанным объектом'},
                {name: null, label: 'Правоустанавливающие и (или) правоудостоверяющие документы на объект недвижимого имущества и на земельный участок под указанным объектом'},
                {name: null, label: 'Документы технического и кадастрового учета на объект недвижимого имущества'},
                {name: null, label: 'Ситуационный план с указанием границ земельного участка, объекта недвижимого имущества и иных объектов (включая незавершенные строительные объекты), принадлежащих третьим лицам, расположенных на указанном земельном участке'},
                {name: null, label: 'Акт технического осмотра объекта капитального строительства (документ, содержащий сведения о результатах обследования объекта капитального строительства, техническом состоянии строительных конструкций и инженерного оборудования такого объекта и количественной оценке фактических показателей качества строительных конструкций и инженерного оборудования по состоянию на дату обследования, для определения состава, объёмов и сроков работ по капитальному ремонту объекта капитального строительства)'},
                {name: null, label: 'Дефектная ведомость (первичный учётный документ, подготовленный в соответствии с требованиями законодательства Российской Федерации о бухгалтерском учёте по результатам обследования технического состояния объекта капитального строительства и содержащий перечень дефектов строительных конструкций и инженерного оборудования объекта капитального строительства с указанием качественных и количественных характеристик таких дефектов)'},
                {name: null, label: 'Фотографии объекта, предполагаемого к проведению капитального ремонта (подписанные по 2 шт. на листе А4, но не более 10 шт. на объект недвижимости)'},
                {name: null, label: 'Предписания надзорных органов (при наличии)'},
                {name: null, label: 'Задание на проектирование (корректировку проектной документации), составленное в соответствии с рекомендациями Минстроя РФ (в случае разработки/корректировки проектной документации и/или направления данной документации на экспертизу)'},
                {name: null, label: 'Иные документы'},
            ],
            loadProgress: null,
            selectedFiles: [],
        }
    },
    methods: {
        fileInput(index) {
            let file = Array.from(event.target.files)[0];
            if(file.type !== 'application/pdf' ) {
                document.querySelector('#file_form_' + index).reset();
                document.querySelector('#file_input_' + index).value = null;

                return this.wrongDocumentTypeError()
            }

            this.selectedFiles.push({
                id: index,
                name: this.items[index].label,
                file: file
            });

            console.log(this.selectedFiles)
        },
        fileRemove(index) {
            this.selectedFiles.forEach((element, key) => {
                if(element.id = index) {
                    this.selectedFiles.splice(index, 1)
                }
            })
            
        },
        isInputDisabled(index) {
            console.log(this.selectedFiles);
            if(this.selectedFiles.length) {
                for(let item of this.selectedFiles) {
                    if(item.id = index) {
                        return true
                    }
                }
                return false
            }
        },
        // async uploadFile(file) {
        //     let form = new FormData()
        //     form.append('pdf', file, file.name)

        //     await Axios.post('', form, {
        //         onUploadProgress: (itemUpload) => {
        //             this.loadProgress = Math.round( (itemUpload.loaded / itemUpload.total) * 100 )
        //         }
        //     })
        // },
        wrongDocumentTypeError: function() {
            let message = 'Файл не является документом pdf!'
            this.$bvModal.msgBoxOk(message, {
                title: 'Ошибка!',
                size: 'lg',
                buttonSize: 'sm',
                okVariant: 'success',
                headerClass: 'p-2 border-bottom-0',
                footerClass: 'p-2 border-top-0',
                centered: true
            })
        }
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
    background: black;
}
.label:hover .scope-to-animate:nth-child(2) {
    transform: rotate(135deg);
    background: black;
}
.label:hover .scope-to-animate:nth-child(3) {
    transform: rotate(225deg);
    background: black;
}
.label:hover .scope-to-animate:nth-child(4) {
    transform: rotate(-225deg);
    background: black;
}
.hidden-file-input {
    display: none;
}
.label {
    position: relative;
    width: 28px;
}
.example-1 {
    display: flex;
    align-items: center;
}
.example-1 input[type=file] {
    outline:0;
    opacity:0;
    pointer-events:none;
    user-select:none
}
.example-1 .label  {
    height: 28px;
    border:2px dashed grey;
    border-radius:5px;
    display:block;
    transition:border 300ms ease;
    cursor:pointer;
    text-align:center
}
.example-1 .label i {
    display:block;
    font-size:42px;
}
.example-1 .label i,.example-1 .label .title {
    color:grey;
    transition:200ms color
}
.example-1 .label:hover {
    border:2px solid #000
}
.example-1 .label:hover i,.example-1 .label:hover .title {
    color:#000
}
</style>